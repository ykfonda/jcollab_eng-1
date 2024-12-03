<?php
class UsersController extends AppController {
	public $UniqueSession = false; // True mean you can't open more than one Session for the same username

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(['forgetpassword','lock','sendEmail','apiGetUsersToSync','insertUsersApi']);
	}

	public function forgetpassword(){
		$messages = [];
		if( $this->request->is('post') ){
			if ( isset( $this->data['User']['email'] ) ) {
				$options = array('contain'=>[],'conditions' => array('User.email' => $this->data['User']['email'] ));
				$user = $this->User->find('first', $options);
				$new_password = substr(str_shuffle(MD5(microtime())), 0, 10);
				if ( !empty( $user ) ) {
					$to = [ $user['User']['email'] ];
					$subject = 'Rénitialisation du mot de passe';
					$content = "<p>Bonjour ".$user['User']['nom']." ".$user['User']['prenom'].",</p>
					<p>Suivant votre demande, on vous informe que votre mot de passe a été bien changé avec succès le ".date('d-m-Y')."</p>
					<p>Votre username est : ".$user["User"]["username"]."<p>
					<p>Votre nouveau mot de passe est : ".$new_password." <p>
					<p><strong>Remarque importante : </strong><br/>Veuillez changer votre mot de passe lors de votre connexion.</p>
					<p>Avant d'imprimer ce courrier, réfléchissons à l'impact sur l'environnement !</p>
					<p>Ce mail a été généré automatiquement. Veuillez ne pas répondre à cette adresse électronique.</p>
					<p>Cordialement</p>";
					$parametreSte = $this->GetParametreSte();
					if ( isset( $user['User']['id'] ) ) {
						$this->User->id = $user['User']['id'];
						if ($this->User->saveField( 'password',AuthComponent::password( $new_password ) ) ){
							if( $this->sendEmail( $parametreSte, $subject , $content , $to ) ){
								$this->Session->setFlash("Votre nouveau mot de passe a été envoyé avec succès à votre boite mail",'green');
							}else{
								$this->Session->setFlash("Il y a un problème de l'envoi de mail",'red');
							}
						}else{
							$this->Session->setFlash("Il y a un problème de l'envoi de mail",'red');
						}
						return $this->redirect($this->referer());
					}
				}else{
					$this->Session->setFlash("L'adresse email n'existe pas, veuillez recommencer ou contacter le support technique",'red');
					return $this->redirect($this->referer());
				}
			}
		}
		$this->set(compact('messages'));
	}




	public function login($type_app=NULL) {
		
		$this->loadModel('Lastsession');
		if ( !is_dir( TMP.'sessions' ) ) {
			mkdir( TMP.'sessions', 0777, true);
			return $this->redirect($this->referer());
		} 
		
		if($this->Session->check('Auth.User')) return $this->redirect('/');		
		if ($this->request->is('post')) {
			
			// Préparer le type d'application : POS ou ADMINSITRATION
			$type_app 			= $this->data['User']['type_app'];
			$store_id_config	= $this->data['User']['store_id'];
			$caisse_id_config	= $this->data['User']['caisse_id'];

			// Remplir les données _Session
			$this->Session->write('caisse_id', $caisse_id_config);

			if ($this->UniqueSession) {
				//$findUser = $this->User->find('first',['conditions' => ['username' => $this->data['User']['username'], 'password' => AuthComponent::password($this->data['User']['password'])] ]);
				$findUser = $this->User->find('first',['conditions' => ['password' => AuthComponent::password($this->data['User']['password'])] ]);
				if( isset($findUser['User']['id']) ){
					$connect = $this->Lastsession->find('first',[
						'conditions' => [
							'Lastsession.logout' => 1,
							'Lastsession.id' => $findUser['User']['id'],
							'Lastsession.date >=' => date('Y-m-d H:i:s', strtotime("-".$this->SessionTime." min"))
						]
					]);

					if( !empty($connect) ){
						$this->Session->setFlash('Cet utilisateur est déjà connecté !','red');
						return false;
					}
				}
			}

		$findUser = $this->User->find('first',['conditions' => ['password' => AuthComponent::password($this->data['User']['password'])] ]);

		if (!empty($findUser) && $this->Auth->login($findUser["User"])) {

			$userId 					= $this->Session->read('Auth.User.id');
			$username 					= $this->Session->read('Auth.User.username');
			$dataSession['Lastsession'] = ['id' => $userId, 'logout' => 1 ,'deleted' => 0,'login'=>$username,'force_to_deco' => 0 , 'date'=>date('Y-m-d H:i:s') ];
			$this->Lastsession->save($dataSession);
				
			// Recupérer la liste des stores d'user
			$user_id = $this->Auth->Session->read('Auth.User.id');
				
			// Récupérer l'adresse IP PUBLIC de la machine cliente
			$adresse_ip_public_user = CakeSession::read('adresse_ip_public_user');

			$this->loadModel('Store');

			$role_id_db = $findUser['User']['role_id']; // recupérer l'ID de rôle
			
			$conditions = [];

			if ($role_id_db == 1 || $role_id_db == 2) {
				$conditions = ['StoreUser.user_id' => $user_id];
			}else{
				// Recherche avec une seul adresse IP 
				// $conditions = ['StoreUser.user_id' => $user_id, 'Store.adresses_ip' => $adresse_ip_public_user];
			
				// Recherche avec plusieurs, en mode ARRAY				
				$conditions = [
					'StoreUser.user_id' => $user_id,
					"CONCAT(',', Store.adresses_ip, ',') LIKE" => "%,{$adresse_ip_public_user},%"
				];				
			}
			
			$storesList = $this->Store->find('all', [
				'fields' => ['Store.*', 'Societe.*'],
				'joins' => [
					['table' => 'stores_users', 'alias' => 'StoreUser', 'type' => 'INNER', 'conditions' => ['StoreUser.store_id = Store.id', 'StoreUser.deleted = 0']],
					['table' => 'societes', 'alias' => 'Societe', 'type' => 'INNER', 'conditions' => ['Societe.id = Store.societe_id', 'Societe.deleted = 0']],
					['table' => 'users', 'alias' => 'User', 'type' => 'INNER', 'conditions' => ['User.id = StoreUser.user_id', 'User.deleted = 0']],
				],
				'conditions' => $conditions
			]);
			
			// INSTANCE SERVEUR
			// pas de store affecté à ce USER (selon son adresse IP PUBLIC)
			
				//  le bloc de code sera exécuté uniquement si $storesList est vide, $type_app n'est pas égal à 2, et $role_id_db n'est ni égal à 1 ni égal à 2.
				if (empty($storesList) && $type_app != 2 && $role_id_db != 1 && $role_id_db != 2 ) {
					// Push to logout
					$this->Session->setFlash('Vous n\'avez pas l\'autorisation d\'accèder à ce point de vente.','red');
					$this->loadModel('Lastsession');
					$userId = $this->Session->read('Auth.User.id');
					if($this->Auth->logout()){
						if ( !empty( $userId ) ) {
							$this->Lastsession->id = $userId;
							$this->Lastsession->saveField('logout', -1);
						}
						$this->Session->delete('Auth');
						return $this->redirect(array('action' => 'login'));
					}
				}
					

			// Type app =  2 Client POS ou 1 Administration local 
			if ($type_app == 1 OR $type_app == 2) {
				// récupérer les informations de store de la t_CONFIG
				$StoreSession = $this->User->StoreSession->find('first',
				['conditions' => ['StoreSession.id' => $store_id_config] ]);
			   
				$this->Session->write('Auth.User.StoreSession', $StoreSession['StoreSession']);

				// récupérer les informations de depôt de la t_CONFIG
				$depotList = $this->User->StoreSession->Depot->find('list',
				[ 'fields' => ['Depot.id','Depot.id'],
				'conditions' => ['Depot.store_id' => $store_id_config] ]);
				
				$this->Session->write('depots', $depotList);

				// si le type == 2 => vers POS
				if ($type_app == 2) {
					return $this->redirect( $this->Auth->redirect('/Pos/index/') );
				}

				// si le type == 1 => vers ADMINISTRATION LOCAL
				if ($type_app == 1) {
					return $this->redirect( $this->Auth->redirect('/') );
				}

			}


			// Type app = 3 Serveur
			if ($type_app == 3) { 

				// Pour l'admin et super admin : affiché tt les stores affectés
				if ($role_id_db == 1 OR $role_id_db == 2) {
					// récupérer les informations de store USER
					$StoreSession = $this->User->StoreSession->find('first',
					['conditions' => 
					[
					'StoreSession.id' => $findUser['User']['store_id']
					] 
					]);
				}

				// Autres ROLES ID 
				else {
					$StoreSession = $this->User->StoreSession->find('first',
						['conditions' => 
						[
						'StoreSession.id' => $storesList[0]['Store']['id'],
						'StoreSession.adresses_ip' => $adresse_ip_public_user
						] 
						]);
				}

				$depotList = $this->User->StoreSession->Depot->find('list',
				[ 'fields' => ['Depot.id','Depot.id'],
				'conditions' => ['Depot.store_id' => $storesList[0]['Store']['id']] ]);




				// Go to the application
				return $this->redirect( $this->Auth->redirect('/') );

			}	// Fin type = 3 SERVEUR 

			// Stocker les informations STORE & DEPOT => SESSION
			if (!empty($store_id_config)) {
				$this->Session->write('Auth.User.StoreSession', $StoreSession['StoreSession']);
			}
		
			$this->Session->write('depots', $depotList);
			
			if ( $this->Auth->redirect() == '/modules/getSidebarMenu' ) 
			{	
				return $this->redirect( '/' );
			}

					// TEST - à voir avec youssef ********* Vérfieir que l'user store = store _CONFIG
					// Installation unique
					if ($type_app == 1 OR $type_app == 2 OR  $type_app == 3) {
							$store_user_item_ID = [];
							foreach ($storesList as $store_user_item) {
								array_push($store_user_item_ID, $store_user_item['Store']['id']);
							}
					}




		} else {
			$this->Session->setFlash('Mot de passe invalide','red');
			return $this->redirect($this->referer());
		}

	} 
		
		$usernames = $this->User->findUsernames();//[],true
		$this->set(compact('usernames'));
		$this->layout = 'login';

} // fin login function



	public function changepassword(){
		if ($this->request->is(array('post', 'put'))) {
			$user = $this->User->find('first',[
				'conditions' => [
					'User.id' => $this->data['User']['id'], 
					'User.password' => AuthComponent::password($this->data['User']['Oldpassword'])
				] 
			]);

			if( !empty($user) ){
				if( $this->data['User']['Newpassword'] == $this->data['User']['Newpassword2'] && !empty($this->data['User']['Newpassword']) ){
					$data = [
						'User' => [
							'id' => $this->data['User']['id'], 
							'password' => AuthComponent::password($this->data['User']['Newpassword'])
						] 
					];
					if( $this->User->save($data) ){
						$this->Session->setFlash('Le mot de passe a été changé avec succès.','alert-success');
					}else{
						$this->Session->setFlash('Il y a un problème','alert-danger');
					}
				}else{
					$this->Session->setFlash('La confirmation du mot de passe ne correspond pas !','alert-danger');
				}
			}else{
				$this->Session->setFlash('Ancien mot de passe est incorrect','alert-danger');
			}
		}

		return $this->redirect( $this->referer() );
	}

	public function saveImage($id = null){
		if ($this->request->is(array('post', 'put'))) {

			$filename = $this->convertBaseName( $this->request->data['User']['avatar']['name'] , $id );

			$path = WWW_ROOT.'uploads'.DS.'avatar'.DS.'user'.DS.$filename;
			$b = move_uploaded_file($this->data['User']['avatar']['tmp_name'],$path);
			if( $b ){
				$this->User->id = $id;
				if ($this->User->saveField('avatar',$filename) )
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				else
					$this->Session->setFlash('Il y a un problème','alert-danger');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}
		return $this->redirect( $this->referer() );
	}

	public function profil() {
		$id = $this->Auth->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->User->exists($id)) {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

	private function convertBaseName($basename,$id = null){
		$file_info = pathinfo($basename);
		$basenameSlug = $id.'-'.time().'.'.$file_info['extension'];
		return $basenameSlug;
	}

	public function logout(){
		$this->loadModel('Lastsession');
		$userId = $this->Session->read('Auth.User.id');
		if($this->Auth->logout()){
			if ( !empty( $userId ) ) {
				$this->Lastsession->id = $userId;
				$this->Lastsession->saveField('logout', -1);
			}
			$this->Session->delete('Auth');
			return $this->redirect(array('action' => 'login'));
		}
	}

	public function darkmode($darkmode = 'off') {
		$this->User->id = (int) $this->Session->read('Auth.User.id');
		if ( $this->User->saveField('darkmode',$darkmode) ) die('alert-success');
		else die('alert-danger');
	}

	public function changestore($store_id = null) {

		$user_id = $this->Session->read('Auth.User.id');
		$this->User->id = $user_id;
		if ($this->User->saveField('store_id',$store_id)) {
		   	$StoreSession = $this->User->StoreSession->find('first',['conditions' => ['StoreSession.id' => $store_id] ]);
			   
			$this->Session->write('Auth.User.StoreSession', $StoreSession['StoreSession']);

		   	$depotList = $this->User->StoreSession->Depot->find('list',[ 'fields' => ['Depot.id','Depot.id'],'conditions' => ['Depot.store_id' => $store_id] ]);
		   	$this->Session->write('depots', $depotList);

			$this->Session->setFlash("L'action a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );

	}

	public function produit(){
		$this->layout = false;
	}

	public function getinfos($search = null){
		$this->loadModel('Produit');
		$produit = [];
		if ( !empty( $search ) ) {
			$search = trim( $search );
			$produit = $this->Produit->find('first',[
				'contain'=>['Categorieproduit'],
				'conditions' => [
					'OR' => [
						'Produit.code_barre' => $search, 
						'Produit.reference' => $search, 
						'Produit.libelle LIKE ' => "%$search%" , 
					]
				] 
			]);
		}
		$this->set(compact('produit'));
		$this->layout = false;
	}

    // recupérer les users depuis le serveur 
	public function apiGetUsersToSync($store_id = null, $caisse_id = null)
	{
		// Définir le type de réponse
		$this->response->type('json');

        // Récupérer les données de la table "Salepoint"
        $users = $this->User->find('all',[
            'conditions' => [
				//'User.id' => [85], // juste un teste
                'User.deleted' => 0,
			],
			'contain' => ['Role'=>['Permission']],
        ]);

		// Afficher les données en format JSON
		echo json_encode($users);
        
		// Arrêter le rendu de la vue
		return $this->response;
	}

// Inérer les données récupérées des users à la caisse demanderesse
public function insertUsersApi($caisse_id = null, $server_link=null, $check_sync=null, $json_data=null, $data=null)
{
	// Récupérer les informations de l'application 
	$result = $this->requestAction(array('controller' => 'Configs', 'action' => 'Getinfo'));
	$server_link = $result['server_link'];
	$caisse_id      = $result['caisse_id'];
	$store_id       = $result['store_id'];

	// Vérifier la disponibilité de la connexion Internet
	if(checkdnsrr('google.com', 'A')){		

			$link_api = $server_link.'/users/apiGetUsersToSync';
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
						$user_api_ids = $item['User']['id'];
						 $date_update_api = $item['User']['date_u'];
		
							// Vérifier si le produit existe déjà dans la base de données
							$user_caisse_db = $this->User->find('all',[
								'conditions' => [
								'User.id' => $user_api_ids,
								'User.deleted' => 0,
								],
								'contain' => ['Role'=>['Permission']],
								]);
		
								// Affecter les variable s'il y a des données dans la BDD
								if (!empty($user_caisse_db)) {								
									// recupérer et affecter la data => variable
									$user_db         = $user_caisse_db['0'];
									$date_update_db     = $user_caisse_db['0']['User']['date_u'];
			
									// pour faire comparer les dates des updates
									$date_update_api    = strtotime($date_update_api);
									$date_update_db     = strtotime($date_update_db);
								}
		
								// Verifier s'il y a des prouits à mettre à jour
								if (!empty($user_caisse_db) AND $date_update_api > $date_update_db) {
									// Mettre à jour les données dans la table "users"
									$difference = array_diff_assoc($item['User'], $user_db['User']);    
										if (!empty($difference)) {
											$id_user = intval($user_db['User']['id']);
											$this->User->id = $id_user;
											$this->User->saveAll($item);
											$check_sync = "DONE";
										}
								}
								
								if (empty($user_caisse_db)){
								// Ajouter les users manquants
									$this->User->saveAll($item);
									$check_sync = "DONE";
									echo "We added some users here! <br / >";
								}

								// Ajouter les permission manquantes
								if (empty($user_caisse_db[0]['Role']['Permission'])) {
									$this->Permission->saveAll($item['Role']['Permission']);
									 $check_sync = "DONE";
									echo "we are permission added <br / >";
								}
		
				   }             
						if (isset($check_sync) AND $check_sync=="DONE") {
							// Charger le modèle + Enregistrer l'entité dans la base de données
							$this->loadModel('Synchronisation');
							$this->Synchronisation->save(array(
							'source' => $server_link,
							'user_created' => 0,
							'destination' => 'Store='.$store_id.' Caisse='.$caisse_id)
							);
							$this->Session->setFlash('La liste des users a été synchronisée avec succès.', 'alert-success');
						}
					$this->layout = false;
					
	} else {
		$this->Session->setFlash('La liste des users n\'a pas été synchronisée.', 'alert-danger');
	}



	}







} // fin controller