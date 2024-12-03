<?php

class BontransfertsController extends AppController
{
    protected $idModule = 114;

    public function index()
    {
        $depots = $this->Bontransfert->DepotSource->findList();
        $produits = $this->Bontransfert->Produit->findList();
        $this->set(compact('produits', 'depots'));
        $this->getPath($this->idModule);
    }

    public function loadproduit($produit_id = null, $depot_id = null)
    {
        App::uses('HtmlHelper', 'View/Helper');
        $HtmlHelper = new HtmlHelper(new View());
        $produit = [];
        if (!empty($produit_id) and !empty($depot_id)) {
            $produit = $this->Bontransfert->Produit->find('first', [
                'fields' => [/* 'Depotproduit.*', */'Produit.*'],
                'conditions' => ['Produit.id' => $produit_id],
                /* 'joins' => [
                    ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
                    ['table' => 'unites', 'alias' => 'Unite', 'type' => 'LEFT', 'conditions' => ['Unite.id = Produit.unite_id','Unite.deleted = 0']],
                ], */
            ]);

            $produit['Produit']['unite'] = (isset($produit['Unite']['id']) and !empty($produit['Unite']['id'])) ? strtolower($produit['Unite']['libelle']) : '';
            $produit['Produit']['stock'] = (isset($produit['Depotproduit']['quantite']) and !empty($produit['Depotproduit']['quantite'])) ? $produit['Depotproduit']['quantite'] : 0;

            if (isset($produit['Produit']['image']) and file_exists(WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image'])) {
                $produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
            } else {
                $produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');
            }
        }
        //$data = ["stock" => $produit['Depotproduit']['quantite'],
        $data = ['stock' => $produit['Produit']['stockactuel'],
    'prixachat' => $produit['Produit']['prixachat'], ];
        die(json_encode($data));
    }

    public function validerExp($id)
    {
        if ($this->request->is(['post', 'put'])) {
            //var_dump($id,$this->request->data["Validerexp"]["depots"]);die();
            $this->valider($id, $this->request->data['Validerexp']['depots']);
        }
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $entree = $this->Bontransfert->find('first', ['conditions' => ['Bontransfert.id' => $id]]);
        $depots = $this->Bontransfert->DepotDestination->find('list', ['conditions' => ['DepotDestination.store_id' => $selected_store, 'DepotDestination.id !=' => $entree['Bontransfert']['depot_source_id']]]);
        $this->set(compact('depots', 'id'));
        $this->layout = false;

        //sortie
    }

    public function loadquatite($depot_id = null, $produit_id = null)
    {
        $req = $this->Bontransfert->Produit->Depotproduit->find('first', ['conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);
        $quantite = (isset($req['Depotproduit']['id']) and !empty($req['Depotproduit']['quantite'])) ? $req['Depotproduit']['quantite'] : 0;
        die(json_encode($quantite));
    }

    public function loaddepots($produit_id = null)
    {
        $depots = $this->Bontransfert->DepotSource->find('list', [
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = DepotSource.id', 'Depotproduit.deleted = 0']],
                ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id', 'Produit.deleted = 0']],
            ],
            'conditions' => [
                'Depotproduit.quantite ' => 0,
                'Produit.id' => $produit_id,
            ],
        ]);

        die(json_encode($depots));
    }

    public function transfert($produit_id = null, $depot_source_id = 1, $depot_destination_id = 1, $quantite_saisie = 0)
    {
        // Sortie du stock source
        $this->loadModel('Mouvement');
        $source = $this->Mouvement->Produit->Depotproduit->find('first', [
            'conditions' => [
                'produit_id' => $produit_id,
                'depot_id' => $depot_source_id,
            ],
        ]);

        $quantite_source = (isset($source['Depotproduit']['quantite'])) ? $source['Depotproduit']['quantite'] : 0;
        $quantite = $quantite_source - $quantite_saisie;
        if ($quantite <= 0) {
            $quantite = 0;
        }

        $source_id = (isset($source['Depotproduit']['id'])) ? $source['Depotproduit']['id'] : null;

        $insert = [
            'id' => $source_id,
            'quantite' => $quantite,
            'date' => date('Y-m-d'),
            'quantite' => $quantite,
            'produit_id' => $produit_id,
            'depot_id' => $depot_source_id,
        ];

        // Entrée au stock destination
        $req = $this->Mouvement->Produit->Depotproduit->find('first', [
            'conditions' => [
                'depot_id' => $depot_destination_id,
                'produit_id' => $produit_id,
            ],
        ]);

        $quantite_destination = (isset($req['Depotproduit']['id'])) ? (int) $req['Depotproduit']['quantite'] : 0;
        $quantite = $quantite_destination + $quantite_saisie;
        if ($quantite <= 0) {
            $quantite = 0;
        }

        $destination_id = (isset($req['Depotproduit']['id'])) ? $req['Depotproduit']['id'] : null;

        $save = [
            'id' => $destination_id,
            'date' => date('Y-m-d'),
            'quantite' => $quantite,
            'produit_id' => $produit_id,
            'depot_id' => $depot_destination_id,
        ];

        $transfert = [
            'id' => null,
            'operation' => 2,
            'date' => date('Y-m-d'),
            'produit_id' => $produit_id,
            'stock_source' => $quantite_saisie,
            'depot_source_id' => $depot_source_id,
            'stock_destination' => $quantite_saisie,
            'depot_destination_id' => $depot_destination_id,
            'description' => 'Transfert en masse',
        ];

        if ($this->Mouvement->Produit->Depotproduit->save($insert)) {
            $this->Mouvement->save($transfert);
            $this->Mouvement->Produit->Depotproduit->save($save);
        }

        return true;
    }

    public function editall()
    {
        if ($this->request->is(['post', 'put'])) {
            $data['Bontransfert']['id'] = null;
            $data['Bontransfertdetail'] = [];
            $data['Bontransfert']['date'] = (isset($this->data['Bontransfert']['date'])) ? date('Y-m-d', strtotime($this->data['Bontransfert']['date'])) : date('Y-m-d');
            $data['Bontransfert']['type'] = 'Transfert';
            if ($this->data['Bontransfert']['depot_source_id'] == $this->data['Bontransfert']['depot_destination_id']) {
                $this->Session->setFlash('Le dépot source ne peut pas être le même que le dépot destination', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
            $data['Bontransfert']['depot_source_id'] = (isset($this->data['Bontransfert']['depot_source_id'])) ? $this->data['Bontransfert']['depot_source_id'] : 1;
            $data['Bontransfert']['depot_destination_id'] = (isset($this->data['Bontransfert']['depot_destination_id'])) ? $this->data['Bontransfert']['depot_destination_id'] : 1;
            $total = 0;
            if (isset($this->data['Bontransfertdetail']) and !empty($this->data['Bontransfertdetail'])) {
                foreach ($this->data['Bontransfertdetail'] as $key => $value) {
                    $data['Bontransfertdetail'][] = [
                        'id' => null,
                        'operation' => -1,
                        'produit_id' => $value['produit_id'],
                        'stock_source' => $value['stock_source'],
                        'stock_destination' => $value['stock_source'],
                        'depot_source_id' => (isset($this->data['Bontransfert']['depot_source_id'])) ? $this->data['Bontransfert']['depot_source_id'] : 1,
                        'depot_destination_id' => (isset($this->data['Bontransfert']['depot_destination_id'])) ? $this->data['Bontransfert']['depot_destination_id'] : 1,
                        'date' => (isset($this->data['Bontransfert']['date'])) ? date('Y-m-d', strtotime($this->data['Bontransfert']['date'])) : date('Y-m-d'),
                    ];
                    $this->loadModel('Bonentree');
                    $produit = $this->Bonentree->Produit->find('first', [
                        'conditions' => ['id' => $value['produit_id']],
                    ]);
                    $total += $produit['Produit']['prix_vente'] * $value['stock_source'];
                }
                $data['Bontransfert']['total'] = $total;
                if ($this->Bontransfert->saveAssociated($data)) {
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                } else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Session->setFlash('Opération impossible : Aucun produit saisie !', 'alert-danger');

                return $this->redirect($this->referer());
            }
        }
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $depots = $this->Bontransfert->DepotSource->find('list', ['conditions' => ['DepotSource.store_id' => $selected_store]]);
        $this->set(compact('depots'));
        $this->getPath($this->idModule);
    }

    public function newrow($count = 0, $produit_id = null, $stock_source = 0, $prix_achat = 0, $stock = 0, $valeur = 0, $depot_id)
    {
        $stock_source = (!isset($stock_source)) ? 0 : $stock_source;
        $produit_id = (!isset($produit_id)) ? 0 : $produit_id;
        $prix_achat = (!isset($prix_achat)) ? 0 : $prix_achat;
        $stock = (!isset($stock)) ? 0 : $stock;
        $valeur = (!isset($valeur)) ? 0 : $valeur;
        $this->loadModel('Bonentree');
        $conditions['Produit.active'] = 1;
        if ($depot_id != null) {
            $conditions['Depotproduit.depot_id'] = $depot_id;
            $conditions['Depotproduit.quantite >='] = 0;
        }
        $produits = $this->Bonentree->Produit->find('list', [
            /* 'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id','Depotproduit.deleted = 0']],
            ],
            'conditions' => $conditions, */
        ]);
        $this->set(compact('produits', 'count', 'produit_id', 'stock', 'stock_source', 'prix_achat', 'valeur'));
        $this->layout = false;
    }

    public function indexAjax()
    {
        $conditions = [];
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Produit.libelle') {
                    $conditions['Produit.libelle LIKE'] = "%$value%";
                } elseif ($param_name == 'Bontransfert.num_lot') {
                    $conditions['Bontransfert.num_lot LIKE'] = "%$value%";
                } elseif ($param_name == 'Bontransfert.reference') {
                    $conditions['Bontransfert.reference LIKE'] = "%$value%";
                } elseif ($param_name == 'Bontransfert.date1') {
                    $conditions['Bontransfert.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Bontransfert.date2') {
                    $conditions['Bontransfert.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
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
        //$conditions["Bontransfert.depot_source_id"] = array($depots);
        //$conditions["Bontransfert.depot_destination_id"] = array($depots);
      
        $conditions[] = ['OR' => [
            [
                'Bontransfert.depot_source_id' => $depots,
                'Bontransfert.type' => "Transfert",
            ],
            [
                'Bontransfert.type' => 'Expedition',
                'Bontransfert.depot_destination_id' => $depots,
            ],
        ]];

        $this->Bontransfert->recursive = -1;
        //$this->Bontransfert->Bontransfertdetail->fields("SUM (Bontransfertdetail.prix_achat) as total"
        $this->Paginator->settings = [
            'order' => ['Bontransfert.id' => 'DESC'],
            'contain' => [
                'DepotSource',
                'DepotDestination',
                'Bontransfertdetail' => ['conditions' => ['Bontransfertdetail.deleted' => 0]],
            ],
            'conditions' => $conditions,
        ];

        $taches = $this->Paginator->paginate();
        //var_dump($taches);die();
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function scan($code_barre = null, $depot_id)
    {
        $response['error'] = true;
        $response['message'] = '';
        $response['data']['prix_achat'] = 0;
        $response['data']['stock_source'] = 0;
        $response['data']['stock'] = null;
        $response['data']['produit_id'] = null;
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
                $produit = $this->Bontransfert->Produit->find('first', ['fields' => ['id', 'prix_vente', 'stockactuel', 'unite_id', 'prixachat'], 'conditions' => ['Produit.type' => 2, 'Produit.code_barre' => $code_article]]);
                if (!isset($produit['Produit']['id'])) {
                    $response['message'] = 'Code a barre incorrect produit introuvable !';
                }

                $produit = $this->Bontransfert->Produit->find('first', [
                    'fields' => [/* 'Depotproduit.*', */'Produit.*'],
                    'conditions' => ['Produit.code_barre' => $code_article],
                    /* 'joins' => [
                        ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
                    ], */
                ]);
                /* if(!isset($produit['Depotproduit']['id'])) {
                    $response['message'] = "Le produit n'existe pas dans ce dépôt !";
                }
                else */
                $quantite = (float) $quantite;
                if (isset($produit['Produit']['id']) and !empty($produit['Produit']['id'])) {
                    if (isset($produit['Produit']['pese']) and $produit['Produit']['pese'] == '1') {
                        $qte = $quantite / $cb_div_kg;
                    } // autre
                    else {
                        $qte = $quantite;
                    } // piéce

                    if ($qte <= 0) {
                        $response['message'] = 'Opération impossible la quantité doit étre supérieur a zéro !';
                    } else {
                        $response['error'] = false;
                        $response['data']['stock_source'] = $qte;
                        $response['data']['produit_id'] = $produit['Produit']['id'];
                        $response['data']['prix_achat'] = $produit['Produit']['prixachat'];
                        //$response['data']['stock'] =  $produit['Depotproduit']['quantite'];
                        $response['data']['stock'] = $produit['Produit']['stockactuel'];
                        $response['data']['valeur'] = $produit['Produit']['prixachat'] * $qte;
                    }
                }
            }
        }

        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }

    public function edit($id = null, $bontransfert_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Bontransfertdetail']['bontransfert_id'] = $bontransfert_id;
            $options = ['conditions' => ['Bontransfert.id' => $bontransfert_id]];
            $bon = $this->Bontransfert->find('first', $options);

            if ($this->Bontransfert->Bontransfertdetail->save($this->request->data)) {
                $options = ['conditions' => ['Bontransfertdetail.bontransfert_id' => $bontransfert_id]];
                $details = $this->Bontransfert->Bontransfertdetail->find('all', $options);
                $this->loadModel('Bonentree');
                $total = 0;
                foreach ($details as $detail) {
                    $produit = $this->Bonentree->Produit->find('first', [
                    'conditions' => ['id' => $detail['Bontransfertdetail']['produit_id']],
                ]);
                    if ($bon['Bontransfert']['type'] == 'Expedition') {
                        $total += $produit['Produit']['prix_vente'] * $detail['Bontransfertdetail']['stock_destination'];
                    } else {
                        $total += $produit['Produit']['prix_vente'] * $detail['Bontransfertdetail']['stock_source'];
                    }
                }
                $this->Bontransfert->id = $bontransfert_id;
                $this->Bontransfert->updateAll(['Bontransfert.total' => $total], ['Bontransfert.id' => $bontransfert_id]);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Bontransfert->Bontransfertdetail->exists($id)) {
            $options = ['conditions' => ['Bontransfertdetail.'.$this->Bontransfert->Bontransfertdetail->primaryKey => $id]];
            $this->request->data = $this->Bontransfert->Bontransfertdetail->find('first', $options);
        }

        $options = ['conditions' => ['Bontransfert.'.$this->Bontransfert->primaryKey => $bontransfert_id]];
        $bontransfert = $this->Bontransfert->find('first', $options);
        //$depots = $this->Bontransfert->DepotSource->find("first",["fields"=> ["libelle","id"],"conditions" => ["id" => $bontransfert["Bontransfert"]["depot_source_id"]]]);
        //$depots2[$depots["DepotSource"]["id"]] = $depots["DepotSource"]["libelle"];
        $this->request->data['Bontransfert']['type'] = $bontransfert['Bontransfert']['type'];
        $this->request->data['Bontransfertdetail']['depot_source_id'] = $bontransfert['Bontransfert']['depot_source_id'];
        $this->request->data['Bontransfertdetail']['depot_destination_id'] = $bontransfert['Bontransfert']['depot_destination_id'];
        $depots = $this->Bontransfert->DepotSource->findList();
        //$produits = $this->Bontransfert->Produit->findList();
        $conditions['Produit.active'] = 1;
        $conditions['Depotproduit.depot_id'] = $bontransfert['Bontransfert']['depot_source_id'];
        $conditions['Depotproduit.quantite >='] = 0;

        $produits = $this->Bontransfert->Produit->find('list', [
            /* 'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id','Depotproduit.deleted = 0']],
            ],
            'conditions' => $conditions, */
        ]);
        $this->set(compact('produits', 'depots'));
        $this->layout = false;
    }

    public function view($bontransfert_id = null)
    {
        $details = [];
        if ($this->Bontransfert->exists($bontransfert_id)) {
            $options = ['conditions' => ['Bontransfert.'.$this->Bontransfert->primaryKey => $bontransfert_id],
            'contain' => ['Produit', 'DepotSource', 'DepotDestination'], ];
            $this->request->data = $this->Bontransfert->find('first', $options);

            $details = $this->Bontransfert->Bontransfertdetail->find('all', [
                'conditions' => ['Bontransfertdetail.bontransfert_id' => $bontransfert_id],
                'contain' => ['Produit', 'DepotSource', 'DepotDestination'],
                'order' => ['Bontransfertdetail.id' => 'DESC'],
            ]);
        }

        $depots = $this->Bontransfert->DepotSource->findList();
        $produits = $this->Bontransfert->Produit->findList();
        $this->set(compact('produits', 'depots', 'details'));
        $this->getPath($this->idModule);
    }

    public function valider($bontransfert_id = null, $depot_dest = null)
    {
        $mouvement = [];
        $details = [];
        $entree = $this->Bontransfert->find('first', ['conditions' => ['Bontransfert.id' => $bontransfert_id]]);
        $details = $this->Bontransfert->Bontransfertdetail->find('all', [
            'conditions' => ['Bontransfertdetail.bontransfert_id' => $bontransfert_id],
            'order' => ['Bontransfertdetail.id' => 'DESC'],
        ]);

        if (empty($details)) {
            $this->Session->setFlash('Opération impossible : Aucun produit saisie !!', 'alert-danger');

            return $this->redirect($this->referer());
        }
        if (isset($depot_dest)) {
            $this->Bontransfert->id = $bontransfert_id;
            $this->Bontransfert->saveField('depot_destination_id', $depot_dest);
            $this->loadModel('Bontransfertdetail');
            $this->Bontransfertdetail->query("Update bontransfertdetails set depot_destination_id=$depot_dest where bontransfert_id=$bontransfert_id");

            $details = $this->Bontransfert->Bontransfertdetail->find('all', [
                'conditions' => ['Bontransfertdetail.bontransfert_id' => $bontransfert_id],
                'order' => ['Bontransfertdetail.id' => 'DESC'],
            ]);
        }
        if (isset($entree['Bontransfert']['id']) and !empty($entree['Bontransfert']['id']) and $entree['Bontransfert']['valide'] == -1) {
            /* foreach ($details as $bonentree) {
                $mouvement[] = [
                    'id' => null,
                    'operation' => -1,
                    'produit_id' => $bonentree['Bontransfertdetail']['produit_id'],
                    'stock_source' => $bonentree['Bontransfertdetail']['stock_source'],
                    'depot_source_id' => ( isset( $bonentree['Bontransfertdetail']['depot_source_id'] ) ) ? $bonentree['Bontransfertdetail']['depot_source_id'] : 1,
                    'depot_destination_id' => ( isset( $bonentree['Bontransfertdetail']['depot_destination_id'] ) ) ? $bonentree['Bontransfertdetail']['depot_destination_id'] : 1,
                    'date' => ( isset( $bonentree['Bontransfertdetail']['date'] ) ) ? date('Y-m-d', strtotime( $bonentree['Bontransfertdetail']['date'] ) ) : date('Y-m-d') ,
                    'description' => 'Numéro du bon de transfert : '.$entree['Bontransfert']['reference'],
                ];
            } */

            foreach ($details as $bonentree) {
                if (isset($depot_dest)) {
                    $mouvement[] = [
                            'id' => null,
                            'operation' => -1,
                            'produit_id' => $bonentree['Bontransfertdetail']['produit_id'],
                            'stock_source' => $bonentree['Bontransfertdetail']['stock_source'],
                            'depot_source_id' => (isset($bonentree['Bontransfertdetail']['depot_destination_id'])) ? $bonentree['Bontransfertdetail']['depot_destination_id'] : 1,
                            'date' => date('Y-m-d'),
                            'description' => 'Numéro du bon de transfert : '.$entree['Bontransfert']['reference'],
                        ];
                    $this->loadModel('Mouvement');
                    $this->Mouvement->saveMany($mouvement);
                    App::import('Controller', 'Bonentrees');
                    $Bonentrees = new BonentreesController();
                    $this->loadModel('Depot');
                    $Bonentrees->entree($produit_id = $bonentree['Bontransfertdetail']['produit_id'], $depot_id = $bonentree['Bontransfertdetail']['depot_destination_id'], $bonentree['Bontransfertdetail']['stock_destination']);
                } else {
                    $this->transfert($bonentree['Bontransfertdetail']['produit_id'], $bonentree['Bontransfertdetail']['depot_source_id'], $bonentree['Bontransfertdetail']['depot_destination_id'], $bonentree['Bontransfertdetail']['stock_source']);
                }
            }
            $this->Bontransfert->id = $bontransfert_id;
            $this->Bontransfert->saveField('valide', 1);
            $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            /* } else {
                $this->Session->setFlash('Il y a un problème','alert-danger');
            } */
            return $this->redirect($this->referer());
        } else {
            $this->Session->setFlash('Opération impossible : bon déja validé', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function delete($id = null)
    {
        $this->Bontransfert->id = $id;
        if (!$this->Bontransfert->exists()) {
            throw new NotFoundException(__('Invalide bon de transfert'));
        }

        $this->Bontransfert->id = $id;

        if ($this->Bontransfert->deleteAll(['Bontransfert.id' => $id], false)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null, $bontransfert_id = null)
    {
        $this->Bontransfert->Bontransfertdetail->id = $id;
        if (!$this->Bontransfert->Bontransfertdetail->exists()) {
            throw new NotFoundException(__('Invalide detail '));
        }

        if ($this->Bontransfert->Bontransfertdetail->flagDelete()) {
            $options = ['conditions' => ['Bontransfertdetail.bontransfert_id' => $bontransfert_id]];
            $details = $this->Bontransfert->Bontransfertdetail->find('all', $options);
            $options = ['conditions' => ['Bontransfert.id' => $bontransfert_id]];

            $bon = $this->Bontransfert->find('first', $options);
            $total = 0;
            foreach ($details as $detail) {
                $produit = $this->Bontransfert->Bontransfertdetail->Produit->find('first', [
                    'conditions' => ['id' => $detail['Bontransfertdetail']['produit_id']],
                ]);
                if ($bon['Bontransfert']['type'] == 'Expedition') {
                    $total += $produit['Produit']['prix_vente'] * $detail['Bontransfertdetail']['stock_destination'];
                } else {
                    $total += $produit['Produit']['prix_vente'] * $detail['Bontransfertdetail']['stock_source'];
                }
            }
            $this->Bontransfert->id = $bontransfert_id;
            $this->Bontransfert->updateAll(['Bontransfert.total' => $total], ['Bontransfert.id' => $bontransfert_id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }
}
