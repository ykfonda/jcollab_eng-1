<?php
class OrdersController extends AppController {
	
	public $uses = ['Produit','Role','User','Salepoint','Attente','Commande','Parametreste','Ecommerce'];

 	public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow();
	} 

    public function commandesDetails() {	 
		if($_SERVER["PHP_AUTH_USER"] == "jcoapi" and $_SERVER["PHP_AUTH_PW"] == "1563dfyc") {

			$ecommerce = $this->Ecommerce->find('all',[
				'conditions' => [
					array('Ecommerce.etat' => 2),
				],
			    'joins' => [
					['table' => 'ecommercedetails', 'alias' => 'Ecommercedetail', 'type' => 'INNER', 'conditions' => ['Ecommercedetail.ecommerce_id = Ecommerce.id','Ecommercedetail.deleted = 0'] ],
					['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Client.id = Ecommerce.client_id','Client.deleted = 0'] ],
					['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Ecommercedetail.produit_id','Produit.deleted = 0'] ]
				], 
				'order' => ['Ecommerce.date desc'],
				'fields'=>['Ecommerce.online_id','Ecommerce.date','Ecommerce.payment_method','Ecommerce.shipment',
				'Ecommerce.total_a_payer_ttc','Ecommerce.fee','Client.designation','Client.telmobile',
				'Client.email','Ecommercedetail.produit_id','Ecommercedetail.qte_cmd','Ecommercedetail.qte',"Ecommercedetail.unit_price", "Ecommercedetail.qte_ordered","Produit.code_barre"],
			    
			]);
			
		
			$ecommerce_id_or = $ecommerce[0]["Ecommerce"]["online_id"];
		    $data = [];
			$arr_details = [];
			$tab_details = [];
			$tab_customer = [];
			$j = 0;
			for($i = 0;$i < sizeof($ecommerce); $i++) {
				
				if($ecommerce[$i]["Ecommerce"]["online_id"] != $ecommerce_id_or and $i != 0) {
					$ecommerce_id_or = $ecommerce[$i]["Ecommerce"]["online_id"];
					
					$j = $i;
					/* var_dump($j); */
					$arr_details = [];
					/* array_push($arr_details,$arr); */
				}
				if($ecommerce[$i]["Ecommerce"]["online_id"] == $ecommerce_id_or) {
					
					$data[$j] = [
						"id" => $ecommerce[$j]["Ecommerce"]["online_id"],
						"date_created" => $ecommerce[$j]["Ecommerce"]["date"],
						"payment_method" => $ecommerce[$j]["Ecommerce"]["payment_method"],
						"shipment" => $ecommerce[$j]["Ecommerce"]["shipment"],
						"subtotal" => $ecommerce[$j]["Ecommerce"]["total_a_payer_ttc"],
						"fee" => $ecommerce[$j]["Ecommerce"]["fee"],
						"total" => number_format($ecommerce[$j]["Ecommerce"]["total_a_payer_ttc"] + $ecommerce[$j]["Ecommerce"]["fee"],2)
						
					];
					$data[$j]["customer"] = [
						
						"name" => $ecommerce[$j]["Client"]["designation"],
						"phone" => $ecommerce[$j]["Client"]["telmobile"],
						"email" => $ecommerce[$j]["Client"]["email"]
				
					];
				}
				$arr = [ 
					"product_id" => $ecommerce[$i]["Produit"]["code_barre"],
					"quantity" => $ecommerce[$i]["Ecommercedetail"]["qte_cmd"],
					"quantite_livree" => $ecommerce[$i]["Ecommercedetail"]["qte"],
					"unit_price" => $ecommerce[$i]["Ecommercedetail"]["unit_price"],
					"qte_ordered" => $ecommerce[$i]["Ecommercedetail"]["qte_ordered"]
					
				]; 
				/* var_dump(($arr)); */
				if($ecommerce[$i]["Ecommerce"]["online_id"] == $ecommerce_id_or) {
					array_push($arr_details,$arr);
				}
				
				
			
				$data[$j]["line_items"] = $arr_details;
				/* var_dump($ecommerce[$i]["Ecommerce"]["online_id"]); */
			}
			/*  die();  */
			/* die();  
			var_dump($ecommerce);die();  */
			header('Content-Type: application/json; charset=UTF-8');
			die( json_encode( array_values($data) ) );
		}
		else { 
			header('Content-Type: application/json; charset=UTF-8');
			$data = [
				"Erreur" => "le nom d'utilisateur ou mot de passe est incorrect"
			]; 
			die( json_encode( $data ) );
			
		}
		/* var_dump($salepoints[1]["Salepoint"]);die(); */	
	}
}
