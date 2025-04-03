<?php

App::uses('Uploadfile', 'Lib');

class IngredientsController extends AppController
{
    public $uses = ['Produit'];
    protected $idModule = 117;

    public function beforeFilter()
    {
        // sync
        $this->Auth->allow('insertProduitsApi', 'apiGetProduitsToSync');
        
        // before filtre
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function index()
    {
        $categorieproduits = $this->Produit->Categorieproduit->find('list', ['order' => 'libelle asc']);
        $souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order' => 'libelle asc']);
        $unites = $this->Produit->Unite->find('list', ['order' => 'libelle asc']);
        $this->set(compact('categorieproduits', 'souscategorieproduits', 'unites', 'typeOF'));
        $this->getPath($this->idModule);
    }

    public function pdf($id = null)
    {
        if ($this->Produit->exists($id)) {
            $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
            $this->request->data = $this->Produit->find('first', $options);
        } else {
            $this->Session->setFlash("Ce produit n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('params'));
        $this->layout = false;
    }

    public function excel()
    {
        $admins = $this->Session->read('admins');
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $store_type = $this->Session->read('Auth.User.StoreSession.type');
        $conditions['Produit.type'] = 2;
        $conditions['OR'] = ['Produit.display_on' => $store_type, 'display_on' => 3];
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Produit.reference') {
                    $conditions['Produit.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.libelle') {
                    $conditions['Produit.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.code_barre') {
                    $conditions['Produit.code_barre LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.date1') {
                    $conditions['Produit.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Produit.date2') {
                    $conditions['Produit.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }
        $settings = [
            'contain' => ['Categorieproduit', 'Unite', 'Creator'],
            'order' => ['Produit.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Produit->find('all', $settings);
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function indexAjax()
    {
        $admins = $this->Session->read('admins');
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $conditions = [];
        /* $store_type = $this->Session->read('Auth.User.StoreSession.type');
        $conditions['Produit.type'] = 2;
        $conditions['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3]; */
        //afficher les produits pour tous les utilisateurs
        //if ( !in_array($role_id, $admins) ) $conditions['Produit.user_c'] = $user_id;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Produit.reference') {
                    $conditions['Produit.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.libelle') {
                    $conditions['Produit.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.code_barre') {
                    $conditions['Produit.code_barre LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.date1') {
                    $conditions['Produit.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Produit.date2') {
                    $conditions['Produit.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }
        $this->Produit->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['Categorieproduit', 'Souscategorieproduit', 'Unite', 'Creator'],
            'order' => ['Produit.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function recettes($produit_id = null)
    {
        $recettes = $this->Produit->Produitingredient->find('all', [
            'fields' => ['Produitingredient.*', 'Produit.*'],
            'joins' => [
                ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produitingredient.produit_id = Produit.id']],
            ],
            'conditions' => ['Produitingredient.ingredient_id' => $produit_id],
            'order' => ['Produitingredient.id' => 'DESC'],
        ]);

        $this->set(compact('recettes', 'produit_id'));
        $this->layout = false;
    }

    public function societeprices($produit_id = null)
    {
        $prices = $this->Produit->Produitprice->find('all', [
            'fields' => ['Produitprice.*', 'Societe.designation', 'Store.libelle'],
            'conditions' => ['Produitprice.produit_id' => $produit_id],
            'joins' => [
                ['table' => 'societes', 'alias' => 'Societe', 'type' => 'INNER', 'conditions' => ['Produitprice.societe_id = Societe.id']],
                ['table' => 'stores', 'alias' => 'Store', 'type' => 'INNER', 'conditions' => ['Produitprice.store_id = Store.id']],
            ],
            'order' => ['Produitprice.id' => 'DESC'],
        ]);

        $this->set(compact('prices', 'produit_id'));
        $this->layout = false;
    }

    public function fournisseurprices($produit_id = null)
    {
        $prices = $this->Produit->Produitprice->find('all', [
            'fields' => ['Produitprice.*', 'Fournisseur.designation'],
            'conditions' => ['Produitprice.produit_id' => $produit_id],
            'joins' => [
                ['table' => 'fournisseurs', 'alias' => 'Fournisseur', 'type' => 'INNER', 'conditions' => ['Produitprice.fournisseur_id = Fournisseur.id']],
            ],
            'order' => ['Produitprice.id' => 'DESC'],
        ]);

        $this->set(compact('prices', 'produit_id'));
        $this->layout = false;
    }

    public function editsocieteprice($id = null, $produit_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Produitprice']['produit_id'] = $produit_id;
            if ($this->Produit->Produitprice->save($this->request->data)) {
                die('L\'enregistrement a été effectué avec succès.');
            } else {
                die('Il y a un problème');
            }
        } elseif ($this->Produit->Produitprice->exists($id)) {
            $options = ['conditions' => ['Produitprice.'.$this->Produit->Produitprice->primaryKey => $id]];
            $this->request->data = $this->Produit->Produitprice->find('first', $options);
        }
        $tvas = $this->Produit->TvaAchat->findList();
        $societes = $this->Produit->Produitprice->Societe->find('list');
        $stores = $this->Produit->Produitprice->Store->find('list');
        $this->set(compact('societes', 'stores', 'produit_id', 'tvas'));
        $this->layout = false;
    }

    public function editfournisseurprice($id = null, $produit_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Produitprice']['produit_id'] = $produit_id;
            $this->request->data['Produitprice']['default_frs'] = (isset($this->request->data['Produitprice']['default_frs']) and $this->request->data['Produitprice']['default_frs'] == 1) ? 1 : -1;

            if (isset($this->request->data['Produitprice']['id']) and !empty($this->request->data['Produitprice']['id'])) {
                $count = $this->Produit->Produitprice->find('count', [
                    'conditions' => [
                        'Produitprice.id !=' => $this->request->data['Produitprice']['id'],
                        'Produitprice.produit_id' => $produit_id,
                        'Produitprice.societe_id' => null,
                        'Produitprice.default_frs' => 1,
                    ],
                ]);
                if ($count == 0) {
                    $this->request->data['Produitprice']['default_frs'] = 1;
                }
            }

            if ($this->Produit->Produitprice->save($this->request->data)) {
                $price_id = $this->Produit->Produitprice->id;
                $count = $this->Produit->Produitprice->find('count', [
                    'conditions' => [
                        'Produitprice.id !=' => $price_id,
                        'Produitprice.produit_id' => $produit_id,
                        'Produitprice.societe_id' => null,
                        'Produitprice.default_frs' => 1,
                    ],
                ]);
                if ($count == 0) {
                    $this->Produit->Produitprice->id = $price_id;
                    $this->Produit->Produitprice->saveField('default_frs', 1);
                }
                if ($this->request->data['Produitprice']['default_frs'] == 1) {
                    $this->Produit->Produitprice->updateAll(['Produitprice.default_frs' => -1], ['Produitprice.id !=' => $price_id, 'Produitprice.produit_id' => $produit_id, 'Produitprice.societe_id' => null]);
                }
                die('L\'enregistrement a été effectué avec succès.');
            } else {
                die('Il y a un problème');
            }
        } elseif ($this->Produit->Produitprice->exists($id)) {
            $options = ['conditions' => ['Produitprice.'.$this->Produit->Produitprice->primaryKey => $id]];
            $this->request->data = $this->Produit->Produitprice->find('first', $options);
            $this->request->data['Produitprice']['default_frs'] = (isset($this->request->data['Produitprice']['default_frs']) and $this->request->data['Produitprice']['default_frs'] == 1) ? 1 : 0;
        }
        $tvas = $this->Produit->TvaAchat->findList();
        $fournisseurs = $this->Produit->Produitprice->Fournisseur->find('list');
        $this->set(compact('fournisseurs', 'produit_id', 'tvas'));
        $this->layout = false;
    }

    public function deleteprice($id = null)
    {
        $this->Produit->Produitprice->id = $id;
        if ($this->Produit->Produitprice->delete()) {
            die('La suppression a été effectué avec succès.');
        } else {
            die('Il y a un problème');
        }
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->data['Produit']['code_barre']) and !empty($this->data['Produit']['code_barre'])) {
                $code_barre = trim($this->data['Produit']['code_barre']);
                if (isset($this->data['Produit']['id']) and !empty($this->data['Produit']['id'])) {
                    $produit = $this->Produit->find('first', ['conditions' => ['code_barre' => $code_barre, 'id !=' => $this->data['Produit']['id']]]);
                    if (!empty($produit)) {
                        $this->Session->setFlash('Opération impossible : code à barre "'.$code_barre.'" déja existant !', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                } else {
                    $produit = $this->Produit->find('first', ['conditions' => ['code_barre' => $code_barre]]);
                    if (!empty($produit)) {
                        $this->Session->setFlash('Opération impossible : code à barre "'.$code_barre.'" déja existant !', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                }
            }

            if (empty($this->data['Produit']['id']) and isset($this->data['Produit']['prixachat'])) {
                $this->request->data['Produit']['pmp'] = $this->data['Produit']['prixachat'];
            }
            if (isset($this->data['Produit']['image'])) {
                unset($this->request->data['Produit']['image']);
            }
            if (isset($_FILES['data']['name']['Produit']['image']) and !empty($_FILES['data']['name']['Produit']['image'])) {
                $uploadfile = new Uploadfile();
                $basenameSlug = $uploadfile->convertBaseName($_FILES['data']['name']['Produit']['image']);
                $file_name = $basenameSlug;
                $file_tmp = $_FILES['data']['tmp_name']['Produit']['image'];
                $size = $_FILES['data']['size']['Produit']['image'];
                $dest_dossier = str_replace('\\', '/', WWW_ROOT.'uploads\\articles_images\\');
                if (!is_dir($dest_dossier)) {
                    mkdir($dest_dossier, 0777, true);
                }
                if (!empty($this->data['Produit']['id'])) {
                    $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
                    $produit = $this->Produit->find('first', $options);
                    if (empty($file_name) and !empty($produit['Produit']['image'])) {
                        $this->request->data['Produit']['image'] = $produit['Produit']['image'];
                    } elseif (!empty($file_name)) {
                        $this->request->data['Produit']['image'] = $file_name;
                    }
                } else {
                    if (empty($file_name)) {
                        $file_name = 'default.jpg';
                    } else {
                        $this->request->data['Produit']['image'] = $file_name;
                    }
                }

                if (!empty($file_name)) {
                    move_uploaded_file($file_tmp, $dest_dossier.$file_name);
                }
            }
            $this->request->data['Produit']['type'] = 2;
            $dataConditionnement = (isset($this->request->data['Produit']['type_conditionnement1'])) ? $this->request->data['Produit']['type_conditionnement1'] : '';
            $dataOptions = (isset($this->request->data['Produit']['options1'])) ? $this->request->data['Produit']['options1'] : '';
            // unset($this->request->data['Produit']['type_conditionnement']);
            // unset($this->request->data['Produit']['options']);



            if (isset($this->request->data['Produit']['type_conditionnement']) && is_array($this->request->data['Produit']['type_conditionnement'])) {
    
                // Vérifier si les prix sont envoyés et les décoder
                if (!empty($this->request->data['Produit']['type_conditionnement_prix'])) {
                    $prixArray = json_decode($this->request->data['Produit']['type_conditionnement_prix'], true);
                } else {
                    $prixArray = [];
                }
            
                // Création d'un format structuré combinant types et prix
                $this->request->data['Produit']['type_conditionnement'] = json_encode([
                    "variation" => $this->request->data['Produit']['type_conditionnement'], // Liste des types
                    "prix"  => $prixArray // Liste des prix associés
                ]);
            }     

            ///call api
            if ($id != null) {
                $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
                $produit = $this->Produit->find('first', $options);
                if ($produit['Produit']['prix_vente'] != $this->data['Produit']['prix_vente']) {
                    if (isset($this->data['Produit']['code_barre']) and !empty($this->data['Produit']['code_barre'])) {
                        $data2 = [
                            'sku' => intval($this->data['Produit']['code_barre']),
                            'price' => floatval($this->data['Produit']['prix_vente']),
                        ];
                    } else {
                        $this->Session->setFlash('vous devez saisir un code à barre', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                    $parametres = $this->GetParametreSte();

                    $data2 = json_encode(($data2));
                    $ch = curl_init();
                    $url = $parametres['Api sync produits'];
                    $headers = [
                        'Content-Type:application/json',
                    ];
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt_array($ch, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => '['.$data2.']',
                        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                        CURLOPT_USERPWD => $parametres['User'].':'.$parametres['Password'],
                    ]);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    $return = curl_exec($ch);
                    curl_close($ch);
                    $return = json_decode($return, true);
                    $messages = ['Product Sync Successful !!', 'Product not found !!'];

                    if (!in_array($return['msg'], $messages)) {
                        $this->Session->setFlash('Problème Api', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                }
            }



            // debug($this->request->data);
            // die();

            if ($this->Produit->save($this->request->data)) {
                if ($id == null) {
                    $id = $this->Produit->getLastInsertId();
                }
                if ($dataConditionnement != '') {
                    $this->Produit->Typeconditionnementtproduit->deleteAll(['Typeconditionnementtproduit.id_produit' => $id], false);
                    for ($i = 0; $i < sizeof($dataConditionnement); ++$i) {
                        $typeconditionnement = $this->Produit->Typeconditionnement->find('first', ['conditions' => ['code_type' => $dataConditionnement[$i]]]);
                        $data[$i] = [
                                'id_produit' => $id,
                                'id_typeconditionnement' => $typeconditionnement['Typeconditionnement']['id'],
                                'user_c' => $this->Session->read('Auth.User.id'),
                                'date_c' => date('Y-m-d H:i:s'),
                            ];
                    }
                    if (!$this->Produit->Typeconditionnementtproduit->saveMany($data)) {
                        $this->Session->setFlash('Il y a un problème', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                    unset($data);
                } else {
                    $this->Produit->Typeconditionnementtproduit->deleteAll(['Typeconditionnementtproduit.id_produit' => $id], false);
                }
                if ($dataOptions != '') {
                    $this->Produit->Optionproduit->deleteAll(['Optionproduit.id_produit' => $id], false);
                    for ($i = 0; $i < sizeof($dataOptions); ++$i) {
                        $data[$i] = [
                                'id_produit' => $id,
                                'id_option' => $dataOptions[$i],
                                'user_c' => $this->Session->read('Auth.User.id'),
                                'date_c' => date('Y-m-d H:i:s'),
                            ];
                    }
                    if (!$this->Produit->Optionproduit->saveMany($data)) {
                        $this->Session->setFlash('Il y a un problème', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                } else {
                    $this->Produit->Optionproduit->deleteAll(['Optionproduit.id_produit' => $id], false);
                }

                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Produit->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect($this->referer());
            }
        } elseif ($this->Produit->exists($id)) {
            $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
            $this->request->data = $this->Produit->find('first', $options);
        }

        $tvas = $this->Produit->TvaAchat->findList();
        $unites = $this->Produit->Unite->find('list', ['order' => 'libelle asc']);
        $categorieproduits = $this->Produit->Categorieproduit->find('list', ['order' => 'libelle asc']);
        $souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order' => 'libelle asc']);
        $condtionnements = $this->Produit->Typeconditionnement->findList();
        $options = $this->Produit->Options->findList();
        if ($id != null) {
            $soucategid = $this->Produit->find('first', ['conditions' => ['id' => $id]]);
            $souscategorieproduits_id = $this->Produit->Souscategorieproduit->find('first', ['conditions' => ['Souscategorieproduit.id' => $soucategid['Produit']['souscategorieproduit_id']],
        'order' => 'libelle asc', ]);
            $souscategorieproduits_id = isset($souscategorieproduits_id['Souscategorieproduit']['libelle']) ? $souscategorieproduits_id['Souscategorieproduit']['libelle'] : 0;
        } else {
            $souscategorieproduits_id = null;
        }
        $typeconditionnementslibelles = [];
        $optionlibelles = [];
        if ($id != null) {
            $condtionnementproduits = $this->Produit->Typeconditionnementtproduit->query("SELECT * FROM typeconditionnementtproduits where id_produit={$id};");

            for ($i = 0; $i < sizeof($condtionnementproduits); ++$i) {
                $id_typeconditionnement = $condtionnementproduits[$i]['typeconditionnementtproduits']['id_typeconditionnement'];
                $typeconditionnement = $this->Produit->Typeconditionnement->find('list', ['conditions' => ['id' => $id_typeconditionnement]]);
                $typeconditionnementslibelles[$i] = $typeconditionnement[$id_typeconditionnement];
            }
            $optionproduits = $this->Produit->Optionproduit->query("SELECT * FROM optionproduits where id_produit={$id};");

            for ($i = 0; $i < sizeof($optionproduits); ++$i) {
                $id_option = $optionproduits[$i]['optionproduits']['id_option'];
                $option = $this->Produit->Options->find('list', ['conditions' => ['id' => $id_option]]);
                $optionlibelles[$i] = $option[$id_option];
            }
        }
        $this->set(compact('typeconditionnementslibelles', 'optionlibelles', 'categorieproduits', 'unites', 'tvas', 'souscategorieproduits_id', 'souscategorieproduits', 'condtionnements', 'options'));
        $this->layout = false;
    }

    public function loadSousCateg($categorie_id)
    {
        $this->loadModel('Souscategorieproduit');
        $sous_categories = $this->Souscategorieproduit->find('list', ['conditions' => ['categorieproduit_id' => $categorie_id]]);

        die(json_encode($sous_categories));
    }

    public function loadStores($societe_id)
    {
        $this->loadModel('Store');
        $stores = $this->Store->find('list', ['conditions' => ['societe_id' => $societe_id]]);

        die(json_encode($stores));
    }

    public function viewOldIsGold($id = null)
    {
        $sortie = [];
        $mouvements = [];
        $quantite_general = 0;
        $depotproduits = 0;
        if ($this->request->is(['post', 'put'])) {
            if (isset($this->data['Produit']['code_barre']) and !empty($this->data['Produit']['code_barre'])) {
                $code_barre = trim($this->data['Produit']['code_barre']);
                $produit = $this->Produit->find('first', ['conditions' => ['code_barre' => $code_barre, 'id !=' => $id]]);
                if (!empty($produit)) {
                    $this->Session->setFlash('Opération impossible : code à barre "'.$code_barre.'" déja existant !', 'alert-danger');

                    return $this->redirect($this->referer());
                }
            }

            if (isset($this->data['Produit']['image'])) {
                unset($this->request->data['Produit']['image']);
            }
            if (isset($_FILES['data']['name']['Produit']['image']) and !empty($_FILES['data']['name']['Produit']['image'])) {
                $uploadfile = new Uploadfile();
                $basenameSlug = $uploadfile->convertBaseName($_FILES['data']['name']['Produit']['image']);
                $file_name = $basenameSlug;
                $file_tmp = $_FILES['data']['tmp_name']['Produit']['image'];
                $size = $_FILES['data']['size']['Produit']['image'];
                $dest_dossier = str_replace('\\', '/', WWW_ROOT.'uploads\\articles_images\\');
                if (!is_dir($dest_dossier)) {
                    mkdir($dest_dossier, 0777, true);
                }
                if (!empty($this->data['Produit']['id'])) {
                    $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
                    $produit = $this->Produit->find('first', $options);
                    if (empty($file_name) and !empty($produit['Produit']['image'])) {
                        $this->request->data['Produit']['image'] = $produit['Produit']['image'];
                    } elseif (!empty($file_name)) {
                        $this->request->data['Produit']['image'] = $file_name;
                    }
                } else {
                    if (empty($file_name)) {
                        $file_name = 'default.jpg';
                    } else {
                        $this->request->data['Produit']['image'] = $file_name;
                    }
                }

                if (!empty($file_name)) {
                    move_uploaded_file($file_tmp, $dest_dossier.$file_name);
                }
            }

            $dataConditionnement = (isset($this->request->data['Produit']['type_conditionnement'])) ? $this->request->data['Produit']['type_conditionnement'] : [];
            $dataOptions = (isset($this->request->data['Produit']['options'])) ? $this->request->data['Produit']['options'] : [];
            unset($this->request->data['Produit']['type_conditionnement']);
            unset($this->request->data['Produit']['options']);
            $this->request->data['Produit']['type'] = 2;
            //////api

            $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
            $produit = $this->Produit->find('first', $options);
            if ($produit['Produit']['prix_vente'] != $this->data['Produit']['prix_vente']) {
                if (isset($this->data['Produit']['code_barre']) and !empty($this->data['Produit']['code_barre'])) {
                    $data = [
                            'sku' => $this->data['Produit']['code_barre'],
                            'price' => $this->data['Produit']['prix_vente'],
                        ];
                } else {
                    $this->Session->setFlash('vous devez saisir un code à barre', 'alert-danger');

                    return $this->redirect($this->referer());
                }
                $data = json_encode(array_values($data));
                //var_dump($data);
                //die( $data );
                $ch = curl_init();
                $parametres = $this->GetParametreSte();
                $url = $parametres['Api sync produits'];

                $headers = [
                        'Content-Type:application/json',
                    ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt_array($ch, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $data,
                        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                        CURLOPT_USERPWD => $parametres['User'].':'.$parametres['Password'],
                    ]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);
                if ($return[1] != $this->data['Produit']['prix_vente']) {
                    $this->Session->setFlash('Problème Api', 'alert-danger');

                    return $this->redirect($this->referer());
                }
                //var_dump($return);die();
            }

            if ($this->Produit->save($this->request->data)) {
                $this->Produit->Typeconditionnementtproduit->deleteAll(['Typeconditionnementtproduit.id_produit' => $id], false);
                $this->Produit->Optionproduit->deleteAll(['Optionproduit.id_produit' => $id], false);
                $id_produit = $id;

                if ($dataConditionnement != []) {
                    for ($i = 0; $i < sizeof($dataConditionnement); ++$i) {
                        $typeconditionnement = $this->Produit->Typeconditionnement->find('first', ['conditions' => ['code_type' => $dataConditionnement[$i]]]);
                        $data[$i] = [
                            'id_produit' => $id_produit,
                            'id_typeconditionnement' => $typeconditionnement['Typeconditionnement']['id'],
                            'user_c' => $this->Session->read('Auth.User.id'),
                            'date_c' => date('Y-m-d H:i:s'),
                        ];
                    }
                    if (!$this->Produit->Typeconditionnementtproduit->saveMany($data)) {
                        $this->Session->setFlash('Il y a un problème', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                }
                if ($dataOptions != []) {
                    for ($i = 0; $i < sizeof($dataOptions); ++$i) {
                        $data[$i] = [
                            'id_produit' => $id_produit,
                            'id_option' => $dataOptions[$i],
                            'user_c' => $this->Session->read('Auth.User.id'),
                            'date_c' => date('Y-m-d H:i:s'),
                        ];
                    }
                    if (!$this->Produit->Optionproduit->saveMany($data)) {
                        $this->Session->setFlash('Il y a un problème', 'alert-danger');

                        return $this->redirect($this->referer());
                    }
                }
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Produit->exists($id)) {
            $options = ['conditions' => ['Produit.'.$this->Produit->primaryKey => $id]];
            $this->request->data = $this->Produit->find('first', $options);

            $depotproduits = $this->Produit->Depotproduit->find('all', [
                'fields' => ['Depotproduit.*', 'Depot.*'],
                'conditions' => ['produit_id' => $id],
                'joins' => [
                    ['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id']],
                ],
                'order' => ['Depotproduit.date' => 'DESC'],
            ]);

            $mouvements = $this->Produit->Mouvement->find('all', [
                'contain' => ['DepotSource', 'DepotDestination'],
                'conditions' => [
                    'Mouvement.produit_id' => $id,
                    'Mouvement.operation' => -1,
                ],
                'order' => ['Mouvement.id' => 'DESC'],
            ]);

            $sortie = $this->Produit->Mouvement->find('all', [
                'contain' => ['DepotSource', 'DepotDestination'],
                'conditions' => [
                    'Mouvement.produit_id' => $id,
                    'Mouvement.operation' => 1,
                ],
                'order' => ['Mouvement.id' => 'DESC'],
            ]);

            $quantite_actual_entree = 0;
            foreach ($mouvements as $key => $value) {
                $quantite_actual_entree = $quantite_actual_entree + $value['Mouvement']['stock_source'];
            }

            $quantite_actual_sortie = 0;
            foreach ($sortie as $key => $value) {
                $quantite_actual_sortie = $quantite_actual_sortie + $value['Mouvement']['stock_source'];
            }

            $quantite_general = (isset($this->request->data['Produit']['stockactuel']) and !empty($this->request->data['Produit']['stockactuel'])) ? (int) $this->request->data['Produit']['stockactuel'] : 0;
            $total_stock = (!empty($quantite_general) and !empty($this->request->data['Produit']['prixachat'])) ? (float) $quantite_general * $this->request->data['Produit']['prixachat'] : 0;
        }

        $tvas = $this->Produit->TvaAchat->findList();
        $unites = $this->Produit->Unite->find('list', ['order' => 'libelle asc']);
        $categorieproduits = $this->Produit->Categorieproduit->find('list', ['order' => 'libelle asc']);
        $souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order' => 'libelle asc']);
        $condtionnements = $this->Produit->Typeconditionnement->findList();
        ///////////////////////////
        $condtionnementproduits = $this->Produit->Typeconditionnementtproduit->query("SELECT * FROM typeconditionnementtproduits where id_produit={$id};");
        $typeconditionnementslibelles = [];
        for ($i = 0; $i < sizeof($condtionnementproduits); ++$i) {
            $id_typeconditionnement = $condtionnementproduits[$i]['typeconditionnementtproduits']['id_typeconditionnement'];
            $typeconditionnement = $this->Produit->Typeconditionnement->find('list', ['conditions' => ['id' => $id_typeconditionnement]]);
            $typeconditionnementslibelles[$i] = $typeconditionnement[$id_typeconditionnement];
        }
        $optionproduits = $this->Produit->Optionproduit->query("SELECT * FROM optionproduits where id_produit={$id};");
        $optionlibelles = [];
        for ($i = 0; $i < sizeof($optionproduits); ++$i) {
            $id_option = $optionproduits[$i]['optionproduits']['id_option'];
            $option = $this->Produit->Options->find('list', ['conditions' => ['id' => $id_option]]);
            $optionlibelles[$i] = $option[$id_option];
        }
        /* var_dump($optionlibelles);die(); */
        ///////////////////////////////
        $options = $this->Produit->Options->findList();
        $soucategid = $this->Produit->find('first', ['conditions' => ['id' => $id]]);
        $souscategorieproduits_id = $this->Produit->Souscategorieproduit->find('first', ['conditions' => ['Souscategorieproduit.id' => $soucategid['Produit']['souscategorieproduit_id']],
        'order' => 'libelle asc', ]);
        $souscategorieproduits_id = isset($souscategorieproduits_id['Souscategorieproduit']['libelle']) ? $souscategorieproduits_id['Souscategorieproduit']['libelle'] : 0;

        $this->set(compact('optionlibelles', 'souscategorieproduits_id', 'typeconditionnementslibelles', 'depotproduits', 'mouvements', 'categorieproduits', 'total_stock', 'sortie', 'quantite_general', 'souscategorieproduits', 'total_stock_ht', 'unites', 'tvas', 'condtionnements', 'options'));
        $this->getPath($this->idModule);
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


    public function view($id = null)
{
    $quantite_general = 0;
    $depotproduits = 0;
    $mouvements = [];
    $sortie = [];
    $tvas = $this->Produit->TvaAchat->findList();
    $unites = $this->Produit->Unite->find('list', ['order' => 'libelle asc']);
    $categorieproduits = $this->Produit->Categorieproduit->find('list', ['order' => 'libelle asc']);
    $souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order' => 'libelle asc']);
    $condtionnements = $this->Produit->Typeconditionnement->findList();

    if ($this->Produit->exists($id)) {
        // Récupération du produit
        $options = ['conditions' => ['Produit.' . $this->Produit->primaryKey => $id]];
        $produit = $this->Produit->find('first', $options);
        $this->request->data = $produit;

        // Récupération des produits liés au dépôt
        $depotproduits = $this->Produit->Depotproduit->find('all', [
            'fields' => ['Depotproduit.*', 'Depot.*'],
            'conditions' => ['produit_id' => $id],
            'joins' => [
                ['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id']],
            ],
            'order' => ['Depotproduit.date' => 'DESC'],
        ]);

        // Récupération des mouvements sortants et entrants
        $mouvements = $this->Produit->Mouvement->find('all', [
            'contain' => ['DepotSource', 'DepotDestination'],
            'conditions' => [
                'Mouvement.produit_id' => $id,
                'Mouvement.operation' => -1,
            ],
            'order' => ['Mouvement.id' => 'DESC'],
        ]);

        $sortie = $this->Produit->Mouvement->find('all', [
            'contain' => ['DepotSource', 'DepotDestination'],
            'conditions' => [
                'Mouvement.produit_id' => $id,
                'Mouvement.operation' => 1,
            ],
            'order' => ['Mouvement.id' => 'DESC'],
        ]);

        // Calcul de la quantité générale
        $quantite_actual_entree = 0;
        foreach ($mouvements as $key => $value) {
            $quantite_actual_entree += $value['Mouvement']['stock_source'];
        }

        $quantite_actual_sortie = 0;
        foreach ($sortie as $key => $value) {
            $quantite_actual_sortie += $value['Mouvement']['stock_source'];
        }

        $quantite_general = (isset($this->request->data['Produit']['stockactuel']) && !empty($this->request->data['Produit']['stockactuel'])) ? (int)$this->request->data['Produit']['stockactuel'] : 0;
        $total_stock = (!empty($quantite_general) && !empty($this->request->data['Produit']['prixachat'])) ? (float)$quantite_general * $this->request->data['Produit']['prixachat'] : 0;
    }

    // Récupération des types de conditionnement associés au produit
    $condtionnementproduits = $this->Produit->Typeconditionnementtproduit->query("SELECT * FROM typeconditionnementtproduits WHERE id_produit = {$id};");
    $typeconditionnementslibelles = [];


    // Récupération des types de conditionnement disponibles
    $type_conditionnement_data = json_decode($produit['Produit']['type_conditionnement'], true);
    $typeconditionnementslibelles = isset($type_conditionnement_data['prix']) ? 
    
    $type_conditionnement_data['prix'] : [];

    $prix_conditionnement = $type_conditionnement_data['prix']; // Assigning the value to a variable

    // Préparer les données pour l'affichage
    $ean13_variante_data = json_decode($produit['Produit']['ean13_variante'], true);
    $ean13_variante_display = [];

    if (!empty($ean13_variante_data)) {
        foreach ($ean13_variante_data as $key => $value) {
            $ean13_variante_display[] = "Conditionnement: {$key}, EAN13: {$value}";
        }
    }

    // Joindre les données pour un affichage lisible
    $ean13_variante_display = implode('<br>', $ean13_variante_display);
    $this->set(compact('ean13_variante_display'));


    foreach ($condtionnementproduits as $condtionnement) {
        $id_typeconditionnement = $condtionnement['typeconditionnementtproduits']['id_typeconditionnement'];
        $typeconditionnement = $this->Produit->Typeconditionnement->find('list', ['conditions' => ['id' => $id_typeconditionnement]]);
        $typeconditionnementslibelles[] = $typeconditionnement[$id_typeconditionnement];
    }

    // Récupération des options associées au produit
    $optionproduits = $this->Produit->Optionproduit->query("SELECT * FROM optionproduits WHERE id_produit = {$id};");
    $optionlibelles = [];
    foreach ($optionproduits as $optionproduit) {
        $id_option = $optionproduit['optionproduits']['id_option'];
        $option = $this->Produit->Options->find('list', ['conditions' => ['id' => $id_option]]);
        $optionlibelles[] = $option[$id_option];
    }

    // Récupération des options disponibles
    $options = $this->Produit->Options->findList();

    // Récupération de la sous-catégorie du produit
    $soucategid = $this->Produit->find('first', ['conditions' => ['id' => $id]]);
    $souscategorieproduits_id = $this->Produit->Souscategorieproduit->find('first', [
        'conditions' => ['Souscategorieproduit.id' => $soucategid['Produit']['souscategorieproduit_id']],
        'order' => 'libelle asc',
    ]);
    $souscategorieproduits_id = isset($souscategorieproduits_id['Souscategorieproduit']['libelle']) ? $souscategorieproduits_id['Souscategorieproduit']['libelle'] : 0;

    $this->set(compact('optionlibelles', 'souscategorieproduits_id', 'typeconditionnementslibelles', 'depotproduits', 'mouvements', 'categorieproduits', 'total_stock', 'sortie', 'quantite_general', 'souscategorieproduits', 'total_stock_ht', 'unites', 'tvas', 'condtionnements', 'prix_conditionnement', 'options'));
    $this->getPath($this->idModule);
}



    public function importer()
    {
        $champs = [];
        ini_set('memory_limit', '-1');
        if ($this->request->is(['post', 'put'])) {
            $delimiteur = (isset($this->data['Produit']['delimiteur']) and !empty($this->data['Produit']['delimiteur'])) ? $this->data['Produit']['delimiteur'] : ';';
            $ImportedFile = $this->CsvToArray($this->data['Produit']['file']['tmp_name'], $delimiteur);
            $produits = $this->Produit->find('list', ['fields' => ['Produit.id', 'Produit.code_barre']]);
            $categorieproduits = $this->Produit->Categorieproduit->find('list', ['order' => 'libelle asc']);
            $unites = $this->Produit->Unite->find('list', ['order' => 'libelle asc']);

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
            foreach ($tab as $key => $value) { // Filter
                if (empty($value['code_barre']) and empty($value['libelle'])) {
                    unset($tab[$key]);
                }
            }

            foreach ($tab as $key => $value) {
                $value['id'] = null;
                $value['date'] = date('Y-m-d');
                $value['categorieproduit_id'] = null;
                $value['type'] = 2;

                if (isset($value['prixachat']) and !empty($value['prixachat'])) {
                    $value['prixachat'] = trim($value['prixachat']);
                    $value['prixachat'] = (float) str_replace(',', '.', $value['prixachat']);
                }

                if (isset($value['prix_vente']) and !empty($value['prix_vente'])) {
                    $value['prix_vente'] = trim($value['prix_vente']);
                    $value['prix_vente'] = (float) str_replace(',', '.', $value['prix_vente']);
                }

                if (isset($value['code_barre']) and !empty($value['code_barre'])) {
                    $value['code_barre'] = strtolower(trim($value['code_barre']));
                    $value['code_barre'] = str_replace(' ', '', $value['code_barre']);
                    foreach ($produits as $k => $v) {
                        if ($value['code_barre'] == strtolower(trim($v))) {
                            $value['id'] = $k;
                        }
                    }
                }

                if (isset($value['categorie']) and !empty($value['categorie'])) {
                    $value['categorie'] = strtolower(trim($value['categorie']));
                    $value['categorie'] = str_replace('Ã©', 'é', $value['categorie']);
                    $value['categorie'] = str_replace('Ã¨', 'è', $value['categorie']);
                    $value['categorie'] = str_replace('Ãª', 'ê', $value['categorie']);
                    $value['categorie'] = str_replace('Ã§', 'â', $value['categorie']);
                    $value['categorie'] = str_replace('Ã¢', 'â', $value['categorie']);
                    $value['categorie'] = str_replace('Ã', 'à', $value['categorie']);
                    foreach ($categorieproduits as $k => $v) {
                        if ($value['categorie'] == strtolower(trim($v))) {
                            $value['categorieproduit_id'] = $k;
                        }
                    }
                    unset($value['categorie']);
                }

                if (isset($value['unite']) and !empty($value['unite'])) {
                    $value['unite'] = strtolower(trim($value['unite']));
                    $value['unite'] = str_replace('Ã©', 'é', $value['unite']);
                    $value['unite'] = str_replace('Ã¨', 'è', $value['unite']);
                    $value['unite'] = str_replace('Ãª', 'ê', $value['unite']);
                    $value['unite'] = str_replace('Ã§', 'â', $value['unite']);
                    $value['unite'] = str_replace('Ã¢', 'â', $value['unite']);
                    $value['unite'] = str_replace('Ã', 'à', $value['unite']);
                    foreach ($unites as $k => $v) {
                        if ($value['unite'] == strtolower(trim($v))) {
                            $value['unite_id'] = $k;
                        }
                    }
                    unset($value['unite']);
                }

                if (isset($value['libelle']) and !empty($value['libelle'])) {
                    $value['libelle'] = trim($value['libelle']);
                    $value['libelle'] = str_replace('Ã©', 'é', $value['libelle']);
                    $value['libelle'] = str_replace('Ã¨', 'è', $value['libelle']);
                    $value['libelle'] = str_replace('Ãª', 'ê', $value['libelle']);
                    $value['libelle'] = str_replace('Ã§', 'â', $value['libelle']);
                    $value['libelle'] = str_replace('Ã¢', 'â', $value['libelle']);
                    $value['libelle'] = str_replace('Ã', 'à', $value['libelle']);
                }

                if (isset($value['cpt_achat']) and !empty($value['cpt_achat'])) {
                    $value['cpt_achat'] = trim($value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ã©', 'é', $value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ã¨', 'è', $value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ãª', 'ê', $value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ã§', 'â', $value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ã¢', 'â', $value['cpt_achat']);
                    $value['cpt_achat'] = str_replace('Ã', 'à', $value['cpt_achat']);
                }

                if (isset($value['cpt_vente']) and !empty($value['cpt_vente'])) {
                    $value['cpt_vente'] = trim($value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ã©', 'é', $value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ã¨', 'è', $value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ãª', 'ê', $value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ã§', 'â', $value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ã¢', 'â', $value['cpt_vente']);
                    $value['cpt_vente'] = str_replace('Ã', 'à', $value['cpt_vente']);
                }

                $insert[]['Produit'] = $value;
            }

            if (isset($this->data['Produit']['check']) and $this->data['Produit']['check'] == 1) {
                $this->Produit->query('DELETE FROM produits WHERE type = 2');
            }

            if (empty($insert)) {
                $this->Session->setFlash('Opération impossible : Fichier vide !', 'alert-danger');

                return $this->redirect($this->referer());
            }
            if ($this->Produit->saveMany($insert)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
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
        $this->Produit->id = $id;
        if (!$this->Produit->exists()) {
            throw new NotFoundException(__('Invalide produit'));
        }
        if ($this->Produit->flagDelete()) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    	// recupérer les produits depuis le serveur 
	public function apiGetProduitsToSync($store_id = null, $caisse_id = null, $salepoint_id = null)
	{
		// Définir le type de réponse
		$this->response->type('json');

        // Récupérer les données de la table "Salepoint"
        $produits = $this->Produit->find('all',[
            'conditions' => [
                'Produit.deleted' => 0,
            ]
        ]);

		// Afficher les données en format JSON
		echo json_encode($produits);
        
		// Arrêter le rendu de la vue
		return $this->response;
	}

        	// API TEMP
            // Pour l'équipe de NEXA
            public function apiGetEngProducts($store_id = null)
            {
                // Définir le type de réponse
                $this->response->type('json');
            
                // Récupérer les données de la table "Produit"
                $produits = $this->Produit->find('all', [
                    'conditions' => [
                        'Produit.deleted' => 0,
                      //  'Produit.id' => 634,
                    ]
                ]);
            
                // Ajouter le préfixe "2008" au champ "code_barre" pour chaque produit
                foreach ($produits as &$produit) {
                    if (isset($produit['Produit']['code_barre'])) {
                        $produit['Produit']['code_barre'] = '2008' . $produit['Produit']['code_barre'];
                    }
                }
            
                // Afficher les données en format JSON
                echo json_encode($produits);
            
                // Arrêter le rendu de la vue
                return $this->response;
            }
            
    
    
        // Inérer les données récupérées des produits à la caisse demanderesse
    public function insertProduitsApi($caisse_id = null, $server_link=null, $check_sync=null, $json_data=null, $data=null)
    {

        // $store_id = $this->Session->read('Auth.User.StoreSession.id');
        // $caisse_id = $this->Session->read('caisse_id');

        // Récupérer les informations de l'application 
        $result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));
        $server_link = $result['server_link'];
        $caisse_id      = $result['caisse_id'];
        $store_id       = $result['store_id'];

        // Vérifier la disponibilité de la connexion Internet
        if(checkdnsrr('google.com', 'A')){		

                $link_api = $server_link.'/ingredients/apiGetProduitsToSync';
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
                            $product_api_ids = $item['Produit']['id'];
                            $date_update_api = $item['Produit']['date_u'];

                                // Vérifier si le produit existe déjà dans la base de données
                                $produit_caisse_db = $this->Produit->find('all',[
                                    'conditions' => [
                                    'Produit.id' => $product_api_ids,
                                    'Produit.deleted' => 0,
                                    ]
                                    ]);

                                    //  Préparation des variables pour les Array non-vide
                                    if (!empty($produit_caisse_db) ) {
                                        // recupérer et affecter la data => variable
                                        $produit_db         = $produit_caisse_db['0'];
                                        $date_update_db     = $produit_caisse_db['0']['Produit']['date_u'];
                
                                        // pour faire comparer les dates des updates
                                        $date_update_api    = strtotime($date_update_api);
                                        $date_update_db     = strtotime($date_update_db);
                                    }

                                    // Verifier s'il y a des prouits à mettre à jour
                                    if (!empty($produit_caisse_db) AND $date_update_api > $date_update_db) {
                                        // Mettre à jour les données dans la table "produits"
                                        $difference = array_diff_assoc($item['Produit'], $produit_db['Produit']);    
                                            if (!empty($difference)) {
                                                $id_produit = intval($produit_db['Produit']['id']);
                                                $this->Produit->id = $id_produit;
                                                $this->Produit->saveAll($item);
                                                $check_sync = "DONE";
                                            }
                                    }
                                    else{
                                            // Ajouter les produits manquants
                                                if ($this->Produit->saveAll($item)) {
                                                    $check_sync = "DONE";
                                            }
                                    }
            
                       }             
                            if (isset($check_sync) AND $check_sync!=NULL) {
                                // Charger le modèle + Enregistrer l'entité dans la base de données
                                $this->loadModel('Synchronisation');
                                $result_sync = $this->Synchronisation->save(array(
                                'module' => 'Produit',
                                'source' => $server_link,
                                'destination' => 'Store='.$store_id.' Caisse='.$caisse_id,
                                'user_created' => 0,
                                ));
                                $this->Session->setFlash('La liste des produits a été synchronisée avec succès.', 'alert-success');
                            }

                        $this->layout = false;
                        
        } else {
            $this->Session->setFlash('La liste des produits n\'a pas été synchronisée.', 'alert-danger');
        }



        }


}
