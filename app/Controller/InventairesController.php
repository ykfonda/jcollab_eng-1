<?php

class InventairesController extends AppController
{
    public $idModule = 100;
    public $uses = ['Inventaire', 'Entree', 'Salepoint', 'Depotproduit'];

    public function index()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');
        $depots = $this->Session->read('depots');
        $depots = $this->Inventaire->Depot->findList(['Depot.id' => $depots]);
        $this->set(compact('user_id', 'admins', 'role_id', 'depots'));
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $depots = $this->Session->read('depots');
        $conditions['Depot.id'] = $depots;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Inventaire.reference') {
                    $conditions['Inventaire.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Inventaire.libelle') {
                    $conditions['Inventaire.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Inventaire.date1') {
                    $conditions['Inventaire.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Inventaire.date2') {
                    $conditions['Inventaire.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Inventaire->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['Creator', 'Depot'],
            'order' => ['Inventaire.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function rapprochement()
    {
        $depots = $this->Session->read('depots');
      
        $inv = $this->Inventaire->find('all', [
            'conditions' => [
                'depot_id' => $depots,
                'statut' => 1
            ],
            'fields' => ['id', 'reference', 'date', 'Depot.libelle'],
            'contain' => ['Depot']
        ]);
        
        foreach ($inv as $inventaire) {
            $inventaires[$inventaire['Inventaire']['id']] = $inventaire['Inventaire']['reference'].'/'.$inventaire['Inventaire']['date'].'/'.$inventaire['Depot']['libelle'];
        }
        if ($this->request->is(['post', 'put'])) {
            ////verif meme depot
            //comparer les dates

            $inventaire_detail = $this->Inventaire->Inventairedetail->find('all', ['conditions' => ['Inventairedetail.inventaire_id' => $this->request->data['Inventaire']['inventaire']]]);
            $inventaire_detail2 = $this->Inventaire->Inventairedetail->find('all', ['conditions' => ['Inventairedetail.inventaire_id' => $this->request->data['Inventaire']['inventaire_id']]]);
            $data = [];

            for ($i = 0; $i < count($inventaire_detail); ++$i) {
                $inventaire = $this->Inventaire->find('first', ['conditions' => ['id' => $this->request->data['Inventaire']['inventaire']]]);
                $inventaire2 = $this->Inventaire->find('first', ['conditions' => ['id' => $this->request->data['Inventaire']['inventaire_id']]]);
                $produit_id = $inventaire_detail[$i]['Inventairedetail']['produit_id'];
                $produits = $this->Inventaire->Inventairedetail->Produit->find('first', [
                    'contain' => ['Categorieproduit'], 'conditions' => ['Produit.id' => $produit_id], ]);
                $data[$i]['code_art'] = $produits['Produit']['code_barre'];
                $data[$i]['article'] = $produits['Produit']['libelle'];
                $data[$i]['valstkini'] = $produits['Produit']['prix_vente'] * $inventaire_detail[$i]['Inventairedetail']['quantite_reel'];
                $data[$i]['qtstkini'] = $inventaire_detail[$i]['Inventairedetail']['quantite_reel'];

                $entrees = $this->Entree->find('all', ['conditions' => ['produit_id' => $produit_id, 'depot_id' => $inventaire['Inventaire']['depot_id'],
                'date_c >=' => $inventaire['Inventaire']['date'], 'date_c <=' => $inventaire2['Inventaire']['date'],
                'type' => 'Entree', ]]);
                $quantite_entree = 0;

                foreach ($entrees as $entree) {
                    $quantite_entree += $entree['Entree']['quantite'];
                }
                $data[$i]['qntEntree'] = $quantite_entree;
                $data[$i]['valEntree'] = $produits['Produit']['prix_vente'] * $quantite_entree;
                $sorties = $this->Entree->find('all', ['conditions' => ['produit_id' => $produit_id, 'depot_id' => $inventaire['Inventaire']['depot_id'],
                'date_c >=' => $inventaire['Inventaire']['date'], 'date_c <=' => $inventaire2['Inventaire']['date'],
                'type' => 'Sortie', ]]);
                $quantite_sortie = 0;
                foreach ($sorties as $sortie) {
                    $quantite_sortie += $sortie['Entree']['quantite'];
                }
                $data[$i]['qntSortie'] = $quantite_sortie;
                $data[$i]['valSortie'] = $produits['Produit']['prix_vente'] * $quantite_sortie;
                $salepoints = $this->Salepoint->find('all', [
                'joins' => [
                    ['table' => 'salepointdetails', 'alias' => 'Salepointdetail', 'type' => 'INNER', 'conditions' => ['Salepointdetail.salepoint_id = Salepoint.id']],
                ],
                'fields' => ['Salepoint.id', 'Salepointdetail.ttc', 'Salepointdetail.qte'],
                'conditions' => [
                    'Salepointdetail.produit_id' => $produit_id,
                    'Salepoint.etat' => 2,
                    'Salepoint.date_u >=' => $inventaire['Inventaire']['date'],
                    'Salepoint.date_u <=' => $inventaire2['Inventaire']['date'],
                ], ]);
                $qte_vendu = 0;
                $val_vendu = 0;
                foreach ($salepoints as $salepoint) {
                    $qte_vendu += $salepoint['Salepointdetail']['qte'];
                    $val_vendu += $salepoint['Salepointdetail']['ttc'];
                }
                $data[$i]['qntVente'] = $qte_vendu;
                $data[$i]['valVente'] = $val_vendu;
                $data[$i]['valStock'] = $inventaire_detail[$i]['Inventairedetail']['quantite_theorique'];
                $data[$i]['valstkfin'] = $inventaire_detail2[$i]['Inventairedetail']['quantite_reel'] * $produits['Produit']['prix_vente'];
                $data[$i]['qtstkfin'] = $inventaire_detail2[$i]['Inventairedetail']['quantite_reel'];
                $data[$i]['valecart'] = $data[$i]['valstkfin'] - $data[$i]['valStock'];
                $prix_vente = ($produits['Produit']['prix_vente'] != 0.00) ? $produits['Produit']['prix_vente'] : 1;

                $data[$i]['qteEcart'] = $data[$i]['valecart'] / $prix_vente;
                $data[$i]['Prix'] = $produits['Produit']['prix_vente'];
                $data[$i]['famille'] = $produits['Categorieproduit']['libelle'];
                $valvente = ($data[$i]['valVente'] != 0.00) ? $data[$i]['valVente'] : 1;

                $data[$i]['%ecart/vente'] = ($data[$i]['valecart'] * 100) / $valvente;
            }
            $this->Session->write('data', $data);

            return $this->redirect(['controller' => 'Inventaires', 'action' => 'excel']);
        }

        $this->set(compact('inventaires'));
        $this->layout = false;
    }

    public function excel()
    {
        $taches = $this->Session->read('data');

        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function edit($id = null)
    {
        $depots = $this->Session->read('depots');
        if ($this->request->is(['post', 'put'])) {
            $conditions = ['Inventaire.depot_id' => $this->request->data['Inventaire']['depot_id'],
            'Inventaire.statut' => -1, ];
            $result = $this->Inventaire->find('first', ['conditions' => $conditions]);
            if ($result) {
                $this->Session->setFlash('Il y a deja un inventaire en cours pour ce magasin', 'alert-danger');
                return $this->redirect(['action' => 'index']);
            }

            if ($this->Inventaire->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Inventaire->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        } elseif ($this->Inventaire->exists($id)) {
            $options = ['conditions' => ['Inventaire.'.$this->Inventaire->primaryKey => $id]];
            $this->request->data = $this->Inventaire->find('first', $options);
        }
        $depots = $this->Inventaire->Depot->findList(['Depot.id' => $depots]);
        $this->set(compact('depots'));
        $this->layout = false;
    }

    public function scan($inventaire_id = null, $code_barre = null)
    {
        $response['error'] = true;
        $response['message'] = '';
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
                $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);

                if (!empty($code_article)) {
                    $produit = $this->Inventaire->Inventairedetail->find('first', [
                        'conditions' => [
                            'Produit.code_barre' => $code_article,
                            'Inventairedetail.inventaire_id' => $inventaire_id,
                        ],
                        'fields' => [
                            'Inventairedetail.*',
                            'Produit.prix_vente',
                            'Produit.tva_vente',
                            'Produit.unite_id',
                            'Produit.id',
                        ],
                        'contain' => ['Produit'],
                    ]);

                    if (isset($produit['Inventairedetail']['id']) and !empty($produit['Inventairedetail']['id'])) {
                        $quantite_reel = (!empty($produit['Inventairedetail']['quantite_reel'])) ? $produit['Inventairedetail']['quantite_reel'] : 0;
                        if (isset($produit['Produit']['unite_id']) and $produit['Produit']['unite_id'] == 4) {
                            $qte = (int) $quantite;
                        } // piéce
                        else {
                            $qte = round($quantite / $cb_div_kg, 2);
                        } // autre

                        if ($qte <= 0) {
                            $response['message'] = 'Opération impossible la quantité doit étre supérieur a zéro !';
                        } else {
                            $data['Inventairedetail']['id'] = $produit['Inventairedetail']['id'];
                            $data['Inventairedetail']['quantite_reel'] = $quantite_reel + $qte;

                            $depot_produit = $this->Depotproduit->find('first', ['conditions' => ['produit_id' => $produit['Produit']['id'], 'depot_id' => $inventaire['Inventaire']['depot_id']]]);
                            $this->Depotproduit->id = $depot_produit['Depotproduit']['id'];
                            $this->Depotproduit->saveField('quantite', $data['Inventairedetail']['quantite_reel']);

                            if ($this->Inventaire->Inventairedetail->save($data)) {
                                $response['message'] = "L'enregistrement a été fait avec succès. !";
                                $response['error'] = false;
                            } else {
                                $response['message'] = 'Erreur de sauvgarde des donnée !';
                            }
                        }
                    } else {
                        $produit = $this->Inventaire->Inventairedetail->Produit->find('first', [
                            'conditions' => [
                                'Produit.code_barre' => $code_article,
                        ], ]);
                        $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);

                        if (isset($produit['Produit']['unite_id']) and $produit['Produit']['unite_id'] == 4) {
                            $qte = (int) $quantite;
                        } // piéce
                        else {
                            $qte = round($quantite / $cb_div_kg, 2);
                        } // autre

                        if ($qte <= 0) {
                            $response['message'] = 'Opération impossible la quantité doit étre supérieur a zéro !';
                        } else {
                            $data['Inventairedetail']['id'] = null;
                            $data['Inventairedetail']['quantite_reel'] = $qte;
                            $data['Inventairedetail']['inventaire_id'] = $inventaire['Inventaire']['id'];
                            $data['Inventairedetail']['produit_id'] = $produit['Produit']['id'];

                            $depot_produit = $this->Depotproduit->find('first', ['conditions' => ['produit_id' => $produit['Produit']['id'], 'depot_id' => $inventaire['Inventaire']['depot_id']]]);
                            if (isset($depot_produit['Depotproduit']['id'])) {
                                $this->Depotproduit->id = $depot_produit['Depotproduit']['id'];
                                $this->Depotproduit->saveField('quantite', $qte);
                            } else {
                                $data['Depotproduit'] = [
                                    'date' => date('Y-m-d'),
                                    'depot_id' => $inventaire['Inventaire']['depot_id'],
                                    'produit_id' => $produit['Produit']['id'],
                                    'quantite' => $data['Inventairedetail']['quantite_reel'],
                                ];
                                $this->Depotproduit->save($data);
                            }

                            if ($this->Inventaire->Inventairedetail->save($data)) {
                                $response['message'] = "L'enregistrement a été fait avec succès. !";
                                $response['error'] = false;
                            } else {
                                $response['message'] = 'Erreur de sauvgarde des donnée !';
                            }
                        }

                        //$response['message'] = 'Code a barre incorrect produit introuvable !';
                    }
                } else {
                    $response['message'] = 'Code a barre incorrect ou vide !';
                }
            }
        }

        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }

    public function callDetailsAjax($inventaire_id = null, $page = 1)
    {
        if ($this->request->is('post')) {
            $filter_url['controller'] = $this->request->params['controller'];
            $filter_url['action'] = 'details/'.$inventaire_id;

            $filter_url['page'] = $page;
            if (isset($this->data['Filter']) && is_array($this->data['Filter'])) {      
                foreach ($this->data['Filter'] as $name => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            if ($v) {
                                $filter_url[$name.'.'.$k] = $v;
                            }
                        }
                    } else {
                        if ($value) {
                            $filter_url[$name] = urlencode($value);
                        }
                    }
                }
            }

            return $this->redirect($filter_url);
        }
    }

    public function details($inventaire_id = null)
    {
        $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);
        $conditions['Inventairedetail.inventaire_id'] = $inventaire_id;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Inventairedetail.reference') {
                    $conditions['Inventairedetail.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Inventairedetail.libelle') {
                    $conditions['Inventairedetail.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Inventairedetail.date1') {
                    $conditions['Inventairedetail.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Inventairedetail.date2') {
                    $conditions['Inventairedetail.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Inventaire->Inventairedetail->recursive = -1;
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $inventaire['Inventaire']['depot_id']; /* $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]); */
        $conditions['Depotproduit.depot_id'] = $depots;

        
        $this->Paginator->settings = [
            'fields' => ['Inventaire.*', 'Inventairedetail.*', 'Depotproduit.quantite as quantite', 'Produit.*'],
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Inventairedetail.produit_id', 'Depotproduit.deleted = 0']],
            /* 	['table' => 'produits','alias' => 'Produit', 'type' => 'INNER','conditions' => ['Produit.id = Inventairedetail.produit_id','Produit.deleted = 0']] , */
            ],
            'order' => ['Inventairedetail.id' => 'ASC'],
            'group' => ['Inventairedetail.id'],
            'contain' => ['Produit', 'Inventaire'],
            'conditions' => $conditions,
        ];

        $taches = $this->Paginator->paginate('Inventairedetail');
        $this->set(compact('taches', 'inventaire'));
        $this->layout = false;
    }

    public function affectation($inventaire_id = null)
    {
        $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);
        $depot_id = (isset($inventaire['Inventaire']['depot_id']) and !empty($inventaire['Inventaire']['depot_id'])) ? $inventaire['Inventaire']['depot_id'] : 1;
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->request->data['Inventairedetail']['Produit']) and !empty($this->request->data['Inventairedetail']['Produit'])) {
                $data = [];
                foreach ($this->request->data['Inventairedetail']['Produit'] as $k => $v) {
                    $data[]['Inventairedetail'] = [
                        'inventaire_id' => $inventaire_id,
                        'produit_id' => $v,
                        'id' => null,
                    ];
                }
            }

            if (empty($data)) {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect($this->referer());
            }

            if ($this->Inventaire->Inventairedetail->saveMany($data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }

        $store_type = $this->Session->read('Auth.User.StoreSession.type');
        $options['Produit.type'] = 2;
        $options['OR'] = ['Produit.display_on' => $store_type, 'display_on' => 3];
        $already = $this->Inventaire->Inventairedetail->find('list', ['fields' => ['produit_id', 'produit_id'], 'conditions' => ['inventaire_id' => $inventaire_id]]);
        $exception = (!empty($already)) ? ['Produit.id !=' => $already] : [];
        $produits = $this->Inventaire->Inventairedetail->Produit->findList($options + $exception);
        $this->set(compact('produits'));
        $this->layout = false;
    }

    public function savedetails($inventaire_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);
            if (isset($this->request->data['Inventairedetail']) and !empty($this->request->data['Inventairedetail'])) {
                $data = [];
                foreach ($this->request->data['Inventairedetail'] as $k => $v) {
                    $data[]['Inventairedetail'] = [
                        'ecart' => $v['quantite_theorique'] - $v['quantite_reel'],
                        'quantite_theorique' => $v['quantite_theorique'],
                        'quantite_reel' => $v['quantite_reel'],
                        'id' => $v['id'],
                    ];
                    if ($v['quantite_reel'] != '0.000') {
                        $depot_produit = $this->Depotproduit->find('first', ['conditions' => ['produit_id' => $v['produit_id'], 'depot_id' => $inventaire['Inventaire']['depot_id']]]);
                        $this->Depotproduit->id = $depot_produit['Depotproduit']['id'];
                        $this->Depotproduit->saveField('quantite', $v['quantite_reel']);
                    }
                }
            }

            if (empty($data)) {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect($this->referer());
            }

            if ($this->Inventaire->Inventairedetail->saveMany($data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }
    }

    public function view($id = null)
    {
        $this->loadModel('Salepointdetail', 'Salepoint');
        $this->loadModel('Produit', 'Entree', 'Inventairedetail');

        if ($this->Inventaire->exists($id)) {
            $options1 = ['contain' => ['Creator', 'Depot'], 'conditions' => ['Inventaire.'.$this->Inventaire->primaryKey => $id]];
            $inventaire_header = $this->request->data = $this->Inventaire->find('first', $options1);
        }


        $depot_id = $this->request->data['Inventaire']['depot_id'];
        
        /*  $store_type = $this->Session->read('Auth.User.StoreSession.type');
         $options['Produit.type'] = 2;
         $options['OR'] = ['Produit.display_on' => $store_type, 'display_on' => 3];
         $already = $this->Inventaire->Inventairedetail->find('list', ['fields' => ['produit_id', 'produit_id'], 'conditions' => ['inventaire_id' => $id]]);
         $exception = (!empty($already)) ? ['Produit.id !=' => $already] : [];
         $produits = $this->Inventaire->Inventairedetail->Produit->findList($options + $exception); */
        $produits = $this->Inventaire->Inventairedetail->Produit->Depotproduit->find('list', ['fields' => ['produit_id', 'quantite'], 'conditions' => ['Depotproduit.depot_id' => $depot_id, 'Depotproduit.quantite !=' => 0]]);



        $this->getPath($this->idModule);
    }








    public function statut($inventaire_id = null, $statut = -1)
    {
        if (isset($this->globalPermission['Permission']['v']) and $this->globalPermission['Permission']['v'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de valider !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $inventaire = $this->Inventaire->find('first', ['conditions' => ['Inventaire.id' => $inventaire_id]]);
        $depot_id = (isset($inventaire['Inventaire']['depot_id']) and !empty($inventaire['Inventaire']['depot_id'])) ? $inventaire['Inventaire']['depot_id'] : 1;
        $reference = (isset($inventaire['Inventaire']['reference']) and !empty($inventaire['Inventaire']['reference'])) ? $inventaire['Inventaire']['reference'] : '';

        if (isset($inventaire['Inventaire']['statut']) and $inventaire['Inventaire']['statut'] == 1) {
            $this->Session->setFlash('Inventaire numéro : '.$reference.' déja cloturé', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $details = $this->Inventaire->Inventairedetail->find('all', ['conditions' => ['inventaire_id' => $inventaire_id]]);

        if (empty($details)) {
            $this->Session->setFlash('Opération impossible : aucun produit affecté !', 'alert-danger');

            return $this->redirect($this->referer());
        }

        $this->Inventaire->id = $inventaire_id;
        if ($this->Inventaire->saveField('statut', $statut)) {
            if ($statut == 1) {
                // adaptation du stock dépot
                foreach ($details as $k => $v) {
                    if (isset($v['Inventairedetail']['produit_id']) and !empty($v['Inventairedetail']['produit_id'])) {
                        $quantite_reel = (isset($v['Inventairedetail']['quantite_reel']) and !empty($v['Inventairedetail']['quantite_reel'])) ? (int) $v['Inventairedetail']['quantite_reel'] : 0;
                        $produit_id = $v['Inventairedetail']['produit_id'];
                        $this->adaptation($produit_id, $depot_id, $quantite_reel, $reference);
                    }
                }
            }
            $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function adaptation($produit_id = null, $depot_id = 1, $quantite_reel = 0, $reference = null)
    {
        $this->loadModel('Depotproduit');
        $depot = $this->Depotproduit->find('first', ['conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);

        $id = (isset($depot['Depotproduit']['id']) and !empty($depot['Depotproduit']['id'])) ? $depot['Depotproduit']['id'] : null;

        $data = [
            'id' => $id,
            'date' => date('Y-m-d'),
            'depot_id' => $depot_id,
            'produit_id' => $produit_id,
            'quantite' => $quantite_reel,
        ];

        if ($this->Depotproduit->save($data)) {
            unset($data);
        }

        $sortie = [
            'id' => null,
            'operation' => 3,
            'date' => date('Y-m-d'),
            'produit_id' => $produit_id,
            'depot_source_id' => $depot_id,
            'date_sortie' => date('Y-m-d'),
            'stock_source' => $quantite_reel,
            'description' => 'Inventaire du stock numéro : '.$reference,
        ];

        $this->loadModel('Mouvement');

        if ($this->Mouvement->save($sortie)) {
            unset($sortie);

            return true;
        } else {
            return false;
        }
    }

    private function CsvToArray($file, $delimiter)
    {
        ini_set('memory_limit', '-1');
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

    // Old but Gold
    public function exportergold($id_inv = null)
    {
        $this->loadModel('Inventairedetail');
        $this->loadModel('Produit');

        if (!$id_inv) {
            // Traitement si $id_inv n'est pas fourni
            // ...
        }
    
        // Récupérer les données de la table inventairedetails
        $data = $this->Inventairedetail->find('all', array(
            'conditions' => array('inventaire_id' => $id_inv),
            'fields' => array(
                'inventaire_id',
                'produit_id',
                'code_barre',
                'quantite_reel',
                'quantite_theorique',
                'ecart',
                'valstkini',
                'valentree',
                'valsortie',
                'qtentree',
                'qtsortie',
                'qtvente',
                'valvente'
            )
        ));
    
        // Nom du fichier de sortie
        $filename = 'inventaire_' . date('Y-m-d_H-i-s') . '.csv';
    
        // Ouverture du fichier en écriture
        $file = fopen($filename, 'w');
    
        // En-têtes CSV
        fputcsv($file, array(
            'inventaire_id',
            'produit_id',
            'code_barre',
            'quantite_reel',
            'quantite_theorique',
            'ecart',
            'valstkini',
            'valentree',
            'valsortie',
            'qtentree',
            'qtsortie',
            'qtvente',
            'valvente'
        ));
    
        // Écrire les données dans le fichier CSV
        foreach ($data as $row) {
            fputcsv($file, $row['Inventairedetail']);
        }
    
        // Fermer le fichier
        fclose($file);
    
        // Télécharger le fichier CSV généré
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $filename . '"');
        readfile($filename);
    
        // Supprimer le fichier après le téléchargement
        unlink($filename);
    
        // Empêcher le rendu de la vue
        $this->autoRender = false;

        $this->layout = false;
    }


    public function exporter($id_inv = null)
    {
        $this->loadModel('Inventairedetail');
        $this->loadModel('Produit');
    
        if (!$id_inv) {
            // Traitement si $id_inv n'est pas fourni
            // ...
        }
    
        // Récupérer les données de la table inventairedetails avec la jointure vers produits
        $data = $this->Inventairedetail->find('all', array(
            'conditions' => array('inventaire_id' => $id_inv),
            'fields' => array(
                'Inventairedetail.inventaire_id',
                'Inventairedetail.produit_id',
                'Produit.libelle',
                'Inventairedetail.code_barre',
                'Inventairedetail.quantite_reel',
                'Inventairedetail.quantite_theorique',
                'Inventairedetail.ecart',
                'Inventairedetail.valstkini',
                'Inventairedetail.valentree',
                'Inventairedetail.valsortie',
                'Inventairedetail.qtentree',
                'Inventairedetail.qtsortie',
                'Inventairedetail.qtvente',
                'Inventairedetail.valvente'
            ),
            'joins' => array(
                array(
                    'table' => 'produits',
                    'alias' => 'Produit',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Inventairedetail.produit_id = Produit.id'
                    )
                )
            )
        ));
    
        // Nom du fichier de sortie
        $filename = 'inventaire_' . date('Y-m-d_H-i-s') . '.csv';
    
        // Ouverture du fichier en écriture
        $file = fopen($filename, 'w');
    
        // En-têtes CSV
        fputcsv($file, array(
            'inventaire_id',
            'produit_id',
            'libelle', // Changement de position
            'code_barre',
            'quantite_reel',
            'quantite_theorique',
            'ecart',
            'valstkini',
            'valentree',
            'valsortie',
            'qtentree',
            'qtsortie',
            'qtvente',
            'valvente'
        ));
    
        // Écrire les données dans le fichier CSV
        foreach ($data as $row) {
            // Combiner les valeurs de 'Inventairedetail' et 'Produit'
            $combinedValues = array_merge($row['Inventairedetail'], $row['Produit']);
    
            // Extraire les valeurs du tableau associatif avec libelle en 3e position
            $csvRow = array(
                $combinedValues['inventaire_id'],
                $combinedValues['produit_id'],
                $combinedValues['libelle'], // Changement de position
                $combinedValues['code_barre'],
                $combinedValues['quantite_reel'],
                $combinedValues['quantite_theorique'],
                $combinedValues['ecart'],
                $combinedValues['valstkini'],
                $combinedValues['valentree'],
                $combinedValues['valsortie'],
                $combinedValues['qtentree'],
                $combinedValues['qtsortie'],
                $combinedValues['qtvente'],
                $combinedValues['valvente']
            );
    
            // Écrire la ligne dans le fichier CSV
            fputcsv($file, $csvRow);
        }
    
        // Fermer le fichier
        fclose($file);
    
        // Télécharger le fichier CSV généré
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);
    
        // Supprimer le fichier après le téléchargement
        unlink($filename);
    
        // Empêcher le rendu de la vue
        $this->autoRender = false;
    
        $this->layout = false;
    }

    

    
    

    




    public function importer($id = null)
    {

// bonreceptions = données entrées => relation mouvementprincipal_id
// mouvementprincipals = stocker tt les données stock et pas forcement son valider

// sortiedetails

        // Connexion aux tables
        $this->loadModel('Salepointdetail', 'Salepoint');
        $this->loadModel('Produit', 'Entree', 'Inventairedetail');
        $this->loadModel("Sortiedetail", "Depotproduit");

        $champs = [];
        ini_set('memory_limit', '-1');
        if ($this->request->is(['post', 'put'])) {
            $delimiteur = (isset($this->data['Inventairedetail']['delimiteur']) and !empty($this->data['Inventairedetail']['delimiteur'])) ? $this->data['Inventairedetail']['delimiteur'] : ';';
            $ImportedFile = $this->CsvToArray($this->data['Inventairedetail']['file']['tmp_name'], $delimiteur);

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

            foreach ($tab as $key => $value) { // Filter
                if (empty($value['code_barre'])) {
                    unset($tab[$key]);
                }

                // recupérer le code barre net
                if (!empty($value['code_barre'])) {
                     $code_barre_array[] = $value['code_barre'];
                }
            }

// $tab ==========================> data CSV importé


            

        // Inventaire informations header
        if ($this->Inventaire->exists($id)) {
            $options1 = ['contain' => ['Creator', 'Depot'], 'conditions' => ['Inventaire.'.$this->Inventaire->primaryKey => $id]];
            $inventaire_header = $this->request->data = $this->Inventaire->find('first', $options1);
        }

        // Depot ID 
        $depot_id = $this->request->data['Inventaire']['depot_id'];
     
        // Inventaire actual
        $inventaire_id_actuel               = $inventaire_header['Inventaire']['id'];         

        // Si il y a des données dans la table Inventairedetail == vider la table avant l'importation
        $inventaire_details_actuel  = $this->Inventaire->Inventairedetail->find('all', array(
            'conditions' => array(
                'inventaire_id' => $inventaire_id_actuel,
            ),
        ));

       
        if (!empty($inventaire_details_actuel)) {
            $this->loadModel('Inventairedetail');
            $conditions = array(
                'Inventairedetail.inventaire_id' => $inventaire_id_actuel
            );
            if ($this->Inventairedetail->deleteAll($conditions)) {
                $this->Session->setFlash('Les enregistrements ont été supprimés avec succès.', 'alert-success');
                echo "on deleted inv detail";
            } else {
                $this->Session->setFlash('Une erreur s\'est produite lors de la suppression des enregistrements.', 'alert-danger');
            }
        }
            
            // inventaire J -1
            $full_inventaire_date_actuel    = $inventaire_header['Inventaire']['date'];
            $inventaire_date_actuel             = date('Y-m-d', strtotime($full_inventaire_date_actuel));
            $inventaire_date_actuel = new DateTime($inventaire_date_actuel); // Convertir en objet DateTime
            $inventaire_date_actuel->sub(new DateInterval('P1D')); // Soustraire 1 jour 
            $inventaire_date_actuel_J_moins_1 = $inventaire_date_actuel->format('Y-m-d'); // Formatage de la date au format 'YYYY-MM-DD'

            // Prépration de condition pour inventaire_precedent 
            $conditions = array(
                'Inventaire.statut' => 1,
                'Inventaire.depot_id' => $depot_id,
                'Inventaire.id <' => $inventaire_id_actuel
            );

            $inventaire_precedent = $this->Inventaire->find('first', array(
                'conditions' => $conditions,
                'order' => array('Inventaire.id DESC')
            ));

            if (!empty($inventaire_precedent)) {
                $full_date_inventaire_precedent = $inventaire_precedent['Inventaire']['date'];
                $date_inventaire_precedent      = date('Y-m-d', strtotime($full_date_inventaire_precedent));
            }else{
                // App::uses('CakeTime', 'Utility');
                // $date_inventaire_precedent = CakeTime::format('Y-m-d', 'now');
                // Date d'importation des données initiales.
                $date_inventaire_precedent = "2024-01-01";
            }

    
            $inventaire_id_precedent = $inventaire_precedent['Inventaire']['id'];
            // $inventaire_id_precedent = 13; // pour le teste

            $inventaire_precedent_details = $this->Inventaire->Inventairedetail->find('all', array(
                'conditions' => array(
                    'inventaire_id' => $inventaire_id_precedent,
                    // 'produit_id' => $produit_id
                ),
                'fields' => array(
                    'produit_id',
                    'quantite_reel',
                )
            ));

            $donnees_inv_prece_db = array();

            foreach ($inventaire_precedent_details as $detail) {
                // Récupérer les éléments nécessaires du tableau existant
                $produit_id = $detail['Inventairedetail']['produit_id'];
                $valstkini = $detail['Inventairedetail']['quantite_reel'];
                // Ajouter les éléments au tableau reformulé
                $donnees_inv_prece_db[] = array(
                    'produit_id_inv_prece' => $produit_id,
                    'valstkini' => $valstkini,
                );
            }
            /// $donnees_inv_prece_db => détails données des INV PRECE

            // Les ventes
            $spdetail = $this->Salepointdetail->find('all', array(
                'fields' => array(
                    'SUM(Salepointdetail.qte) as total_qte',
                    'SUM(Salepointdetail.total) as total_prix_vente',
                    'Salepointdetail.produit_id as produit_id_vente',
                ),
                'conditions' => array(
                    'Salepoint.depot_id' => $depot_id,
                    'DATE(Salepointdetail.date_c) BETWEEN ? AND ?' => array(
                        $date_inventaire_precedent,
                        $inventaire_date_actuel_J_moins_1
                    )
                ),
                'group' => 'Salepointdetail.produit_id',
                'joins' => array(
                    array(
                        'table' => 'salepoints',
                        'alias' => 'Salepoint',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Salepoint.id = Salepointdetail.salepoint_id'
                        )
                    )
                )
            ));
            
            // Organiser les résultats
            $lesVentes = array();
            foreach ($spdetail as $detail) {
                $lesVentes[] = array(
                    'total_qte' => $detail[0]['total_qte'],
                    'total_prix_vente' => $detail[0]['total_prix_vente'],
                    'produit_id_vente' => $detail['Salepointdetail']['produit_id_vente']
                );
            }
            
            // Maintenant, $lesVentes contient les résultats formatés comme souhaité
            
// $lesVentes ======================> data des Ventes


        $conditions_sortie = array(
            'Sortiedetail.depot_source_id' => $depot_id,
            'Sortiedetail.date BETWEEN ? AND ?' => array(
                $date_inventaire_precedent,
                $inventaire_date_actuel_J_moins_1
            ),
            'Sortiedetail.deleted' => 0
        );

        $donnees_sortie = $this->Sortiedetail->find('all', array(
            'conditions' => $conditions_sortie,
            'fields' => array(
                'SUM(Sortiedetail.stock_source) as sum_stock_source',
                'Sortiedetail.produit_id',
                'Produits.code_barre', // Ajout de la colonne code_barre
            ),
            'group' => 'Sortiedetail.produit_id',
            'joins' => array(
                array(
                    'table' => 'produits', // Utilisation du bon nom de table
                    'alias' => 'Produits', // Utilisation de l'alias correct
                    'type' => 'INNER',
                    'conditions' => array(
                        'Produits.id = Sortiedetail.produit_id',
                    ),
                ),
            ),
        ));
        
        // Initialiser le tableau final
        $donnees_sortie_db = array();
        
        // Parcourir les résultats et ajuster le tableau final
        foreach ($donnees_sortie as $result) {
            $donnees_sortie_db[] = array(
                'total_qnt_sortie' => $result[0]['sum_stock_source'],
                'produit_id_sortie' => $result['Sortiedetail']['produit_id'],
                'code_barre_sortie' => $result['Produits']['code_barre'], // Utilisation du bon nom de table
            );
        }
    
// $donnees_sortie_db ======================> data des sortie


        $conditions_entree = array(
            'Sortiedetail.depot_destination_id' => $depot_id,
            'Sortiedetail.date BETWEEN ? AND ?' => array(
                $date_inventaire_precedent,
                $inventaire_date_actuel_J_moins_1
            ),
            'Sortiedetail.deleted' => 0
        );

        $donnees_entree = $this->Sortiedetail->find('all', array(
            'conditions' => $conditions_entree,
            'fields' => array(
                'SUM(Sortiedetail.stock_source) as sum_stock_source_entree',
                'Sortiedetail.produit_id',
                'Produits.code_barre', // Utilisation du bon nom de table
            ),
            'group' => 'Sortiedetail.produit_id',
            'joins' => array(
                array(
                    'table' => 'produits', // Utilisation du bon nom de table
                    'alias' => 'Produits', // Utilisation de l'alias correct
                    'type' => 'INNER',
                    'conditions' => array(
                        'Produits.id = Sortiedetail.produit_id',
                    ),
                ),
            ),
        ));
    
        // Initialiser le tableau final
        $donnees_entree_db = array();
        
        // Parcourir les résultats et ajuster le tableau final
        foreach ($donnees_entree as $result) {
            $donnees_entree_db[] = array(
                'total_qnt_entree' => $result[0]['sum_stock_source_entree'],
                'produit_id_entree' => $result['Sortiedetail']['produit_id'],
                'code_barre_entree' => $result['Produits']['code_barre'], // Utilisation du bon nom de table
            );
        }

// $donnees_entree ======================> data des Entree

        $donnees_depot_produits = $this->Depotproduit->find('all', array(
            'conditions' => array(
                'depot_id' => $depot_id,
                // 'deleted' => 0,
            ),
            'fields' => array(
                'Depotproduit.produit_id',
                'Depotproduit.quantite',
                'Produits.code_barre',
                'Produits.prix_vente',
            ),
            'joins' => array(
                array(
                    'table' => 'produits',
                    'alias' => 'Produits',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Produits.id = Depotproduit.produit_id',
                    ),
                ),
            ),
        ));

        // Initialiser le tableau final
        $donnees_depot_produits_reformatees = array();

        // Parcourir les résultats et ajuster le tableau final
        foreach ($donnees_depot_produits as $result) {
            $donnees_depot_produits_reformatees[] = array(
                'produit_id' => $result['Depotproduit']['produit_id'],
                'quantite' => $result['Depotproduit']['quantite'],
                'code_barre_depot_produit' => $result['Produits']['code_barre'],
                'prix_vente_produit_depot_produit' => $result['Produits']['prix_vente'],
            );
        }
        // Utilisez $donnees_depot_produits_reformatees comme tableau reformulé selon vos besoins.

        $produit_id_entree_array    = array_column($donnees_entree_db, 'produit_id_entree');
        $produit_id_sortie_array    = array_column($donnees_sortie_db, 'produit_id_sortie');
        $produit_id_vente_array     = array_column($lesVentes, 'produit_id_vente');
        $code_barre_array           = array_column($tab, 'code_barre');
        $produit_id_inv_prece_array = array_column($donnees_inv_prece_db, 'produit_id_inv_prece');
        
        $inventaireDataToSave = array();

        foreach ($donnees_depot_produits_reformatees as $depot_produit) {
            $produit_id_depot_produit = $depot_produit['produit_id'];
            $code_barre_depot_produit = $depot_produit['code_barre_depot_produit'];
            $prix_vente_depot_produit = $depot_produit['prix_vente_produit_depot_produit'];
            
            // Initialiser les variables
            $quantite_reel = "0,000";
            $code_barre_tab = 0;
            $total_qte_vente = "0.000";
            $total_prix_vente = "0.000";
            $total_qnt_sortie = "0.000";
            $total_qnt_entree = "0.000";
            $valstkini = "0.000";
            $quantite_theorique = "0.000";
            $ecart = "0.000";
            

            // Vérifier si $produit_id_depot_produit existe 
            $produit_id_entree_key      = array_search($produit_id_depot_produit, $produit_id_entree_array);
            $produit_id_sortie_key      = array_search($produit_id_depot_produit, $produit_id_sortie_array);
            $produit_id_vente_key       = array_search($produit_id_depot_produit, $produit_id_vente_array);
            $code_barre_tab_key         = array_search($code_barre_depot_produit, $code_barre_array); // fichier CSV
            $produit_id_inv_prece_key   = array_search($produit_id_depot_produit, $produit_id_inv_prece_array);

            if ($produit_id_inv_prece_key !== false) {
                $information_inv_prece = $donnees_inv_prece_db[$produit_id_inv_prece_key];
                $valstkini = $information_inv_prece['valstkini'];
            }

            if ($produit_id_entree_key !== false) {
                $information_entree = $donnees_entree_db[$produit_id_entree_key];
                $total_qnt_entree = $information_entree['total_qnt_entree'];
            }

            if ($produit_id_sortie_key !== false) {
                $information_sortie = $donnees_sortie_db[$produit_id_sortie_key];
                $total_qnt_sortie = $information_sortie['total_qnt_sortie'];
            }

            if ($produit_id_vente_key !== false) {
                $information_vente = $lesVentes[$produit_id_vente_key];
                $total_qte_vente    = $information_vente['total_qte'];
                $total_prix_vente   = $information_vente['total_prix_vente'];
            }

            if ($code_barre_tab_key !== false) {
                $information_tab = $tab[$code_barre_tab_key];
                $quantite_reel = $information_tab['quantite_reel'];

                $quantite_reel  = trim($quantite_reel);
                $quantite_reel  = (float) str_replace(',', '.', $quantite_reel);

                $code_barre_tab = $information_tab['code_barre'];
            }

            // Calculer quantite_theorique & ecart
            $quantite_theorique = ($valstkini + $total_qnt_entree - $total_qnt_sortie - $total_qte_vente);
            $ecart = $quantite_reel - $quantite_theorique;

            // Calculer valentree & valentree            
            $valentree = $prix_vente_depot_produit * $total_qnt_entree;
            $valsortie = $prix_vente_depot_produit * $total_qnt_sortie;

            // Ajouter les éléments au tableau $inventaireDataToSave
            $inventaireDataToSave[] = array(
                'inventaire_id' => $inventaire_id_actuel,
                'produit_id' => $produit_id_depot_produit,
                'code_barre' => $code_barre_depot_produit,
                'valstkini' => $valstkini, // quantite_theorique de l'INV precedent
                'quantite_reel' => $quantite_reel,
                'qtvente' => $total_qte_vente,
                'valvente' => $total_prix_vente,
                'qtsortie' => $total_qnt_sortie,
                'qtentree' => $total_qnt_entree,
                'quantite_theorique' => $quantite_theorique,
                'ecart' => $ecart,
                'valentree' => $valentree,
                'valsortie' => $valsortie,
            );

        } // END of Foreach

        // debug($inventaireDataToSave);
        // die(); 

            if ($this->Inventaire->Inventairedetail->saveMany($inventaireDataToSave)) {
                $this->Session->setFlash('Les données d\'inventaire ont été importées avec succès. [MS2-MD100]', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème lors d\'enregistrement des données [MS1-MD101]', 'alert-danger');
            }
            return $this->redirect($this->referer());

        }

        $this->layout = false;
    }



    // Function GOLD - copy of IMPORTER
    public function importerOLDONE($id = null)
    {
        // Connexion aux tables
        $this->loadModel('Salepointdetail', 'Salepoint');
        $this->loadModel('Produit', 'Entree', 'Inventairedetail');

        $champs = [];
        ini_set('memory_limit', '-1');
        if ($this->request->is(['post', 'put'])) {
            $delimiteur = (isset($this->data['Inventairedetail']['delimiteur']) and !empty($this->data['Inventairedetail']['delimiteur'])) ? $this->data['Inventairedetail']['delimiteur'] : ';';
            $ImportedFile = $this->CsvToArray($this->data['Inventairedetail']['file']['tmp_name'], $delimiteur);

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

            foreach ($tab as $key => $value) { // Filter
                if (empty($value['code_barre'])) {
                    unset($tab[$key]);
                }

                // recupérer le code barre net
                if (!empty($value['code_barre'])) {
                    echo $code_barre_array[] = $value['code_barre'];
                    echo "<br /";
                }
            }



die();

        // Inventaire informations header
        if ($this->Inventaire->exists($id)) {
            $options1 = ['contain' => ['Creator', 'Depot'], 'conditions' => ['Inventaire.'.$this->Inventaire->primaryKey => $id]];
            $inventaire_header = $this->request->data = $this->Inventaire->find('first', $options1);
        }

        // Depot ID 
        $depot_id = $this->request->data['Inventaire']['depot_id'];
     
        // Inventaire actual
        $inventaire_id_actuel               = $inventaire_header['Inventaire']['id'];         

        // Si il y a des données dans la table Inventairedetail == vider la table avant l'importation
        $inventaire_details_actuel  = $this->Inventaire->Inventairedetail->find('all', array(
            'conditions' => array(
                'inventaire_id' => $inventaire_id_actuel,
            ),
        ));

        if (!empty($inventaire_details_actuel)) {
            
            $this->loadModel('Inventairedetail');
            $conditions = array(
                'Inventairedetail.inventaire_id' => $inventaire_id_actuel
            );
            if ($this->Inventairedetail->deleteAll($conditions)) {
                $this->Session->setFlash('Les enregistrements ont été supprimés avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Une erreur s\'est produite lors de la suppression des enregistrements.', 'alert-danger');
            }
        }

                  
            // inventaire J -1
            $full_inventaire_date_actuel    = $inventaire_header['Inventaire']['date'];
            $inventaire_date_actuel             = date('Y-m-d', strtotime($full_inventaire_date_actuel));
            $inventaire_date_actuel = new DateTime($inventaire_date_actuel); // Convertir en objet DateTime
            $inventaire_date_actuel->sub(new DateInterval('P1D')); // Soustraire 1 jour 
            $inventaire_date_actuel_J_moins_1 = $inventaire_date_actuel->format('Y-m-d'); // Formatage de la date au format 'YYYY-MM-DD'

            // Prépration de condition pour inventaire_precedent 
            $conditions = array(
                'Inventaire.statut' => 1,
                'Inventaire.depot_id' => $depot_id,
                'Inventaire.id <' => $inventaire_id_actuel
            );

            $inventaire_precedent = $this->Inventaire->find('first', array(
                'conditions' => $conditions,
                'order' => array('Inventaire.id DESC')
            ));

            if (!empty($inventaire_precedent)) {
                $full_date_inventaire_precedent = $inventaire_precedent['Inventaire']['date'];
                $date_inventaire_precedent      = date('Y-m-d', strtotime($full_date_inventaire_precedent));
            }else{
                App::uses('CakeTime', 'Utility');
                $date_inventaire_precedent = CakeTime::format('Y-m-d', 'now');
            }

            /// Récupération des quantités d'entrées et sorties entre les deux dates
            $quantites_entree_sortie = $this->Entree->find('all', array(
                'fields' => array(
                    'Entree.id',
                    'Entree.produit_id',
                    'SUM(CASE WHEN Entree.type = "Entree" THEN Entree.quantite ELSE 0 END) as qtentree',
                    'SUM(CASE WHEN Entree.type = "Sortie" THEN Entree.quantite ELSE 0 END) as qtsortie'
                ),
                'conditions' => array(
                    'Entree.depot_id' => $depot_id,
                    'DATE(Entree.date_c) BETWEEN ? AND ?' => array(
                        date('Y-m-d', strtotime($date_inventaire_precedent)),       // Date de l'inventaire précédent
                        date('Y-m-d', strtotime($inventaire_date_actuel_J_moins_1))  // Jusqu'à hier J-1
                    )
                ),
                'group' => array('Entree.produit_id'),
                'recursive' => -1
            ));

            // Récupration des données FOREACH
            $inventaireData = array();
            $ecart_calc = "0.000";

            foreach ($quantites_entree_sortie as $entree_sortie) {                
                $produit_id = $entree_sortie['Entree']['produit_id'];

                // Récupération du prix de vente du produit ___________ CHECK THIS OUT ! 
                $produit = $this->Produit->find('first', array(
                    'fields' => array('Produit.prix_vente', 'Produit.code_barre'),
                    'conditions' => array('Produit.id' => $produit_id),
                    'recursive' => -1
                ));

                // Détails des ventes t_salepoints
                $spdetail = $this->Salepointdetail->find('first', array(
                    'fields' => array(
                        'SUM(Salepointdetail.qte) as total_qte',
                        'SUM(Salepointdetail.total) as total_prix_vente'
                    ),
                    'conditions' => array(
                        'Salepointdetail.produit_id' => $produit_id,
                        'Salepoint.depot_id' => $depot_id, // Condition depot_id
                        'DATE(Salepointdetail.date_c) BETWEEN ? AND ?' => array(
                            $date_inventaire_precedent,      // Date de l'inventaire précédent
                            $inventaire_date_actuel_J_moins_1 // Jusqu'à hier J-1
                        )
                    ),
                    'joins' => array(
                        array(
                            'table' => 'salepoints',
                            'alias' => 'Salepoint',
                            'type' => 'INNER',
                            'conditions' => array(
                                'Salepoint.id = Salepointdetail.salepoint_id'
                            )
                        )
                    )
                ));

                $qtvente    = $spdetail[0]['total_qte'];
                $valvente   = $spdetail[0]['total_prix_vente'];


              
                // Récupération STOCK INI
                    /// => Récupération des infos inventaire -1

                if (!empty($inventaire_precedent)) {

                    $inventaire_id_precedent = $inventaire_precedent['Inventaire']['id'];

                    $inventaire_details = $this->Inventaire->Inventairedetail->find('all', array(
                        'conditions' => array(
                            'inventaire_id' => $inventaire_id_precedent,
                            'produit_id' => $produit_id
                        ),
                        'fields' => array(
                            'produit_id',
                            'quantite_reel',
                            'quantite_theorique'
                        )
                    ));

                    if (!empty($inventaire_details)) {
                        $quantites_reel = Set::extract('/Inventairedetail/quantite_reel', $inventaire_details);
                        $quantite_theorique = Set::extract('/Inventairedetail/quantite_theorique', $inventaire_details);
                        $produit_precedent = Set::extract('/Inventairedetail/produit_id', $inventaire_details);
                        $valstkini  = $quantites_reel['0'];
                    }else{
                        $quantites_reel     = "0.000";
                        $quantite_theorique = "0.000";
                        $produit_precedent  = "0.000";
                        $valstkini          = "0.000";
                    }

                } else {
                    // Aucun inventaire précédent trouvé
                    // Crée un nouveau inventaire vide ::: EMPTY DATA
                    $quantites_reel     = "0.000";
                    $quantite_theorique = "0.000";
                    $produit_precedent  = "0.000";
                    $valstkini          = "0.000";
                }

                // Calculer valentree & valentree
                $prix_vente = $produit['Produit']['prix_vente'];
                $code_barre = $produit['Produit']['code_barre'];
                $valentree  = (float)$prix_vente * (float)$entree_sortie[0]['qtentree'];
                $valsortie  = (float)$prix_vente * (float)$entree_sortie[0]['qtsortie'];



                // Calculer STOCK THÉORIQUE
                $qtsortie   = (float)$entree_sortie[0]['qtsortie'];
                $qtentree   = (float)$entree_sortie[0]['qtentree'];
                $quantite_theorique = ($valstkini + $qtentree - $qtsortie - $qtvente);

                // Gérer les valeurs nulles
                $qtvente    = ($qtvente !== null) ? $qtvente : "0.000";
                $valvente   = ($valvente !== null) ? $valvente : "0.000";

                $qtentree    = ($qtentree !== null || $qtentree === "0") ? $qtentree : "0.000";
                $qtsortie   = ($qtsortie !== null || $qtsortie === "0") ? $qtsortie : "0.000";


                // Sauvegarde des données dans la table Inventaire
                $inventaireData[] = array(
                    'Inventairedetail' => array(
                        'inventaire_id' => $inventaire_header['Inventaire']['id'],
                        'produit_id' => $produit_id,
                        'code_barre' => $code_barre,
                        'valstkini' => $valstkini,
                        'qtentree' => $qtentree,
                        'qtsortie' => $qtsortie,
                        'valentree' => $valentree,
                        'valsortie' => $valsortie,
                        'qtvente' => $qtvente,
                        'valvente' => $valvente,
                        'quantite_theorique' => $quantite_theorique,
                    )
                );
                
                        // THIS IS THE GOLD!
                    $this->Inventaire->Inventairedetail->saveMany($inventaireData);
                    
            } // END foreach




            $insert = [];
            foreach ($tab as $key => $value) {
                $value['id'] = null;
                $value['inventaire_id'] = $id;
                
                if (isset($value['quantite_reel']) && !empty($value['quantite_reel'])) {
                    $value['quantite_reel'] = trim($value['quantite_reel']);
                    $value['quantite_reel'] = (float) str_replace(',', '.', $value['quantite_reel']);
                }
            
                if (isset($value['code_barre']) && !empty($value['code_barre'])) {
                    $value['code_barre'] = strtolower(trim($value['code_barre']));
                    $value['code_barre'] = str_replace(' ', '', $value['code_barre']);
                    
                    // Chercher le code_barre dans le tableau $produit
                    if (isset($produit[$value['code_barre']])) {
                        $value['produit_id'] = $produit[$value['code_barre']];
                    }
                }
                
                $insert[]['Inventairedetail'] = $value;
            }
            
            
            $mergedData = array();
            // Créer un tableau associatif avec le code_barre comme clé pour le tableau insert
            $insertDataByCodeBarre = [];
            foreach ($insert as $insertData) {
                $insertDataByCodeBarre[$insertData['Inventairedetail']['code_barre']] = $insertData;
            }
            
            // Parcourir le tableau inventaireData
            foreach ($inventaireData as $inventaireDataItem) {
                $code_barre = $inventaireDataItem['Inventairedetail']['code_barre'];
                $quantite_reel = 0.000; // Valeur par défaut
            
                // Vérifier si le code_barre existe dans le tableau insertDataByCodeBarre
                if (isset($insertDataByCodeBarre[$code_barre])) {
                    $quantite_reel = $insertDataByCodeBarre[$code_barre]['Inventairedetail']['quantite_reel'];
                }
            
                // Déterminer le type_data en fonction de la comparaison des code_barre
                // $type_data = ($code_barre === $insertDataByCodeBarre[$code_barre]['Inventairedetail']['code_barre']) ? 0 : 1;
                $type_data = isset($insertDataByCodeBarre[$code_barre]) && ($code_barre === $insertDataByCodeBarre[$code_barre]['Inventairedetail']['code_barre']) ? 0 : 1;

                // Créer le tableau de données fusionnées et mises à jour
                $mergedData[] = array(
                    'Inventairedetail' => array(
                        'inventaire_id' => $inventaireDataItem['Inventairedetail']['inventaire_id'],
                        'produit_id' => $inventaireDataItem['Inventairedetail']['produit_id'],
                        'code_barre' => $code_barre,
                        'valstkini' => $inventaireDataItem['Inventairedetail']['valstkini'],
                        'qtentree' => $inventaireDataItem['Inventairedetail']['qtentree'],
                        'qtsortie' => $inventaireDataItem['Inventairedetail']['qtsortie'],
                        'valentree' => $inventaireDataItem['Inventairedetail']['valentree'],
                        'valsortie' => $inventaireDataItem['Inventairedetail']['valsortie'],
                        'qtvente' => $inventaireDataItem['Inventairedetail']['qtvente'],
                        'valvente' => $inventaireDataItem['Inventairedetail']['valvente'],
                        'quantite_theorique' => $inventaireDataItem['Inventairedetail']['quantite_theorique'],
                        'quantite_reel' => $quantite_reel,
                        'type_data' => $type_data,
                        'ecart' => $quantite_reel - $inventaireDataItem['Inventairedetail']['quantite_theorique']
                    )
                );

                
            }
            


            
            
            if (empty($insert)) {
                $this->Session->setFlash('Opération impossible : Fichier vide !', 'alert-danger');
                return $this->redirect($this->referer());
            }

            if ($this->Inventaire->Inventairedetail->saveMany($mergedData)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès. [MS2-MD100]', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème lors d\'enregistrement des données [MS1-MD101]', 'alert-danger');
            }
            return $this->redirect($this->referer());



            
        }

        $this->layout = false;
    }





    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Inventaire->id = $id;
        if (!$this->Inventaire->exists()) {
            throw new NotFoundException(__('Invalide Inventaire'));
        }

        if ($this->Inventaire->delete()) {
            $this->Inventaire->Inventairedetail->deleteAll(['Inventairedetail.inventaire_id' => $id], false);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function deletedetail($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Inventaire->Inventairedetail->id = $id;
        if (!$this->Inventaire->Inventairedetail->exists()) {
            throw new NotFoundException(__('Invalide Inventaire'));
        }

        if ($this->Inventaire->Inventairedetail->delete()) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }
}
