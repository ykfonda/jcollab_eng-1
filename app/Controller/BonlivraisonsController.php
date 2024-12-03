<?php

App::import('Vendor', 'dompdf', ['file' => 'dompdf'.DS.'dompdf_config.inc.php']);
class BonlivraisonsController extends AppController
{
    public $idModule = 85;

    public function index()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');
        $depots = $this->Session->read('depots');

        $depots = $this->Bonlivraison->Depot->findList(['Depot.vente' => 1, 'Depot.id' => $depots]);
        $clients = $this->Bonlivraison->Client->findList();
        $users = $this->Bonlivraison->User->findList();
        $this->set(compact('users', 'clients', 'user_id', 'role_id', 'admins', 'depots'));
        $this->getPath($this->idModule);
    }

    public function factureBls()
    {
        if ($this->request->is(['post', 'put'])) {
            $conditions = ['conditions' => ['Bonlivraison.type' => 'Expedition', 'Bonlivraison.date >=' => date('Y-m-d', strtotime($this->request->data['Bonlivraison']['date_debut'])), 'Bonlivraison.date <=' => date('Y-m-d H:i:s', strtotime($this->request->data['Bonlivraison']['date_fin'].' 23:59:59'))]];
            $bls = $this->Bonlivraison->find('all', $conditions);
            $depot_id = $this->Session->read('Auth.User.depot_id');
            $selected_store = $this->Session->read('Auth.User.StoreSession.id');
            $this->loadModel('Depot');
            $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
            'fields' => ['id'], ]);
            //$options = array('conditions' => array('Bonlivraison.id' => $bonlivraison_id));
            //$bonlivraison = $this->Bonlivraison->find('first', $options);
            $details = $this->Bonlivraison->Bonlivraisondetail->find('all', ['contain' => ['Bonlivraison'], 'conditions' => ['Bonlivraison.depot_id' => $depots, 'Bonlivraison.date >=' => date('Y-m-d', strtotime($this->request->data['Bonlivraison']['date_debut'])), 'Bonlivraison.date <=' => date('Y-m-d H:i:s', strtotime($this->request->data['Bonlivraison']['date_fin'].' 23:59:59'))]]);
            //$avances = $this->Bonlivraison->Avance->find('all',['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
            $bonlivraison = $bls[0];
            $data['Facture'] = [
                'etat' => 2,
                'id' => null,
                //'bonlivraison_id' => $bonlivraison_id,
                //'paye' => $bonlivraison['Bonlivraison']['paye'],
                'date' => date('Y-m-d'),
                //'user_id' => $bonlivraison['Bonlivraison']['user_id'],
                'depot_id' => $bonlivraison['Bonlivraison']['depot_id'],
                //'montant_tva' => $bonlivraison['Bonlivraison']['montant_tva'],
                'active_remise' => $bonlivraison['Bonlivraison']['active_remise'],
                //'client_id' => $bonlivraison['Bonlivraison']['client_id'],
                /* 'total_qte' => $bonlivraison['Bonlivraison']['total_qte'],
                'total_paye' => $bonlivraison['Bonlivraison']['total_paye'],
                'total_paquet' => $bonlivraison['Bonlivraison']['total_paquet'],
                'reste_a_payer' => $bonlivraison['Bonlivraison']['reste_a_payer'],
                'total_a_payer_ht' => $bonlivraison['Bonlivraison']['total_a_payer_ht'],
                'total_a_payer_ttc' => $bonlivraison['Bonlivraison']['total_a_payer_ttc'],
                'total_apres_reduction' => $bonlivraison['Bonlivraison']['total_apres_reduction'], */
            ];

            $remise = 0;
            $montant_tva = 0;
            foreach ($bls as $key => $value) {
                $remise += $bonlivraison['Bonlivraison']['remise'];
                $montant_tva += $bonlivraison['Bonlivraison']['montant_tva'];

                $avances = $this->Bonlivraison->Avance->find('all', ['conditions' => ['bonlivraison_id' => $value['Bonlivraison']['id']]]);
                $data['Avance'] = [];
                foreach ($avances as $key => $value) {
                    $data['Avance'][] = [
                    'id' => $value['Avance']['id'],
                ];
                }
            }
            $data['Facturedetail'] = [];
            foreach ($details as $key => $value) {
                $data['Facturedetail'][] = [
                    'id' => null,
                    'depot_id' => $depot_id,
                    'ttc' => $value['Bonlivraisondetail']['ttc'],
                    'qte' => $value['Bonlivraisondetail']['qte'],
                    'total' => $value['Bonlivraisondetail']['total'],
                    'paquet' => $value['Bonlivraisondetail']['paquet'],
                    'prix_vente' => $value['Bonlivraisondetail']['prix_vente'],
                    'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                    'total_unitaire' => $value['Bonlivraisondetail']['total_unitaire'],
                    'montant_remise' => $value['Bonlivraisondetail']['montant_remise'],
                    'remise' => $value['Bonlivraisondetail']['remise'],
                ];
            }

            $data['Facture'] = array_merge($data['Facture'], ['remise' => $remise, 'montant_tva' => $montant_tva]);

            if ($this->Bonlivraison->Facture->saveAssociated($data)) {
                $facture_id = $this->Bonlivraison->Facture->id;
                App::import('Controller', 'Factures');
                $facture = new FacturesController();

                $facture->calculatrice($facture_id);
                /* $this->Bonlivraison->id = $bonlivraison_id;WX4FG

                if( $this->Bonlivraison->saveField('facture_id',$facture_id) ); */
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }
        $this->layout = false;
    }

    public function getclient($client_id = null)
    {
        /* $req = $this->Bonlivraison->Client->find('first',['conditions' => ['id'=>$client_id]]);
        $remise = ( isset( $req['Client']['id'] ) AND !empty( $req['Client']['remise'] ) ) ? (float) $req['Client']['remise'] : 0 ;
     */    $this->loadModel('Remiseclient');
        $remisegloable = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'globale']]);

        if (isset($remisegloable['Remiseclient']['id'])) {
            $remise = intval($remisegloable['Remiseclient']['montant']);
        } else {
            $remise = 0;
        }
        die(json_encode($remise));
    }

    public function loadquatite($depot_id = null, $produit_id = null)
    {
        $req = $this->Bonlivraison->Bonlivraisondetail->Produit->Depotproduit->find('first', ['contain' => ['Produit'], 'conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);
        $total = (isset($req['Depotproduit']['total']) and !empty($req['Depotproduit']['total'])) ? (float) $req['Depotproduit']['total'] : 0;
        $quantite = (isset($req['Depotproduit']['quantite']) and !empty($req['Depotproduit']['quantite'])) ? (float) $req['Depotproduit']['quantite'] : 0;
        $paquet = (isset($req['Depotproduit']['paquet']) and !empty($req['Depotproduit']['paquet'])) ? (float) $req['Depotproduit']['paquet'] : 0;
        $prix_vente = (isset($req['Produit']['prix_vente']) and !empty($req['Produit']['prix_vente'])) ? (float) $req['Produit']['prix_vente'] : 0;
        die(json_encode(['quantite' => $quantite, 'paquet' => $paquet, 'prix_vente' => $prix_vente, 'total' => $total]));
    }

    public function indexAjax()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');

        if (in_array($role_id, $admins)) {
            $conditions = [];
        } else {
            $conditions['Bonlivraison.user_c'] = $user_id;
        }

        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Bonlivraison.reference') {
                    $conditions['Bonlivraison.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Bonlivraison.date1') {
                    $conditions['Bonlivraison.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Bonlivraison.date2') {
                    $conditions['Bonlivraison.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
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

        $conditions[] = [
            [
                'Bonlivraison.depot_id' => $depots,
            ],
        ];

        $this->Bonlivraison->recursive = -1;
        $settings = [
            'contain' => ['Creator', 'User', 'Client' => ['Ville']],
            'order' => ['Bonlivraison.date' => 'DESC', 'Bonlivraison.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $bonlivraisons = $this->Bonlivraison->find('all', $settings);
        $this->Paginator->settings = $settings;
        $taches = $this->Paginator->paginate();
        $this->set(compact('taches', 'user_id', 'bonlivraisons'));
        $this->layout = false;
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

                $produit = $this->Bonlivraison->Bonlivraisondetail->Produit->find('first', ['fields' => ['id', 'prix_vente', 'stockactuel', 'unite_id', 'prixachat'], 'conditions' => ['Produit.type' => 2, 'Produit.code_barre' => $code_article]]);
                if (!isset($produit['Produit']['id'])) {
                    $response['message'] = 'Code a barre incorrect produit introuvable !';
                }

                $produit = $this->Bonlivraison->Bonlivraisondetail->Produit->find('first', [
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

    public function edit($id = null)
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');
        $depots = $this->Session->read('depots');
        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['Module.libelle' => 'Remise']]);

        $permission = $this->getPermissionByModule($module['Module']['id']);

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Bonlivraison']['active_remise'] = (isset($this->request->data['Bonlivraison']['active_remise']) and !empty($this->request->data['Bonlivraison']['active_remise'])) ? 1 : -1;
            if ($this->request->data['Bonlivraison']['active_remise'] == -1) {
                $this->request->data['Bonlivraison']['remise'] = 0;
            }
            if ($this->Bonlivraison->save($this->request->data)) {
                if (isset($this->request->data['Bonlivraison']['id']) and !empty($this->request->data['Bonlivraison']['id'])) {
                    $this->calculatrice($this->request->data['Bonlivraison']['id']);
                }
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Bonlivraison->id]);
            } else {
                $this->generateFlashes();
                //$this->Session->setFlash($this->Bonlivraison->error,'alert-danger');
                //$this->Session->setFlash('Il y a un problème','alert-danger');
                return $this->redirect(['action' => 'index']);
            }
        } elseif ($this->Bonlivraison->exists($id)) {
            $options = ['conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);
        }

        $depots = $this->Bonlivraison->Depot->findList([/* 'Depot.vente'=>1, */'Depot.id' => $depots]);
        $clients = $this->Bonlivraison->Client->findList();
        $users = $this->Bonlivraison->User->findList();
        $this->set(compact('permission', 'users', 'clients', 'user_id', 'role_id', 'admins', 'depots'));
        $this->layout = false;
    }

    public function editstatut($bonlivraison_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Bonlivraison->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonlivraison->exists($bonlivraison_id)) {
            $options = ['conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $bonlivraison_id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);
        }
        $this->layout = false;
    }

    public function reduction($bonlivraison_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Bonlivraison->save($this->request->data)) {
                $this->calculatrice($bonlivraison_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonlivraison->exists($bonlivraison_id)) {
            $options = ['conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $bonlivraison_id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);
        }
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Bonlivraison->id = $id;
        if (!$this->Bonlivraison->exists()) {
            throw new NotFoundException(__('Invalide bon de livraison'));
        }

        if ($this->Bonlivraison->delete()) {
            $this->Bonlivraison->Bonlivraisondetail->updateAll(['Bonlivraisondetail.deleted' => 1], ['Bonlivraisondetail.bonlivraison_id' => $id]);
            $this->Bonlivraison->Avance->updateAll(['Avance.deleted' => 1], ['Avance.bonlivraison_id' => $id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null, $bonlivraison_id = null)
    {
        $this->Bonlivraison->Bonlivraisondetail->id = $id;
        if (!$this->Bonlivraison->Bonlivraisondetail->exists()) {
            throw new NotFoundException(__('Invalide article'));
        }

        if ($this->Bonlivraison->Bonlivraisondetail->flagDelete()) {
            $this->calculatrice($bonlivraison_id);
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
        //$depot_id = $this->Session->read('Auth.User.depot_id');

        $details = [];
        $avances = [];
        if ($this->Bonlivraison->exists($id)) {
            $options = ['contain' => ['Fournisseur', 'Client', 'User', 'Depot'], 'conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);

            /* $this->loadModel("Depot");
            $depot = $this->Depot->find('first', ["contain" => ["Store"],"conditions" => ["Depot.id" => $this->request->data["Bonlivraison"]["depot_source_id"]]]);

            $this->loadModel("Store");
            $store = $this->Store->find('first', ["contain" => "Societe","conditions" => ["Store.id" => $depot["Store"]["id"]]]);

            $this->loadModel("Societe");
            $societe = $this->Societe->find('first', ["contain" => "Client","conditions" => ["Societe.id" => $store["Societe"]["id"]]]);
                 */
            //var_dump($societe);die();
            //$this->request->data["Client"]["designation"] = $societe["Client"]["designation"];

            if ($this->request->data['Bonlivraison']['type'] == 'Expedition') {
                /*  $store_id = $this->request->data["Depot"]["store_id"];
                 $this->loadModel("Store");
                 $store = $this->Store->find('first',[
                     'conditions' => ['id' => $store_id]]); */
                //dans le cas expedition, montrer le stock des produits selon le depot source de la sortie
                $depot_source = $this->request->data['Bonlivraison']['depot_source_id'];
                $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                    'fields' => ['Produit.*', 'Bonlivraisondetail.*', 'Depotproduit.*'],
                    'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $id],
                    'joins' => [
                            ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Bonlivraisondetail.produit_id', 'Produit.deleted = 0']],
                        ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.depot_id' => $depot_source, 'Depotproduit.produit_id = Produit.id']],
                    ],
                    'group' => ['Bonlivraisondetail.id'],
                ]);
            } else {
                $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                'fields' => ['Produit.*', 'Bonlivraisondetail.*', 'Depotproduit.*'],
                'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $id],
                'joins' => [
                    ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Bonlivraisondetail.produit_id', 'Produit.deleted = 0']],
                    ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.depot_id = Bonlivraisondetail.depot_id', 'Depotproduit.produit_id = Produit.id']],
                ],
                'group' => ['Bonlivraisondetail.id'],
            ]);
            }

            $avances = $this->Bonlivraison->Avance->find('all', [
                'conditions' => ['Avance.bonlivraison_id' => $id],
                'order' => ['date ASC'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        $produits = $this->Bonlivraison->Bonlivraisondetail->Produit->findList();

        if ($this->request->data['Bonlivraison']['type'] == 'Expedition') {
            $this->set(compact('store', 'produits', 'details', 'role_id', 'user_id', 'avances'));
        } else {
            $this->set(compact('produits', 'details', 'role_id', 'user_id', 'avances'));
        }
        $this->getPath($this->idModule);
    }

    public function getProduitByDepot($bonlivraison_id = null, $depot_id = null, $categorieproduit_id = null)
    {
        $produits_exists = $this->Bonlivraison->Bonlivraisondetail->Produit->find('list', [
            'fields' => ['Produit.id', 'Produit.id'],
            'joins' => [
                ['table' => 'bonlivraisondetails', 'alias' => 'Bonlivraisondetail', 'type' => 'INNER', 'conditions' => ['Bonlivraisondetail.produit_id = Produit.id']],
            ],
            'conditions' => [
                'Bonlivraisondetail.deleted' => 0,
                'Bonlivraisondetail.depot_id' => $depot_id,
                'Bonlivraisondetail.bonlivraison_id' => $bonlivraison_id,
            ],
        ]);

        $produits = $this->Bonlivraison->Bonlivraisondetail->Produit->findList([
            'Produit.categorieproduit_id' => $categorieproduit_id,
            'Depotproduit.depot_id' => $depot_id,
            'Depotproduit.quantite >' => 0,
        ]);

        die(json_encode($produits));
    }

    public function getproduit($produit_id = null, $depot_id = null, $client_id = null)
    {
        $produit = $this->Bonlivraison->Bonlivraisondetail->Produit->find('first', [
            'fields' => ['Produit.id', 'Produit.prix_vente', 'Produit.tva_vente', 'Depotproduit.id', 'Depotproduit.quantite'],
            'conditions' => [
                'Produit.id' => $produit_id,
                /* 'Depotproduit.depot_id'=>$depot_id, */
            ],
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id', 'Depotproduit.deleted = 0']],
            ],
        ]);
        $tva = (isset($produit['Produit']['id']) and !empty($produit['Produit']['tva_vente'])) ? $produit['Produit']['tva_vente'] : 20;
        $prix_vente = (isset($produit['Produit']['prix_vente']) and !empty($produit['Produit']['prix_vente'])) ? $produit['Produit']['prix_vente'] : 0;
        $quantite = (isset($produit['Depotproduit']['id']) and !empty($produit['Depotproduit']['quantite'])) ? $produit['Depotproduit']['quantite'] : 0;
        //add
        $this->loadModel('Remiseclient');
        $remisearticle = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'article', 'produit_id' => $produit_id]]);
        $remisecategories = $this->Remiseclient->find('all', ['conditions' => ['client_id' => $client_id, 'type' => 'categorie']]);
        $remisegloable = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'globale']]);
        $remise = 0;

        if (!isset($remisegloable['Remiseclient']['id'])) {
            if (isset($remisearticle['Remiseclient']['id'])) {
                $remise = floatval($remisearticle['Remiseclient']['montant']);
            } elseif (isset($remisecategories[0]['Remiseclient']['id'])) {
                $produit = $this->Bonlivraison->Bonlivraisondetail->Produit->find('first', ['conditions' => ['id' => $produit_id]]);

                foreach ($remisecategories as $remisecategorie) {
                    if ($produit['Produit']['categorieproduit_id'] == $remisecategorie['Remiseclient']['categorie_id']) {
                        $remise = floatval($remisecategorie['Remiseclient']['montant']);
                    }
                }
            }
        }

        die(json_encode(['tva' => $tva, 'prix_vente' => $prix_vente, 'quantite' => $quantite, 'remise' => $remise]));
    }

    public function journal()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');

        $options['Bonretour.etat'] = 2;
        $options['Bonretour.date'] = date('Y-m-d');
        $this->loadModel('Bonretour');
        $retours = $this->Bonretour->find('all', [
            'conditions' => $options,
            'contain' => ['Client'],
        ]);

        $conditions['Bonlivraison.etat'] = 2;
        $conditions['Bonlivraison.date'] = date('Y-m-d');

        $avances = $this->Bonlivraison->Avance->find('first', [
            'fields' => ['SUM(Avance.montant) as paiment'],
            'conditions' => ['Avance.date' => date('Y-m-d')],
            'joins' => [
                ['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id', 'Bonlivraison.deleted = 0']],
            ],
        ]);

        $total_avance = (isset($avances[0]['paiment'])) ? (float) $avances[0]['paiment'] : 0;

        $reglements = $this->Bonlivraison->Avance->find('all', [
            'fields' => ['SUM(Avance.montant) as paiment', 'Avance.mode'],
            'conditions' => ['Avance.date' => date('Y-m-d')],
            'joins' => [
                ['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id', 'Bonlivraison.deleted = 0']],
            ],
            'group' => ['Avance.mode'],
        ]);

        $groupements = [];
        $modes = [1 => 'Chèque', 2 => 'Espèce', 3 => 'Virement', 5 => 'Effet'];
        foreach ($reglements as $key => $value) {
            $groupements[$value['Avance']['mode']] = [
                'montant' => (isset($value[0]['paiment'])) ? (float) $value[0]['paiment'] : 0,
                'mode' => (isset($modes[$value['Avance']['mode']])) ? $modes[$value['Avance']['mode']] : 'Indéfinie',
            ];
        }

        $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
            'conditions' => $conditions,
            'contain' => ['Produit'],
            'joins' => [
                ['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Bonlivraisondetail.bonlivraison_id', 'Bonlivraison.deleted = 0']],
            ],
        ]);

        $req = $this->Bonlivraison->find('first', [
            'fields' => ['SUM(total_paye) as total_paye', 'SUM(reste_a_payer) as reste_a_payer', 'SUM(total_apres_reduction) as total_apres_reduction'],
            'conditions' => $conditions,
        ]);

        $bonlivraisons = $this->Bonlivraison->find('all', [
            'conditions' => $conditions,
            'contain' => ['Client'],
        ]);

        $total_paye = (isset($req[0]['total_paye']) and !empty($req[0]['total_paye'])) ? (float) $req[0]['total_paye'] : 0;
        $reste_a_payer = (isset($req[0]['reste_a_payer']) and !empty($req[0]['reste_a_payer'])) ? (float) $req[0]['reste_a_payer'] : 0;
        $total_apres_reduction = (isset($req[0]['total_apres_reduction']) and !empty($req[0]['total_apres_reduction'])) ? (float) $req[0]['total_apres_reduction'] : 0;

        $societe = $this->GetSociete();
        $this->set(compact('details', 'role_id', 'user_id', 'societe', 'total_paye', 'reste_a_payer', 'total_apres_reduction', 'bonlivraisons', 'groupements', 'total_avance', 'retours'));
        $this->layout = false;
    }

    public function ticket($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonlivraison->exists($id)) {
            $options = ['contain' => ['User', 'Client' => ['Ville']], 'conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);

            $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $id],
                'contain' => ['Depot', 'Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        // if ( empty( $details ) ) {
        // 	$this->Session->setFlash('Opération impossible : Aucun produit saisie ! ','alert-danger');
        // 	return $this->redirect( $this->referer() );
        // }

        $societe = $this->GetSociete();
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }

    public function pdf($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonlivraison->exists($id)) {
            $options = ['contain' => ['User', 'Client' => ['Ville']], 'conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->find('first', $options);

            $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $id],
                'contain' => ['Depot', 'Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        if (empty($details)) {
            $this->Session->setFlash('Opération impossible : Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $societe = $this->GetSociete();
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }

    public function editavance($id = null, $bonlivraison_id = null)
    {
        $bonlivraison = $this->Bonlivraison->find('first', ['conditions' => ['id' => $bonlivraison_id]]);
        $reste_a_payer = (isset($bonlivraison['Bonlivraison']['reste_a_payer'])) ? $bonlivraison['Bonlivraison']['reste_a_payer'] : 0;
        $client_id = (isset($bonlivraison['Bonlivraison']['client_id'])) ? $bonlivraison['Bonlivraison']['client_id'] : null;
        $user_id = $this->Session->read('Auth.User.id');
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Avance']['user_id'] = $user_id;
            $this->request->data['Avance']['bonlivraison_id'] = $bonlivraison_id;
            $this->request->data['Avance']['client_id'] = $client_id;
            if ($this->Bonlivraison->Avance->save($this->request->data)) {
                $this->calculatrice($bonlivraison_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonlivraison->Avance->exists($id)) {
            $options = ['conditions' => ['Avance.'.$this->Bonlivraison->Avance->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->Avance->find('first', $options);
        }

        $this->set(compact('reste_a_payer'));
        $this->layout = false;
    }

    public function deleteavance($id = null, $bonlivraison_id = null)
    {
        $this->Bonlivraison->Avance->id = $id;
        if (!$this->Bonlivraison->Avance->exists()) {
            throw new NotFoundException(__('Invalide Avance'));
        }

        if ($this->Bonlivraison->Avance->flagDelete()) {
            $this->calculatrice($bonlivraison_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function editdetail($id = null, $bonlivraison_id = null)
    {
        $bonlivraison = $this->Bonlivraison->find('first', ['conditions' => ['id' => $bonlivraison_id]]);
        $depot_id = (isset($bonlivraison['Bonlivraison']['depot_id'])) ? $bonlivraison['Bonlivraison']['depot_id'] : 1;
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');

        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['Module.libelle' => 'Remise']]);

        $permission = $this->getPermissionByModule($module['Module']['id']);

        $produits_exists = $this->Bonlivraison->Bonlivraisondetail->Produit->find('list', [
            'fields' => ['Produit.id', 'Produit.id'],
            'joins' => [
                ['table' => 'bonlivraisondetails', 'alias' => 'Bonlivraisondetail', 'type' => 'INNER', 'conditions' => ['Bonlivraisondetail.produit_id = Produit.id', 'Bonlivraisondetail.deleted = 0']],
            ],
            'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $bonlivraison_id],
        ]);

        $produits = $this->Bonlivraison->Bonlivraisondetail->Produit->findList([
            /* 'Depotproduit.depot_id'=>$depot_id, */
            'Produit.id !=' => $produits_exists,
        ]);

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Bonlivraisondetail']['bonlivraison_id'] = $bonlivraison_id;
            $this->request->data['Bonlivraisondetail']['ttc'] = $this->request->data['Bonlivraisondetail']['ttc'] - $this->request->data['Bonlivraisondetail']['montant_remise'];
            if ($this->Bonlivraison->Bonlivraisondetail->save($this->request->data)) {
                $this->calculatrice($bonlivraison_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bonlivraison->Bonlivraisondetail->exists($id)) {
            $options = ['conditions' => ['Bonlivraisondetail.'.$this->Bonlivraison->Bonlivraisondetail->primaryKey => $id]];
            $this->request->data = $this->Bonlivraison->Bonlivraisondetail->find('first', $options);
            $produits = $this->Bonlivraison->Bonlivraisondetail->Produit->findList();
        }

        $categorieproduits = $this->Bonlivraison->Bonlivraisondetail->Produit->Categorieproduit->find('list');
        $this->set(compact('permission', 'produits', 'role_id', 'depot_id', 'depots', 'categorieproduits'));
        $this->layout = false;
    }

    public function correction($produit_id = null, $depot_source_id = null)
    {
        $this->loadModel('Mouvement');
        $entree = $this->Mouvement->find('first', [
            'fields' => ['SUM(Mouvement.paquet_source) as paquet', 'SUM(Mouvement.stock_source) as quantite', 'SUM(Mouvement.total_general) as total'],
            'conditions' => [
                'depot_source_id' => $depot_source_id,
                'produit_id' => $produit_id,
                'operation' => -1,
            ],
        ]);

        $quantite_entree = (isset($entree[0]['quantite']) and !empty($entree[0]['quantite'])) ? (int) $entree[0]['quantite'] : 0;
        $paquet_entree = (isset($entree[0]['paquet']) and !empty($entree[0]['paquet'])) ? (int) $entree[0]['paquet'] : 0;
        $total_entree = (isset($entree[0]['total']) and !empty($entree[0]['total'])) ? (int) $entree[0]['total'] : 0;

        $sortie = $this->Mouvement->find('first', [
            'fields' => ['SUM(Mouvement.paquet_source) as paquet', 'SUM(Mouvement.stock_source) as quantite', 'SUM(Mouvement.total_general) as total'],
            'conditions' => [
                'depot_source_id' => $depot_source_id,
                'produit_id' => $produit_id,
                'operation' => 1,
            ],
        ]);

        $quantite_sortie = (isset($entree[0]['quantite']) and !empty($entree[0]['quantite'])) ? (int) $entree[0]['quantite'] : 0;
        $paquet_sortie = (isset($entree[0]['paquet']) and !empty($entree[0]['paquet'])) ? (int) $entree[0]['paquet'] : 0;
        $total_sortie = (isset($entree[0]['total']) and !empty($entree[0]['total'])) ? (int) $entree[0]['total'] : 0;

        $quantite = $quantite_entree - $quantite_sortie;
        $paquet = $paquet_entree - $paquet_sortie;
        $total = $total_entree - $total_sortie;

        $quantite = ($quantite <= 0) ? 0 : $quantite;
        $paquet = ($paquet <= 0) ? 0 : $paquet;
        $total = ($total <= 0) ? 0 : $total;

        $this->loadModel('Depotproduit');
        $depot = $this->Depotproduit->find('first', [
            'conditions' => [
                'depot_id' => $depot_source_id,
                'produit_id' => $produit_id,
            ],
        ]);

        $id = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['id'])) ? $depot['Depotproduit']['id'] : null;

        $data['Depotproduit'] = [
            'id' => $id,
            'date' => date('Y-m-d'),
            'depot_id' => $depot_source_id,
            'produit_id' => $produit_id,
            'quantite' => $quantite,
            'paquet' => $paquet,
            'total' => $total,
        ];

        if ($this->Depotproduit->save($data)) {
            return true;
        } else {
            return false;
        }
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
        $this->Entree->save($donnees);

        $ancienne_paquet = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['paquet'])) ? (int) $depot['Depotproduit']['paquet'] : 0;
        $paquet = $ancienne_paquet - $paquet_sortie;
        if ($paquet <= 0) {
            $paquet = 0;
        }

        $ancienne_quantite = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['quantite'])) ? $depot['Depotproduit']['quantite'] : 0;
        $quantite = $ancienne_quantite - $quantite_sortie;
        /* if( $quantite <= 0 ) $quantite = 0;

     */    $ancienne_total = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['total'])) ? (int) $depot['Depotproduit']['total'] : 0;
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

        /* $sortie = [
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

        if ( $this->Mouvement->save($sortie) ) {
            unset( $sortie );
            return true;
        } else return false; */
    }

    public function changestate($bonlivraison_id = null, $etat = -1)
    {
        $depot_id = $this->Session->read('Auth.User.depot_id');
        $bonlivraison = $this->Bonlivraison->find('first', ['contain' => ['User'], 'conditions' => ['Bonlivraison.id' => $bonlivraison_id]]);

        $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
            'fields' => ['Depotproduit.*', 'Produit.*', 'Bonlivraisondetail.*', 'Depot.*'],
            'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $bonlivraison_id],
            'contain' => ['Produit', 'Depot'],
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id', 'Depotproduit.depot_id = Depot.id']],
            ],
            'group' => ['Bonlivraisondetail.id'],
        ]);

        if (empty($details)) {
            $this->Session->setFlash('Opération impossible : Aucun produit saisie !', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $error = false;
        foreach ($details as $key => $value) {
            $stock_actuel = (isset($value['Depotproduit']['quantite']) and !empty($value['Depotproduit']['quantite'])) ? $value['Depotproduit']['quantite'] : 0;
            if ($stock_actuel < $value['Bonlivraisondetail']['qte']) {
                $error = true;
            }
        }

        /* 	if ( $etat == 2 AND $error ) {
                $this->Session->setFlash('Opération impossible stock insuffisant','alert-danger');
                return $this->redirect( $this->referer() );
            } */

        $this->Bonlivraison->id = $bonlivraison_id;
        if ($this->Bonlivraison->saveField('etat', $etat)) {
            $bonlivraison = $this->Bonlivraison->find('first', [
                'conditions' => ['id' => $bonlivraison_id], ]);

            if (isset($bonlivraison['Bonlivraison']['id']) and $bonlivraison['Bonlivraison']['etat'] == 2) { // Valider bon de livraison
                $this->Bonlivraison->id = $bonlivraison_id;
                $this->Bonlivraison->saveField('date', date('Y-m-d'));
            }
            if ($etat == 2) {
                if ($bonlivraison['Bonlivraison']['type'] == 'Expedition') {
                    /*  $data_expedition['Bonreception']['id'] = null;
                     $data_expedition['Bonreceptiondetail'] = [];
                     $data_expedition['Bonreception']['date'] = $bonlivraison['Bonlivraison']['date_u'];

                     $data_expedition['Bonreception']['depot_id'] = $bonlivraison['Bonlivraison']['depot_id'];
                     $data_expedition['Bonreception']['depot_source_id'] = $bonlivraison['Bonlivraison']['depot_source_id'];

                     $this->loadModel("Depot");
                     $societe_source = $this->Depot->find('first', [ "contain" => ["Societe"],'conditions' => ['Depot.id' => $bonlivraison['Bonlivraison']['depot_source_id']]]);

                     $data_expedition['Bonreception']['etat'] = -1;
                     $data_expedition['Bonreception']['type'] = "Expedition";
                     $data_expedition['Bonreception']['paye'] = -1;
                     $data_expedition['Bonreception']['fournisseur_id'] = $societe_source["Societe"]["fournisseur_id"];


                     $bonlivraisondet = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                     'conditions' => ['Bonlivraisondetail.bonlivraison_id'=>$bonlivraison_id],
                     'fields' => ['Produit.*','Bonlivraisondetail.*'],
                     'contain' => ['Produit'],
                ]);
                     foreach ($bonlivraisondet as $key => $value) {
                         $data_expedition['Bonreceptiondetail'][] = [
                         'id' => null,
                         'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                         'qte_cmd' => $value['Bonlivraisondetail']['qte'],
                         'qte' => $value['Bonlivraisondetail']['qte'],
                         'prix_vente' => $value['Produit']['prix_vente'],
                         "num_lot" => ""
                     ];
                         $this->sortie($value['Bonlivraisondetail']['produit_id'], $depot_id, $value['Bonlivraisondetail']['paquet'], $value['Bonlivraisondetail']['qte'], $value['Bonlivraisondetail']['total_unitaire']);
                     }
                     $this->loadModel('Bonreception');
                     if ($this->Bonreception->saveAssociated($data_expedition)) {
                         $total = 0;
                         $id = $this->Bonreception->getLastInsertId();
                         $options = array('contain'=>['Fournisseur','Depot'],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
                         $this->request->data = $this->Bonreception->find('first', $options);

                         $details_r = $this->Bonreception->Bonreceptiondetail->find('all', [
                         'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
                         'fields' => ['Produit.*','Bonreceptiondetail.*'],
                         'contain' => ['Produit'],
                     ]);
                         for ($i = 0; $i < count($details); $i++) {
                             $details_r[$i]["Bonreceptiondetail"]["total"] = $details_r[$i]["Bonreceptiondetail"]["prix_vente"] * $details_r[$i]["Bonreceptiondetail"]["qte"];

                             $this->Bonreception->Bonreceptiondetail->id = $details_r[$i]["Bonreceptiondetail"]["id"];
                             $this->Bonreception->Bonreceptiondetail->savefield("total", $details_r[$i]["Bonreceptiondetail"]["total"]);
                         }
                         App::import('Controller', 'Bonreceptions');
                         $Bonreceptions = new BonreceptionsController;
                         $Bonreceptions->calculatrice($id);


                         $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                     } */
                } else {
                    foreach ($details as $key => $value) {
                        //add
                        $mouvement[] = [
                            'id' => null,
                            'operation' => 4,
                            //'num_lot' => $sortiedetail['Sortiedetail']['num_lot'],
                            'prix_achat' => $value['Bonlivraisondetail']['prix_vente'],
                            'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                            'stock_source' => $value['Bonlivraisondetail']['qte'],
                            'depot_source_id' => $depot_id,
                            'depot_destination_id' => null,
                            'date' => (isset($value['Bonlivraisondetail']['date'])) ? date('Y-m-d', strtotime($value['Bonlivraisondetail']['date'])) : date('Y-m-d'),
                            'date_sortie' => (isset($value['Bonlivraisondetail']['date'])) ? date('Y-m-d', strtotime($value['Bonlivraisondetail']['date'])) : date('Y-m-d'),
                            'description' => '',
                        ];

                        $this->sortie($value['Bonlivraisondetail']['produit_id'], $depot_id, $value['Bonlivraisondetail']['paquet'], $value['Bonlivraisondetail']['qte'], $value['Bonlivraisondetail']['total_unitaire']);
                    }
                    $this->loadModel('Mouvement');

                    $this->Mouvement->saveMany($mouvement);
                }
            }

            $this->Session->setFlash("L'enregistrement a été effectué avec succès.", 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function calculatricefacture($facture_id = null)
    {
        $this->loadModel('Facture');
        $facture = $this->Facture->find('first', ['conditions' => ['id' => $facture_id]]);
        $remise = (isset($facture['Facture']['remise']) and !empty($facture['Facture']['remise'])) ? (float) $facture['Facture']['remise'] : 0;
        $details = $this->Facture->Facturedetail->find('all', ['contain' => ['Produit'], 'conditions' => ['facture_id' => $facture_id]]);
        $avances = $this->Facture->Avance->find('all', ['conditions' => ['facture_id' => $facture_id]]);
        $societe = $this->GetSociete();
        /* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
        $division_tva = (1+$tva/100); */

        $total_qte = 0;
        $total_paquet = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $tva = 0;
        foreach ($details as $k => $value) {
            $total_qte = $total_qte + $value['Facturedetail']['qte'];
            $total_paquet = $total_paquet + $value['Facturedetail']['paquet'];
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Facturedetail']['ttc'];
            $tva += (isset($value['Produit']['tva_vente']) and !empty($value['Produit']['tva_vente'])) ? (int) $value['Produit']['tva_vente'] : 0;
        }
        $division_tva = (1 + $tva / 100);
        $total_a_payer_ht = round($total_a_payer_ttc / $division_tva, 2);
        //$montant_remise = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
        $montant_remise = ($total_a_payer_ttc >= 0) ? (float) ($total_a_payer_ttc * $remise) / 100 : 0;
        $montant_tva = round($total_a_payer_ht * $tva / 100, 2);

        $total_paye = 0;
        foreach ($avances as $k => $value) {
            $total_paye = $total_paye + $value['Avance']['montant'];
        }

        $total_apres_reduction = ($total_a_payer_ht - $montant_remise) + $montant_tva;

        $reste_a_payer = $total_apres_reduction - $total_paye;
        $reste_a_payer = ($reste_a_payer <= 0) ? 0 : $reste_a_payer;

        if ($total_apres_reduction == $total_paye) {
            $paye = 2;
        } elseif ($total_paye == 0) {
            $paye = -1;
        } else {
            $paye = 1;
        }

        $data['Facture'] = [
            'paye' => $paye,
            'id' => $facture_id,
            'total_qte' => $total_qte,
            'total_paye' => $total_paye,
            'montant_tva' => $montant_tva,
            'reduction' => $montant_remise,
            'total_paquet' => $total_paquet,
            'reste_a_payer' => $reste_a_payer,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
        ];

        if ($this->Facture->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function calculatrice($bonlivraison_id = null)
    {
        $bonlivraison = $this->Bonlivraison->find('first', ['conditions' => ['id' => $bonlivraison_id]]);
        $remise = (isset($bonlivraison['Bonlivraison']['remise']) and !empty($bonlivraison['Bonlivraison']['remise'])) ? (float) $bonlivraison['Bonlivraison']['remise'] : 0;
        $etat = (isset($bonlivraison['Bonlivraison']['etat']) and !empty($bonlivraison['Bonlivraison']['etat'])) ? (int) $bonlivraison['Bonlivraison']['etat'] : -1;
        $details = $this->Bonlivraison->Bonlivraisondetail->find('all', ['contain' => ['Produit'], 'conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
        $avances = $this->Bonlivraison->Avance->find('all', ['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
        $societe = $this->GetSociete();
        //$tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;

        $total_qte = 0;
        $total_paquet = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $tva = 0;
        foreach ($details as $k => $value) {
            //add
            $tva += (isset($value['Produit']['tva_vente']) and !empty($value['Produit']['tva_vente'])) ? (int) $value['Produit']['tva_vente'] : 0;
            $total_qte = $total_qte + $value['Bonlivraisondetail']['qte'];
            $total_paquet = $total_paquet + $value['Bonlivraisondetail']['paquet'];
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Bonlivraisondetail']['ttc'];
        }
        $division_tva = (1 + $tva / 100);

        $total_a_payer_ht = round($total_a_payer_ttc / $division_tva, 2);
        $montant_remise = ($total_a_payer_ttc >= 0) ? (float) ($total_a_payer_ttc * $remise) / 100 : 0;
        $montant_tva = round($total_a_payer_ht * $tva / 100, 2);

        $total_paye = 0;
        foreach ($avances as $k => $value) {
            $total_paye = $total_paye + $value['Avance']['montant'];
        }

        $total_apres_reduction = round(($total_a_payer_ht - $montant_remise) + $montant_tva, 2);

        $reste_a_payer = $total_apres_reduction - $total_paye;
        $reste_a_payer = ($reste_a_payer <= 0) ? 0 : $reste_a_payer;

        if ($etat != -1 and $total_apres_reduction == $total_paye) {
            $paye = 2;
        } elseif ($total_paye == 0) {
            $paye = -1;
        } else {
            $paye = 1;
        }

        $data['Bonlivraison'] = [
            'paye' => $paye,
            'id' => $bonlivraison_id,
            'reduction' => $montant_remise,
            'total_qte' => $total_qte,
            'total_paye' => $total_paye,
            'montant_tva' => $montant_tva,
            'montant_remise' => $montant_remise,
            'total_paquet' => $total_paquet,
            'reste_a_payer' => $reste_a_payer,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
        ];

        if ($this->Bonlivraison->save($data)) {
            if (isset($bonlivraison['Bonlivraison']['facture_id']) and !empty($bonlivraison['Bonlivraison']['facture_id'])) {
                $this->Bonlivraison->Avance->updateAll(['Avance.facture_id' => $bonlivraison['Bonlivraison']['facture_id']], ['Avance.bonlivraison_id' => $bonlivraison_id]);
                $this->calculatricefacture($bonlivraison['Bonlivraison']['facture_id']);
            }

            return true;
        } else {
            return false;
        }
    }

    public function facture($bonlivraison_id = null)
    {
        $depot_id = $this->Session->read('Auth.User.depot_id');
        if ($this->Bonlivraison->exists($bonlivraison_id)) {
            $options = ['conditions' => ['Bonlivraison.id' => $bonlivraison_id]];
            $bonlivraison = $this->Bonlivraison->find('first', $options);
            $details = $this->Bonlivraison->Bonlivraisondetail->find('all', ['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
            $avances = $this->Bonlivraison->Avance->find('all', ['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);

            $data['Facture'] = [
                'etat' => 2,
                'id' => null,
                'bonlivraison_id' => $bonlivraison_id,
                'paye' => $bonlivraison['Bonlivraison']['paye'],
                'date' => $bonlivraison['Bonlivraison']['date'],
                'remise' => $bonlivraison['Bonlivraison']['remise'],
                'user_id' => $bonlivraison['Bonlivraison']['user_id'],
                'depot_id' => $bonlivraison['Bonlivraison']['depot_id'],
                'montant_tva' => $bonlivraison['Bonlivraison']['montant_tva'],
                'active_remise' => $bonlivraison['Bonlivraison']['active_remise'],
                'client_id' => $bonlivraison['Bonlivraison']['client_id'],
                'total_qte' => $bonlivraison['Bonlivraison']['total_qte'],
                'total_paye' => $bonlivraison['Bonlivraison']['total_paye'],
                'total_paquet' => $bonlivraison['Bonlivraison']['total_paquet'],
                'reste_a_payer' => $bonlivraison['Bonlivraison']['reste_a_payer'],
                'total_a_payer_ht' => $bonlivraison['Bonlivraison']['total_a_payer_ht'],
                'total_a_payer_ttc' => $bonlivraison['Bonlivraison']['total_a_payer_ttc'],
                'total_apres_reduction' => $bonlivraison['Bonlivraison']['total_apres_reduction'],
            ];

            $data['Avance'] = [];
            foreach ($avances as $key => $value) {
                $data['Avance'][] = [
                    'id' => $value['Avance']['id'],
                ];
            }

            $data['Facturedetail'] = [];
            foreach ($details as $key => $value) {
                $data['Facturedetail'][] = [
                    'id' => null,
                    'depot_id' => $depot_id,
                    'ttc' => $value['Bonlivraisondetail']['ttc'],
                    'qte' => $value['Bonlivraisondetail']['qte'],
                    'total' => $value['Bonlivraisondetail']['total'],
                    'paquet' => $value['Bonlivraisondetail']['paquet'],
                    'prix_vente' => $value['Bonlivraisondetail']['prix_vente'],
                    'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                    'total_unitaire' => $value['Bonlivraisondetail']['total_unitaire'],
                    'montant_remise' => $value['Bonlivraisondetail']['montant_remise'],
                    'remise' => $value['Bonlivraisondetail']['remise'],
                ];
            }

            if ($this->Bonlivraison->Facture->saveAssociated($data)) {
                $facture_id = $this->Bonlivraison->Facture->id;
                $this->Bonlivraison->id = $bonlivraison_id;
                if ($this->Bonlivraison->saveField('facture_id', $facture_id));
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }
    }

    public function mail($bonlivraison_id = null)
    {
        $bonlivraison = $this->Bonlivraison->find('first', ['contain' => ['Client'], 'conditions' => ['Bonlivraison.id' => $bonlivraison_id]]);
        $email = (isset($bonlivraison['Client']['email']) and !empty($bonlivraison['Client']['email'])) ? $bonlivraison['Client']['email'] : '';
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Email']['bonlivraison_id'] = $bonlivraison_id;
            if ($this->Bonlivraison->Email->save($this->request->data)) {
                $url = $this->generatepdf($bonlivraison_id);
                $email_id = $this->Bonlivraison->Email->id;
                if ($this->Bonlivraison->Email->saveField('url', $url)) {
                    $settings = $this->GetParametreSte();
                    $to = [$this->data['Email']['email']];
                    $objet = (isset($this->data['Email']['objet'])) ? $this->data['Email']['objet'] : '';
                    $content = (isset($this->data['Email']['content'])) ? $this->data['Email']['content'] : '';
                    $attachments = ['Bonlivraison' => ['mimetype' => 'application/pdf', 'file' => $url]];
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

    public function generatepdf($bonlivraison_id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Bonlivraison->exists($bonlivraison_id)) {
            $options = ['contain' => ['Client' => ['Ville']], 'conditions' => ['Bonlivraison.'.$this->Bonlivraison->primaryKey => $bonlivraison_id]];
            $data = $this->Bonlivraison->find('first', $options);

            $details = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                'conditions' => ['Bonlivraisondetail.bonlivraison_id' => $bonlivraison_id],
                'contain' => ['Produit'],
            ]);
        }
        $societe = $this->GetSociete();

        App::uses('LettreHelper', 'View/Helper');
        $LettreHelper = new LettreHelper(new View());

        $view = new View($this, false);
        $style = $view->element('style', ['societe' => $societe]);
        $header = $view->element('header', ['societe' => $societe, 'title' => 'BON DE LIVRAISON']);
        $footer = $view->element('footer', ['societe' => $societe]);
        $ville = (isset($this->data['Client']['Ville']['id']) and !empty($this->data['Client']['Ville']['id'])) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '';
        $ice = (isset($this->data['Client']['ice']) and !empty($this->data['Client']['ice'])) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '';

        $html = '
			<html>
			<head>
			    <title>Bon de livraison</title>
			    '.$style.'
			</head>
			<body>

			    '.$header.'

			    '.$footer.'

			    <div>

				    <table class="info" width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">BON DE LIVRAISON N° : '.$data['Bonlivraison']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">DATE : '.$data['Bonlivraison']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'
		                    			'.$ice.'
				                    </h4>
				                </td>
				            </tr>
				        </tbody>
				    </table>

				    <table class="details" width="100%">
				        <thead>
				            <tr>
				                <th>Désignation </th>
				                <th>Quantité </th>
				                <th>Prix TTC</th>
				                <th>Remise(%)</th>
				                <th>Montant total TTC</th>
				            </tr>
				        </thead>
				        <tbody>';
        foreach ($details as $tache) {
            $html .= '<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Bonlivraisondetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonlivraisondetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.(int) $tache['Bonlivraisondetail']['remise'].'%</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonlivraisondetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
        }
        $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Bonlivraison']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
				                    <td class="total">'.number_format($data['Bonlivraison']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TTC</td>
				                    <td class="total">'.number_format($data['Bonlivraison']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">REMISE('.$data['Bonlivraison']['remise'].'%)</td>
				                    <td class="total">'.number_format($data['Bonlivraison']['reduction'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Bonlivraison']['total_apres_reduction'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente devis à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper($LettreHelper->NumberToLetter(strval($data['Bonlivraison']['total_apres_reduction']))).' DHS
				                </td>
				            </tr>
				        </tbody>
				    </table>

			    </div>

			    '.$footer.'

			</body>
			</html>';

        //echo $html;die;
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $canvas = $dompdf->get_canvas();
        $font = Font_Metrics::get_font('helvetica', 'bold');
        $canvas->page_text(512, 820, 'Page : {PAGE_NUM}/{PAGE_COUNT}', $font, 8, [0, 0, 0]);
        $output = $dompdf->output();
        $destination = WWW_ROOT.'pdfs';
        if (!file_exists($destination)) {
            mkdir($destination, true, 0700);
        }
        file_put_contents($destination.DS.'Bonlivraison.'.$data['Bonlivraison']['date'].'-'.$data['Bonlivraison']['id'].'.pdf', $output);

        return $destination.DS.'Bonlivraison.'.$data['Bonlivraison']['date'].'-'.$data['Bonlivraison']['id'].'.pdf';
    }
}
