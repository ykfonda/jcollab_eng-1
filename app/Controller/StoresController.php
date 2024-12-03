<?php
class StoresController extends AppController {
	public  $idModule = 116;
	public $uses = ["Store"];

	public function index() {
		$societes = $this->Store->Societe->find('list');
		$this->set(compact('societes'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
	    $this->loadModel("Store");
		$store = $this->Store->find('first',["contain"=> ["Societe"],'conditions' => ['Store.id' => $selected_store] ]);
		
		$conditions = ['Store.societe_id' => $store["Societe"]["id"]] ;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Store.reference' )
					$conditions['Store.reference LIKE '] = "%$value%";
				else if( $param_name == 'Store.libelle' )
					$conditions['Store.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Store.adresse' )
					$conditions['Store.adresse LIKE '] = "%$value%";
				else if( $param_name == 'Store.date1' )
					$conditions['Store.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Store.date2' )
					$conditions['Store.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Store->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Societe'],
			'conditions'=>$conditions,
			'order'=>['Store.libelle'=>'ASC'],
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Store->save($this->request->data)) {

				if($id == null) {
					$id = $this->Store->getLastInsertId();
					$user_id = $this->Session->read('Auth.User.id');
					$this->loadModel("Stores_user");
					
					$this->Stores_user->query("INSERT INTO `stores_users` (`id`, `store_id`, `user_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES ('', $id, $user_id, '0', NULL, NULL, NULL, NULL);");
					
					$compteurs = [];
					$noms = ["Bon commande","Bon livraison","Bon retour","Facture","Devis"];
					for($i = 0;$i < 5;$i++) {
						$compteurs[] = [
							"module" => $noms[$i],
							"store_id" => $id,
							"active" => 1
						];
					}
					$this->loadModel("Compteur");
					$this->Compteur->saveMany($compteurs);

				}
				
				
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Store->exists($id)) {
			$options = array('conditions' => array('Store.' . $this->Store->primaryKey => $id));
			$this->request->data = $this->Store->find('first', $options);
		}

		$frais_livraison = $this->Store->Fraislivraison->findList();
		$societes = $this->Store->Societe->find('list');
		$this->set(compact('societes','frais_livraison'));
		$this->layout = false;

	}

	public function view($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Store->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Store->exists($id)) {
			$options = array('conditions' => array('Store.' . $this->Store->primaryKey => $id));
			$this->request->data = $this->Store->find('first', $options);
		}

		$societes = $this->Store->Societe->find('list');
		$this->set(compact('societes'));
		$this->getPath($this->idModule);
		
	}

	public function delete($id = null) {
		$this->Store->id = $id;
		if (!$this->Store->exists()) {
			throw new NotFoundException(__('Invalide Store'));
		}

		if ($this->Store->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function saveImage($id = null){
		if( $this->request->is(['put','post']) ){
			$data = $this->data;
			$filename = $this->convertBaseName( $this->data['Store']['avatar']['name'] , $id );
			$path = '/img'.DS.'logo'.DS.$filename;
			$b = move_uploaded_file($this->data['Store']['avatar']['tmp_name'],WWW_ROOT.$path);
			
			if( $b ){
				$this->Store->id = $id;
				$this->Store->saveField('avatar', $path);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		}
	}

	private function convertBaseName($basename,$id = null){
		$time = date('i');
		$file_info = pathinfo($basename);
		$basenameSlug = $id.'-'.$time.'.'.$file_info['extension'];
		return $basenameSlug;
	}
}
