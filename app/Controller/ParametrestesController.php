<?php
class ParametrestesController extends AppController {
	public $idModule = 27;
	private $Helper = [
		'Email_all' => ['label' => 'Envoi des emails','type' => 'bool','cat' => 'email','default' => '-1'],
		################################## Start SMTP ##################################
		'SMTP_host' => ['label' => 'Serveur SMTP','type' => 'normal','cat' => 'smtp','default' => 'ssl://smtp.gmail.com'],
		'SMTP_port' => ['label' => 'Port SMTP','type' => 'normal','cat' => 'smtp','default' => '465'],
		'SMTP_username' => ['label' => 'SMTP Username','type' => 'normal','cat' => 'smtp','default' => 'cakephp.smtp@gmail.com'],
		'SMTP_password' => ['label' => 'Mot de passe SMTP','type' => 'normal','cat' => 'smtp','default' => 'cake.php'],
		'SMTP_auth' => ['label' => 'Authentification SMTP','type' => 'normal','cat' => 'smtp','default' => 'true'],
		'SMTP_from' => ['label' => 'De la part de','type' => 'normal','cat' => 'smtp','default' => 'notification@hec.ma'],
		################################## End SMTP ##################################
		'Push_Notification' => ['label' => 'Push notification','type' => 'normal','default' => 1],
		################################## Alert ##################################
		'Alert_duree' => ['label' => 'Rappelle avant (par jour) : ','type' => 'normal','default' => 2],
		'Alert_groupe' => ['label' => "Groupe d'alerte",'type' => 'normal','default' => 1],
		################################## Alert ##################################
		################################## Code à barre ##################################
		'cb_identifiant' => ['label' => 'Identifiant','type' => 'normal','default' => 2],
		'cb_produit_depart' => ['label' => "Produit",'type' => 'normal','default' => 1],
		'cb_produit_longeur' => ['label' => "Produit",'type' => 'normal','default' => 1],
		'cb_quantite_depart' => ['label' => "Quantité",'type' => 'normal','default' => 1],
		'cb_quantite_longeur' => ['label' => "Quantité",'type' => 'normal','default' => 1],
		'cb_div_kg' => ['label' => "Division kilograme",'type' => 'normal','default' => 1],
		################################## Code à barre ##################################
		################################## E-commerce ##################################
		'Api pending' => ['label' => 'Api pending','type' => 'normal','default' => '9TG1tavUBYMG'],
		'Api update pos' => ['label' => "Api update pos",'type' => 'normal','default' => 'HMAC-SHA1'],
		'Api annulation partielle' => ['label' => "Api annulation partielle",'type' => 'normal','default' => 'QufR2AvM4La8pxIQB8PfffKU'],
		'Api Abondan total' => ['label' => "Api Abondan total",'type' => 'normal','default' => '1.0'],
		'Api sync produits' => ['label' => "Api sync produits",'type' => 'normal','default' => '1.0'],
		/* 'Api Get Salepoints Cod' => ['label' => "Api Get Salepoints Cod",'type' => 'normal','default' => '1.0'],
		'Api Update payment method' => ['label' => "Api Update payment method",'type' => 'normal','default' => '1.0'],
		'User Api payment method' => ['label' => "User Api payment method",'type' => 'normal','default' => '1.0'],
		'Password Api payment method' => ['label' => "Password Api payment method",'type' => 'normal','default' => '1.0'],
	 */	'User' => ['label' => "User",'type' => 'normal','default' => 'Ha4JSJgplUV0jV66gAATyajoVrv5wBoTAXXnLkm4mIHiiZbY'],
		'Password' => ['label' => "Password",'type' => 'normal','default' => 'onoW1V9yHRt72v2jyLysZ7hF67WAPdXpmZhYN6TBw7jB4Lhn'],
		################################## E-commerce ##################################
	];

	public $uses = ['Parametreste','Groupe','Ecommerce','Produit'];

	public function index() {
		if( $this->request->is(['post', 'put']) ){
			if( !empty( $this->data ) ){
				if( $this->Parametreste->saveAll($this->data) ) {
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				}else{
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
			}
			return $this->redirect(['action' => 'index']);
		}

		$Helper = $this->Helper;
		$parametrestes = $this->Parametreste->find('all',[ 'order' => ['key'] ]);

		$keyParametrestes = [];
		foreach ($parametrestes as $k => $v){
			$keyParametrestes[$v['Parametreste']['key']] = $v['Parametreste'];
			if( isset($checkHelper[$v['Parametreste']['key']]) ) unset($checkHelper[$v['Parametreste']['key']]);
		}
		$groupes = $this->Groupe->find('list');
		$this->set(compact('parametrestes','keyParametrestes','Helper','groupes'));
		$this->getPath($this->idModule);
	}
	public function generatecommandes() {
		
		$ch = curl_init();
		$parametres = $this->GetParametreSte();

		$url = $parametres["Api pending"];
		$headers = array(
			'Content-Type:application/json',
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
    		CURLOPT_POSTFIELDS => '{ "site" : 8 }',
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_USERPWD => $parametres["User"] . ':' . $parametres["Password"],
		]);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$return = curl_exec($ch);
		curl_close($ch);
		$return = json_decode($return,true);

		if ( isset($return) AND !empty($return) ) {
			$data = [];
			foreach ($return as $v) {

				$data[ $v['id'] ]['Ecommerce'] = [
					'online_id' => $v['id'],
					/* 'barcode' => $v['barcode'], */
					'shipment' => $v['shipment'],
					'payment_method' => $v['payment_method'],
					'date' => date('Y-m-d', strtotime( $v['date_created'] )),
				];

				if ( isset($v['customer']['phone']) AND !empty($v['customer']['phone'])) {
					$client = $this->Ecommerce->Client->find('first',['fields'=>['id'],'conditions' => [ 'Client.telmobile' => trim($v['customer']['phone']) ] ]);

					if ( isset($client['Client']['id']) AND !empty($client['Client']['id']) ) $data[ $v['id'] ]['Ecommerce']['client_id'] = $client['Client']['id'];
					else{
						$insert = ['designation' => $v['customer']['name'],'telmobile' => $v['customer']['phone'],'email' => $v['customer']['email'],'organisme' => 1];
						$this->Ecommerce->Client->create();
						if( $this->Ecommerce->Client->save($insert) ) $data[ $v['id'] ]['Ecommerce']['client_id'] = $this->Ecommerce->Client->id;
					}
				}

				if ( isset($v['line_items']) AND !empty($v['line_items'])) {
					$data[ $v['id'] ]['Ecommercedetail'] = [];
					foreach ($v['line_items'] as $key => $value) {
						$produit = $this->Produit->find('first',['fields'=>['id'],'conditions'=>['Produit.code_barre'=>$value['product_id']]]);
						$produit_id = ( isset($produit['Produit']['id']) AND !empty($produit['Produit']['id']) ) ? $produit['Produit']['id'] : null ;
						$qte_cmd = ( isset( $value['quantity'] ) AND !empty( $value['quantity'] ) ) ? (int) $value['quantity'] : (float) $value['weight_ordered'] ;
						$data[ $v['id'] ]['Ecommercedetail'][] = [
							'prix_vente' => $value['unit_price'],
							'produit_id' => $produit_id,
							'online_id' => $value['id'],
							'qte_cmd' => $qte_cmd,
							'total' => 0,
							'ttc' => 0,
							'qte' => 0,
						];
					}
				}
			}

			if ( isset($data) AND empty($data) ) {
				$this->Session->setFlash('Opération impossible : la liste des commandes est vide !','alert-danger');
				return $this->redirect($this->referer());
			}

		/* 	$commandes = $this->Ecommerce->find("list",['fields'=>['id','id'],'conditions'=>['Ecommerce.etat'=>-1]]);
			$this->Ecommerce->updateAll(['Ecommerce.deleted'=>0],['Ecommerce.id' => $commandes]);

			$details = $this->Ecommerce->Ecommercedetail->find('list',['fields'=>['id','id'],'conditions'=>['Ecommercedetail.ecommerce_id'=>$commandes]]);
			$this->Ecommerce->Ecommercedetail->updateAll(['Ecommercedetail.deleted'=>0],['Ecommercedetail.id'=>$details]);
			 */
			foreach ($data as $commande) {
			    $online_id = $commande["Ecommerce"]["online_id"];
				$ecommerce = $this->Ecommerce->query("Select * from ecommerces where online_id=$online_id");
				if(!isset($ecommerce[0]["ecommerces"]["id"]))
				$this->Ecommerce->saveAssociated($commande); 
			}

			$this->Session->setFlash('La liste des commandes a été mise à jour avec succès.','alert-success');
			return $this->redirect($this->referer());

		} else {
			$this->Session->setFlash('Opération impossible : problème de la connexion e-commerce !','alert-danger');
			return $this->redirect($this->referer());
		}
		

		$params = $this->Parametreste->findList();
		$url = 'https://centrale.lafonda.info/wp-json/fnd-api/v1/confirmed-orders';
		$oauth_access_token_secret = ( isset($params['oauth_access_token_secret']) ) ? $params['oauth_access_token_secret'] : 'onoW1V9yHRt72v2jyLysZ7hF67WAPdXpmZhYN6TBw7jB4Lhn';
		$oauth_consumer_secret = ( isset($params['oauth_consumer_secret']) ) ? $params['oauth_consumer_secret'] : 'Ha4JSJgplUV0jV66gAATyajoVrv5wBoTAXXnLkm4mIHiiZbY';
		$oauth_signature_method = ( isset($params['oauth_signature_method']) ) ? $params['oauth_signature_method'] : 'HMAC-SHA1';
		$oauth_consumer_key = ( isset($params['oauth_consumer_key']) ) ? $params['oauth_consumer_key'] : '9TG1tavUBYMG';
		$oauth_token = ( isset($params['oauth_token']) ) ? $params['oauth_token'] : 'QufR2AvM4La8pxIQB8PfffKU';
		$oauth_version = ( isset($params['oauth_version']) ) ? $params['oauth_version'] : '1.0';
		$oauth_timestamp =  time();
		$oauth_nonce = time();

		$param_string = 
		    'oauth_consumer_key=' . $oauth_consumer_key .
		    '&oauth_nonce=' . $oauth_nonce .
		    '&oauth_signature_method=' . $oauth_signature_method .
		    '&oauth_timestamp=' . $oauth_timestamp .
		    '&oauth_token=' . $oauth_token .
		    '&oauth_version=' . $oauth_version;

		//Generate a signature base string for POST
		$base_string = 'POST&' . rawurlencode($url) . '&' . rawurlencode($param_string);
		$sign_key = rawurlencode($oauth_consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);

		//Generate a unique signature
		$request['url'] = $url;
		$oauth_signature = base64_encode(hash_hmac('sha1', $base_string, $sign_key, true));
		$request['method'] = 'POST';

		$url = 'https://centrale.lafonda.info/wp-json/fnd-api/v1/confirmed-orders?'.
		  'oauth_consumer_key='.$oauth_consumer_key.
		  '&oauth_token='.$oauth_token.
		  '&oauth_signature='.$oauth_signature.
		  '&oauth_signature_method='.$oauth_signature_method.
		  '&oauth_timestamp='.$oauth_timestamp.
		  '&oauth_nonce='.$oauth_nonce.
		  '&oauth_version='.$oauth_version;
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => array(
		    'Cookie: PHPSESSID=prhfr62lc5r06ale4v66hnb21q',
		    "content-type: application/x-www-form-urlencoded",
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);

		$result = json_decode($response,true);

		if ( isset($result['message']) AND !empty($result['message']) ) {
		  	$return['message'] = $result['message'];
		  	$return['error'] = true;
		  	$return['data'] = [];
		}else{
			$return['message'] = '';
		  	$return['error'] = false;
		  	$return['data'] = json_decode($response,true);
		}
		if ( isset($return['data']) AND !empty($return['data']) ) {
			$data = [];
			foreach ($return['data'] as $v) {

				$data[ $v['id'] ]['Ecommerce'] = [
					'online_id' => $v['id'],
					'barcode' => $v['barcode'],
					'shipment' => $v['shipment'],
					'payment_method' => $v['payment_method'],
					'date' => date('Y-m-d', strtotime( $v['date_created'] )),
				];

				if ( isset($v['customer']['phone']) AND !empty($v['customer']['phone'])) {
					$client = $this->Ecommerce->Client->find('first',['fields'=>['id'],'conditions' => [ 'Client.telmobile' => trim($v['customer']['phone']) ] ]);

					if ( isset($client['Client']['id']) AND !empty($client['Client']['id']) ) $data[ $v['id'] ]['Ecommerce']['client_id'] = $client['Client']['id'];
					else{
						$insert = ['designation' => $v['customer']['name'],'telmobile' => $v['customer']['phone'],'email' => $v['customer']['email'],'organisme' => 1];
						$this->Ecommerce->Client->create();
						if( $this->Ecommerce->Client->save($insert) ) $data[ $v['id'] ]['Ecommerce']['client_id'] = $this->Ecommerce->Client->id;
					}
				}

				if ( isset($v['line_items']) AND !empty($v['line_items'])) {
					$data[ $v['id'] ]['Ecommercedetail'] = [];
					foreach ($v['line_items'] as $key => $value) {
						$produit = $this->Produit->find('first',['fields'=>['id'],'conditions'=>['Produit.code_barre'=>$value['product_id']]]);
						$produit_id = ( isset($produit['Produit']['id']) AND !empty($produit['Produit']['id']) ) ? $produit['Produit']['id'] : null ;
						$qte_cmd = ( isset( $value['quantity_ordered'] ) AND !empty( $value['quantity_ordered'] ) ) ? (int) $value['quantity_ordered'] : (float) $value['weight_ordered'] ;
						$data[ $v['id'] ]['Ecommercedetail'][] = [
							'prix_vente' => $value['unit_price'],
							'produit_id' => $produit_id,
							'online_id' => $value['id'],
							'qte_cmd' => $qte_cmd,
							'total' => 0,
							'ttc' => 0,
							'qte' => 0,
						];
					}
				}
			}

			if ( isset($data) AND empty($data) ) {
				$this->Session->setFlash('Opération impossible : la liste des commandes est vide !','alert-danger');
				return $this->redirect($this->referer());
			}

			$commandes = $this->Ecommerce->find("list",['fields'=>['id','id'],'conditions'=>['Ecommerce.etat'=>-1]]);
			$this->Ecommerce->updateAll(['Ecommerce.deleted'=>1],['Ecommerce.id' => $commandes]);

			$details = $this->Ecommerce->Ecommercedetail->find('list',['fields'=>['id','id'],'conditions'=>['Ecommercedetail.ecommerce_id'=>$commandes]]);
			$this->Ecommerce->Ecommercedetail->updateAll(['Ecommercedetail.deleted'=>1],['Ecommercedetail.id'=>$details]);
			
			foreach ($data as $commande) { $this->Ecommerce->saveAssociated($commande); }

			$this->Session->setFlash('La liste des commandes a été mise à jour avec succès.','alert-success');
			return $this->redirect($this->referer());

		} else {
			$this->Session->setFlash('Opération impossible : problème de la connexion e-commerce !','alert-danger');
			return $this->redirect($this->referer());
		}
	}
}