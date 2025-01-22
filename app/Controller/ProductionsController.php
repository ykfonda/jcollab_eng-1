<?php
class ProductionsController extends AppController {
	public $idModule = 131;
	
	public function index() {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Production.reference' )
					$conditions['Production.reference LIKE '] = "%$value%";
				else if( $param_name == 'Production.libelle' )
					$conditions['Production.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Production.date1' )
					$conditions['Production.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Production.date2' )
					$conditions['Production.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Production->recursive = -1;
		$settings = ['contain'=>['User','Depot','Produit'],'order'=>['Production.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Production->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Production.reference' )
					$conditions['Production.reference LIKE '] = "%$value%";
				else if( $param_name == 'Production.libelle' )
					$conditions['Production.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Production.date1' )
					$conditions['Production.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Production.date2' )
					$conditions['Production.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Production->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User','Depot','Produit'],'order'=>['Production.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function editall() {

		

		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		if ($this->request->is(array('post', 'put'))) {
			$data = [];
			if (isset($this->data['Productiondetail']) AND !empty($this->data['Productiondetail'])) {
				foreach ($this->data['Productiondetail'] as $k => $v) {
					$i = $k+1;
					$data[$k]['Production'] = [
						'libelle' => $this->data['Production']['libelle'].' '.$i,
						'depot_id' => $this->data['Production']['depot_id'],
						'user_id' => $this->data['Production']['user_id'],
						'date' => $this->data['Production']['date'],
						'produit_id' => $v['produit_id'],
						'quantite' => $v['quantite'],
					];
					$data[$k]['Productiondetail'] = [];

					if ( isset($data[$k]['Production']['produit_id']) AND !empty($data[$k]['Production']['produit_id']) ) {
						$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('all',[
							'conditions' => [ 'produit_id' => $data[$k]['Production']['produit_id'] ],
							'fields' => [ 'ingredient_id' ],
						]);
						foreach ($ingredients as $value) {
							$data[$k]['Productiondetail'][] = [
								'produit_id' => $value['Produitingredient']['ingredient_id'],
								'quantite_theo' => $v['quantite'],
							];
						}
					}
				}
			}

			if (empty($data)) {
				$this->Session->setFlash('Opération impossible : Aucun produit saisie !','alert-danger');
				return $this->redirect($this->referer());
			}

			foreach ($data as $production) { $this->Production->saveAssociated($production); }
			$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			return $this->redirect($this->referer());
		}

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];
		$produits = $this->Production->Produit->findList($settings);
		$this->set(compact('produits','count'));
		$this->layout = false;
	}
	public function updateProduction() {

		

		$quantite_prod = $this->request->data['Production']['quantite_prod'];
		$this->Production->id = $this->request->data['Production']['id'];
		$this->Production->saveField("quantite_prod",$quantite_prod);

		$details = $this->Production->Productiondetail->find('all',[
			'conditions' => ['Productiondetail.production_id' => $this->request->data['Production']['id']],
			'contain'=>['Produit' => ['Unite'] ,'Production'],
		]);

		$total_prod = 0;	
		foreach ($details as $v) {
			$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('first',[
				'conditions' => [ 'produit_id' => $v['Production']['produit_id'],'ingredient_id' => $v['Productiondetail']['produit_id'] ],
				'contain' => ["Produit"],	
			]);
				//$quantite_reel =  $this->request->data['Production']['quantite_prod'] * $ingredients['Produitingredient']['quantite'];
				$this->Production->Productiondetail->id = $v['Productiondetail']['id'];
				// $this->Production->Productiondetail->saveField("quantite_reel",$quantite_reel);


				$total_prod += ($v['Productiondetail']['quantite_reel'] * $v['Produit']['prixachat']);
			}
		
		$total_prod /= $this->request->data['Production']['quantite_prod'];
		
		$this->Production->id = $this->request->data['Production']['id'];
		$this->Production->saveField("prix_prod",$total_prod);

		$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
		return $this->redirect(['action'=>'view',$this->Production->id]);

	}


	// public function Ajouter une nouvel OF {
	public function edit($id = null) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		if ($this->request->is(array('post', 'put'))) {
			if( empty($this->request->data['Production']['id']) ){			
				$this->request->data['Productiondetail'] = [];
				 
				if ( isset($this->request->data['Production']['produit_id']) AND !empty($this->request->data['Production']['produit_id']) ) {
					$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('all',[
						'conditions' => [ 'produit_id' => $this->request->data['Production']['produit_id'] ],
						'contain' => ["Produit"],
					]);
					$total_theo = 0;
					// Retrieve qteofeco from the Produit table
					$produit = $this->Production->Productiondetail->Produit->find('first', [
						'conditions' => ['Produit.id' => $this->request->data['Production']['produit_id']],
						'fields' => ['qteofeco']
					]);
					$qteofeco = $produit['Produit']['qteofeco'];
					$coefficient = $this->request->data['Production']['quantite'] / $qteofeco;

					// recuperation des ingredients
					foreach ($ingredients as $v) {
						$this->request->data['Productiondetail'][] = [
							'quantite_theo' => $coefficient * $v['Produitingredient']['quantite']*(1+$v['Produitingredient']['pourcentage_perte']/100),
							'produit_id' => $v['Produitingredient']['ingredient_id'],
						];

						$total_theo += ($coefficient * $v['Produitingredient']['quantite'] * $v['Produit']['prixachat']*(1+$v['Produitingredient']['pourcentage_perte']/100));
					}

					$total_theo /= $this->request->data['Production']['quantite'];
					$this->request->data['Production']['prix_theo'] = $total_theo;
					$this->request->data['Production']['user_id'] = $this->Session->read('Auth.User.id');
				}
				if( empty($this->request->data['Productiondetail']) ){
					$this->Session->setFlash('Opération impossible : Aucun produit trouvé','alert-danger');
					return $this->redirect($this->referer());
				}
			}
			if ($this->Production->saveAssociated($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(['action'=>'view',$this->Production->id]);
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect($this->referer());
			}
		} else if ($this->Production->exists($id)) {
			$options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
			$this->request->data = $this->Production->find('first', $options);
		}

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->layout = false;
	}

	public function view($id = null) {
		

		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');
		$details = [];
		if ($this->Production->exists($id)) {
			$options = array('contain'=>['Produit','User','Depot'],'conditions' => array('Production.' . $this->Production->primaryKey => $id));
			$this->request->data = $this->Production->find('first', $options);
			$details = $this->Production->Productiondetail->find('all',[
				'conditions' => ['Productiondetail.production_id' => $id],
				'contain'=>['Produit' => ['Unite'] ],
			]);
		}
		$this->set(compact('details'));
		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->id = $id;
		if (!$this->Production->exists()) throw new NotFoundException(__('Invalide Production'));

		if ($this->Production->flagDelete()) {
			$this->Production->Productiondetail->updateAll(['Productiondetail.deleted'=>1],['Productiondetail.production_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function changestate($production_id = null,$statut = -1) {
		$production = $this->Production->find('first', [ 'conditions' => ['Production.id' => $production_id] ]);
		$depot_id = ( isset($production['Production']['depot_id']) AND !empty($production['Production']['depot_id']) ) ? $production['Production']['depot_id'] : 1 ;
		$details = $this->Production->Productiondetail->find('all',['conditions' => ['Productiondetail.production_id'=>$production_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : aucun détail à produire ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->id = $production_id;
		if ($this->Production->saveField('statut',$statut)) {
			foreach ($details as $production) { $this->entree($production['Productiondetail']['produit_id'],$depot_id,$production['Productiondetail']['quantite_reel']); }
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function entree($produit_id = null,$depot_id = null,$quantite_entree = 0) {
		$this->loadModel('Depotproduit');
		$depot = $this->Depotproduit->find('first',[ 'conditions'=>[ 'depot_id' => $depot_id, 'produit_id' => $produit_id ] ]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);
		
		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) ) ? (int) $depot['Depotproduit']['quantite'] : 0 ;
		$id = ( isset( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		$quantite = $ancienne_quantite + $quantite_entree;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
		];

		if ( $this->Depotproduit->save($data) ) { unset( $data ); return true;
		} else { unset( $data ); return false; }
	}

	public function editdetail($id = null,$production_id = null) {

		

		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Production->Productiondetail->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Production->Productiondetail->exists($id)) {
			$options = array('conditions' => array('Productiondetail.' . $this->Production->Productiondetail->primaryKey => $id));
			$this->request->data = $this->Production->Productiondetail->find('first', $options);
		}

		$produits = $this->Production->Productiondetail->Produit->findList();
		$this->set(compact('produits','role_id'));
		$this->layout = false;
	}

	public function deletedetail($id = null,$production_id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->Productiondetail->id = $id;
		if (!$this->Production->Productiondetail->exists()) throw new NotFoundException(__('Invalide produit'));

		if ($this->Production->Productiondetail->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}