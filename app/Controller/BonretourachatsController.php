<?php

App::import('Vendor', 'dompdf', ['file' => 'dompdf'.DS.'dompdf_config.inc.php']);

class BonretourachatsController extends AppController
{
    public $idModule = 119;

    public function index()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');

        //---  recupérer uniquement les dépots de site en cours
        // $depots = $this->Bonretourachat->Depot->findList(['Depot.principal'=>1]);
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store]]);

        $fournisseurs = $this->Bonretourachat->Fournisseur->find('list');
        $users = $this->Bonretourachat->User->findList();
        $this->set(compact('users', 'fournisseurs', 'user_id', 'role_id', 'depots'));
        $this->getPath($this->idModule);
    }

    public function loadquatite($depot_id = null, $produit_id = null)
    {
        $req = $this->Bonretourachat->Bonretourachatdetail->Produit->Depotproduit->find('first', ['conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);
        $quantite = (isset($req['Depotproduit']['id']) and !empty($req['Depotproduit']['quantite'])) ? (float) $req['Depotproduit']['quantite'] : 0;
        die(json_encode($quantite));
    }

    public function scan($code_barre = null, $depot_id = null)
    {
        $response['error'] = true;
        $response['message'] = '';
        $response['data']['prix_achat'] = 0;
        $response['data']['stock_source'] = 0;
        $response['data']['produit_id'] = null;

        $longeur = strlen($code_barre);
        if ($longeur != 13) {
            $response['message'] = 'Code a barre est incorrect , produit introuvable !';
        } else {
            $this->loadModel('Parametreste');
            $params = $this->Parametreste->findList();
            $cb_identifiant = (isset($params['cb_identifiant']) and !empty($params['cb_identifiant'])) ? $params['cb_identifiant'] : '2900';
            $cb_produit_depart = (isset($params['cb_produit_depart']) and !empty($params['cb_produit_depart'])) ? $params['cb_produit_depart'] : 4;
            $cb_produit_longeur = (isset($params['cb_produit_longeur']) and !empty($params['cb_produit_longeur'])) ? $params['cb_produit_longeur'] : 3;
            $cb_quantite_depart = (isset($params['cb_quantite_depart']) and !empty($params['cb_quantite_depart'])) ? $params['cb_quantite_depart'] : 7;
            $cb_quantite_longeur = (isset($params['cb_quantite_longeur']) and !empty($params['cb_quantite_longeur'])) ? $params['cb_quantite_longeur'] : 5;
            $cb_div_kg = (isset($params['cb_div_kg']) and !empty($params['cb_div_kg']) and $params['cb_div_kg'] > 0) ? (int) $params['cb_div_kg'] : 1000;
            $identifiant = substr(trim($code_barre), 0, 4);
            if ($cb_identifiant != $identifiant) {
                $response['message'] = "Identifiant du code à barre est incorrect , veuillez vérifier votre paramétrage d'application !";
            } else {
                $code_article = substr(trim($code_barre), $cb_produit_depart, $cb_produit_longeur);
                $quantite = substr(trim($code_barre), $cb_quantite_depart, $cb_quantite_longeur);

                $this->loadModel('Produit');
                $produit = $this->Produit->find('first', ['fields' => ['id', 'prix_vente', 'stockactuel', 'unite_id', 'prixachat'], 'conditions' => ['Produit.type' => 2, 'Produit.code_barre' => $code_article]]);
                if (!isset($produit['Produit']['id'])) {
                    $response['message'] = 'Code a barre incorrect produit introuvable !';
                }

                $produit = $this->Produit->find('first', [
                    'fields' => [/* 'Depotproduit.*', */'Produit.*'],
                    'conditions' => ['Produit.code_barre' => $code_article],
                    /* 'joins' => [
                        ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
                    ], */
                ]);
                /* if(!isset($produit['Depotproduit']['id'])) {
                    $response['message'] = "Le produit n'existe pas dans ce dépôt !";
                } */
                $quantite = (float) $quantite;
                /* else */ if (isset($produit['Produit']['id']) and !empty($produit['Produit']['id'])) {
                    if (isset($produit['Produit']['pese']) and $produit['Produit']['pese'] == '1') {
                        $qte = round($quantite / $cb_div_kg, 3);
                    } // autre
                    else {
                        $qte = $quantite;
                    } // piéce

                    if ($qte < 0) {
                        $response['message'] = 'Opération impossible la quantité doit étre supérieur a zéro !';
                    } else {
                        $response['error'] = false;
                        $response['data']['quantite_sortie'] = $qte;
                        $response['data']['produit_id'] = $produit['Produit']['id'];
                        //$response['data']['stock'] =  $produit['Depotproduit']['quantite'];
                        $response['data']['prix'] = $produit['Produit']['prix_vente'];
                    }
                }
            }
        }

        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }

    public function indexAjax()
    {
        $admins = $this->Session->read('admins');
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $conditions = [];
        if (!in_array($role_id, $admins)) {
            $conditions['Bonretourachat.user_c'] = $user_id;
        }
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Bonretourachat.reference') {
                    $conditions['Bonretourachat.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Bonretourachat.date1') {
                    $conditions['Bonretourachat.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Bonretourachat.date2') {
                    $conditions['Bonretourachat.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]);

        $conditions['Bonretourachat.depot_id'] = $depots;

        $this->Bonretourachat->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['User', 'Fournisseur' => ['Ville']],
            'order' => ['Bonretourachat.date' => 'DESC', 'Bonretourachat.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();
        $ventes = $this->Bonretourachat->find('all', ['contain' => ['User', 'Fournisseur'], 'conditions' => $conditions]);
        $this->set(compact('taches', 'ventes', 'user_id'));
        $this->layout = false;
    }

    public function editreception($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['Bonretourachat']['Bonreception_id']) and !empty($this->request->data['Bonretourachat']['Bonreception_id'])) {
                $bonreceptiondetail['Bonreceptiondetail'] = [];
                $bonreception = $this->Bonretourachat->Bonreception->find('first', ['conditions' => ['Bonreception.id' => $this->request->data['Bonretourachat']['Bonreception_id']]]);

                $this->request->data['Bonretourachat']['depot_id'] = (isset($bonreception['Bonreception']['depot_id']) and !empty($bonreception['Bonreception']['depot_id'])) ? $bonreception['Bonreception']['depot_id'] : 1;
                $this->request->data['Bonretourachat']['fournisseur_id'] = (isset($bonreception['Bonreception']['fournisseur_id']) and !empty($bonreception['Bonreception']['fournisseur_id'])) ? $bonreception['Bonreception']['fournisseur_id'] : null;
                $details = $this->Bonretourachat->Bonreception->Bonreceptiondetail->find('all', ['conditions' => ['Bonreceptiondetail.Bonreception_id' => $this->request->data['Bonretourachat']['Bonreception_id']]]);
                foreach ($details as $k => $v) {
                    $Bonretourachatdetail['Bonretourachatdetail'][] = [
                        'produit_id' => $v['Bonreceptiondetail']['produit_id'],
                        'prix_vente' => $v['Bonreceptiondetail']['prix_vente'],
                        'qte' => 0,
                        'remise' => 0,
                        'total' => 0,
                        'ttc' => 0,
                    ];
                }
                if (!empty($Bonretourachatdetail)) {
                    $this->request->data['Bonretourachatdetail'] = $Bonretourachatdetail['Bonretourachatdetail'];
                }
            }
            if ($this->Bonretourachat->saveAssociated($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Bonretourachat->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        }

        $bonreceptions = $this->Bonretourachat->Bonreception->find('list');
        $this->set(compact('bonreceptions', 'user_id', 'role_id'));
        $this->layout = false;
    }

    public function edit($id = null, $flag = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        if ($this->request->is(['post', 'put'])) {
            if ($this->Bonretourachat->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Bonretourachat->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        } elseif ($this->Bonretourachat->exists($id)) {
            $options = ['conditions' => ['Bonretourachat.'.$this->Bonretourachat->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->find('first', $options);
        }

        //	$depots = $this->Bonretourachat->Depot->findList(['Depot.principal'=>1]);

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
    'fields' => ['libelle'], ]);

        $fournisseurs = $this->Bonretourachat->Fournisseur->find('list');
        $users = $this->Bonretourachat->User->findList();
        $this->set(compact('users', 'fournisseurs', 'user_id', 'role_id', 'flag', 'depots'));
        $this->layout = false;
    }

    public function editavance($id = null, $bonretourachat_id = null)
    {
        $boncommande = $this->Bonretourachat->find('first', ['conditions' => ['id' => $bonretourachat_id]]);
        $reste_a_payer = (isset($boncommande['Bonretourachat']['reste_a_payer'])) ? $boncommande['Bonretourachat']['reste_a_payer'] : 0;
        $user_id = $this->Session->read('Auth.User.id');
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Avance']['user_id'] = $user_id;
            $this->request->data['Avance']['bonretourachat_id'] = $bonretourachat_id;
            if ($this->Bonretourachat->Avance->save($this->request->data)) {
                $this->calculatrice($bonretourachat_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonretourachat->Avance->exists($id)) {
            $options = ['conditions' => ['Avance.'.$this->Bonretourachat->Avance->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->Avance->find('first', $options);
        }

        $this->set(compact('reste_a_payer'));
        $this->layout = false;
    }

    public function deleteavance($id = null, $bonretourachat_id = null)
    {
        $this->Bonretourachat->Avance->id = $id;
        if (!$this->Bonretourachat->Avance->exists()) {
            throw new NotFoundException(__('Invalide Avance'));
        }

        if ($this->Bonretourachat->Avance->flagDelete()) {
            $this->calculatrice($bonretourachat_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function delete($id = null)
    {
        $this->Bonretourachat->id = $id;
        if (!$this->Bonretourachat->exists()) {
            throw new NotFoundException(__('Invalide vente'));
        }

        if ($this->Bonretourachat->flagDelete()) {
            $this->Bonretourachat->Bonretourachatdetail->updateAll(['Bonretourachatdetail.deleted' => 1], ['Bonretourachatdetail.bonretourachat_id' => $id]);
            $this->Bonretourachat->Avance->updateAll(['Avance.deleted' => 1], ['Avance.bonretourachat_id' => $id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null, $bonretourachat_id = null)
    {
        $this->Bonretourachat->Bonretourachatdetail->id = $id;
        if (!$this->Bonretourachat->Bonretourachatdetail->exists()) {
            throw new NotFoundException(__('Invalide article'));
        }

        if ($this->Bonretourachat->Bonretourachatdetail->flagDelete()) {
            $this->calculatrice($bonretourachat_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function view($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');

        $details = [];
        $avances = [];
        if ($this->Bonretourachat->exists($id)) {
            $options = ['contain' => ['Depot', 'Societe', 'Fournisseur'], 'conditions' => ['Bonretourachat.'.$this->Bonretourachat->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->find('first', $options);

            $depot_src = $this->Bonretourachat->Depot->find('first', ['conditions' => ['id' => $this->request->data['Bonretourachat']['depot_id'], 'deleted' => 0]]);

            $details = $this->Bonretourachat->Bonretourachatdetail->find('all', [
                'conditions' => ['Bonretourachatdetail.bonretourachat_id' => $id],
                'fields' => ['Produit.*', 'Bonretourachatdetail.*'],
                'contain' => ['Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('details', 'role_id', 'user_id', 'avances'));
        $this->getPath($this->idModule);
    }

    public function getProduitByDepot($bonretourachat_id = null, $depot_id = null, $categorieproduit_id = null)
    {
        $produits_exists = $this->Bonretourachat->Bonretourachatdetail->Produit->find('list', [
            'fields' => ['Produit.id', 'Produit.id'],
            'joins' => [
                ['table' => 'bonretourachatdetails', 'alias' => 'Bonretourachatdetail', 'type' => 'INNER', 'conditions' => ['Bonretourachatdetail.produit_id = Produit.id']],
            ],
            'conditions' => [
                'Bonretourachatdetail.deleted' => 0,
                'Bonretourachatdetail.depot_id' => $depot_id,
                'Bonretourachatdetail.bonretourachat_id' => $bonretourachat_id,
            ],
        ]);

        $produits = $this->Bonretourachat->Bonretourachatdetail->Produit->findList([
            'Produit.categorieproduit_id' => $categorieproduit_id,
        ]);

        die(json_encode($produits));
    }

    public function getProduit($produit_id = null, $depot_id = null)
    {
        $article = $this->Bonretourachat->Bonretourachatdetail->Produit->find('first', [
            'fields' => ['Produit.*', 'Depotproduit.*'],
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id']],
            ],
            'conditions' => ['Produit.id' => $produit_id, 'Depotproduit.depot_id' => $depot_id],
        ]);

        die(json_encode($article));
    }

    public function ticket($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonretourachat->exists($id)) {
            $options = ['contain' => ['User', 'Fournisseur' => ['Ville']], 'conditions' => ['Bonretourachat.'.$this->Bonretourachat->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->find('first', $options);

            $details = $this->Bonretourachat->Bonretourachatdetail->find('all', [
                'conditions' => ['Bonretourachatdetail.bonretourachat_id' => $id],
                'contain' => ['Depot', 'Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $societe = $this->GetSociete();
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }

    public function pdf($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonretourachat->exists($id)) {
            $options = ['contain' => ['User', 'Fournisseur' => ['Ville']], 'conditions' => ['Bonretourachat.'.$this->Bonretourachat->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->find('first', $options);

            $details = $this->Bonretourachat->Bonretourachatdetail->find('all', [
                'conditions' => ['Bonretourachatdetail.bonretourachat_id' => $id],
                'contain' => ['Depot', 'Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $societe = $this->GetSociete();
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }

    public function editdetail($id = null, $bonretourachat_id = null)
    {
        $commande = $this->Bonretourachat->find('first', ['contain' => ['User'], 'conditions' => ['Bonretourachat.id' => $bonretourachat_id]]);
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');
        $depot_id = 1;

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Bonretourachatdetail']['bonretourachat_id'] = $bonretourachat_id;
            if ($this->Bonretourachat->Bonretourachatdetail->save($this->request->data)) {
                /* $this->request->data['Avance']['user_id'] = $user_id;
                $this->request->data['Avance']['bonretourachat_id'] = $bonretourachat_id;
                $this->request->data['Avance']['montant'] = $bonretourachat_id; *
                $this->Bonretourachat->Avance->save($this->request->data);*/
                $this->calculatrice($bonretourachat_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonretourachat->Bonretourachatdetail->exists($id)) {
            $options = ['conditions' => ['Bonretourachatdetail.'.$this->Bonretourachat->Bonretourachatdetail->primaryKey => $id]];
            $this->request->data = $this->Bonretourachat->Bonretourachatdetail->find('first', $options);
        }

        $produits = $this->Bonretourachat->Bonretourachatdetail->Produit->findList();
        $depots = $this->Bonretourachat->Bonretourachatdetail->Depot->find('list');
        $categorieproduits = $this->Bonretourachat->Bonretourachatdetail->Produit->Categorieproduit->find('list');
        $this->set(compact('produits', 'role_id', 'depot_id', 'depots', 'categorieproduits'));
        $this->layout = false;
    }

    public function changestate($bonretourachat_id = null, $etat = -1)
    {
        $details = $this->Bonretourachat->Bonretourachatdetail->find('all', ['conditions' => ['bonretourachat_id' => $bonretourachat_id]]);
        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Bonretourachat->id = $bonretourachat_id;
        if ($this->Bonretourachat->saveField('etat', $etat)) {
            $boncommande = $this->Bonretourachat->find('first', ['conditions' => ['Bonretourachat.id' => $bonretourachat_id]]);
            foreach ($details as $key => $value) {
                if ($value['Bonretourachatdetail']['qte'] == '0.000') {
                    $this->Bonretourachat->Bonretourachatdetail->delete($value['Bonretourachatdetail']['id']);
                }
                /* else
                    $this->sortie($value['Bonretourachatdetail']['produit_id'],1,$value['Bonretourachatdetail']['paquet'],$value['Bonretourachatdetail']['qte'],$value['Bonretourachatdetail']['total_unitaire']); */
            }
            if (isset($boncommande['Bonretourachat']['id']) and $boncommande['Bonretourachat']['etat'] == 2) {
                foreach ($details as $key => $value) {
                    if ($value['Bonretourachatdetail']['qte'] == '0.000') {
                        $this->Bonretourachat->Bonretourachatdetail->delete($value['Bonretourachatdetail']['id']);
                    } else {
                        $this->sortie($value['Bonretourachatdetail']['produit_id'], 1, $value['Bonretourachatdetail']['paquet'], $value['Bonretourachatdetail']['qte'], $value['Bonretourachatdetail']['total_unitaire']);
                    }
                }
            }
            $this->Session->setFlash("L'enregistrement a été effectué avec succès.", 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function sortie($produit_id = null, $depot_id = 1, $paquet_sortie = 0, $quantite_sortie = 0, $total_sortie = 0)
    {
        $this->loadModel('Depotproduit');
        $depot = $this->Depotproduit->find('first', [
            'conditions' => [
                'depot_id' => $depot_id,
                'produit_id' => $produit_id,
            ],
        ]);

        $this->loadModel('Entree');
        $donnees['Entree'] = [
            'quantite' => $paquet_sortie,
            'depot_id' => $depot_id,
            'produit_id' => $produit_id,
            'type' => 'Sortie',
        ];
        $this->Entree->saveMany($donnees);

        $ancienne_paquet = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['paquet'])) ? (int) $depot['Depotproduit']['paquet'] : 0;
        $paquet = $ancienne_paquet - $paquet_sortie;
        if ($paquet <= 0) {
            $paquet = 0;
        }

        $ancienne_quantite = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['quantite'])) ? $depot['Depotproduit']['quantite'] : 0;
        $quantite = $ancienne_quantite - $quantite_sortie;
        /* if( $quantite <= 0 ) $quantite = 0;
 */
        $ancienne_total = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['total'])) ? (int) $depot['Depotproduit']['total'] : 0;
        $total = $ancienne_total - $total_sortie;
        if ($total <= 0) {
            $total = 0;
        }

        $id = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['id'])) ? $depot['Depotproduit']['id'] : null;

        $data = [
            'id' => $id,
            'date' => date('Y-m-d'),
            'depot_id' => $depot_id,
            'produit_id' => $produit_id,
            'quantite' => $quantite,
            'paquet' => $paquet,
            'total' => $total,
        ];

        $this->Depotproduit->save($data);

        unset($data);

        $sortie = [
            'id' => null,
            'operation' => 1,
            'date' => date('Y-m-d'),
            'produit_id' => $produit_id,
            'depot_source_id' => $depot_id,
            'date_sortie' => date('Y-m-d'),
            'paquet_source' => $paquet_sortie,
            'stock_source' => $quantite_sortie,
            'total_general' => $total_sortie,
        ];

        $this->loadModel('Mouvement');

        if ($this->Mouvement->save($sortie)) {
            unset($sortie);

            return true;
        } else {
            return false;
        }
    }

    public function entree($produit_id = null, $depot_id = 1, $paquet_entree = 0, $quantite_entree = 0, $total_entree = 0)
    {
        $this->loadModel('Mouvement');
        $source = $this->Mouvement->Produit->Depotproduit->find('first', [
            'conditions' => [
                'depot_id' => $depot_id,
                'produit_id' => $produit_id,
            ],
        ]);

        $this->loadModel('Entree');
        $donnees['Entree'] = [
            'quantite' => $quantite_entree,
            'depot_id' => $depot_id,
            'produit_id' => $produit_id,
            'type' => 'Entree',
        ];
        $this->Entree->save($donnees);

        $ancienne_paquet = (isset($source['Depotproduit']['id']) and !empty($source['Depotproduit']['paquet'])) ? (int) $source['Depotproduit']['paquet'] : 0;
        $paquet = $ancienne_paquet + $paquet_entree;
        if ($paquet <= 0) {
            $paquet = 0;
        }

        $ancienne_quantite = (isset($source['Depotproduit']['id']) and !empty($source['Depotproduit']['quantite'])) ? (int) $source['Depotproduit']['quantite'] : 0;
        $quantite = $ancienne_quantite + $quantite_entree;
        if ($quantite <= 0) {
            $quantite = 0;
        }

        $ancienne_total = (isset($source['Depotproduit']['id']) and !empty($source['Depotproduit']['total'])) ? (int) $source['Depotproduit']['total'] : 0;
        $total = $ancienne_total + $total_entree;
        if ($total <= 0) {
            $total = 0;
        }

        $id = (isset($source['Depotproduit']['id'])) ? $source['Depotproduit']['id'] : null;

        // Entrée
        $entree = [
            'id' => null,
            'operation' => -1,
            'date' => date('Y-m-d'),
            'produit_id' => $produit_id,
            'paquet_source' => $paquet_entree,
            'stock_source' => $quantite_entree,
            'total_general' => $total_entree,
            'depot_source_id' => $depot_id,
        ];

        $this->Mouvement->save($entree);

        $data['Depotproduit'] = [
            'id' => $id,
            'depot_id' => 1,
            'date' => date('Y-m-d'),
            'produit_id' => $produit_id,
            'quantite' => $quantite,
            'paquet' => $paquet,
            'total' => $total,
        ];

        if ($this->Mouvement->Produit->Depotproduit->save($data)) {
            unset($entree);
            unset($data);

            return true;
        } else {
            return false;
        }
    }

    public function mail($bonretourachat_id = null)
    {
        $boncommande = $this->Bonretourachat->find('first', ['contain' => ['Fournisseur'], 'conditions' => ['Bonretourachat.id' => $bonretourachat_id]]);
        $email = (isset($boncommande['Fournisseur']['email']) and !empty($boncommande['Fournisseur']['email'])) ? $boncommande['Fournisseur']['email'] : '';
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Email']['bonretourachat_id'] = $bonretourachat_id;
            if ($this->Bonretourachat->Email->save($this->request->data)) {
                $url = $this->generatepdf($bonretourachat_id);
                $email_id = $this->Bonretourachat->Email->id;
                if ($this->Bonretourachat->Email->saveField('url', $url)) {
                    $settings = $this->GetParametreSte();
                    $to = [$this->data['Email']['email']];
                    $objet = (isset($this->data['Email']['objet'])) ? $this->data['Email']['objet'] : '';
                    $content = (isset($this->data['Email']['content'])) ? $this->data['Email']['content'] : '';
                    $attachments = ['Bonretourachat' => ['mimetype' => 'application/pdf', 'file' => $url]];
                    if ($this->sendEmail($settings, $objet, $content, $to, $attachments)) {
                        $this->Session->setFlash('Votre email a été anvoyer avec succès.', 'alert-success');
                    } else {
                        $this->Session->setFlash("Problème d'envoi de mail", 'alert-danger');
                    }
                }
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }

        $this->set(compact('email'));
        $this->layout = false;
    }

    public function calculatriceboncommande($boncommande_id = null)
    {
        $this->loadModel('Boncommande');
        $boncommande = $this->Boncommande->find('first', ['conditions' => ['id' => $boncommande_id]]);
        $remise = (isset($boncommande['Boncommande']['remise']) and !empty($boncommande['Boncommande']['remise'])) ? (float) $boncommande['Boncommande']['remise'] : 0;
        $details = $this->Boncommande->Boncommandedetail->find('all', ['contain' => ['Produit'], 'conditions' => ['boncommande_id' => $boncommande_id]]);
        $avances = $this->Boncommande->Avance->find('all', ['conditions' => ['boncommande_id' => $boncommande_id]]);
        $societe = $this->GetSociete();
        /* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
        $division_tva = (1+$tva/100); */

        $total_qte = 0;
        $total_paquet = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $tva = 0;
        foreach ($details as $k => $value) {
            $total_qte = $total_qte + $value['Boncommandedetail']['qte'];
            $total_paquet = $total_paquet + $value['Boncommandedetail']['paquet'];
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Boncommandedetail']['ttc'];
            $tva += (isset($value['Produit']['tva_vente']) and !empty($value['Produit']['tva_vente'])) ? (int) $value['Produit']['tva_vente'] : 0;
        }
        $division_tva = (1 + $tva / 100);
        $total_a_payer_ht = round($total_a_payer_ttc / $division_tva, 2);
        $reduction = ($total_a_payer_ht >= 0) ? (float) ($total_a_payer_ht * $remise) / 100 : 0;
        $montant_tva = round($total_a_payer_ht * $tva / 100, 2);

        $total_paye = 0;
        foreach ($avances as $k => $value) {
            $total_paye = $total_paye + $value['Avance']['montant'];
        }

        $total_apres_reduction = ($total_a_payer_ht - $reduction) + $montant_tva;

        $reste_a_payer = $total_apres_reduction - $total_paye;
        $reste_a_payer = ($reste_a_payer <= 0) ? 0 : $reste_a_payer;

        $data['Boncommande'] = [
            'id' => $boncommande_id,
            'reduction' => $reduction,
            'total_qte' => $total_qte,
            'total_paye' => $total_paye,
            'montant_tva' => $montant_tva,
            'total_paquet' => $total_paquet,
            'reste_a_payer' => $reste_a_payer,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
        ];

        if ($this->Boncommande->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function calculatrice($bonretourachat_id = null)
    {
        $bonreception = $this->Bonretourachat->find('first', ['conditions' => ['id' => $bonretourachat_id]]);
        $remise = (isset($bonreception['Bonretourachat']['remise']) and !empty($bonreception['Bonretourachat']['remise'])) ? (float) $bonreception['Bonretourachat']['remise'] : 0;
        $details = $this->Bonretourachat->Bonretourachatdetail->find('all', ['contain' => ['Produit'], 'conditions' => ['bonretourachat_id' => $bonretourachat_id]]);
        //$avances = $this->Bonretourachat->Avance->find('all',['conditions' => ['bonretourachat_id' => $bonretourachat_id]]);
        $societe = $this->GetSociete();
        /* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
        $division_tva = (1+$tva/100); */

        $total_qte = 0;
        $total_paquet = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $tva = 0;
        foreach ($details as $k => $value) {
            $total_qte = $total_qte + $value['Bonretourachatdetail']['qte'];
            $total_paquet = $total_paquet + $value['Bonretourachatdetail']['paquet'];
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Bonretourachatdetail']['ttc'];
            $tva += (isset($value['Produit']['tva_vente']) and !empty($value['Produit']['tva_vente'])) ? (int) $value['Produit']['tva_vente'] : 0;
        }
        $division_tva = (1 + $tva / 100);
        $total_a_payer_ht = round($total_a_payer_ttc / $division_tva, 2);
        $reduction = ($total_a_payer_ht >= 0) ? (float) ($total_a_payer_ht * $remise) / 100 : 0;
        $montant_tva = round($total_a_payer_ht * $tva / 100, 2);

        $total_paye = 0;
        foreach ($details as $k => $value) {
            $total_paye = $total_paye + $value['Bonretourachatdetail']['ttc'];
        }

        $total_apres_reduction = ($total_a_payer_ht - $reduction) + $montant_tva;

        $reste_a_payer = $total_apres_reduction - $total_paye;
        $reste_a_payer = ($reste_a_payer <= 0) ? 0 : $reste_a_payer;

        $data['Bonretourachat'] = [
            'id' => $bonretourachat_id,
            'reduction' => $reduction,
            'total_qte' => $total_qte,
            'total_paye' => $total_paye,
            'montant_tva' => $montant_tva,
            'total_paquet' => $total_paquet,
            'reste_a_payer' => $reste_a_payer,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
        ];

        if ($this->Bonretourachat->save($data)) {
            if (isset($bonreception['Bonretourachat']['boncommande_id']) and !empty($bonreception['Bonretourachat']['boncommande_id'])) {
                $this->Bonretourachat->Avance->updateAll(['Avance.boncommande_id' => $bonreception['Bonretourachat']['boncommande_id']], ['Avance.bonretourachat_id' => $bonretourachat_id]);
                $this->calculatriceboncommande($bonreception['Bonretourachat']['boncommande_id']);
            }

            return true;
        } else {
            return false;
        }
    }

    public function generatepdf($bonretourachat_id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonretourachat->exists($bonretourachat_id)) {
            $options = ['contain' => ['Fournisseur' => ['Ville']], 'conditions' => ['Bonretourachat.'.$this->Bonretourachat->primaryKey => $bonretourachat_id]];
            $data = $this->Bonretourachat->find('first', $options);

            $details = $this->Bonretourachat->Bonretourachatdetail->find('all', [
                'conditions' => ['Bonretourachatdetail.bonretourachat_id' => $bonretourachat_id],
                'contain' => ['Produit'],
            ]);
        }
        $societe = $this->GetSociete();

        App::uses('LettreHelper', 'View/Helper');
        $LettreHelper = new LettreHelper(new View());

        $view = new View($this, false);
        $style = $view->element('style', ['societe' => $societe]);
        $header = $view->element('header', ['societe' => $societe, 'title' => 'BON DE COMMANDE']);
        $footer = $view->element('footer', ['societe' => $societe]);
        $ville = (isset($data['Fournisseur']['Ville']['libelle'])) ? $data['Fournisseur']['Ville']['libelle'] : '';

        $html = '
		<html>
			<head>
				<title>Bon de commande</title>
			    '.$style.'
			</head>
			<body>

			    '.$header.'

			    <table class="info" width="100%">
			        <tbody>
			            <tr>
			                <td style="width:60%;text-align:center;">
			                    <h4 class="container" style="width:50%;">BON DE COMMANDE N° : <br/>'.$data['Bonretourachat']['reference'].'</h4>
			                </td>
			                <td style="width:40%;text-align:center;">
			                    <h4 class="container" style="width:80%;">DATE : '.$data['Bonretourachat']['date'].'</h4>
			                </td>
			            </tr>
			            <tr>
			                <td style="width:60%;text-align:center;"></td>
			                <td style="width:40%;text-align:left;border:1px solid black;border-radius: 15px;">
			                    <h4>
			                    '.strtoupper($data['Fournisseur']['designation']).'<br/>
			                    '.strtoupper($data['Fournisseur']['adresse']).'<br/>
			                    '.$ville.'<br/><br/>
			                    ICE : '.strtoupper($data['Fournisseur']['ice']).'
			                    </h4>
			                </td>
			            </tr>
			        </tbody>
			    </table><br/><br/>

			    <table class="details" width="100%">
			        <thead>
			            <tr>
			                <th>Désignation </th>
			                <th>Quantité </th>
			                <th>Prix TTC</th>
			                <th>Remise(%) </th>
			                <th>Montant total TTC</th>
			            </tr>
			        </thead>
			        <tbody>';
        foreach ($details as $tache) {
            $html .= '<tr>
			                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
			                    <td nowrap style="text-align:right;">'.$tache['Bonretourachatdetail']['qte'].'</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Bonretourachatdetail']['prix_vente'], 2, ',', ' ').'</td>
			                    <td nowrap style="text-align:right;">'.(int) $tache['Bonretourachatdetail']['remise'].'%</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Bonretourachatdetail']['total'], 2, ',', ' ').'</td>
			                </tr>';
        }
        $html .= '
			                <tr class="hide_total">
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="hide_total">TOTAL HT</td>
			                    <td class="hide_total">'.number_format($this->data['Bonretourachat']['total_a_payer_ht'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">TOTAL TVA ('.(int) $societe['Societe']['tva'].'%)</td>
			                    <td class="total">'.number_format($this->data['Bonretourachat']['montant_tva'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">NET A PAYER</td>
			                    <td class="total">'.number_format($this->data['Bonretourachat']['total_a_payer_ttc'], 2, ',', ' ').'</td>
			                </tr>
			        </tbody>
			    </table><br/>

			    <table width="100%">
			        <tbody>
			            <tr>
			                <td style="width:60%;text-align:left;font-weight:bold;">
			                    <u>Arrêtée la présente bon de commande à la somme de :</u>
			                </td>
			                <td style="width:40%;text-align:left;font-weight:bold;">
			                    '.strtoupper($LettreHelper->NumberToLetter(strval($total))).' DHS
			                </td>
			            </tr>
			        </tbody>
			    </table><br/>

			    '.$footer.'

			</body>
		</html>';

        //echo $html;die;
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();

        $output = $dompdf->output();
        $destination = WWW_ROOT.'pdfs';
        if (!file_exists($destination)) {
            mkdir($destination, true, 0700);
        }
        file_put_contents($destination.DS.'Bonretourachat.'.$data['Bonretourachat']['date'].'-'.$data['Bonretourachat']['id'].'.pdf', $output);

        return $destination.DS.'Bonretourachat.'.$data['Bonretourachat']['date'].'-'.$data['Bonretourachat']['id'].'.pdf';
    }
}
