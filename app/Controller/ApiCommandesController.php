<?php

class ApiCommandesController extends AppController
{
    public $uses = ['Commandeglovo', 'Produit', 'Commandeglovodetail', 'Client'];

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function ApiOrderUpdateMethod($storeId = null, $orderId)
    {
        //set layout as false to unset default CakePHP layout. This is to prevent our JSON response from mixing with HTML
        $this->autoRender = false;

        //check if HTTP method is PUT
        /*  if ($this->request->is('post')) { */
        //if ($_SERVER['PHP_AUTH_USER'] != 'restapi' or $_SERVER['PHP_AUTH_PW'] != 'fAcbrrLrgGjmKvPNu7Yi') {
        $headers = getallheaders();
        $headers['Authorization'];

        /* $this->response->type('application/json');
        $this->response->body(json_encode('1'));

        return $this->response->send();
 */     /* $this->response->type('application/json');
        $this->response->body(json_encode($orderId)); */

        $options = ['conditions' => ['Commandeglovo.order_id' => $orderId]];
        $commande = $this->Commandeglovo->find('first', $options);
        if ($commande['Commandeglovo']['modified'] == 1) {
            //error already modified
        }
        if (isset($commande['Commandeglovo']['READY_FOR_PICKUP'])) {
            //error commande deja prepare
        }
        if (isset($commande['Commandeglovo']['api_ACCEPTED'])) {
            //error commande deja annulé
        }
        $data = $this->request->input('json_decode', true);
        $replacements = $data['replacements'];
        $removed_purchases = $data['removed_purchases'];
        $added_products = $data['added_products'];
        if (empty($replacements) and empty($removed_purchases) and empty($added_products)) {
            // error
        }

        foreach ($replacements as $replacement) {
            $purchased_product_id = $replacement['purchased_product_id'];
            //verify existence product
        }

        //update products
        foreach ($replacements as $replacement) {
            $purchased_product_id = $replacement['purchased_product_id'];
            $product = $replacement['product'];
            unset($product['attributes']);
            $keys_products = array_keys($product);
            if (($key = array_search('id', $keys_products)) !== false) {
                unset($keys_products[$key]);
            }

            $produit = $this->Produit->find('first', ['fields' => ['id'], 'conditions' => ['Produit.code_barre' => $purchased_product_id]]);
            if (isset($produit['Produit']['id']) and !empty($produit['Produit']['id'])) {
                $produit_id = $produit['Produit']['id'];
            } else {
                //purchased_product_id not availaible
            }
            $detail = $this->Commandeglovo->Commandeglovodetail->find('first', [
                'conditions' => ['Commandeglovodetail.Commandes_glovo_id' => $commande['Commandeglovo']['id'],
            'produit_id' => $produit_id, ],
            ]);
            if (isset($detail['Commandeglovodetail']['id'])) {
                foreach ($keys_products as $keys_product) {
                    $this->Commandeglovodetail->updateAll([
            'Commandeglovodetail.'.$keys_product => "'".$product[$keys_product]."'", ],
             ['Commandeglovodetail.id' => $detail['Commandeglovodetail']['id']]);
                }
            } else {
                //error
            }
        }

        $removed = [];
        foreach ($removed_purchases as $removed_purchase) {
            $removed[] = $removed_purchase;
            //verify existence product
        }

        if (!$this->Commandeglovodetail->deleteAll(['Commandeglovodetail.product_barcode' => $removed], false)) {
            // api error
        }

        foreach ($added_products as $added_product) {
            $product = [];
            unset($added_product['attributes']);
            $keys_products = array_keys($added_product);
            foreach ($keys_products as $keys_product) {
                if ($keys_product == 'id') {
                    $product['glovo_id'] = $added_product['id'];
                } else {
                    $product[$keys_product] = $added_product[$keys_product];
                }
            }
            $product['commandes_glovo_id'] = $commande['Commandeglovo']['id'];
            $this->Commandeglovodetail->clear();
            if (!$this->Commandeglovodetail->save($product)) {
                //error
            }
        }
        $this->Commandeglovo->id = $commande['Commandeglovo']['id'];
        $this->Commandeglovo->saveField('modified', 1);
    }

    // API : Update the Payement Methode the Salepoint
    public function ApiCancelMethod($id = null)
    {
        //set layout as false to unset default CakePHP layout. This is to prevent our JSON response from mixing with HTML
        $this->layout = false;

        //check if HTTP method is PUT
        /*  if ($this->request->is('post')) { */
        //if ($_SERVER['PHP_AUTH_USER'] != 'restapi' or $_SERVER['PHP_AUTH_PW'] != 'fAcbrrLrgGjmKvPNu7Yi') {
        $headers = getallheaders();
        $headers['Authorization'];

        /* $this->response->type('application/json');
        $this->response->body(json_encode('1'));

        return $this->response->send();
 */
        $data = $this->request->input('json_decode', true);

        $order_id = $data['order_id'];
        $store_id = $data['store_id'];
        $cancel_reason = $data['cancel_reason'];
        $payment_strategy = $data['payment_strategy'];

        $this->Commandeglovo->updateAll(['Commandeglovo.status_glovo' => "'Cancelled'",
            'Commandeglovo.etat' => 3,
            'Commandeglovo.cancel_reason' => "'".$cancel_reason."'", 'Commandeglovo.payment_strategy' => "'".$payment_strategy."'", ], ['Commandeglovo.order_id' => $order_id,
            'Commandeglovo.store_id' => $store_id, ]);
    }

    // API : Update the Payement Methode the Salepoint
    public function ApiCommandesMethod($id = null)
    {
        //set layout as false to unset default CakePHP layout. This is to prevent our JSON response from mixing with HTML
        $this->layout = false;

        //check if HTTP method is PUT
        /*  if ($this->request->is('post')) { */
        //if ($_SERVER['PHP_AUTH_USER'] != 'restapi' or $_SERVER['PHP_AUTH_PW'] != 'fAcbrrLrgGjmKvPNu7Yi') {
        //$headers = getallheaders();
        //$headers['Authorization'];

        /* $this->response->type('application/json');
        $this->response->body(json_encode('1'));

        return $this->response->send();
 */
        $data = $this->request->input('json_decode', true);

        $data2 = $this->request->input();

        $commande_glovo = [];
        $commande_glovo['Commandeglovo'] = [
        'order_id' => $data['order_id'],  //: "12345",
        'store_id' => $data['store_id'], //:: "your-store-id",
        'order_time' => $data['order_time'], //:: "2018-06-08 14:24:53",
        'estimated_pickup_time' => $data['estimated_pickup_time'], //:: "2018-06-08 14:45:44",
        'utc_offset_minutes' => $data['utc_offset_minutes'], //:: "60",
        'payment_method' => $data['payment_method'], //:: "CASH",
        'currency' => $data['currency'], //:: "EUR",
        'order_code' => $data['order_code'], //:: "BA7DWBUL",
        'allergy_info' => $data['allergy_info'], //:: "I am allergic to tomato",
        'special_requirements' => $data['special_requirements'], //:: "Make sure there is no meat",
        'estimated_total_price' => $data['estimated_total_price'] / 100, //:: 3080,
        'delivery_fee' => $data['delivery_fee'], //:: null,
        'minimum_basket_surcharge' => $data['minimum_basket_surcharge'], //:: null,
        'customer_cash_payment_amount' => $data['customer_cash_payment_amount'] / 100, //:: 5000,
        'courier_name' => $data['courier']['name'], //: "Flash",
        'courier_phone_number' => $data['courier']['phone_number'], //: "+34666666666"
        'date' => $data['estimated_pickup_time'],
        'pick_up_code' => $data['pick_up_code'], //:: "Make sure there is no meat",
        'is_picked_up_by_customer' => $data['is_picked_up_by_customer'], //:: 3080,
        'cutlery_requested' => $data['cutlery_requested'], //:: null,
        'partner_discounts_products' => $data['partner_discounts_products'], //:: null,
        'partner_discounted_products_total' => $data['partner_discounted_products_total'] / 100, //:: 5000,
        'total_customer_to_pay' => $data['total_customer_to_pay'], //:: 5000,
        'loyalty_card' => $data['loyalty_card'], //:: 5000,
        'delivery_address_label' => $data['delivery_address']['label'], //: "Flash",
        'delivery_address_latitude' => $data['delivery_address']['latitude'],
        'delivery_address_longitude' => $data['delivery_address']['longitude'],
        'reqjeson' => $data2,
    ];

        //$this->Commandeglovo->save($commande_glovo);

        $client_exist = $this->Client->find('first', ['conditions' => ['hash' => $data['customer']['hash']]]);
        if (!isset($client_exist['Client']['id'])) {
            $commande_glovo['Client'] = [
                'designation' => $data['customer']['name'],
                'telmobile' => $data['customer']['phone_number'],
                'hash' => $data['customer']['hash'],
                'organisme' => $data['customer']['invoicing_details']['company_name'],
                'adresse' => $data['customer']['invoicing_details']['company_address'],
                'tax_id' => $data['customer']['invoicing_details']['tax_id'],
                'is_glovo' => true,
                ];
        } else {
            $commande_glovo['Commandeglovo']['client_id'] = $client_exist['Client']['id'];
        }

        /*    "pick_up_code": "433",
           "is_picked_up_by_customer": false,
           "cutlery_requested": true,
           "partner_discounts_products": 1550,
           "partner_discounted_products_total": 1530,
           "total_customer_to_pay": null,
           "loyalty_card": "CUSTOMER123" */

        /* "delivery_address": {
            "label": "123 Fake Street, Gotham",
            "latitude": 41.3971955,
            "longitude": 2.2001737
            },
            "bundled_orders": [
            "order-id-1",
            "order-id-2"
            ], */

        /* "customer": {
        "name": "Waldo",
        "phone_number": "N/A",
        "hash": "11111111-2222-3333-4444-555555555555",
        "invoicing_details": {
        "company_name": "Acme Inc.",
        "company_address": "42 Wallaby Way, Sydney",
        "tax_id": "B12341234"
        }
        }, */
        /*
                    "customer": {
                        "name": "Waldo",
                        "phone_number": "N/A",
                        "hash": "11111111-2222-3333-4444-555555555555",
                        "invoicing_details": {
                        "company_name": "Acme Inc.",
                        "company_address": "42 Wallaby Way, Sydney",
                        "tax_id": "B12341234"
                        }
                        },
                        "products": [
                        {
                        "id": "pd1",
                        "purchased_product_id": "A1",
                        "name": "Burger",
                        "price": 1000,
                        "quantity": 2,
                        "attributes": [
                        {
                        "id": "at1",
                        "name": "Extra meat",
                        "price": 300,
                        "quantity": 1
                        }, */
        $products = $data['products'];
        $commande_glovo['Commandeglovodetail'] = [];
        foreach ($products as $product) {
            $produit = $this->Produit->find('first', ['conditions' => ['Produit.code_barre' => $product['id']]]);
            $produit_id = (isset($produit['Produit']['id']) and !empty($produit['Produit']['id'])) ? $produit['Produit']['id'] : null;
            $cdt_cmd = $produit['Produit']['conditionnement'];
            $prix_cmd = $product['price'] / $cdt_cmd;
            $qty_cmd = $product['quantity'] * $cdt_cmd;

            $commande_glovo['Commandeglovodetail'][] = [
            'glovo_id' => $product['id'],
            'product_barcode' => $product['id'],
            'name' => $product['name'],
            'price' => floatval($prix_cmd) / 100,
            'quantity' => floatval($qty_cmd),
            'produit_id' => $produit_id,
            ];
        }

        if ($this->Commandeglovo->saveAssociated($commande_glovo)) {
            $store_id = $commande_glovo['Commandeglovo']['store_id'];
            $order_id = $commande_glovo['Commandeglovo']['order_id'];
            $data['status'] = 'ACCEPTED';

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
                $this->Commandeglovo->id = $this->Commandeglovo->getLastInsertId();
                $this->Commandeglovo->saveField('status_glovo', 'ACCEPTED');
                $this->Commandeglovo->id = $this->Commandeglovo->getLastInsertId();
                $this->Commandeglovo->saveField('api_ACCEPTED', 'ok');

                $erreur = false;
            } else {
                $this->Commandeglovo->id = $this->Commandeglovo->getLastInsertId();
                $this->Commandeglovo->saveField('api_ACCEPTED', 'erreur');

                $erreur = true;
            }
        }
    }

    public function ApiUpdateStatus($id = null)
    {
        //set layout as false to unset default CakePHP layout. This is to prevent our JSON response from mixing with HTML
        $this->layout = false;

        if ($this->request->is('put')) {
            $headers = getallheaders();

            if ($headers['Authorization'] == 'vbnnnn') {
                $this->Commandeglovo->id = 9;
                $this->Commandeglovo->saveField('order_id', 158);
            }
        }
    }
}
