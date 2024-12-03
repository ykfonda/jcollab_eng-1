<?php

App::import('Vendor', 'dompdf', ['file' => 'dompdf'.DS.'dompdf_config.inc.php']);
class CommandeglovosController extends AppController
{
    public $idModule; //354;

    public $uses = ['Commandeglovo', 'Commandeglovodetail'];

    public function beforeFilter()
    {
        $this->idModule = $this->getModule('Commandes Glovo');
        parent::beforeFilter();
		$this->Auth->allow(['insertGlovoApiPOS','apiGetGlovoToSync']);
    }

    public function index()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $depots = $this->Session->read('depots');
        $clients = $this->Commandeglovo->Client->findList();

        $this->set(compact('clients', 'user_id', 'role_id'));
        $this->getPath($this->idModule);
    }

    public function getclient($client_id = null)
    {
        $req = $this->Commandeglovo->Client->find('first', ['conditions' => ['id' => $client_id]]);
        $remise = (isset($req['Client']['id']) and !empty($req['Client']['remise'])) ? (float) $req['Client']['remise'] : 0;
        die(json_encode($remise));
    }

    public function loadquatite($depot_id = null, $produit_id = null)
    {
        $req = $this->Commandeglovo->Commandeglovodetail->Produit->Depotproduit->find('first', ['conditions' => ['depot_id' => $depot_id, 'produit_id' => $produit_id]]);
        $quantite = (isset($req['Depotproduit']['id']) and !empty($req['Depotproduit']['quantite'])) ? (float) $req['Depotproduit']['quantite'] : 0;
        die(json_encode($quantite));
    }

    public function indexAjax()
    {
        $admins = $this->Session->read('admins');
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $conditions = [];
        //if ( !in_array($role_id, $admins) ) $conditions['Commandeglovo.user_c'] = $user_id;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Commandeglovo.order_code') {
                    $conditions['Commandeglovo.order_code LIKE '] = "%$value%";
                } elseif ($param_name == 'Commandeglovo.date1') {
                    $conditions['Commandeglovo.date_c >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Commandeglovo.date2') {
                    $conditions['Commandeglovo.date_c <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $data['Filter'][$param_name] = $value;
                }
            }
        }

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $conditions['Commandeglovo.store_id'] = $selected_store;

        $this->Commandeglovo->recursive = -1;
        $this->Paginator->settings = [
            'contain' => ['Creator', 'Client'],
            'order' => ['Commandeglovo.date' => 'DESC'],
            'conditions' => $conditions,
        ];
        $taches = $this->Paginator->paginate();

        $this->set(compact('taches', 'user_id'));
        $this->layout = false;
    }

    public function bonPreparation($id = null)
    {
        $options = ['contain' => ['Client', 'Commandeglovodetail', 'Commandeglovodetail' => ['Produit']], 'conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
        $commande = $this->Commandeglovo->find('first', $options);
        $num_commande = $commande['Commandeglovo']['order_code'];

        $client = $commande['Client']['designation'];

        /* $commande_glovo['Commandeglovodetail']['product_barcode'];
        $commande_glovo['Commandeglovodetail']['quantity'];
         */
        $this->set(compact('commande'));
        $this->layout = false;
    }

    public function Apiglovo($id = null, $statut)
    {
        $options = ['conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
        $commande = $this->Commandeglovo->find('first', $options);
        $store_id = $commande['Commandeglovo']['store_id'];
        $order_id = $commande['Commandeglovo']['order_id'];
        $data['status'] = $statut;

        $ch = curl_init();
        $url = "https://stageapi.glovoapp.com/webhook/stores/{$store_id}/orders/{$order_id}/status";
        $headers = [
            'Content-Type:application/json',
        ];
        $authorisation = 'vbnnnn';
        $headers[] = 'Authorization: vbnnnn'; // . $authorisation;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $return = curl_exec($ch);
        curl_close($ch);
        $return = json_decode($return, true);

        if ($return['status'] == '204') {
            $this->Commandeglovo->id = $id;
            $this->Commandeglovo->saveField('status_glovo', $statut);
            if ($statut == 'OUT_FOR_DELIVERY') {
                $this->Commandeglovo->saveField('api_OUT_FOR_DELIVERY', 'ok');
                $this->Commandeglovo->saveField('etat', 4);
            } elseif ($statut == 'PICKED_UP_BY_CUSTOMER') {
                $this->Commandeglovo->saveField('api_PICKED_UP_BY_CUSTOMER', 'ok');
                $this->Commandeglovo->saveField('etat', 5);
            } elseif ($statut == 'ACCEPTED') {
                $this->Commandeglovo->saveField('api_ACCEPTED', 'ok');
            }
            $erreur = false;
        } else {
            $this->Commandeglovo->id = $id;
            if ($statut == 'OUT_FOR_DELIVERY') {
                $this->Commandeglovo->saveField('api_OUT_FOR_DELIVERY', 'erreur');
            } elseif ($statut == 'PICKED_UP_BY_CUSTOMER') {
                $this->Commandeglovo->saveField('api_PICKED_UP_BY_CUSTOMER', 'erreur');
            } elseif ($statut == 'ACCEPTED') {
                $this->Commandeglovo->saveField('api_ACCEPTED', 'erreur');
            }
            $erreur = true;
        }

        header('Content-Type: application/json; charset=UTF-8');
        $message = ($erreur == true) ? 'Probleme Api' : 'Api ok';
        $return = ['error' => $erreur, 'message' => $message];

        die(json_encode($return));
    }

    public function edit($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $depots = $this->Session->read('depots');
        $this->set(compact('users', 'clients', 'user_id', 'role_id'));
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Commandeglovo']['active_remise'] = (isset($this->request->data['Commandeglovo']['active_remise']) and !empty($this->request->data['Commandeglovo']['active_remise'])) ? 1 : -1;
            if ($this->request->data['Commandeglovo']['active_remise'] == -1) {
                $this->request->data['Commandeglovo']['remise'] = 0;
            }
            if ($this->Commandeglovo->save($this->request->data)) {
                if (isset($this->request->data['Commandeglovo']['id']) and !empty($this->request->data['Commandeglovo']['id'])) {
                    $this->CheckRemise($this->request->data['Commandeglovo']['id']);
                }
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                return $this->redirect(['action' => 'view', $this->Commandeglovo->id]);
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        } elseif ($this->Commandeglovo->exists($id)) {
            $options = ['conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
            $this->request->data = $this->Commandeglovo->find('first', $options);
        }

        $clients = $this->Commandeglovo->Client->findList();
        $users = $this->Commandeglovo->User->findList();
        $depots = $this->Commandeglovo->Depot->findList(['Depot.vente' => 1, 'Depot.id' => $depots]);
        $this->set(compact('users', 'clients', 'depots', 'user_id', 'role_id'));
        $this->layout = false;
    }

    public function MotifsAbandon($order_code, $id)
    {
        if ($this->request->is(['post', 'put'])) {
            $this->loadModel('Motif');
            if ($this->Motif->save($this->request->data)) {
                $Commandeglovo = $this->Commandeglovo->find('first', ['conditions' => ['id' => $id]]);
                $online_id = $Commandeglovo['Commandeglovo']['online_id'];
                $ch = curl_init();

                $headers = [
                    'Content-Type:application/json',
                ];
                $store_id = $this->Session->read('Auth.User.StoreSession.id');
                $this->loadModel('Store');
                $storeSession = $this->Store->find('first', ['conditions' => ['Store.id' => $store_id], 'contain' => ['Societe']]);
                $id_Commandeglovo = $storeSession['Store']['id_Commandeglovo'];
                $data = [];
                $data['site'] = intval($id_Commandeglovo);
                $data['id'] = $online_id;
                $parametres = $this->GetParametreSte();
                $url = $parametres['Api Abondan total'];

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($data),
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_USERPWD => $parametres['User'].':'.$parametres['Password'],
                ]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $return = curl_exec($ch);
                curl_close($ch);
                $return = json_decode($return, true);

                if ($return['message'] != 'Order returned.') {
                    $this->Session->setFlash('problème Api', 'alert-danger');

                    return $this->redirect(['action' => 'index']);
                }
                ///////////////////

                $this->Commandeglovo->updateAll(['Commandeglovo.total_apres_reduction' => 0,
            'Commandeglovo.total_a_payer_ttc' => 0,
            'Commandeglovo.total_a_payer_ht' => 0, ], ['Commandeglovo.id' => $id]);

                $this->loadModel('Salepoint');
                $this->Salepoint->updateAll(['Salepoint.total_apres_reduction' => 0,
            'Salepoint.total_a_payer_ttc' => 0, 'Salepoint.total_paye' => 0,
            'Salepoint.montant_tva' => 0, 'Salepoint.total_a_payer_ht' => 0, ], ['Salepoint.Commandeglovo_id' => $id]);

                $this->loadModel('Salepoint');
                $salepoint = $this->Salepoint->find('first', ['conditions' => ['Salepoint.Commandeglovo_id' => $id]]);

                $this->loadModel('Salepoint');
                $this->Salepoint->Avance->updateAll(['Avance.montant' => 0], ['Avance.salepoint_id' => $salepoint['Salepoint']['id'], 'Avance.montant !=' => 0]);

                $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
                    'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $id],
                    'contain' => ['Produit'],
                ]);

                for ($i = 0; $i < sizeof($details); ++$i) {
                    $this->Commandeglovo->create();
                    $this->Commandeglovo->Commandeglovodetail->updateAll(
                        ['Commandeglovodetail.ttc' => 0,
                    'Commandeglovodetail.qte' => 0, ],
                        ['Commandeglovodetail.id' => $details[$i]['Commandeglovodetail']['id']]
                    );

                    $this->loadModel('Salepointdetail');
                    $this->Salepointdetail->create();
                    $this->Salepointdetail->updateAll(
                        ['Salepointdetail.ttc' => 0,
                    'Salepointdetail.qte' => 0, ],
                        ['Salepointdetail.Commandeglovodetail_id' => $details[$i]['Commandeglovodetail']['id']]
                    );
                }
                ////////////////
                $this->Commandeglovo->id = $id;
                if ($this->Commandeglovo->saveField('etat', 4)) {
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');

                    return $this->redirect(['action' => 'index']);
                }
                $this->Session->setFlash('Il y a un problème', 'alert-danger');

                return $this->redirect(['action' => 'index']);
            }
        }
        $this->loadModel('Motifsabandon');
        $motifsabandons = $this->Motifsabandon->find('list', ['conditions' => ['deleted' => 0],
        'fields' => ['libelle'], ]);
        $this->set(compact('order_code', 'motifsabandons'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Commandeglovo->id = $id;
        if (!$this->Commandeglovo->exists()) {
            throw new NotFoundException(__('Invalide vente'));
        }

        if ($this->Commandeglovo->delete()/* flagDelete() */) {
            $this->Commandeglovo->Commandeglovodetail->deleteAll(['Commandeglovodetail.Commandes_glovo_id' => $id]);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function deletedetail($id = null, $Commandeglovo_id = null)
    {
        $this->Commandeglovo->Commandeglovodetail->id = $id;
        if (!$this->Commandeglovo->Commandeglovodetail->exists()) {
            throw new NotFoundException(__('Invalide article'));
        }

        if ($this->Commandeglovo->Commandeglovodetail->flagDelete()) {
            $this->calculatrice($Commandeglovo_id);
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function AnnulerProduits($Commandeglovo_id, $produits, $qte)
    {
        $options = ['conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $Commandeglovo_id]];
        $Commandeglovo = $this->Commandeglovo->find('first', $options);

        $online_id = $Commandeglovo['Commandeglovo']['online_id'];

        $produit2 = $produits;
        $produits = explode(',', $produits);
        $qte = explode(',', $qte);
        $qteD = [];

        for ($i = 0; $i < count($produits); ++$i) {
            $qteD[$produits[$i]] = $qte[$i];
        }
        $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
            'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id,
            'Commandeglovodetail.id' => $produits, ],
            'contain' => ['Produit'],
        ]);

        //$product_barres = [];
        $quantities = [];
        $weight_ordered = [];
        $qteF = [];
        foreach ($details as $detail) {
            $product_barres[] = $detail['Produit']['code_barre'];
            $quantities[] = $detail['Commandeglovodetail']['qte_cmd'];
            $weight_ordered[] = $detail['Commandeglovodetail']['qte_ordered'];
        }
        $data = [];
        $arr_details = [];

        $this->loadModel('Store');
        $store_id = $this->Session->read('Auth.User.StoreSession.id');
        $storeSession = $this->Store->find('first', ['conditions' => ['Store.id' => $store_id], 'contain' => ['Societe']]);
        $id_Commandeglovo = $storeSession['Store']['id_Commandeglovo'];

        $data[0] = [
            'site' => intval($id_Commandeglovo),
            'id' => intval($online_id),
        ];

        for ($i = 0; $i < sizeof($details); ++$i) {
            $qte2 = $qteD[$details[$i]['Commandeglovodetail']['id']];
            if ($details[$i]['Commandeglovodetail']['variation_id'] != '0') {
                // Calcul avec KG
                $arr = [
                'id' => $details[$i]['Commandeglovodetail']['online_id'],
                'variation_id' => $details[$i]['Commandeglovodetail']['variation_id'],
               // "quantity" =>  intval($quantities[$i]),
                'quantity' => $qte2, //intval($quantities[$i]),
                'weight_ordered' => $qte2, //floatval($weight_ordered[$i])
            ];
            } else {
                // Calcul avec pièce
                $arr = [
                'id' => $details[$i]['Commandeglovodetail']['online_id'],
                'variation_id' => $details[$i]['Commandeglovodetail']['variation_id'],
                // "quantity" =>  intval($quantities[$i]),
                'quantity' => $qte2, //intval($quantities[$i]),
                'quantity_ordered' => $qte2, //intval($quantity_ordered[$i])
            ];
            }

            array_push($arr_details, $arr);
            $data[0]['line_items'] = $arr_details;
        }

        $data = trim(json_encode(array_values($data)), '[]');
        header('Content-Type: application/json; charset=UTF-8');

        //var_dump($data);
        //die();

        $ch = curl_init();

        $parametres = $this->GetParametreSte();
        $url = $parametres['Api annulation partielle'];

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

        /* if($return["message"] == "The order is updated successfully") { */

        // $return["status"] = "success";

        // if($return["message"] == "Order returned.") { // version HAMZA

        if ($return['status'] == 'success') {
            /* $this->Commandeglovo->Commandeglovodetail->updateAll(['Commandeglovodetail.qte'=> 0,'Commandeglovodetail.ttc'=> 0],['Commandeglovodetail.Commandes_glovo_id'=> $Commandeglovo_id,
                'Commandeglovodetail.id'=> $produits]); */

            $somme = 0;
            $total = 0;
            $diff = 0;
            //ecomdetail --> qte
            $this->loadModel('Salepoint');
            $salepoint = $this->Salepoint->find('first', ['conditions' => ['Salepoint.Commandeglovo_id' => $Commandeglovo_id]]);

            for ($i = 0; $i < sizeof($details); ++$i) {
                $prix = $details[$i]['Commandeglovodetail']['unit_price'];
                $montant = $prix * $qteD[$details[$i]['Commandeglovodetail']['id']];
                $somme += $montant;
                $oldqte = $details[$i]['Commandeglovodetail']['qte'] - $qteD[$details[$i]['Commandeglovodetail']['id']];
                $oldmontant = $prix * $oldqte;
                $diff += $oldmontant;

                $this->Commandeglovo->create();
                $this->Commandeglovo->Commandeglovodetail->updateAll(['Commandeglovodetail.ttc' => $montant,
                'Commandeglovodetail.qte' => $qteD[$details[$i]['Commandeglovodetail']['id']], ],
                ['Commandeglovodetail.id' => $details[$i]['Commandeglovodetail']['id']]);

                $this->loadModel('Salepointdetail');
                $this->Salepointdetail->create();
                $this->Salepointdetail->updateAll(['Salepointdetail.ttc' => $montant,
                'Salepointdetail.qte' => $qteD[$details[$i]['Commandeglovodetail']['id']], ],
                ['Salepointdetail.Commandeglovodetail_id' => $details[$i]['Commandeglovodetail']['id']]);
            }

            $details2 = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id,
                ['NOT' => ['Commandeglovodetail.id' => $produits]], ],
                'contain' => ['Produit'],
            ]);
            $sommeR = 0;

            for ($i = 0; $i < sizeof($details2); ++$i) {
                $prix = $details2[$i]['Commandeglovodetail']['unit_price'];
                $montant = $prix * $details2[$i]['Commandeglovodetail']['qte'];
                $sommeR += $montant;
            }

            $Commandeglovo = $this->Commandeglovo->find('first', ['conditions' => ['Commandeglovo.id' => $details[0]['Commandeglovodetail']['Commandeglovo_id']]]);
            //$net_a_payer = $Commandeglovo['Commandeglovo']['total_apres_reduction'];

            $net_a_payer = $somme + $sommeR;

            //////////////
            $details3 = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id],
                'contain' => ['Produit'],
            ]);
            $total_a_payer_ht = 0;
            foreach ($details3 as $k => $v) {
                $tva = (isset($v['Produit']['tva_vente']) and !empty($v['Produit']['tva_vente'])) ? (int) $v['Produit']['tva_vente'] : 20;
                $division_tva = (1 + $tva / 100);
                // Quantité & Prix de vente

                $qte = $v['Commandeglovodetail']['qte'];

                $prix_vente_ht = round($v['Commandeglovodetail']['unit_price'] / $division_tva, 2);
                // Calcule total
                $total_ht = round($prix_vente_ht * $qte, 2);
                $total_a_payer_ht += $total_ht;
            }

            ///////////////////////
            //$total_ht = $Commandeglovo['Commandeglovo']['total_a_payer_ht'] - $diff;
            $this->Commandeglovo->updateAll(['Commandeglovo.total_apres_reduction' => $net_a_payer,
            'Commandeglovo.total_a_payer_ttc' => $net_a_payer,
            'Commandeglovo.total_a_payer_ht' => $total_a_payer_ht, ], ['Commandeglovo.id' => $details[0]['Commandeglovodetail']['Commandeglovo_id']]);

            $montant_tva = $net_a_payer - $total_a_payer_ht;
            $this->loadModel('Salepoint');
            $this->Salepoint->updateAll(['Salepoint.total_apres_reduction' => $net_a_payer + $salepoint['Salepoint']['fee'],
            'Salepoint.total_a_payer_ttc' => $net_a_payer, 'Salepoint.total_paye' => $net_a_payer + $salepoint['Salepoint']['fee'],
            'Salepoint.montant_tva' => $montant_tva, 'Salepoint.total_a_payer_ht' => $total_a_payer_ht, ], ['Salepoint.Commandeglovo_id' => $details[0]['Commandeglovodetail']['Commandeglovo_id']]);
            $this->loadModel('Salepoint');

            $this->loadModel('Salepoint');
            $this->Salepoint->Avance->updateAll(['Avance.montant' => $net_a_payer + $salepoint['Salepoint']['fee']], ['Avance.salepoint_id' => $salepoint['Salepoint']['id'], 'Avance.montant !=' => 0]);

            return $this->redirect(['action' => 'view', $Commandeglovo_id, 4, $return['message']]);
        } else {
            $error = 3;

            return $this->redirect(['action' => 'view', $Commandeglovo_id, $error, $return['message']]);
        }
        /* $this->render('view');
$this->set('id', 9);
 */
    }

    public function view($id = null, $produits = null, $message = null, $flag = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');

        $details = [];

        if ($this->Commandeglovo->exists($id)) {
            $options = ['contain' => ['Client', 'Store'], 'conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
            $this->request->data = $this->Commandeglovo->find('first', $options);

            $options = ['contain' => ['Store', 'Client', 'User'], 'conditions' => ['Salepoint.Commandeglovo_id' => $id]];

            $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $id],
                'contain' => ['Produit'],
            ]);
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');

            return $this->redirect(['action' => 'index']);
        }

        if ($produits == '4') {
            $error = false;
            $this->set(compact('details', 'error', 'message', 'role_id', 'user_id', 'flag'));
        } elseif ($produits == '3') {
            $error = true;
            $this->set(compact('details', 'error', 'message', 'role_id', 'user_id', 'flag'));
        } else {
            $this->set(compact('details', 'role_id', 'user_id', 'flag'));
        }
        $this->getPath($this->idModule);
    }

    public function getProduit($produit_id = null, $depot_id = null)
    {
        $produit = $this->Commandeglovo->Commandeglovodetail->Produit->find('first', ['conditions' => ['Produit.id' => $produit_id]]);
        $tva = (isset($produit['Produit']['tva_vente']) and !empty($produit['Produit']['tva_vente'])) ? $produit['Produit']['tva_vente'] : 20;
        $prix_vente = (isset($produit['Produit']['prix_vente']) and !empty($produit['Produit']['prix_vente'])) ? $produit['Produit']['prix_vente'] : 20;
        die(json_encode(['tva' => $tva, 'prix_vente' => $prix_vente]));
    }

    public function pdf($id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Commandeglovo->exists($id)) {
            $options = ['contain' => ['Client' => ['Ville']], 'conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
            $this->request->data = $this->Commandeglovo->find('first', $options);

            $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $id],
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
        if ($this->Commandeglovo->exists($id)) {
            $options = ['contain' => ['Depot', 'User', 'Client' => ['Ville']], 'conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $id]];
            $this->request->data = $this->Commandeglovo->find('first', $options);

            $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $id],
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

    public function editdetail($id = null, $Commandeglovo_id = null)
    {
        $Commandeglovo = $this->Commandeglovo->find('first', ['contain' => ['User'], 'conditions' => ['Commandeglovo.id' => $Commandeglovo_id]]);
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');
        $depot_id = 1;

        $produits_exists = $this->Commandeglovo->Commandeglovodetail->Produit->find('list', [
            'fields' => ['Produit.id', 'Produit.id'],
            'joins' => [
                ['table' => 'Commandeglovodetails', 'alias' => 'Commandeglovodetail', 'type' => 'INNER', 'conditions' => ['Commandeglovodetail.produit_id = Produit.id', 'Commandeglovodetail.deleted = 0']],
            ],
            'conditions' => [
                'Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id,
            ],
        ]);

        $produits = $this->Commandeglovo->Commandeglovodetail->Produit->findList([
            'Produit.id !=' => $produits_exists,
        ]);

        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Commandeglovodetail']['Commandeglovo_id'] = $Commandeglovo_id;
            if ($this->Commandeglovo->Commandeglovodetail->save($this->request->data)) {
                $this->calculatrice($Commandeglovo_id);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Commandeglovo->Commandeglovodetail->exists($id)) {
            $options = ['conditions' => ['Commandeglovodetail.'.$this->Commandeglovo->Commandeglovodetail->primaryKey => $id]];
            $this->request->data = $this->Commandeglovo->Commandeglovodetail->find('first', $options);
            $produits = $this->Commandeglovo->Commandeglovodetail->Produit->findList();
        }

        $depots = $this->Commandeglovo->Commandeglovodetail->Depot->find('list');
        $categorieproduits = $this->Commandeglovo->Commandeglovodetail->Produit->Categorieproduit->find('list');
        $this->set(compact('produits', 'role_id', 'depot_id', 'depots', 'categorieproduits'));
        $this->layout = false;
    }

    public function changestate($Commandeglovo_id = null, $etat = -1)
    {
        $details = $this->Commandeglovo->Commandeglovodetail->find('all', ['conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id]]);
        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Commandeglovo->id = $Commandeglovo_id;
        if ($this->Commandeglovo->saveField('etat', $etat)) {
            $this->Session->setFlash("L'enregistrement a été effectué avec succès.", 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect($this->referer());
    }

    public function CheckRemise($Commandeglovo_id = null)
    {
        $Commandeglovo = $this->Commandeglovo->find('first', ['conditions' => ['Commandeglovo.id' => $Commandeglovo_id]]);
        $remise = (isset($Commandeglovo['Commandeglovo']['remise']) and !empty($Commandeglovo['Commandeglovo']['remise'])) ? (float) $Commandeglovo['Commandeglovo']['remise'] : 0;
        $details = $this->Commandeglovo->Commandeglovodetail->find('all', ['contain' => ['Produit'], 'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id]]);

        $CommandeglovodetailData = [];
        foreach ($details as $k => $v) {
            // TVA
            $tva = (isset($v['Produit']['tva_vente']) and !empty($v['Produit']['tva_vente'])) ? (int) $v['Produit']['tva_vente'] : 20;
            $division_tva = (1 + $tva / 100);

            // Quantité & Prix de vente
            $qte_cmd = (isset($v['Commandeglovodetail']['qte_cmd'])) ? $v['Commandeglovodetail']['qte_cmd'] : 0;
            $qte = (isset($v['Commandeglovodetail']['qte']) and $v['Commandeglovodetail']['qte'] > 0) ? $v['Commandeglovodetail']['qte'] : $qte_cmd;
            $prix_vente_ht = round($v['Commandeglovodetail']['prix_vente'] / $division_tva, 2);
            $prix_vente_ttc = $v['Commandeglovodetail']['prix_vente'];

            // Calcule total
            $total_ht = round($prix_vente_ht * $qte, 2);
            $total_ttc = round($prix_vente_ttc * $qte, 2);

            $montant_remise = ($total_ttc >= 0) ? (float) ($total_ttc * $remise) / 100 : 0;

            $total_ttc = $total_ttc - $montant_remise;

            // Data structure
            $CommandeglovodetailData[] = [
                'id' => $v['Commandeglovodetail']['id'],
                'montant_remise' => $montant_remise,
                'total' => $total_ht,
                'ttc' => $total_ttc,
                'remise' => $remise,
            ];
        }

        if ($this->Commandeglovo->Commandeglovodetail->saveMany($CommandeglovodetailData)) {
            $this->calculatrice($Commandeglovo_id);
        }

        return true;
    }

    public function calculatrice($Commandeglovo_id = null)
    {
        $Commandeglovo = $this->Commandeglovo->find('first', ['conditions' => ['id' => $Commandeglovo_id]]);
        $remise = (isset($Commandeglovo['Commandeglovo']['remise']) and !empty($Commandeglovo['Commandeglovo']['remise'])) ? (float) $Commandeglovo['Commandeglovo']['remise'] : 0;
        $details = $this->Commandeglovo->Commandeglovodetail->find('all', ['conditions' => ['Commandeglovo_id' => $Commandeglovo_id]]);

        $tva = 0;
        $montant_tva = 0;
        $total_a_payer_ht = 0;
        $total_a_payer_ttc = 0;
        $nombre_lines = count($details);
        foreach ($details as $k => $value) {
            $total_a_payer_ttc = $total_a_payer_ttc + $value['Commandeglovodetail']['ttc'];
            $total_a_payer_ht = $total_a_payer_ht + $value['Commandeglovodetail']['total'];
            $montant_tva = $montant_tva + $value['Commandeglovodetail']['montant_tva'];
            $tva = $tva + $value['Commandeglovodetail']['tva'];
        }
        $tva = round($tva / $nombre_lines, 2);
        $montant_remise = ($total_a_payer_ttc >= 0) ? round(($total_a_payer_ttc * $remise) / 100, 2) : 0;
        $total_apres_reduction = round($total_a_payer_ttc - $montant_remise, 2);

        $data['Commandeglovo'] = [
            'id' => $Commandeglovo_id,
            'tva' => $tva,
            'montant_tva' => $montant_tva,
            'montant_remise' => $montant_remise,
            'total_a_payer_ht' => $total_a_payer_ht,
            'total_a_payer_ttc' => $total_a_payer_ttc,
            'total_apres_reduction' => $total_apres_reduction,
        ];

        if ($this->Commandeglovo->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function mail($Commandeglovo_id = null)
    {
        $Commandeglovo = $this->Commandeglovo->find('first', ['contain' => ['Client'], 'conditions' => ['Commandeglovo.id' => $Commandeglovo_id]]);
        $email = (isset($Commandeglovo['Client']['email']) and !empty($Commandeglovo['Client']['email'])) ? $Commandeglovo['Client']['email'] : '';
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['Email']['Commandeglovo_id'] = $Commandeglovo_id;
            if ($this->Commandeglovo->Email->save($this->request->data)) {
                $url = $this->generatepdf($Commandeglovo_id);
                $email_id = $this->Commandeglovo->Email->id;
                if ($this->Commandeglovo->Email->saveField('url', $url)) {
                    $settings = $this->GetParametreSte();
                    $to = [$this->data['Email']['email']];
                    $objet = (isset($this->data['Email']['objet'])) ? $this->data['Email']['objet'] : '';
                    $content = (isset($this->data['Email']['content'])) ? $this->data['Email']['content'] : '';
                    $attachments = ['Commandeglovo' => ['mimetype' => 'application/pdf', 'file' => $url]];
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

    public function generatepdf($Commandeglovo_id = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Commandeglovo->exists($Commandeglovo_id)) {
            $options = ['contain' => ['Client' => ['Ville']], 'conditions' => ['Commandeglovo.'.$this->Commandeglovo->primaryKey => $Commandeglovo_id]];
            $data = $this->Commandeglovo->find('first', $options);

            $details = $this->Commandeglovo->Commandeglovodetail->find('all', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $Commandeglovo_id],
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
        $ville = (isset($data['Client']['Ville']['id'])) ? strtoupper($data['Client']['Ville']['libelle']).'<br/>' : '';
        $ice = (isset($data['Client']['id']) and !empty($data['Client']['ice'])) ? 'ICE : '.strtoupper($data['Client']['ice']).'<br/>' : '';
        $adresse = (isset($data['Client']['id']) and !empty($data['Client']['adresse'])) ? strtoupper($data['Client']['adresse']).'<br/>' : '';

        $html = '
			<html>
			<head>
				<title>BON COMMANDE N° : '.$data['Commandeglovo']['order_code'].'</title>
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
				                    <h4 class="container"">BON COMMANDE N° : '.$data['Commandeglovo']['order_code'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container"">DATE : '.$data['Commandeglovo']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.$adresse.'
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
				                <th>Prix</th>
				                <th>Montant total</th>
				            </tr>
				        </thead>
				        <tbody>';
        foreach ($details as $tache) {
            $html .= '<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Commandeglovodetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Commandeglovodetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Commandeglovodetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
        }
        $html .= '
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Commandeglovo']['total_apres_reduction'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente de la commande à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper($LettreHelper->NumberToLetter(strval($data['Commandeglovo']['total_apres_reduction']))).' DHS
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
        file_put_contents($destination.DS.'Commandeglovo.'.$data['Commandeglovo']['date'].'-'.$data['Commandeglovo']['id'].'.pdf', $output);

        return $destination.DS.'Commandeglovo.'.$data['Commandeglovo']['date'].'-'.$data['Commandeglovo']['id'].'.pdf';
    }


    // Fonction : Synchronisation des données SERVEUR <> POS


    // recupérer les clients depuis le serveur 
	public function apiGetGlovoToSync($store_id = null)
	{
		// Définir le type de réponse
		$this->response->type('json');

        // Récupérer les données de la table "Salepoint"
        $Commandeglovos = $this->Commandeglovo->find('all',[
            'conditions' => [
                'Commandeglovo.store_id' => $store_id,
                'Commandeglovo.etat' => [-1, 3], // recupérer les nouvelles commandes :-1 et les commandes annulées : 3
                // il faut ajouter les 3 état à recpere
                'Commandeglovo.deleted' => 0,
			],
			'contain' => ['Commandeglovodetail'],
        ]);

		// Afficher les données en format JSON
		echo json_encode($Commandeglovos);
        
		// Arrêter le rendu de la vue
		return $this->response;
	}




        // Inérer les données récupérées des users à la caisse demanderesse
    public function insertGlovoApiPOS($caisse_id = null, $server_link=null, $json_data=null, $store_id = null)
    {
        // Récupérer les informations de l'application 
        $result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));
        $server_link = $result['server_link'];
        $caisse_id      = $result['caisse_id'];
        $store_id       = $result['store_id'];

        $link_api = $server_link.'/Commandeglovos/apiGetGlovoToSync/'.$store_id;  // uniquement le store demandeur 
        $json_data = file_get_contents($link_api);

        if ($json_data === false) {
            // Le fichier n'a pas été trouvé, définir un message d'erreur personnalisé
            $this->Session->setFlash("Impossible de récupérer les données du fichier", 'alert-danger');
            $check_sync = NULL;
        } else {
            $data = json_decode($json_data, true);
            $this->set('data', $data);
        }

        // Régle d'état : JCOLLAB V4.1
            //-1    : Nouvelle commande => Récupérer depuis le serveur et enregistrer dans POS
            // 2    : Commandes traitées  => Mise à jour de l'etat dans le serveur =2
            // 3    : Commande annulée  => Récupérer depuis le serveur et enregistrer dans POS

        $existing_data = NULL;
        foreach ($data as $k => $item) {
            $glovo_api_ids  = $item['Commandeglovo']['id'];
            $glovo_api_etat = $item['Commandeglovo']['etat'];

           // $existing_data = $this->Commandeglovo->findByid($glovo_api_ids);

           $existing_data = $this->Commandeglovo->find('all', [
            'conditions' => [
                'id' => $glovo_api_ids
            ],
            'contain' => ['Commandeglovodetail']
            ]);
        
            //-1    : Nouvelles commandes
            if (!$existing_data) {
                $this->Commandeglovo->saveAssociated($item);
            }else{
                
                foreach ($existing_data as $key => $existing_data_elem) {
                   
                    $glovo_db_etat = $existing_data_elem['Commandeglovo']['etat'];
                    $glovo_db_id = $existing_data_elem['Commandeglovo']['id'];
                    
                    echo "Element $key - ID: $glovo_db_id, Etat: $glovo_db_etat<br>";

                        // 2    : Commandes traitées
                        if ($glovo_db_etat == 2 && $glovo_api_etat != 3) {
                            // Connexion à la deuxième base de données  *******
                            $this->Commandeglovo->setDataSource('sync_server'); 
                            $fields = array('Commandeglovo.etat' => 2);
                            $conditions = array('Commandeglovo.id' => $glovo_db_id);
                            $this->Commandeglovo->updateAll($fields, $conditions);


                            // Update associated records  ___ base des données externe
                            $this->Commandeglovo->Commandeglovodetail->setDataSource('sync_server');
                            foreach ($existing_data_elem['Commandeglovodetail'] as $detail) {
                                $detailId = $detail['id'];
                                $associatedRecord = $this->Commandeglovo->Commandeglovodetail->findById($detailId);
                                    if ($associatedRecord) {
                                        $associatedRecord['Commandeglovodetail']['ttc'] = $detail['ttc'];
                                        $associatedRecord['Commandeglovodetail']['total'] = $detail['total'];
                                        $associatedRecord['Commandeglovodetail']['qte'] = $detail['qte'];
                                        $this->Commandeglovo->Commandeglovodetail->save($associatedRecord);
                                    }
                            }

                            // Back to the main database
                            $this->Commandeglovo->setDataSource('default');
                            $this->Commandeglovodetail->setDataSource('default');
                        }
                        // 3    : Commandes annulées 
                        if ($glovo_api_etat == 3) {
                            $fields = array('Commandeglovo.etat' => 3);
                            $conditions = array('Commandeglovo.id' => $glovo_db_id);
                            $this->Commandeglovo->updateAll($fields, $conditions);
                        }
                }

            }

        }   // END foreach item



        $this->layout = false;
    }







}
