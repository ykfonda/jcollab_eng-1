<?php

class ClientsController extends AppController
{
    public $idModule = 57;
    public $uses = ['Client', 'Remiseclient'];

    public function index()
    {
        $users = $this->Client->User->findList();
        $categorieclients = $this->Client->Categorieclient->find('list', ['order' => 'libelle asc']);
        $clienttypes = $this->Client->Clienttype->find('list', ['order' => 'libelle asc']);
        $villes = $this->Client->Ville->find('list', ['order' => 'libelle asc']);
        $this->set(compact('users', 'categorieclients', 'villes', 'clienttypes'));
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $conditions['Client.type'] = 1;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Client.reference') {
                    $conditions['Client.reference LIKE '] = "%$value%";
                }
                if ($param_name == 'Client.designation') {
                    $conditions['Client.designation LIKE '] = "%$value%";
                } elseif ($param_name == 'Client.date1') {
                    $conditions['Client.date_c >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Client.date2') {
                    $conditions['Client.date_c <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Client->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['Creator', 'User', 'Categorieclient', 'Ville', 'Clienttype'],
            'order' => ['Client.date_c' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function remiseCategorie($client_id = null)
    {
        $remises = $this->Client->Remiseclient->find('all', [
            'fields' => ['Remiseclient.*', 'Categorieproduit.libelle'],
            'conditions' => ['Remiseclient.client_id' => $client_id, 'Remiseclient.type' => 'categorie'],
            'joins' => [
                ['table' => 'categorieproduits', 'alias' => 'Categorieproduit', 'type' => 'INNER', 'conditions' => ['Remiseclient.categorie_id = Categorieproduit.id']],
            ],
            'order' => ['Remiseclient.id' => 'DESC'],
        ]);

        $this->set(compact('remises', 'client_id'));
        $this->layout = false;
    }

    public function remiseArticle($client_id = null)
    {
        $remises = $this->Client->Remiseclient->find('all', [
            'fields' => ['Remiseclient.*', 'Produit.libelle'],
            'conditions' => ['Remiseclient.client_id' => $client_id, 'Remiseclient.type' => 'article'],
            'joins' => [
                ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Remiseclient.produit_id = Produit.id']],
            ],
            'order' => ['Remiseclient.id' => 'DESC'],
        ]);

        $this->set(compact('remises', 'client_id'));
        $this->layout = false;
    }

    public function remiseGlobale($client_id = null)
    {
        $remises = $this->Client->Remiseclient->find('all', [
            'fields' => ['Remiseclient.*'],
            'conditions' => ['Remiseclient.client_id' => $client_id, 'Remiseclient.type' => 'globale'],
            'order' => ['Remiseclient.id' => 'DESC'],
        ]);

        $this->set(compact('remises', 'client_id'));
        $this->layout = false;
    }

    public function deleteremise($id)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }

        if ($this->Remiseclient->deleteAll(['Remiseclient.id' => $id], false)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function editremisearticle($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Remiseclient']['type'] = 'article';
            $this->request->data['Remiseclient']['client_id'] = $client_id;
            $remisearticle = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'article', 'produit_id' => $this->request->data['Remiseclient']['produit_id']]]);
            $message['message'] = '';
            $message['err'] = false;
            /* if ($this->request->data["Remiseclient"]["id"] == null) {
                if (empty($remisearticle["Remiseclient"]["id"])) {
                    if ($this->Client->Remiseclient->save($this->request->data)) {
                        die('L\'enregistrement a été effectué avec succès.');
                    } else {
                        die('Il y a un problème');
                    }
                }
                else {
                    $message["err"] = true;
                    $message["message"] = 'La remise pour le produit existe déjà';

                }
            }
            else { */
            if ($this->Client->Remiseclient->save($this->request->data)) {
                die('L\'enregistrement a été effectué avec succès.');
            } else {
                die('Il y a un problème');
            }
            //}

            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode($message));
        }

        if ($this->Client->Remiseclient->exists($id)) {
            $options = ['conditions' => ['Remiseclient.'.$this->Client->Remiseclient->primaryKey => $id]];
            $this->request->data = $this->Client->Remiseclient->find('first', $options);
        }

        $produits = $this->Remiseclient->Produit->findList();
        $this->set(compact('produits', 'client_id'));
        $this->layout = false;
    }

    public function editremisecategorie($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Remiseclient']['type'] = 'categorie';
            $this->request->data['Remiseclient']['client_id'] = $client_id;
            $remisecategories = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'categorie', 'categorie_id' => $this->request->data['Remiseclient']['categorie_id']]]);
            $message['message'] = '';
            $message['err'] = false;
            if ($this->request->data['Remiseclient']['id'] == null) {
                if (empty($remisecategories['Remiseclient']['id'])) {
                    if ($this->Remiseclient->save($this->request->data)) {
                        die('L\'enregistrement a été effectué avec succès.');
                    } else {
                        die('Il y a un problème');
                    }
                } else {
                    $message['err'] = true;
                    $message['message'] = 'La remise pour cette catégorie existe déjà';
                }
            } else {
                if ($this->Client->Remiseclient->save($this->request->data)) {
                    die('L\'enregistrement a été effectué avec succès.');
                } else {
                    die('Il y a un problème');
                }
            }

            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode($message));
        } elseif ($this->Client->Remiseclient->exists($id)) {
            $options = ['conditions' => ['Remiseclient.'.$this->Client->Remiseclient->primaryKey => $id]];
            $this->request->data = $this->Client->Remiseclient->find('first', $options);
        }

        $categories = $this->Remiseclient->Categorieproduit->find('list');
        $this->set(compact('categories', 'client_id'));
        $this->layout = false;
    }

    public function editremiseglobale($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Remiseclient']['type'] = 'globale';
            $this->request->data['Remiseclient']['client_id'] = $client_id;
            $remisegloable = $this->Remiseclient->find('first', ['conditions' => ['client_id' => $client_id, 'type' => 'globale']]);
            $message['message'] = '';
            $message['err'] = false;
            if ($this->request->data['Remiseclient']['id'] == null) {
                if (empty($remisegloable['Remiseclient']['id'])) {
                    if ($this->Client->Remiseclient->save($this->request->data)) {
                        die('L\'enregistrement a été effectué avec succès.');
                    } else {
                        die('Il y a un problème');
                    }
                } else {
                    $message['err'] = true;
                    $message['message'] = 'La remise gloable pour ce client existe déjà';
                }
            } else {
                if ($this->Client->Remiseclient->save($this->request->data)) {
                    die('L\'enregistrement a été effectué avec succès.');
                } else {
                    die('Il y a un problème');
                }
            }

            header('Content-Type: application/json; charset=UTF-8');
            die(json_encode($message));
        } elseif ($this->Client->Remiseclient->exists($id)) {
            $options = ['conditions' => ['Remiseclient.'.$this->Client->Remiseclient->primaryKey => $id]];
            $this->request->data = $this->Client->Remiseclient->find('first', $options);
        }

        $this->set(compact('client_id'));
        $this->layout = false;
    }

    public function view($id = null, $annee = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $annee = ($annee == null) ? date('Y') : $annee;
        $taux = 0.00;
        $ca_total = 0.00;
        $total_paye_valide = 0.00;
        $ca_avoirs = 0.00;
        $bonlivraisons = [];
        $avoirs = [];
        $factures = [];
        $objectifclients = [];
        $produits = [];
        if ($this->Client->exists($id)) {
            $options = ['contain' => ['User', 'Categorieclient', 'Clienttype'], 'conditions' => ['Client.'.$this->Client->primaryKey => $id]];
            $this->request->data = $this->Client->find('first', $options);

            $objectifclients = $this->Client->Objectifclient->find('all', [
                'conditions' => ['Objectifclient.client_id' => $id],
                'order' => 'Objectifclient.id DESC',
            ]);

            $bonlivraisons = $this->Client->Bonlivraison->find('all', [
                'conditions' => [
                    'Bonlivraison.client_id' => $id,
                    'YEAR(Bonlivraison.date)' => $annee,
                ],
                'order' => 'Bonlivraison.id DESC',
            ]);

            $avoirs = $this->Client->Bonavoir->find('all', [
                'conditions' => [
                    'YEAR(Bonavoir.date)' => $annee,
                    'Bonavoir.client_id' => $id,
                ],
                'order' => 'Bonavoir.id DESC',
            ]);

            $factures = $this->Client->Facture->find('all', [
                'conditions' => [
                    'YEAR(Facture.date)' => $annee,
                    'Facture.client_id' => $id,
                ],
                'order' => 'Facture.id DESC',
            ]);

            $req1 = $this->Client->Bonlivraison->Avance->find('first', [
                'fields' => ['SUM(montant) as total_paye'],
                'conditions' => [
                    'Bonlivraison.facture_id' => null,
                    'YEAR(Bonlivraison.date)' => $annee,
                    'Bonlivraison.client_id' => $id,
                    'Avance.etat' => 1,
                ],
                'joins' => [
                    ['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id', 'Bonlivraison.deleted = 0']],
                ],
            ]);

            $total_paye_livraison = (isset($req1[0]['total_paye']) and !empty($req1[0]['total_paye'])) ? (float) $req1[0]['total_paye'] : 0.00;

            $req2 = $this->Client->Facture->Avance->find('first', [
                'fields' => ['SUM(montant) as total_paye'],
                'conditions' => [
                    'Facture.bonlivraison_id' => null,
                    'YEAR(Facture.date)' => $annee,
                    'Facture.client_id' => $id,
                    'Avance.etat' => 1,
                ],
                'joins' => [
                    ['table' => 'factures', 'alias' => 'Facture', 'type' => 'INNER', 'conditions' => ['Facture.id = Avance.facture_id', 'Facture.deleted = 0']],
                ],
            ]);

            $total_paye_facture = (isset($req2[0]['total_paye']) and !empty($req2[0]['total_paye'])) ? (float) $req2[0]['total_paye'] : 0.00;

            $total_paye_valide = $total_paye_livraison + $total_paye_facture;

            $solde1 = $this->Client->Bonlivraison->find('first', [
                'fields' => ['SUM(reste_a_payer) as reste_a_payer'],
                'conditions' => [
                    'Bonlivraison.facture_id' => null,
                    'YEAR(Bonlivraison.date)' => $annee,
                    'Bonlivraison.client_id' => $id,
                    'Bonlivraison.etat' => [1, 2],
                ],
            ]);

            $credit_restant_livraison = (isset($solde1[0]['reste_a_payer']) and !empty($solde1[0]['reste_a_payer'])) ? (float) $solde1[0]['reste_a_payer'] : 0.00;

            $solde2 = $this->Client->Facture->find('first', [
                'fields' => ['SUM(reste_a_payer) as reste_a_payer'],
                'conditions' => [
                    'Facture.bonlivraison_id' => null,
                    'YEAR(Facture.date)' => $annee,
                    'Facture.client_id' => $id,
                    'Facture.etat' => [1, 2],
                ],
            ]);

            $credit_restant_facture = (isset($solde2[0]['reste_a_payer']) and !empty($solde2[0]['reste_a_payer'])) ? (float) $solde2[0]['reste_a_payer'] : 0.00;

            $credit_restant = $credit_restant_livraison + $credit_restant_facture;

            $req2 = $this->Client->Bonavoir->find('first', [
                'fields' => ['SUM(Bonavoir.total_a_payer_ttc) as total_a_payer_ttc'],
                'conditions' => ['Bonavoir.client_id' => $id, 'YEAR(Bonavoir.date)' => $annee],
            ]);

            $ca_avoirs = (isset($req2[0]['total_a_payer_ttc']) and !empty($req2[0]['total_a_payer_ttc'])) ? (float) $req2[0]['total_a_payer_ttc'] : 0.00;

            $ca_total = $total_paye_valide - $ca_avoirs;

            $current_obj = $this->Client->Objectifclient->find('first', [
                'conditions' => ['Objectifclient.client_id' => $id, 'Objectifclient.annee' => $annee],
                'order' => 'Objectifclient.id DESC',
            ]);

            $obj_fixe = (isset($current_obj['Objectifclient']['id']) and !empty($current_obj['Objectifclient']['objectif'])) ? (float) $current_obj['Objectifclient']['objectif'] : 0.00;
            $taux = ($obj_fixe > 0) ? (float) round(($total_paye_valide / $obj_fixe) * 100, 2) : 0.00;

            $produits = $this->Client->Bonlivraison->Bonlivraisondetail->Produit->find('all', [
                'fields' => ['Produit.id', 'Produit.libelle', 'COUNT(Bonlivraisondetail.produit_id) as NbrProduits'],
                'conditions' => [
                    'Bonlivraison.etat' => 2,
                    'Bonlivraison.client_id' => $id,
                    'YEAR(Bonlivraison.date)' => $annee,
                ],
                'joins' => [
                    ['table' => 'bonlivraisondetails', 'alias' => 'Bonlivraisondetail', 'type' => 'INNER', 'conditions' => ['Bonlivraisondetail.produit_id = Produit.id', 'Bonlivraisondetail.deleted = 0']],
                    ['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Bonlivraisondetail.bonlivraison_id', 'Bonlivraison.deleted = 0']],
                ],
                //'order' => 'MAX(Bonlivraisondetail.produit_id)'
                'group' => 'Produit.id',
            ]);
        } else {
            $this->Session->setFlash("Ce client n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('user_id', 'role_id', 'total_paye_valide', 'ca_avoirs', 'ca_total', 'bonlivraisons', 'annee', 'taux', 'avoirs', 'factures', 'objectifclients', 'credit_restant', 'produits'));
        $this->getPath($this->idModule);
    }

    public function changelocation($id = null, $latitude = null, $longitude = null)
    {
        $data['Client']['id'] = $id;
        $data['Client']['latitude'] = $latitude;
        $data['Client']['longitude'] = $longitude;
        if ($this->Client->save($data)) {
            $this->Session->setFlash('La mise à jour a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function edit($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        if ($this->request->is(['post', 'put'])) {
            if (empty($this->request->data['Client']['id'])) {
                $this->request->data['Client']['user_id'] = $user_id;
            }
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Client->exists($id)) {
            $options = ['conditions' => ['Client.'.$this->Client->primaryKey => $id]];
            $this->request->data = $this->Client->find('first', $options);
        }

        $users = $this->Client->User->findList();
        $categorieclients = $this->Client->Categorieclient->find('list');
        $villes = $this->Client->Ville->find('list', ['order' => 'libelle asc']);
        $clienttypes = $this->Client->Clienttype->find('list', ['order' => 'libelle asc']);
        $this->set(compact('users', 'categorieclients', 'user_id', 'role_id', 'villes', 'clienttypes'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalide client'));
        }

        if ($this->Client->flagDelete()) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function editobjectif($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Objectifclient']['client_id'] = $client_id;
            if ($this->Client->Objectifclient->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Client->Objectifclient->exists($id)) {
            $options = ['conditions' => ['Objectifclient.'.$this->Client->Objectifclient->primaryKey => $id]];
            $this->request->data = $this->Client->Objectifclient->find('first', $options);
        }

        $this->set(compact('years'));
        $this->layout = false;
    }

    private function CsvToArray($file, $delimiter)
    {
        $data2DArray = [];
        if (($handle = fopen($file, 'r')) !== false) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== false) {
                $tab = count($lineArray);
                for ($j = 0; $j < $tab; ++$j) {
                    $data2DArray[$i][$j] = utf8_encode($lineArray[$j]);
                }
                ++$i;
            }
            fclose($handle);
        }

        return $data2DArray;
    }

    public function importer()
    {
        $year_id = $this->Auth->Session->read('Auth.Year.id');
        $champs = [];
        if ($this->request->is(['post', 'put'])) {
            $ImportedFile = $this->CsvToArray($this->data['Client']['file']['tmp_name'], ',');
            $clients = $this->Client->find('list', ['fields' => ['Client.id', 'Client.ice']]);

            array_shift($ImportedFile);

            $result = (isset($this->data['csv']) and !empty($this->data['csv'])) ? $this->data['csv'] : array_flip($champs);

            $tab = [];
            foreach ($ImportedFile as $key => $value) {
                foreach ($result as $k => $v) {
                    if (isset($value[$v])) {
                        $tab[$key][$k] = trim($value[$v]);
                    }
                }
            }

            $insert = [];
            foreach ($tab as $key => $value) {
                $value['id'] = null;
                $value['date'] = date('Y-m-d');
                $value['classification'] = 1;
                $value['categorieclient_id'] = 1;
                if (isset($value['ice']) and !empty($value['ice'])) {
                    foreach ($clients as $k => $v) {
                        if ($value['ice'] == $v) {
                            $value['id'] = $k;
                        }
                    }
                }

                $insert[]['Client'] = $value;
            }

            $datasource = $this->Client->getDataSource();
            try {
                $datasource->begin();

                if (!$this->Client->saveMany($insert)) {
                    throw new Exception();
                }

                $datasource->commit();
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } catch (Exception $e) {
                $datasource->rollback();
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        }

        $this->layout = false;
    }

    public function deleteobjectif($id = null)
    {
        $this->Client->Objectifclient->id = $id;
        if (!$this->Client->Objectifclient->exists()) {
            throw new NotFoundException(__('Invalide Objectif client'));
        }

        if ($this->Client->Objectifclient->flagDelete()) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    // recupérer les clients depuis le serveur 
	public function apiGetClientsToSync($store_id = null, $caisse_id = null)
	{
		// Définir le type de réponse
		$this->response->type('json');

        // Récupérer les données de la table "Salepoint"
        $clients = $this->Client->find('all',[
            'conditions' => [
                'Client.deleted' => 0,
            ]
        ]);

		// Afficher les données en format JSON
		echo json_encode($clients);
        
		// Arrêter le rendu de la vue
		return $this->response;
	}


        // Inérer les données récupérées des clients à la caisse demanderesse
        public function insertClientsApi($caisse_id = null, $server_link=null, $check_sync=null, $json_data=null, $data=null)
        {
        
            // Récupérer les informations de l'application 
            $result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));
            $server_link = $result['server_link'];
            $caisse_id      = $result['caisse_id'];
            $store_id       = $result['store_id'];
            
            // Vérifier la disponibilité de la connexion Internet
            if(checkdnsrr('google.com', 'A')){		
    
                    $link_api = $server_link.'/clients/apiGetClientsToSync';
                    $json_data = file_get_contents($link_api);

                    if ($json_data === false) {
                        // Le fichier n'a pas été trouvé, définir un message d'erreur personnalisé
                        $this->Session->setFlash("Impossible de récupérer les données du fichier", 'alert-danger');
                        $check_sync = NULL;
                    } else {
                        $data = json_decode($json_data, true);
                        $this->set('data', $data);
                    }
                           foreach ($data as $item) {
                                $client_api_ids = $item['Client']['id'];
                                $date_update_api = $item['Client']['date_u'];
                
                                    // Vérifier si le client existe déjà dans la base de données
                                    $client_caisse_db = $this->Client->find('all',[
                                        'conditions' => [
                                        'Client.id' => $client_api_ids,
                                        'Client.deleted' => 0,
                                        ]
                                        ]);
                
                                        if (!empty($client_caisse_db)) {
                                            // recupérer et affecter la data => variable
                                            $client_db         = $client_caisse_db['0'];
                                            $date_update_db     = $client_caisse_db['0']['Client']['date_u'];
                    
                                            // pour faire comparer les dates des updates
                                            $date_update_api    = strtotime($date_update_api);
                                            $date_update_db     = strtotime($date_update_db);
                                        }
                
                                        // Verifier s'il y a des clients à mettre à jour
                                        if (!empty($client_caisse_db) AND $date_update_api > $date_update_db) {
                                            // Mettre à jour les données dans la table "clients"
                                            $difference = array_diff_assoc($item['Client'], $client_db['Client']);    
                                                if (!empty($difference)) {
                                                    $id_produit = intval($client_db['Client']['id']);
                                                    $this->Client->id = $id_produit;
                                                    $this->Client->saveAll($item);
                                                    $check_sync = "DONE";
                                                }
                                        }
                                        else{
                                                // Ajouter les clients manquants
                                                    if ($this->Client->saveAll($item)) {
                                                        $check_sync = "DONE";
                                                }
                                        }
                           }     

                                if (isset($check_sync) AND $check_sync!=NULL) {
                                    // Charger le modèle + Enregistrer l'entité dans la base de données
                                    $this->loadModel('Synchronisation');
                                    $this->Synchronisation->save(array(
                                    'source' => $server_link,
                                    'module' => "Client",
                                    'user_created' => 0,
                                    'destination' => 'Store'.$store_id.' Caisse '.$caisse_id,
                                    ));
                                    $this->Session->setFlash('La liste des clients a été synchronisée avec succès.', 'alert-success');
                                }
                            $this->layout = false;
                            
            } else {
                $this->Session->setFlash('La liste des clients n\'a pas été synchronisée.', 'alert-danger');
            }
    
    
    
            }







} // fin controller
