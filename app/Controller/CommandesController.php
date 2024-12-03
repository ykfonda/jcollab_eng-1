<?php

App::import('Vendor', 'dompdf', ['file' => 'dompdf'.DS.'dompdf_config.inc.php']);
class CommandesController extends AppController
{
    public $idModule = 124;

    public function index()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $depots = $this->Session->read('depots');
        $clients = $this->Commande->Client->findList();
        $users = $this->Commande->User->findList();
        $depots = $this->Commande->Depot->findList(['Depot.vente' => 1, 'Depot.id' => $depots]);
        $this->set(compact('users', 'clients', 'depots', 'user_id', 'role_id'));
        $this->getPath($this->idModule);
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

                $produit = $this->Commande->Commandedetail->Produit->find('first', ['fields' => ['id', 'prix_vente', 'stockactuel', 'unite_id', 'prixachat'], 'conditions' => ['Produit.type' => 2, 'Produit.code_barre' => $code_article]]);
                if (!isset($produit['Produit']['id'])) {
                    $response['message'] = 'Code a barre incorrect produit introuvable !';
                }

                $produit = $this->Commande->Commandedetail->Produit->find('first', [
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

    public function getclient($client_id = null)
    {
        /* $req = $this->Commande->Client->find('first',['conditions' => ['id'=>$client_id]]);
        $remise = ( isset( $req['Client']['id'] ) AND !empty( $req['Client']['remise'] ) ) ? (float) $req['Client']['remise'] : 0 ;
         */
        $this->loadModel('Remiseclient');
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
        $req = $this->Commande->Commandedetail->Produit->Depotproduit->find('first', ['conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);
        $quantite = (isset($req['Depotproduit']['id']) and !empty($req['Depotproduit']['quantite'])) ? (float) $req['Depotproduit']['quantite'] : 0;
        die(json_encode($quantite));
    }

    public function bonlivraison($commande_id = null)
    {
        $details = $this->Commande->Commandedetail->find('all', [
            'conditions' => ['Commandedetail.commande_id' => $commande_id],
        ]);
        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }

        if ($this->Commande->exists($commande_id)) {
            $commande = $this->Commande->find('first', ['contain' => ['User'], 'conditions' => ['Commande.id' => $commande_id]]);

            $data['Bonlivraison'] = [
                'etat' => 1,
                'id' => null,
                'commande_id' => $commande_id,
                'date' => $commande['Commande']['date'],
                'remise' => $commande['Commande']['remise'],
                'depot_id' => $commande['Commande']['depot_id'],
                'user_id' => $commande['Commande']['user_id'],
                'client_id' => $commande['Commande']['client_id'],
                'total_qte' => $commande['Commande']['total_qte'],
                'total_paye' => $commande['Commande']['total_paye'],
                'montant_tva' => $commande['Commande']['montant_tva'],
                'total_paquet' => $commande['Commande']['total_paquet'],
                'active_remise' => $commande['Commande']['active_remise'],
                'reste_a_payer' => $commande['Commande']['reste_a_payer'],
                'total_a_payer_ht' => $commande['Commande']['total_a_payer_ht'],
                'total_a_payer_ttc' => $commande['Commande']['total_a_payer_ttc'],
                'total_apres_reduction' => $commande['Commande']['total_apres_reduction'],
            ];

            $data['Bonlivraisondetail'] = [];
            foreach ($details as $key => $value) {
                $data['Bonlivraisondetail'][] = [
                    'id' => null,
                    'depot_id' => $commande['Commande']['depot_id'],
                    'ttc' => $value['Commandedetail']['ttc'],
                    'qte' => $value['Commandedetail']['qte_cmd'],
                    'total' => $value['Commandedetail']['total'],
                    'prix_vente' => $value['Commandedetail']['prix_vente'],
                    'produit_id' => $value['Commandedetail']['produit_id'],
                ];
            }

            if ($this->Commande->Bonlivraison->saveAssociated($data)) {
                $bonlivraison_id = $this->Commande->Bonlivraison->id;
                $this->Commande->id = $commande_id;
                $this->Commande->saveField('bonlivraison_id', $bonlivraison_id);
                $this->Commande->saveField('etat', 2);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                if (isset($this->Commande->Bonlivraison->error)) {
                    $this->Session->setFlash($this->Commande->Bonlivraison->error, 'alert-danger');
                } else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }
            }

            return $this->redirect($this->referer());
        }
    }

    public function indexAjax()
    {
        $admins = $this->Session->read('admins');
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $conditions = [];
        if (!in_array($role_id, $admins)) {
            $conditions['Commande.user_c'] = $user_id;
        }
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Commande.reference') {
                    $conditions['Commande.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Commande.date1') {
                    $conditions['Commande.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Commande.date2') {
                    $conditions['Commande.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $data['Filter'][$param_name] = $value;
                }
            }
        }

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]);

        $conditions['Commande.depot_id'] = $depots;

        $this->Commande->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['Creator', 'Depot', 'User', 'Client' => ['Ville', 'Categorieclient']],
            'order' => ['Commande.date' => 'DESC', 'Commande.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();
        $ventes = $this->Commande->find('all', ['contain' => ['Depot', 'User', 'Client'], 'conditions' => $conditions]);
        $this->set(compact('taches', 'ventes', 'user_id'));
        $this->layout = false;
    }

    protected function getPermissionByModule($idModule = null)
    {
        if ($idModule === null) {
            $idModule = $this->idModule;
        }

        $this->loadModel('Permission');

        $res = $this->Permission->find('all', [
            'conditions' => ['Permission.role_id' => $this->Session->read('Auth.User.role_id'), 'Permission.module_id' => $idModule],
        ]);

        if (!$this->Auth->user()) {
            $global['Permission'] = ['c' => 1, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        } else {
            $global['Permission'] = ['c' => 0, 'a' => 0, 'm1' => 0, 'm2' => 0, 'm3' => 0, 'm4' => 0, 'v' => 0, 's' => 0, 'h' => 0, 'i' => 0, 'e' => 0, 'sa' => 0];
        }
        foreach ($res as $val) {
            if ($val['Permission']['c'] == 1) {
                $global['Permission']['c'] = 1;
            }
            if ($val['Permission']['a'] == 1) {
                $global['Permission']['a'] = 1;
            }
            if ($val['Permission']['m1'] == 1) {
                $global['Permission']['m1'] = 1;
            }
            if ($val['Permission']['m2'] == 1) {
                $global['Permission']['m2'] = 1;
            }
            if ($val['Permission']['m3'] == 1) {
                $global['Permission']['m3'] = 1;
            }
            if ($val['Permission']['m4'] == 1) {
                $global['Permission']['m4'] = 1;
            }
            if ($val['Permission']['v'] == 1) {
                $global['Permission']['v'] = 1;
            }
            if ($val['Permission']['s'] == 1) {
                $global['Permission']['s'] = 1;
            }
            if ($val['Permission']['h'] == 1) {
                $global['Permission']['h'] = 1;
            }
            if ($val['Permission']['i'] == 1) {
                $global['Permission']['i'] = 1;
            }
            if ($val['Permission']['e'] == 1) {
                $global['Permission']['e'] = 1;
            }
            if ($val['Permission']['sa'] == 1) {
                $global['Permission']['sa'] = 1;
            }
        }

        return $global;
    }

    public function edit($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $depots = $this->Session->read('depots');
        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['Module.libelle' => 'Remise']]);

        $permission = $this->getPermissionByModule($module['Module']['id']);

        $this->set(compact('users', 'clients', 'user_id', 'role_id'));
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Commande']['active_remise'] = (isset($this->request->data['Commande']['active_remise']) and !empty($this->request->data['Commande']['active_remise'])) ? 1 : -1;
            if ($this->request->data['Commande']['active_remise'] == -1) {
                $this->request->data['Commande']['remise'] = 0;
            }
            if ($this->Commande->save($this->request->data)) {
                if (isset($this->request->data['Commande']['id']) and !empty($this->request->data['Commande']['id'])) {
                    $this->CheckRemise($this->request->data['Commande']['id']);
                }
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Commande->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        } elseif ($this->Commande->exists($id)) {
            $options = ['conditions' => ['Commande.'.$this->Commande->primaryKey => $id]];
            $this->request->data = $this->Commande->find('first', $options);
        }

        $clients = $this->Commande->Client->findList();
        $users = $this->Commande->User->findList();
        $depots = $this->Commande->Depot->findList(['Depot.vente' => 1, 'Depot.id' => $depots]);
        $this->set(compact('permission', 'users', 'clients', 'depots', 'user_id', 'role_id'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Commande->id = $id;
        if (!$this->Commande->exists()) {
            throw new NotFoundException(__('Invalide vente'));
        }

        if ($this->Commande->flagDelete()) {
            $this->Commande->Commandedetail->updateAll(['Commandedetail.deleted' => 1], ['Commandedetail.commande_id' => $id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null, $commande_id = null)
    {
        $this->Commande->Commandedetail->id = $id;
        if (!$this->Commande->Commandedetail->exists()) {
            throw new NotFoundException(__('Invalide article'));
        }

        if ($this->Commande->Commandedetail->flagDelete()) {
            $this->calculatrice($commande_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function view($id = null, $flag = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');

        $details = [];
        if ($this->Commande->exists($id)) {
            $options = ['contain' => ['Client', 'Depot'], 'conditions' => ['Commande.'.$this->Commande->primaryKey => $id]];
            $this->request->data = $this->Commande->find('first', $options);

            $details = $this->Commande->Commandedetail->find('all', [
                'conditions' => ['Commandedetail.commande_id' => $id],
                'contain' => ['Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('details', 'role_id', 'user_id', 'flag'));
        $this->getPath($this->idModule);
    }

    public function getProduit($produit_id = null, $depot_id = null, $client_id = null)
    {
        $produit = $this->Commande->Commandedetail->Produit->find('first', ['conditions' => ['Produit.id' => $produit_id]]);
        $tva = (isset($produit['Produit']['tva_vente']) and !empty($produit['Produit']['tva_vente'])) ? $produit['Produit']['tva_vente'] : 20;
        $prix_vente = (isset($produit['Produit']['prix_vente']) and !empty($produit['Produit']['prix_vente'])) ? $produit['Produit']['prix_vente'] : 20;

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
                $produit = $this->Commande->Commandedetail->Produit->find('first', ['conditions' => ['id' => $produit_id]]);

                foreach ($remisecategories as $remisecategorie) {
                    if ($produit['Produit']['categorieproduit_id'] == $remisecategorie['Remiseclient']['categorie_id']) {
                        $remise = floatval($remisecategorie['Remiseclient']['montant']);
                    }
                }
            }
        }

        die(json_encode(['tva' => $tva, 'prix_vente' => $prix_vente,
        'remise' => $remise, ]));
    }

    public function pdf($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Commande->exists($id)) {
            $options = ['contain' => ['Depot', 'User', 'Client' => ['Ville']], 'conditions' => ['Commande.'.$this->Commande->primaryKey => $id]];
            $this->request->data = $this->Commande->find('first', $options);

            $details = $this->Commande->Commandedetail->find('all', [
                'conditions' => ['Commandedetail.commande_id' => $id],
                'contain' => ['Produit'],
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

    public function ticket($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Commande->exists($id)) {
            $options = ['contain' => ['Depot', 'User', 'Client' => ['Ville']], 'conditions' => ['Commande.'.$this->Commande->primaryKey => $id]];
            $this->request->data = $this->Commande->find('first', $options);

            $details = $this->Commande->Commandedetail->find('all', [
                'conditions' => ['Commandedetail.commande_id' => $id],
                'contain' => ['Produit'],
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

    public function reduction($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Commande->save($this->request->data)) {
                $this->calculatrice($commande_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Commande->exists($id)) {
            $options = ['conditions' => ['Commande.'.$this->Commande->primaryKey => $id]];
            $this->request->data = $this->Commande->find('first', $options);
        }
        $this->layout = false;
    }

    public function editdetail($id = null, $commande_id = null, $client_id = null)
    {
        $commande = $this->Commande->find('first', ['contain' => ['User'], 'conditions' => ['Commande.id' => $commande_id]]);
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');
        $depot_id = 1;

        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['Module.libelle' => 'Remise']]);

        $permission = $this->getPermissionByModule($module['Module']['id']);

        $produits_exists = $this->Commande->Commandedetail->Produit->find('list', [
            'fields' => ['Produit.id', 'Produit.id'],
            'joins' => [
                ['table' => 'commandedetails', 'alias' => 'Commandedetail', 'type' => 'INNER', 'conditions' => ['Commandedetail.produit_id = Produit.id', 'Commandedetail.deleted = 0']],
            ],
            'conditions' => [
                'Commandedetail.commande_id' => $commande_id,
            ],
        ]);

        $produits = $this->Commande->Commandedetail->Produit->findList([
            'Produit.id !=' => $produits_exists,
        ]);

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Commandedetail']['commande_id'] = $commande_id;
            $this->request->data['Commandedetail']['ttc'] = $this->request->data['Commandedetail']['ttc'] - $this->request->data['Commandedetail']['montant_remise'];
            if ($this->Commande->Commandedetail->save($this->request->data)) {
                $this->calculatrice($commande_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Commande->Commandedetail->exists($id)) {
            $options = ['conditions' => ['Commandedetail.'.$this->Commande->Commandedetail->primaryKey => $id]];
            $this->request->data = $this->Commande->Commandedetail->find('first', $options);
            $produits = $this->Commande->Commandedetail->Produit->findList();
        }

        $depots = $this->Commande->Commandedetail->Depot->find('list');
        $categorieproduits = $this->Commande->Commandedetail->Produit->Categorieproduit->find('list');
        $this->set(compact('permission', 'client_id', 'produits', 'role_id', 'depot_id', 'depots', 'categorieproduits'));
        $this->layout = false;
    }

    public function changestate($commande_id = null, $etat = -1)
    {
        $details = $this->Commande->Commandedetail->find('all', ['conditions' => ['Commandedetail.commande_id' => $commande_id]]);
        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Commande->id = $commande_id;
        if ($this->Commande->saveField('etat', $etat)) {
            $this->Session->setFlash("L'enregistrement a été effectué avec succès.", 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function CheckRemise($commande_id = null)
    {
        $commande = $this->Commande->find('first', ['conditions' => ['Commande.id' => $commande_id]]);
        $remise = (isset($commande['Commande']['remise']) and !empty($commande['Commande']['remise'])) ? (float) $commande['Commande']['remise'] : 0;
        $details = $this->Commande->Commandedetail->find('all', ['contain' => ['Produit'], 'conditions' => ['Commandedetail.commande_id' => $commande_id]]);

        $CommandedetailData = [];
        foreach ($details as $k => $v) {
            // TVA
            $tva = (isset($v['Produit']['tva_vente']) and !empty($v['Produit']['tva_vente'])) ? (int) $v['Produit']['tva_vente'] : 20;
            $division_tva = (1 + $tva / 100);

            // Quantité & Prix de vente
            $qte_cmd = (isset($v['Commandedetail']['qte_cmd'])) ? $v['Commandedetail']['qte_cmd'] : 0;
            $qte = (isset($v['Commandedetail']['qte']) and $v['Commandedetail']['qte'] > 0) ? $v['Commandedetail']['qte'] : $qte_cmd;
            $prix_vente_ht = round($v['Commandedetail']['prix_vente'] / $division_tva, 2);
            $prix_vente_ttc = $v['Commandedetail']['prix_vente'];

            // Calcule total
            $total_ht = round($prix_vente_ht * $qte, 2);
            $total_ttc = round($prix_vente_ttc * $qte, 2);

            $montant_remise = ($total_ttc >= 0) ? (float) ($total_ttc * $remise) / 100 : 0;

            $total_ttc = $total_ttc - $montant_remise;

            // Data structure
            $CommandedetailData[] = [
                'id' => $v['Commandedetail']['id'],
                'montant_remise' => $montant_remise,
                'total' => $total_ht,
                'ttc' => $total_ttc,
                'remise' => $remise,
            ];
        }

        if ($this->Commande->Commandedetail->saveMany($CommandedetailData)) {
            $this->calculatrice($commande_id);
        }

        return true;
    }

    public function calculatrice($commande_id = null)
    {
        $commande = $this->Commande->find('first', ['conditions' => ['id' => $commande_id]]);
        $remise = (isset($commande['Commande']['remise']) and !empty($commande['Commande']['remise'])) ? (float) $commande['Commande']['remise'] : 0;
        $details = $this->Commande->Commandedetail->find('all', ['contain' => ['Produit'], 'conditions' => ['commande_id' => $commande_id]]);

        $tva = 0;
        $montant_tva = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $nombre_lines = count($details);
        foreach ($details as $k => $value) {
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Commandedetail']['ttc'];
            $total_a_payer_ht = $total_a_payer_ht + $value['Commandedetail']['total'];
            //$montant_tva = $montant_tva + $value['Commandedetail']['montant_tva'];
            //$tva = $tva + $value['Commandedetail']['tva'];
            $tva += (isset($value['Produit']['tva_vente']) and !empty($value['Produit']['tva_vente'])) ? (int) $value['Produit']['tva_vente'] : 0;
        }
        $tva = ($nombre_lines != 0) ? round($tva / $nombre_lines, 2) : 0;
        $montant_remise = ($total_a_payer_ttc >= 0) ? round(($total_a_payer_ttc * $remise) / 100, 2) : 0;
        $total_apres_reduction = round($total_a_payer_ttc - $montant_remise, 2);
        $montant_tva = round($total_a_payer_ht * $tva / 100, 2);

        $data['Commande'] = [
            'id' => $commande_id,
            'tva' => $tva,
            'montant_tva' => $montant_tva,
            'montant_remise' => $montant_remise,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
            'reste_a_payer' => $total_apres_reduction,
        ];

        if ($this->Commande->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function mail($commande_id = null)
    {
        $commande = $this->Commande->find('first', ['contain' => ['Client'], 'conditions' => ['Commande.id' => $commande_id]]);
        $email = (isset($commande['Client']['email']) and !empty($commande['Client']['email'])) ? $commande['Client']['email'] : '';
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Email']['commande_id'] = $commande_id;
            if ($this->Commande->Email->save($this->request->data)) {
                $url = $this->generatepdf($commande_id);
                $email_id = $this->Commande->Email->id;
                if ($this->Commande->Email->saveField('url', $url)) {
                    $settings = $this->GetParametreSte();
                    $to = [$this->data['Email']['email']];
                    $objet = (isset($this->data['Email']['objet'])) ? $this->data['Email']['objet'] : '';
                    $content = (isset($this->data['Email']['content'])) ? $this->data['Email']['content'] : '';
                    $attachments = ['Commandes' => ['mimetype' => 'application/pdf', 'file' => $url]];
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

    public function generatepdf($commande_id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Commande->exists($commande_id)) {
            $options = ['contain' => ['Client' => ['Ville']], 'conditions' => ['Commande.'.$this->Commande->primaryKey => $commande_id]];
            $data = $this->Commande->find('first', $options);

            $details = $this->Commande->Commandedetail->find('all', [
                'conditions' => ['Commandedetail.commande_id' => $commande_id],
                'contain' => ['Produit'],
            ]);
        }
        $societe = $this->GetSociete();

        App::uses('LettreHelper', 'View/Helper');
        $LettreHelper = new LettreHelper(new View());

        $view = new View($this, false);
        $style = $view->element('style', ['societe' => $societe]);
        $header = $view->element('header', ['societe' => $societe, 'title' => 'BON COMMANDE']);
        $footer = $view->element('footer', ['societe' => $societe]);
        $ville = (isset($data['Client']['Ville']['libelle'])) ? $data['Client']['Ville']['libelle'] : '';

        $html = '
			<html>
			<head>
				<title>BON COMMANDE N° : '.$data['Commande']['reference'].'</title>
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
				                    <h4 class="container"">BON COMMANDE N° : '.$data['Commande']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container"">DATE : '.$data['Commande']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'<br/><br/>
					                    ICE : '.strtoupper($data['Client']['ice']).'
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
				                    <td nowrap style="text-align:right;">'.$tache['Commandedetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Commandedetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.(int) $tache['Commandedetail']['remise'].'%</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Commandedetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
        }
        $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Commande']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA (20%)</td>
				                    <td class="total">'.number_format($data['Commande']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TTC</td>
				                    <td class="total">'.number_format($data['Commande']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">REMISE ('.$data['Commande']['remise'].'%)</td>
				                    <td class="total">'.number_format($data['Commande']['reduction'], 2, ',', ' ').' %</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Commande']['total_apres_reduction'], 2, ',', ' ').'</td>
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
				                    '.strtoupper($LettreHelper->NumberToLetter(strval($data['Commande']['total_apres_reduction']))).' DHS
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
        file_put_contents($destination.DS.'Commande.'.$data['Commande']['date'].'-'.$data['Commande']['id'].'.pdf', $output);

        return $destination.DS.'Commande.'.$data['Commande']['date'].'-'.$data['Commande']['id'].'.pdf';
    }
}
