<?php

App::import('Vendor', 'dompdf', ['file' => 'dompdf'.DS.'dompdf_config.inc.php']);
class SalepointsController extends AppController
{
    // Mode paiement de l'application JCOLLB
    /*
        cod
        espece
        wallet
        cmi
        cheque
        bon_achat
        cheque_cadeau
        offert
        virement
    */

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public $idModule = 123;
    public $uses = ['Salepoint', 'Ecommerce', 'Store', 'Avance', 'Client'];

    public function index()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');
        $this->loadModel('Caisse');
        $stores = $this->Caisse->Store->findList();
        $societes = $this->Caisse->Societe->findList();
        $caisses = $this->Caisse->find('list', ['conditions' => ['deleted' => 0]]);

        $clients = $this->Salepoint->Client->findList();
        $users = $this->Salepoint->User->findList();
        $this->set(compact('caisses', 'stores', 'societes', 'users', 'clients', 'user_id', 'role_id', 'admins'));
        $this->getPath($this->idModule);
    }

    public function Bonretourt09()
    {
        if ($this->request->is(['post', 'put'])) {
            $selected_store = $this->Session->read('Auth.User.StoreSession.id');
            $this->loadModel('Depot');
            $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]);

            $options_salepoint = ['contain' => ['Depot' => ['Societe']], 'conditions' => ['Salepoint.reference LIKE' => '%T09%', 'Salepoint.store' => $selected_store, 'Salepoint.flag_retour' => 0, 'Salepoint.etat' => 2, 'Salepoint.date_u >=' => date('Y-m-d', strtotime($this->request->data['Salepoint']['date_debut'])), 'Salepoint.date_u <=' => date('Y-m-d H:i:s', strtotime($this->request->data['Salepoint']['date_fin'].' 23:59:59'))]];
            $salepoints = $this->Salepoint->find('all', $options_salepoint);

            //$options = array('conditions' => array('Bonlivraison.id' => $bonlivraison_id));
            //$bonlivraison = $this->Bonlivraison->find('first', $options);
            $details = $this->Salepoint->Salepointdetail->find('all',
            ['fields' => ['Salepointdetail.*', 'SUM(Salepointdetail.ttc) as ttc', 'SUM(Salepointdetail.qte) as qte', 'SUM(Salepointdetail.total) as total', 'SUM(Salepointdetail.montant_remise) as montant_remise', 'SUM(Salepointdetail.remise) as remise'], 'contain' => ['Salepoint'],
            'group' => ['Salepointdetail.produit_id', 'Salepointdetail.prix_vente'], 'conditions' => ['Salepoint.reference LIKE' => '%T09%', 'Salepoint.store' => $selected_store, 'Salepoint.flag_retour' => 0, 'Salepoint.etat' => 2, 'Salepoint.date_u >=' => date('Y-m-d', strtotime($this->request->data['Salepoint']['date_debut'])), 'Salepoint.date_u <=' => date('Y-m-d H:i:s', strtotime($this->request->data['Salepoint']['date_fin'].' 23:59:59'))], ]);
            //$avances = $this->Bonlivraison->Avance->find('all',['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);

            if (empty($details)) {
                $this->Session->setFlash('aucun ticket ne correspond au dates', 'alert-danger');

                return $this->redirect($this->referer());
            }
            $salepoint = $salepoints[0];
            $data['Bonretourachat'] = [
            'etat' => 2,
            'id' => null,
            'fournisseur_id' => $this->request->data['Salepoint']['fournisseur_id'],
            //'bonlivraison_id' => $bonlivraison_id,
            //'paye' => $bonlivraison['Bonlivraison']['paye'],
            'date' => date('Y-m-d'),
            //'user_id' => $bonlivraison['Bonlivraison']['user_id'],
            'depot_id' => $salepoint['Salepoint']['depot_id'],
            //'montant_tva' => $bonlivraison['Bonlivraison']['montant_tva'],
            'societe_id' => $salepoint['Depot']['Societe']['id'],

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
            foreach ($salepoints as $key => $salepoint) {
                $remise += $salepoint['Salepoint']['remise'];
                $montant_tva += $salepoint['Salepoint']['montant_tva'];
                $this->Salepoint->id = $salepoint['Salepoint']['id'];
                $this->Salepoint->savefield('flag_retour', 1);
            }
            $data['Bonretourachatdetail'] = [];
            foreach ($details as $key => $value) {
                $data['Bonretourachatdetail'][] = [
                'id' => null,
                'depot_id' => $salepoint['Salepoint']['depot_id'],
                'ttc' => $value[0]['ttc'],
                'qte' => $value[0]['qte'],
                'total' => $value[0]['total'],

                'prix_vente' => $value['Salepointdetail']['prix_vente'],
                'produit_id' => $value['Salepointdetail']['produit_id'],

                'montant_remise' => $value['Salepointdetail']['montant_remise'],
                'remise' => $value['Salepointdetail']['remise'],
            ];
            }

            $data['Bonretourachat'] = array_merge($data['Bonretourachat'], ['remise' => $remise, 'montant_tva' => $montant_tva]);

            $this->loadModel('Bonretourachat');

            if ($this->Bonretourachat->saveAssociated($data)) {
                $Bonretourachat_id = $this->Bonretourachat->id;
                App::import('Controller', 'Bonretourachats');
                $Bonretourachat = new BonretourachatsController();

                $Bonretourachat->calculatrice($Bonretourachat_id);
                /* $this->Bonlivraison->id = $bonlivraison_id;WX4FG

                if( $this->Bonlivraison->saveField('facture_id',$facture_id) ); */
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }
        $this->loadModel('Fournisseur');
        $fournisseurs = $this->Fournisseur->find('list');
        $this->set(compact('fournisseurs'));
        $this->layout = false;
    }

    public function indexAjax()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');

        $conditions['Salepoint.etat'] = [2, 3];
 

        // Obtenir la date d'aujourd'hui au format 'd-m-Y'
        $today = date('d-m-Y');

        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Salepoint.reference') {
                    $conditions['Salepoint.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Salepoint.date1') {
                    $conditions['Salepoint.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Salepoint.date2') {
                    $conditions['Salepoint.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } elseif ($param_name == 'Salepoint.societe_id') {
                    $this->loadModel('Store');
                    $stores = $this->Store->find('all', ['conditions' => ['societe_id' => $value]]);
                    $stores_id = [];
                    foreach ($stores as $store) {
                        $stores_id[] = $store['Store']['id'];
                    }
                    $conditions['Salepoint.store'] = $stores_id;
                } elseif ($param_name == 'Salepoint.heure1') {
                    $conditions['HOUR(Salepoint.date_c) >='] = $value;
                } elseif ($param_name == 'Salepoint.heure2') {
                    $conditions['HOUR(Salepoint.date_c) <'] = $value;
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        if ($param_name == 'page') {
            $conditions['DATE_FORMAT(Salepoint.date, "%d-%m-%Y")'] = $today;
        } 

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $conditions['Salepoint.store'] = $selected_store;

        $this->Salepoint->recursive = -1;
        $settings = [
            'contain' => ['Avance', 'Creator', 'User', 'Client' => ['Ville']],
            'order' => ['Salepoint.date' => 'DESC', 'Salepoint.id' => 'DESC'],
            'conditions' => $conditions,
        ];
        $bonlivraisons = $this->Salepoint->find('all', $settings);
        $this->Paginator->settings = $settings;
        $taches = $this->Paginator->paginate();

        $this->set(compact('taches', 'user_id', 'bonlivraisons'));
        $this->layout = false;
    }

    public function SaisirClient($id = null, $client_id = null)
    {
        $this->set(compact('id', 'client_id'));
        $this->layout = false;
    }

    public function loadClient($client_id = null)
    {
        $options = ['conditions' => ['Client.id' => $client_id]];
        $client = $this->Client->find('first', $options);
        die(json_encode(['adresse' => $client['Client']['adresse'], 'ice' => $client['Client']['ice']]));
    }

    public function infosClientExist($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $client_id = $this->request->data['Client']['client_id'];

            unset($this->request->data['Client']['id']);
            $this->Client->id = $client_id;
            $this->Client->save($this->request->data);

            $options = ['conditions' => ['Client.id' => $client_id]];
            $client = $this->Client->find('first', $options);
            $nom = !empty($client['Client']['designation']) ? $client['Client']['designation'] : 'null';
            $adresse = !empty($client['Client']['adresse']) ? $client['Client']['adresse'] : 'null';
            $ice = !empty($client['Client']['ice']) ? $client['Client']['ice'] : 'null';

            $url = '/Salepoints/pdf/'.$id.'/'.$nom.'/'.$adresse.'/'.$ice;
            $this->redirect($url);
            //$this->redirect(["controller" => "Salepoints","action" => "pdf",$id,$nom,$adresse,$ice]);
        }
        //$options = array('conditions' => array('Client.id' => $client_id));
        $clients = $this->Client->find('list');

        $this->set(compact('clients', 'client_id'));
        $this->layout = false;
    }

    public function infosClient($id = null, $client_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $nom = !empty($this->request->data['Client']['designation']) ? $this->request->data['Client']['designation'] : 'null';
            $adresse = !empty($this->request->data['Client']['adresse']) ? $this->request->data['Client']['adresse'] : 'null';
            $ice = !empty($this->request->data['Client']['ice']) ? $this->request->data['Client']['ice'] : 'null';

            $client_id = $this->request->data['Client']['id'];

            if ($client_id != '1') {
                $this->Client->id = $client_id;
                $this->Client->save($this->request->data);
            } else {
                $options = ['conditions' => ['Client.id' => 1]];
                $client = $this->Client->find('first', $options);
                if ($nom != $client['Client']['designation']) {
                    unset($this->request->data['Client']['id']);
                    $this->Client->save($this->request->data);
                    $client_id = $this->Client->id;
                    $this->Salepoint->id = $id;
                    $this->Salepoint->savefield('client_id', $client_id);
                }
            }
            $url = '/Salepoints/pdf/'.$id.'/'.$nom.'/'.$adresse.'/'.$ice;
            $this->redirect($url);
            //$this->redirect(["controller" => "Salepoints","action" => "pdf",$id,$nom,$adresse,$ice]);
        }
        $options = ['conditions' => ['Client.id' => $client_id]];
        $this->request->data = $this->Client->find('first', $options);
        $this->layout = false;
    }

    // API : Update the Payement Methode the Salepoint
    public function updatePaymentMethod($id = null)
    {
        //set layout as false to unset default CakePHP layout. This is to prevent our JSON response from mixing with HTML
        $this->layout = false;

        //set default response
        $response = ['status' => 'failed', 'message' => 'HTTP method not allowed'];

        //check if HTTP method is PUT
        if ($this->request->is('put')) {
            if ($_SERVER['PHP_AUTH_USER'] != 'restapi' or $_SERVER['PHP_AUTH_PW'] != 'fAcbrrLrgGjmKvPNu7Yi') {
                $response['message'] = "le nom d'utilisateur ou mot de passe d'authentification sont invalides";
                $this->response->type('application/json');
                $this->response->body(json_encode($response));

                return $this->response->send();
            }
            //get data from request object
            $datas = $this->request->input('json_decode', true);
            foreach ($datas as $data) {
                $site_id = $data['site'];
                $online_id_json = $data['online_id'];
                $paymentmethod_json = $data['payment_method'];

                // get data from Salepoint
                //$options = array('conditions' => array('Salepoint.ecommerce_id' => $ecommerce_id_json));
                $store = $this->Store->find('first', ['conditions' => ['id_ecommerce' => $site_id]]);
                if (empty($store)) {
                    $response['status'] = 'failed';
                    $response['message'] = "Le site n'existe pas";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));

                    return $this->response->send();
                }
                $store_exist = $this->Ecommerce->find('first', ['conditions' => ['Ecommerce.store_id' => $store['Store']['id']]]);
                $online_id_exist = $this->Ecommerce->find('first', ['conditions' => ['Ecommerce.online_id' => $online_id_json]]);
                if (empty($store_exist) and empty($online_id_exist)) {
                    $response['status'] = 'failed';
                    $response['message'] = 'Le parametre site et online_id ne correspondent a aucune commande';
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));

                    return $this->response->send();
                }
                if (empty($store_exist)) {
                    $response['status'] = 'failed';
                    $response['message'] = "Le parametre site n'existe pas pour cette commande";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));

                    return $this->response->send();
                }
                if (empty($online_id_exist)) {
                    $response['status'] = 'failed';
                    $response['message'] = "Le parametre online_id n'existe pour aucune commande";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));

                    return $this->response->send();
                }
                $options = ['conditions' => ['Ecommerce.online_id' => $online_id_json, 'Ecommerce.store_id' => $store['Store']['id']]];
                $data_db = $this->Ecommerce->find('first', $options);
                if (empty($data_db)) {
                    $response['status'] = 'failed';
                    $response['message'] = "la commande n'est pas relié a ce site";
                    $this->response->type('application/json');
                    $this->response->body(json_encode($response));

                    return $this->response->send();
                }
                $salepoint = $this->Salepoint->find('first', ['conditions' => ['Salepoint.etat' => 2, 'ecommerce_id' => $data_db['Ecommerce']['id']]]);
                $id_retrived_db = $salepoint['Salepoint']['id'];

                //$ecommerce_id_db = $data_db['Salepoint']['ecommerce_id'];

                // get data from Avance
                $this->loadModel('Avance');
                $options_avance = ['conditions' => ['Avance.salepoint_id' => $id_retrived_db]];
                $data_avance = $this->Avance->find('first', $options_avance);

                if (isset($data_avance['Avance'])) {
                    $id_avance_db = $data_avance['Avance']['id'];
                    $paymentmethod_db = $data_avance['Avance']['mode'];
                }

                if (empty($data)) {
                    $data = $this->request->data;
                }

                //check if Salepoint ID was provided
                if (!empty($id_retrived_db)) {
                    //set the Salepoint ID to update
                    if (isset($data_avance['Avance'])) {
                        $this->Avance->id = $id_avance_db;
                    }

                    if ($this->Avance->saveField('mode', $paymentmethod_json)) {
                        $response = ['status' => 'success', 'message' => 'Salepoint successfully updated'];
                    } else {
                        $response['message'] = 'Failed to update Salepoint';
                    }
                } else {
                    $response['message'] = 'Please provide Salepoint -> Ecommerce_id ';
                }
            }
            /*       var_dump($data_avance);die(); */
        }
        $this->response->type('application/json');
        $this->response->body(json_encode($response));

        return $this->response->send();
    }

    // API : Read the Salepoint
    public function readPaymentMethod($id = null)
    {
        $this->layout = false;
        //set default response
        $response = ['status' => 'failed', 'message' => 'Failed to process request'];

        //check if ID was passed
        if (!empty($id)) {
            //find data of Salepoint by ID
            $result = $this->Salepoint->findById($id);
            if (!empty($result)) {
                $response = ['status' => 'success', 'data' => $result];
            } else {
                $response['message'] = 'Found no matching data';
            }
        } else {
            $response['message'] = 'Please provide ID';
        }

        $this->response->type('application/json');
        $this->response->body(json_encode($response));

        return $this->response->send();
    }

    // API : Update the Payement Methode the Salepoint
    public function readSalepointsCod($id = null)
    {
        $options_avance = ['group' => ['Avance.salepoint_id'], 'contain' => ['Salepoint'], 'conditions' => ['not' => ['Salepoint.ecommerce_id' => null, 'Avance.montant' => 0], 'Avance.mode' => 'cod']];
        $data_avances = $this->Avance->find('all', $options_avance);

        if ($_SERVER['PHP_AUTH_USER'] != 'restapi' or $_SERVER['PHP_AUTH_PW'] != 'fAcbrrLrgGjmKvPNu7Yi') {
            $response['message'] = "le nom d'utilisateur ou mot de passe d'authentification sont invalides";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));

            return $this->response->send();
        }
        /* $options_salepoint = array('conditions' => array('not' => ['Salepoint.ecommerce_id' => null]));
        $data_salepoints = $this->Salepoint->find('list', $options_salepoint);

        $salepoints_ids = array_keys($data_salepoints);*/
        /*       var_dump($data_avances);die(); */
        $salepoints_ids = [];
        foreach ($data_avances as $data_avance) {
            /*  if(in_array($data_avance["Avance"]["salepoint_id"],$salepoints_ids)) */
            $salepoints_ids[] = $data_avance['Avance']['salepoint_id'];
        }

        $options_salepoint = ['contain' => ['Ecommerce' => ['Store']], 'conditions' => ['Salepoint.id' => $salepoints_ids, 'Salepoint.etat' => 2, 'not' => ['Salepoint.ecommerce_id' => null]]];
        $data_salepoints = $this->Salepoint->find('all', $options_salepoint);
        //var_dump($data_salepoints);die();
        $data = [];

        foreach ($data_salepoints as $data_salepoint) {
            /*  if(in_array($data_avance["Avance"]["salepoint_id"],$salepoints_ids)) */
            $arr = [
                'online_id' => $data_salepoint['Ecommerce']['online_id'],
                'site' => isset($data_salepoint['Ecommerce']['Store']['id_ecommerce']) ? $data_salepoint['Ecommerce']['Store']['id_ecommerce'] : null,
                'payment_method' => 'cod',
            ];
            array_push($data, $arr);
        }

        //$data = trim(json_encode( array_values($data)), '[]');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($data));
    }

    public function excel()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');

        $conditions['Salepoint.etat'] = [2, 3];
        if (in_array($role_id, $admins)) {
            $conditions['Salepoint.etat'] = [2, 3];
        } else {
            $conditions['Salepoint.user_c'] = $user_id;
        }

        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Salepoint.reference') {
                    $conditions['Salepoint.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Salepoint.date1') {
                    $conditions['Salepoint.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Salepoint.date2') {
                    $conditions['Salepoint.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } elseif ($param_name == 'Salepoint.societe_id') {
                    $this->loadModel('Store');
                    $stores = $this->Store->find('all', ['conditions' => ['societe_id' => $value]]);
                    $stores_id = [];
                    foreach ($stores as $store) {
                        $stores_id[] = $store['Store']['id'];
                    }
                    $conditions['Salepoint.store'] = $stores_id;
                } elseif ($param_name == 'Salepoint.heure1') {
                    $conditions['HOUR(Salepoint.date_c) >='] = $value;
                } elseif ($param_name == 'Salepoint.heure2') {
                    $conditions['HOUR(Salepoint.date_c) <'] = $value;
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $settings = [
            'contain' => ['Salepointdetail' => ['Produit'], 'Creator', 'Avance', 'User', 'Client' => ['Ville']],
            'order' => ['Salepoint.date' => 'DESC', 'Salepoint.id' => 'DESC'],
            'limit' => 15,
            'conditions' => $conditions,
        ];
        $taches = $this->Salepoint->find('all', $settings);

        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Salepoint->id = $id;
        if (!$this->Salepoint->exists()) {
            throw new NotFoundException(__('Invalide bon de livraison'));
        }

        if ($this->Salepoint->flagDelete()) {
            $this->Salepoint->Salepointdetail->updateAll(['Salepointdetail.deleted' => 1], ['Salepointdetail.salepoint_id' => $id]);
            $this->Salepoint->Avance->updateAll(['Avance.deleted' => 1], ['Avance.salepoint_id' => $id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
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

    public function view($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $depot_id = $this->Session->read('Auth.User.depot_id');

        $this->loadModel('Module');
        $module = $this->Module->find('first', ['conditions' => ['Module.libelle' => 'Annuler ticket']]);

        $permission = $this->getPermissionByModule($module['Module']['id']);

        $details = [];
        $avances = [];
        if ($this->Salepoint->exists($id)) {
           // $options = ['contain' => ['Depot', 'Store', 'Client', 'User', 'Avance'], 'conditions' => ['Salepoint.'.$this->Salepoint->primaryKey => $id]];

            $options = [
                'contain' => ['Store', 'Client', 'User', 'Avance'],
                'conditions' => [
                    'Salepoint.'.$this->Salepoint->primaryKey => $id,
                    //'Salepoint.depot_id' => $depot_id
                ]
            ];

            $Salepoint_header = $this->request->data = $this->Salepoint->find('first', $options);

            $depot_id_db = $Salepoint_header['Salepoint']['depot_id'];
            $this->loadModel('Depot'); // Charger le modèle "Depot"

            $depot = $this->Depot->find('first', [
            'conditions' => ['Depot.id' => $depot_id_db],
            'fields' => ['Depot.libelle']
            ]);

            $libelle_depot = $depot['Depot']['libelle'];

            $this->set('libelle_depot', $libelle_depot);

            $details = $this->Salepoint->Salepointdetail->find('all', [
                'conditions' => ['Salepointdetail.salepoint_id' => $id],
                'contain' => ['Produit'],
            ]);

            $avances = $this->Salepoint->Avance->find('all', [
                'conditions' => ['Avance.salepoint_id' => $id],
                'order' => ['date ASC'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }
        $total_paye = 0;
        foreach ($avances as $avance) {
            $total_paye += $avance['Avance']['montant'];
        }

        $produits = $this->Salepoint->Salepointdetail->Produit->findList();

        $this->set(compact('total_paye', 'permission', 'produits', 'details', 'role_id', 'user_id', 'avances'));
        $this->getPath($this->idModule);
    }

    public function getModePaiment($k = null)
    {
        $Arr = ['cod' => 'Espèces',
         'wallet' => 'Wallet', 'bon_achat' => "Bon d'achat", 'cheque_cadeau' => 'Chèque cadeau',
         'Carte' => 'Carte', 'virement' => 'Virement', 'cmi' => 'CMI', 'offert' => 'Offert', 'cheque' => 'Chèque', ];

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function ticket($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Salepoint->exists($id)) {
            $options = ['contain' => ['Creator', 'Client' => ['Ville']], 'conditions' => ['Salepoint.'.$this->Salepoint->primaryKey => $id]];
            $this->request->data = $this->Salepoint->find('first', $options);

            $details = $this->Salepoint->Salepointdetail->find('all', [
                'conditions' => ['Salepointdetail.salepoint_id' => $id],
                'contain' => ['Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        // if ( empty( $details ) ) {
        // 	$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
        // 	return $this->redirect( $this->referer() );
        // }

        // $this->data['Salepoint']['reference']

        // récupérer les info du store connecté
        $this->loadModel('Caisse');
        $this->loadModel('Store');

        // récupérer les info du store connecté
        $store_of_salepoint = $this->data['Salepoint']['store'];
        $store_data = $this->Store->find('first', ['conditions' => ['id' => $store_of_salepoint]]);

        // récupérer les info du caisse connectée
        $caisse_of_salepoint = $this->data['Salepoint']['caisse_id'];
        $caisse_data = $this->Caisse->find('first', ['conditions' => ['id' => $caisse_of_salepoint]]);

  /*      $details_tva = $this->Salepoint->Salepointdetail->find('all',
        ['contain' => ['Produit.tva_vente'], 'fields' => ['Produit.tva_vente', 'SUM(Salepointdetail.total) as mnt_ht', 'Produit.tva_vente', '(SUM(Salepointdetail.ttc)  - SUM(Salepointdetail.total)) as taxe',
        'SUM(Salepointdetail.ttc) as mnt_ttc', ],
        'conditions' => ['Salepointdetail.salepoint_id' => $id],
        'group' => ['Produit.tva_vente'], ]);
*/
        $str = 'SELECT tva, SUM(mnt_ht) as ht, SUM(taxe) AS tax, SUM(mnt_ttc) As ttc FROM ( 
            SELECT Produits.tva_vente As tva, Salepointdetails.ttc / (1 + (Produits.tva_vente/100)) As mnt_ht, Salepointdetails.ttc * (Produits.tva_vente / 100) / (1 + (Produits.tva_vente/100)) as taxe, Salepointdetails.ttc As mnt_ttc
            from Produits, Salepointdetails where Produits.id = Salepointdetails.produit_id and Salepointdetails.salepoint_id = :salepoint_detail_id
            UNION ALL
            SELECT 20, (Salepoints.fee / 1.2), (Salepoints.fee * 0.2 / 1.2), Salepoints.fee
            from Salepoints
            where Salepoints.id = :salepoint_detail_id and fee <> 0) AS Tmp
            group by tva';
        $db = $this->Salepoint->getDataSource();

        $details_tva = $db->fetchAll(
                $str,
            ['salepoint_detail_id' => $id]
        );

        $modes = [];
        $avances = $this->Salepoint->Avance->find('all', ['conditions' => ['salepoint_id' => $id]]);

        foreach ($avances as $avance) {
            if ($avance['Avance']['montant'] != 0) {
                $modes[] = $this->getModePaiment($avance['Avance']['mode']);
            }
        }

        $modes = implode(',', $modes);
        $societe = $this->GetSociete($store_data['Store']['societe_id']);

        $ref_bon_achat = '';
        if (strpos($modes, "Bon d'achat") !== false) {
            $this->loadModel('Bonachat');
            $bonachats = $this->Bonachat->find('first', [
                'conditions' => ['id' => $this->request->data['Salepoint']['id_bon_achat']], ]
            );

            $ref_bon_achat = $bonachats['Bonachat']['reference'];
        }
        $ref_cheque_cad = '';
        if (strpos($modes, 'Chèque cadeau') !== false) {
            $this->loadModel('Chequecadeau');
            $cheque_cad = $this->Chequecadeau->find('first', [
                'conditions' => ['id' => $this->request->data['Salepoint']['id_cheque_cad']], ]
            );

            $ref_cheque_cad = $cheque_cad['Chequecadeau']['reference'];
        }
        $is_salepoint = 1;
        $this->set(compact('is_salepoint', 'details', 'avances', 'ref_cheque_cad', 'ref_bon_achat', 'modes', 'details_tva', 'role', 'user_id', 'societe', 'store_data', 'caisse_data'));
        $this->layout = false;
    }

    public function chooseClient($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $salepoint_id = $this->request->data['Client']['id'];
            $client_id = $this->request->data['Client']['client_id'];

            $options = ['contain' => ['Client'], 'conditions' => ['Salepoint.id' => $salepoint_id]];
            $salepoint = $this->Salepoint->find('first', $options);

            if ($this->Salepoint->updateAll(['Salepoint.client_id' => $client_id], ['Salepoint.id' => $salepoint_id])) {
                $this->pdf($salepoint_id);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        }

        $options = ['contain' => ['Client'], 'conditions' => ['Salepoint.id' => $id]];
        $salepoint = $this->Salepoint->find('first', $options);

        $client_id = $salepoint['Salepoint']['client_id'];
        $clients = $this->Salepoint->Client->find('list');

        $this->set(compact('id', 'client_id', 'clients'));
        $this->layout = false;
    }

    public function pdf($id = null, $nom = null, $adresse = null, $ice = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Salepoint->exists($id)) {
            $options = ['contain' => ['User', 'Client' => ['Ville']], 'conditions' => ['Salepoint.'.$this->Salepoint->primaryKey => $id]];
            $salepoint = $this->request->data = $this->Salepoint->find('first', $options);

            $details = $this->Salepoint->Salepointdetail->find('all', [
                'conditions' => ['Salepointdetail.salepoint_id' => $id],
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

        if (strpos($salepoint['Salepoint']['reference'], 'T09') !== false) {
            $timestamp = strtotime($salepoint['Salepoint']['date_u']);
            $date_ticket = date('Y-m-d', $timestamp);
            $date_now = date('Y-m-d');
            //senario date = j
            if ($date_ticket == $date_now) {
                $old_ref = explode('-', $salepoint['Salepoint']['reference']);
                $this->loadModel('Caisse');
                $caisse = $this->Caisse->find('first', ['conditions' => ['prefix' => $old_ref[0]]]);
                $num_compteur = $caisse['Caisse']['numero'];
                $num_compteur = (int) $num_compteur;
                $new_ref = $old_ref[0].'-'.str_pad($num_compteur + 1, 6, '0', STR_PAD_LEFT);
                $this->Salepoint->updateAll(['Salepoint.reference' => '"'.$new_ref.'"'], ['Salepoint.id' => $salepoint['Salepoint']['id']]);

                //update compteur caisse
                $this->Caisse->updateAll(['Caisse.numero' => str_pad($num_compteur + 1, 6, '0', STR_PAD_LEFT)], ['Caisse.id' => $caisse['Caisse']['id']]);
            } else {
                //annuler ticket cas de j+1
                $this->Salepoint->updateAll(['Salepoint.etat' => 3], ['Salepoint.id' => $salepoint['Salepoint']['id']]);
                //creation facture
                $this->facture($id);
                /* $data["Facture"] = [
                    "client_id" => $salepoint["Salepoint"]["client_id"],
                    "depot_id" => $salepoint["Salepoint"]["depot_id"]
                ];

                $data['Facturedetail'] = [];
                foreach ($details as $key => $value) {
                    $data['Facturedetail'][] = [
                        'id' => null,
                        'depot_id' => $salepoint["Salepoint"]["depot_id"],
                        'ttc' => $value['Salepointdetail']['ttc'],
                        'qte' => $value['Salepointdetail']['qte'],
                        'total' => $value['Salepointdetail']['total'],
                        'prix_vente' => $value['Produit']['prix_vente'],
                        'produit_id' => $value['Salepointdetail']['produit_id'],
                        'montant_remise' => $value['Salepointdetail']['montant_remise'],
                        'remise' => $value['Salepointdetail']['remise'],
                    ];
                }
                $this->Salepoint->Facture->saveAssociated($data); */
                //return $this->redirect(array('action' => 'index'));
            }
        }
        //$options = array("fields" => ["replace(Client.adresse,'\r\n','')"],'conditions' => array('Client.id'  => $this->request->data['Client']['id']));
        /* $client_id = $this->request->data['Client']['id'];
        $client = $this->Client->query("Select REPLACE(REPLACE(C.adresse, '\r', ''), '\n', '') as adresse from clients C
        where C.id = '$client_id'");

        $this->request->data["Client"]["adresse"] = $client[0][0]["adresse"];
         */
        $this->request->data['Client']['designation'] = ($nom == 'null') ? ' ' : $nom;
        $this->request->data['Client']['adresse'] = ($adresse == 'null') ? ' ' : $adresse;
        $this->request->data['Client']['ice'] = ($ice == 'null') ? ' ' : $ice;

        $societe = $this->GetSociete();
        //$this->view = "pdf_test";
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }

    public function cancel($salepoint_id)
    {
        if ($this->Salepoint->updateAll(['Salepoint.etat' => 3], ['Salepoint.id' => $salepoint_id])) {
            $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function update_api($id = null)
    {
        $return_api = $this->UpdateCommande($id);
        $this->Salepoint->id = $id;
        if ($return_api) {
            $this->Session->setFlash('Update Api ok', 'alert-success');
            $this->Salepoint->saveField('msg_api', 'Update Api ok');
        } else {
            $this->Session->setFlash('problème Api', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function UpdateCommande($salepoint_id = null)
    {
        $salepoint = $this->Salepoint->find('first', ['conditions' => ['Salepoint.id' => $salepoint_id]]);
        $ecommerce_id = $salepoint['Salepoint']['ecommerce_id'];
        $ecommerce = $this->Ecommerce->find('all', [
            'conditions' => [
                ['Ecommerce.etat' => 2, 'Ecommerce.id' => $ecommerce_id],
            ],
            'joins' => [
                ['table' => 'ecommercedetails', 'alias' => 'Ecommercedetail', 'type' => 'INNER', 'conditions' => ['Ecommercedetail.ecommerce_id = Ecommerce.id', 'Ecommercedetail.deleted = 0']],
                ['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Client.id = Ecommerce.client_id', 'Client.deleted = 0']],
                ['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Ecommercedetail.produit_id', 'Produit.deleted = 0']],
            ],
            'order' => ['Ecommerce.date desc'],
            'fields' => ['Ecommerce.online_id', 'Ecommerce.date', 'Ecommerce.payment_method', 'Ecommerce.shipment',
            'Ecommerce.total_a_payer_ttc', 'Ecommerce.fee', 'Client.designation', 'Client.telmobile',
            'Client.email', 'Ecommercedetail.produit_id', 'Ecommercedetail.variation_id', 'Ecommercedetail.online_id', 'Ecommercedetail.qte_cmd', 'Ecommercedetail.qte', 'Ecommercedetail.unit_price', 'Ecommercedetail.qte_ordered', 'Produit.code_barre', ],
        ]);

        $data = [];
        $arr_details = [];
        $tab_details = [];
        $tab_customer = [];
        $j = 0;
        /*modif YK*/
        $store_id = $this->Session->read('Auth.User.StoreSession.id');
        $storeSession = $this->Store->find('first', ['conditions' => ['Store.id' => $store_id], 'contain' => ['Societe']]);
        $id_ecommerce = $storeSession['Store']['id_ecommerce'];

        for ($i = 0; $i < sizeof($ecommerce); ++$i) {
            $data[$j] = [
                        'site' => intval($id_ecommerce),
                        'id' => intval($ecommerce[$j]['Ecommerce']['online_id']),
                        'payment_method' => $ecommerce[$j]['Ecommerce']['payment_method'],
                        'shipment' => $ecommerce[$j]['Ecommerce']['shipment'],
                    ];

            if ($ecommerce[$i]['Ecommercedetail']['variation_id'] != '0') {
                $arr = [
                        'id' => intval($ecommerce[$i]['Ecommercedetail']['online_id']),
                        'product_id' => $ecommerce[$i]['Produit']['code_barre'],
                        'variation_id' => $ecommerce[$i]['Ecommercedetail']['variation_id'],
                        'quantity' => intval($ecommerce[$i]['Ecommercedetail']['qte_cmd']),
                        'unit_price' => floatval($ecommerce[$i]['Ecommercedetail']['unit_price']),
                        'weight_ordered' => floatval($ecommerce[$i]['Ecommercedetail']['qte']),
                    ];
            } else {
                $arr = [
                        'id' => intval($ecommerce[$i]['Ecommercedetail']['online_id']),
                        'product_id' => $ecommerce[$i]['Produit']['code_barre'],
                        'variation_id' => $ecommerce[$i]['Ecommercedetail']['variation_id'],
                        'quantity' => intval($ecommerce[$i]['Ecommercedetail']['qte_cmd']),
                        'unit_price' => floatval($ecommerce[$i]['Ecommercedetail']['unit_price']),
                        'quantity_ordered' => floatval($ecommerce[$i]['Ecommercedetail']['qte']),
                    ];
            }
            /* var_dump(($arr)); */

            array_push($arr_details, $arr);
            $data[$j]['line_items'] = $arr_details;
            /* var_dump($ecommerce[$i]["Ecommerce"]["online_id"]); */
        }

        $parametres = $this->GetParametreSte();
        //header('Content-Type: application/json; charset=UTF-8');
        $data = trim(json_encode(array_values($data)), '[]');
        //die( $data );
        $ch = curl_init();
        $url = $parametres['Api update pos'];
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
        if (array_key_exists('status', $return)) {
            return true;
        } else {
            return false;
        }
    }

    public function changeMode($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $salepoint = $this->Salepoint->find('first', ['contain' => ['Avance'], 'conditions' => ['Salepoint.id' => $id]]);

            $cmp = [];
            $cmp['Avance'][0]['id'] = $salepoint['Avance'][0]['id'];
            $cmp['Avance'][0]['montant'] = $salepoint['Avance'][0]['montant'];
            $cmp['Avance'][0]['mode'] = $salepoint['Avance'][0]['mode'];
            $cmp['Avance'][1]['id'] = $salepoint['Avance'][1]['id'];
            $cmp['Avance'][1]['montant'] = $salepoint['Avance'][1]['montant'];
            $cmp['Avance'][1]['mode'] = $salepoint['Avance'][1]['mode'];
            //var_dump($cmp["Avance"]);die();
            //var_dump($this->request->data["Avance"]);die();
            if ($this->request->data['Avance'] != $cmp['Avance']) {
                if (strpos($salepoint['Salepoint']['reference'], 'T09') !== false) {
                    /* $old_ref = explode("-", $salepoint["Salepoint"]["reference"]);
                    $this->loadModel("Caisse");
                    $caisse = $this->Caisse->find("first", ["conditions" => ["prefix" => $old_ref[0]]]);
                    $num_compteur = $caisse["Caisse"]["numero"];
                    $num_compteur = (int) $num_compteur;
                    $new_ref = $old_ref[0] . "-" .str_pad($num_compteur + 1, 6, '0', STR_PAD_LEFT);
                    $this->Salepoint->updateAll(['Salepoint.reference'=> '"'.$new_ref.'"'], ['Salepoint.id'=>$salepoint["Salepoint"]["id"]]);
                    $this->Caisse->updateAll(['Caisse.numero'=> str_pad($num_compteur + 1, 6, '0', STR_PAD_LEFT)],['Caisse.id'=>$caisse["Caisse"]["id"]]); */
                    $this->Salepoint->id = $id;
                    $this->Salepoint->saveField('etat', 3);
                    $this->facture($id);
                }
                //update compteur caisse

                $this->loadModel('Avance');
                $this->Avance->id = $this->request->data['Avance'][0]['id'];
                $this->Avance->save($this->request->data['Avance'][0]);
                $this->Avance->id = $this->request->data['Avance'][1]['id'];
                $this->Avance->save($this->request->data['Avance'][1]);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            }

            return $this->redirect($this->referer());
        } 
        $modes = ['espece' => 'Espèces', 'cod' => 'COD', 'delayed' => 'Delayed',
         'wallet' => 'Wallet', 'bon_achat' => "Bon d'achat", 'cheque_cadeau' => 'Chèque cadeau',
         'Carte' => 'Carte', 'tpe' => 'TPE', 'virement' => 'Virement', 'cmi' => 'CMI', 'offert' => 'Offert', 'cheque' => 'Chèque', ];

        $this->request->data = $this->Salepoint->find('first', ['contain' => ['Avance'], 'conditions' => ['Salepoint.id' => $id]]);

        $this->set(compact('id', 'modes'));
        $this->layout = false;
    }

    public function editavance($id = null, $salepoint_id = null)
    {
        $bonlivraison = $this->Salepoint->find('first', ['conditions' => ['id' => $salepoint_id]]);
        $reste_a_payer = (isset($bonlivraison['Salepoint']['reste_a_payer'])) ? $bonlivraison['Salepoint']['reste_a_payer'] : 0;
        $client_id = (isset($bonlivraison['Salepoint']['client_id'])) ? $bonlivraison['Salepoint']['client_id'] : null;
        $user_id = $this->Session->read('Auth.User.id');
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Avance']['user_id'] = $user_id;
            $this->request->data['Avance']['salepoint_id'] = $salepoint_id;
            $this->request->data['Avance']['client_id'] = $client_id;
            if ($this->Salepoint->Avance->save($this->request->data)) {
                $this->calculatrice($salepoint_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Salepoint->Avance->exists($id)) {
            $options = ['conditions' => ['Avance.'.$this->Salepoint->Avance->primaryKey => $id]];
            $this->request->data = $this->Salepoint->Avance->find('first', $options);
        }

        $this->set(compact('reste_a_payer'));
        $this->layout = false;
    }

    public function calculatrice($salepoint_id = null)
    {
        $salepoint = $this->Salepoint->find('first', ['conditions' => ['Salepoint.id' => $salepoint_id]]);
        $remise = (isset($salepoint['Salepoint']['remise']) and !empty($salepoint['Salepoint']['remise'])) ? (float) $salepoint['Salepoint']['remise'] : 0;
        $details = $this->Salepoint->Salepointdetail->find('all', ['contain' => ['Produit'], 'conditions' => ['Salepointdetail.salepoint_id' => $salepoint_id]]);
        $avances = $this->Salepoint->Avance->find('all', ['conditions' => ['salepoint_id' => $salepoint_id]]);

        $total_cmd = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $remise_articles = 0;
        $montant_remise_articles = 0;
        $nombre_total = count($details);
        foreach ($details as $k => $v) {
            // TVA
            $tva = (isset($v['Produit']['tva_vente']) and !empty($v['Produit']['tva_vente'])) ? (int) $v['Produit']['tva_vente'] : 20;
            $division_tva = (1 + $tva / 100);
            // Quantité & Prix de vente
            $qte_cmd = $v['Salepointdetail']['qte_cmd'];
            $qte = (isset($v['Salepointdetail']['qte']) and $v['Salepointdetail']['qte'] > 0) ? $v['Salepointdetail']['qte'] : $qte_cmd;

            $prix_vente_ht = round($v['Salepointdetail']['prix_vente'] / $division_tva, 2);
            $prix_vente_ttc = $v['Salepointdetail']['prix_vente'];
            // Calcule total
            $total_ht = round($prix_vente_ht * $qte, 2);
            $total_ttc = round($prix_vente_ttc * $qte, 2);

            $total_a_payer_ht = $total_a_payer_ht + $total_ht;
            $total_a_payer_ttc = $total_a_payer_ttc + $total_ttc;
            $total_cmd = $total_cmd + $qte_cmd;
        }

        $montant_remise = ($total_a_payer_ttc >= 0) ? (float) ($total_a_payer_ttc * $remise) / 100 : 0;

        $montant_tva = $total_a_payer_ttc - $total_a_payer_ht;
        $total_apres_reduction = round($total_a_payer_ttc - $montant_remise, 2);

        $total_paye = 0;
        foreach ($avances as $k => $v) {
            $total_paye = $total_paye + $v['Avance']['montant'];
        }

        $reste_a_payer = $total_apres_reduction - $total_paye;
        $reste_a_payer = ($reste_a_payer <= 0) ? 0 : $reste_a_payer;

        if ($total_apres_reduction == $total_paye) {
            $paye = 2;
        } elseif ($total_paye == 0) {
            $paye = -1;
        } else {
            $paye = 1;
        }

        $salepointData['Salepoint']['paye'] = $paye;
        $salepointData['Salepoint']['remise'] = $remise;
        $salepointData['Salepoint']['id'] = $salepoint_id;
        $salepointData['Salepoint']['total_cmd'] = $total_cmd;
        $salepointData['Salepoint']['total_paye'] = $total_paye;
        $salepointData['Salepoint']['montant_tva'] = $montant_tva;
        $salepointData['Salepoint']['reste_a_payer'] = $reste_a_payer;
        $salepointData['Salepoint']['montant_remise'] = $montant_remise;
        $salepointData['Salepoint']['total_a_payer_ht'] = $total_a_payer_ht;
        $salepointData['Salepoint']['total_a_payer_ttc'] = $total_a_payer_ttc;
        $salepointData['Salepoint']['total_apres_reduction'] = $total_apres_reduction;

        return $this->Salepoint->save($salepointData);
    }

    public function deleteavance($id = null, $salepoint_id = null)
    {
        $this->Salepoint->Avance->id = $id;
        if (!$this->Salepoint->Avance->exists()) {
            throw new NotFoundException(__('Invalide Avance'));
        }

        if ($this->Salepoint->Avance->flagDelete()) {
            $this->calculatrice($salepoint_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function facture($salepoint_id = null)
    {
        $depot_id = $this->Session->read('Auth.User.depot_id');
        if ($this->Salepoint->exists($salepoint_id)) {
            $options = ['conditions' => ['Salepoint.id' => $salepoint_id]];
            $bonlivraison = $this->Salepoint->find('first', $options);
            $details = $this->Salepoint->Salepointdetail->find('all', ['conditions' => ['salepoint_id' => $salepoint_id]]);
            $avances = $this->Salepoint->Avance->find('all', ['conditions' => ['salepoint_id' => $salepoint_id]]);

            $data['Facture'] = [
                'etat' => 2,
                'id' => null,
                'salepoint_id' => $salepoint_id,
                'paye' => $bonlivraison['Salepoint']['paye'],
                'date' => date('Y-m-d'),
                'remise' => $bonlivraison['Salepoint']['remise'],
                'montant_remise' => $bonlivraison['Salepoint']['montant_remise'],
                'user_id' => $bonlivraison['Salepoint']['user_id'],
                //'reduction' => $bonlivraison['Salepoint']['reduction'],
                'depot_id' => $bonlivraison['Salepoint']['depot_id'],
                'montant_tva' => $bonlivraison['Salepoint']['montant_tva'],
                //'active_remise' => $bonlivraison['Salepoint']['active_remise'],
                'client_id' => $bonlivraison['Salepoint']['client_id'],
                //'total_qte' => $bonlivraison['Salepoint']['total_qte'],
                'total_paye' => $bonlivraison['Salepoint']['total_paye'],
                //'total_paquet' => $bonlivraison['Salepoint']['total_paquet'],
                'reste_a_payer' => $bonlivraison['Salepoint']['reste_a_payer'],
                'total_a_payer_ht' => $bonlivraison['Salepoint']['total_a_payer_ht'],
                'total_a_payer_ttc' => $bonlivraison['Salepoint']['total_a_payer_ttc'],
                'total_apres_reduction' => $bonlivraison['Salepoint']['total_apres_reduction'],
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
                    'depot_id' => $bonlivraison['Salepoint']['depot_id'],
                    'ttc' => $value['Salepointdetail']['ttc'],
                    'qte' => $value['Salepointdetail']['qte'],
                    'total' => $value['Salepointdetail']['total'],
                    //'paquet' => $value['Salepointdetail']['paquet'],
                    'prix_vente' => $value['Salepointdetail']['prix_vente'],
                    'produit_id' => $value['Salepointdetail']['produit_id'],
                    //'total_unitaire' => $value['Salepointdetail']['total_unitaire'],
                    'montant_remise' => $value['Salepointdetail']['montant_remise'],
                    'remise' => $value['Salepointdetail']['remise'],
                ];
            }

            if ($this->Salepoint->Facture->saveAssociated($data)) {
                $facture_id = $this->Salepoint->Facture->id;
                $this->Salepoint->id = $salepoint_id;
                if ($this->Salepoint->saveField('facture_id', $facture_id));
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }
            //return $this->redirect( $this->referer() );
        }
    }

    public function mail($salepoint_id = null)
    {
        $bonlivraison = $this->Salepoint->find('first', ['contain' => ['Client'], 'conditions' => ['Salepoint.id' => $salepoint_id]]);
        $email = (isset($bonlivraison['Client']['email']) and !empty($bonlivraison['Client']['email'])) ? $bonlivraison['Client']['email'] : '';
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Email']['salepoint_id'] = $salepoint_id;
            if ($this->Salepoint->Email->save($this->request->data)) {
                $url = $this->generatepdf($salepoint_id);
                $email_id = $this->Salepoint->Email->id;
                if ($this->Salepoint->Email->saveField('url', $url)) {
                    $settings = $this->GetParametreSte();
                    $to = [$this->data['Email']['email']];
                    $objet = (isset($this->data['Email']['objet'])) ? $this->data['Email']['objet'] : '';
                    $content = (isset($this->data['Email']['content'])) ? $this->data['Email']['content'] : '';
                    $attachments = ['Salepoint' => ['mimetype' => 'application/pdf', 'file' => $url]];
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

    public function generatepdf($salepoint_id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Salepoint->exists($salepoint_id)) {
            $options = ['contain' => ['Client' => ['Ville']], 'conditions' => ['Salepoint.'.$this->Salepoint->primaryKey => $salepoint_id]];
            $data = $this->Salepoint->find('first', $options);

            $details = $this->Salepoint->Salepointdetail->find('all', [
                'conditions' => ['Salepointdetail.salepoint_id' => $salepoint_id],
                'contain' => ['Produit'],
            ]);
        }
        $societe = $this->GetSociete();

        App::uses('LettreHelper', 'View/Helper');
        $LettreHelper = new LettreHelper(new View());

        $view = new View($this, false);
        $style = $view->element('style', ['societe' => $societe]);
        $header = $view->element('header', ['societe' => $societe, 'title' => 'VENTE']);
        $footer = $view->element('footer', ['societe' => $societe]);
        $ville = (isset($this->data['Client']['Ville']['id']) and !empty($this->data['Client']['Ville']['id'])) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '';
        $ice = (isset($this->data['Client']['ice']) and !empty($this->data['Client']['ice'])) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '';

        $html = '
			<html>
			<head>
			    <title>VENTE N° : '.$data['Salepoint']['reference'].'</title>
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
			                        <h4 class="container">VENTE N° : '.$data['Salepoint']['reference'].'</h4>
			                    </td>
			                    <td style="width:50%;text-align:center;">
			                        <h4 class="container">DATE : '.$data['Salepoint']['date'].'</h4>
			                    </td>
			                </tr>';
        if (isset($data['Client']['id']) and !empty($data['Client']['id'])) {
            $html .= '<tr>
			                        <td style="width:50%;text-align:center;"></td>
			                        <td style="width:50%;text-align:left;">
			                            <h4 class="container">
			                                '.strtoupper($data['Client']['designation']).'<br/>
			                                '.strtoupper($data['Client']['adresse']).'<br/>
			                                '.strtoupper($data['Client']['telmobile']).'<br/>
			                                '.$ville.'
			                                '.$ice.'
			                            </h4>
			                        </td>
			                    </tr>';
        }
        $html .= '</tbody>
			        </table>

				    <table class="details" width="100%">
				        <thead>
				            <tr>
			                    <th nowrap="">Désignation </th>
			                    <th nowrap="">Quantité </th>
			                    <th nowrap="">Prix</th>
			                    <th nowrap="">Remise(%)</th>
			                    <th nowrap="">Montant total</th>
				            </tr>
				        </thead>
			            <tbody>';
        foreach ($details as $tache) {
            $html .= '<tr>
			                        <td nowrap>'.$tache['Produit']['libelle'].'</td>
			                        <td nowrap style="text-align:right;">'.$tache['Salepointdetail']['qte'].'</td>
			                        <td nowrap style="text-align:right;">'.number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' ').'</td>
			                        <td nowrap style="text-align:right;">'.(int) $tache['Salepointdetail']['remise'].'%</td>
			                        <td nowrap style="text-align:right;">'.number_format($tache['Salepointdetail']['total'], 2, ',', ' ').'</td>
			                    </tr>';
        }
        $html .= '
			                    <tr class="hide_total">
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="hide_total">TOTAL HT</td>
			                        <td class="hide_total">'.number_format($data['Salepoint']['total_a_payer_ht'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
			                        <td class="total">'.number_format($data['Salepoint']['montant_tva'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">TOTAL TTC</td>
			                        <td class="total">'.number_format($data['Salepoint']['total_a_payer_ttc'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">REMISE('.(int) $data['Salepoint']['remise'].'%)</td>
			                        <td class="total">'.number_format($data['Salepoint']['montant_remise'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">NET A PAYER</td>
			                        <td class="total">'.number_format($data['Salepoint']['total_apres_reduction'], 2, ',', ' ').'</td>
			                    </tr>
			            </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente de la vente à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper($LettreHelper->NumberToLetter(strval($data['Salepoint']['total_apres_reduction']))).' DHS
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
        file_put_contents($destination.DS.'Salepoint.'.$data['Salepoint']['date'].'-'.$data['Salepoint']['id'].'.pdf', $output);

        return $destination.DS.'Salepoint.'.$data['Salepoint']['date'].'-'.$data['Salepoint']['id'].'.pdf';
    }
}
