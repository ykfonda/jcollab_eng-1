<?php
class RetoursController extends AppController {
	public $idModule = 65;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Retour->Client->find('list');
		$users_db = $this->Retour->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','clients','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		/*if ( $role_id != 1 ) $conditions['Retour.user_c'] = $user_id;*/
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Retour.reference' )
					$conditions['Retour.reference LIKE '] = "%$value%";
				else if( $param_name == 'Retour.date1' )
					$conditions['Retour.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Retour.date2' )
					$conditions['Retour.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Retour->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['Retour.date'=>'DESC','Retour.id'=>'DESC'],
			'contain'=>['User','Client'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches','user_id'));
		$this->layout = false;
	}

	public function edit($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Retour->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Retour->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Retour->exists($id)) {
			$options = array('conditions' => array('Retour.' . $this->Retour->primaryKey => $id));
			$this->request->data = $this->Retour->find('first', $options);
		}

		$clients = $this->Retour->Client->find('list');
		$users_db = $this->Retour->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','clients','user_id','role_id','flag'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Retour->id = $id;
		if (!$this->Retour->exists()) {
			throw new NotFoundException(__('Invalide return'));
		}

		if ($this->Retour->flagDelete()) {
			$this->Retour->Retourdetail->updateAll(['Retourdetail.deleted'=>1],['Retourdetail.retour_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$retour_id = null) {
		$this->Retour->Retourdetail->id = $id;
		if (!$this->Retour->Retourdetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		$retour = $this->Retour->find('first', ['contain'=>['User'],'conditions' => ['Retour.id' => $retour_id]]);
		$depot_id = ( isset( $retour['User']['id'] ) AND !empty( $retour['User']['depot_id'] ) ) ? $retour['User']['depot_id'] : 1;

		$detail = $this->Retour->Retourdetail->find('first', [ 'conditions' => ['Retourdetail.id' => $id ]]);
		$quantite = ( isset( $detail['Retourdetail']['qte'] ) AND !empty( $detail['Retourdetail']['qte'] ) ) ? $detail['Retourdetail']['qte'] : 0 ;
		$produit_id = ( isset( $detail['Retourdetail']['produit_id'] ) AND !empty( $detail['Retourdetail']['produit_id'] ) ) ? $detail['Retourdetail']['produit_id'] : 0 ;

		if ($this->Retour->Retourdetail->flagDelete()) {
			//$this->sortie($produit_id,$depot_id,$quantite);


			$details = $this->Retour->Retourdetail->find('all',['conditions' => ['retour_id' => $retour_id]]);
			$total_a_payer = 0; $total_qte = 0;
			foreach ($details as $key => $value) {
				$total_a_payer = $total_a_payer + $value['Retourdetail']['ttc'];
				$total_qte = $total_qte + $value['Retourdetail']['qte'];
			}

			$data['Retour'] = [
				'id' => $retour_id,
				'total_a_payer' => $total_a_payer,
				'reste_a_payer' => $total_a_payer,
				'total_apres_reduction' => $total_a_payer,
				'total_qte' => $total_qte,
			];

			$this->Retour->save($data);

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function view($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Retour->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Retour->exists($id)) {
			$options = array('contain'=>['Client','User','Avoir'],'conditions' => array('Retour.' . $this->Retour->primaryKey => $id));
			$this->request->data = $this->Retour->find('first', $options);

			$details = $this->Retour->Retourdetail->find('all',[
				'conditions' => ['Retourdetail.retour_id'=>$id],
				'contain' => ['Produit'],
			]);
		}

		$this->set(compact('details','role_id','user_id','flag'));
		$this->getPath($this->idModule);
	}

	public function changestate($retour_id = null,$etat = -1) {
		$role_id = $this->Session->read('Auth.User.role_id');
		$retour = $this->Retour->find('first', ['contain'=>['User'],'conditions' => ['Retour.id' => $retour_id]]);
		$depot_id = ( isset( $retour['User']['id'] ) AND !empty( $retour['User']['depot_id'] ) ) ? $retour['User']['depot_id'] : 1;
		$details = $this->Retour->Retourdetail->find('all',[ 'conditions' => ['retour_id'=>$retour_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit trouvé !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Retour->id = $retour_id;
		if ($this->Retour->saveField('etat',$etat)) {
			$message = "L'enregistrement a été effectué avec succès.";
			$retour = $this->Retour->find('first', ['contain'=>['Client'],'conditions' => ['Retour.id' => $retour_id]]);
			if ( isset( $retour['Retour']['id'] ) ) {
				if ( $retour['Retour']['etat'] == 1 ) {
					$users = $this->Retour->User->find('list',['fields'=>['id','id'],'conditions'=>['role_id'=>1]]);
					$GroupeNotif = [
						'Notification' => [ 'privee' => 1, 'type' => 2, 'module_id' => 66, 'module' => 'Retour' ],
						'UserList' => $users,
						'Params' => [
							'key' => 3, 
							'id' => $retour['Retour']['id'] ,
							'date' => $retour['Retour']['date'] ,
							'client' => $retour['Client']['designation'],
							'reference' => $retour['Retour']['reference'],
						],
					];
					//$this->loadModel('Notification');
					/*if( $this->Notification->save($GroupeNotif) ){
						$message = $message . " <br/>Et la notification a été bien envoyé avec succès.";
					}*/
					$avoir['Avoir'] = [
						'id' => null,
						'date' => date('Y-m-d'),
						'retour_id' => $retour_id,
						'user_id' => $retour['Retour']['user_id'],
						'client_id' => $retour['Retour']['client_id'],
						'total_qte' => $retour['Retour']['total_qte'],
						'total_paye' => $retour['Retour']['total_paye'],
						'total_a_payer' => $retour['Retour']['total_a_payer'],
						'reste_a_payer' => $retour['Retour']['reste_a_payer'],
						'total_apres_reduction' => $retour['Retour']['total_apres_reduction'],
					];
					$avoir['Avoirdetail'] = [];
					foreach ($details as $k => $v) {
						$avoir['Avoirdetail'][] = [
							'id' => null,
							'produit_id' => $v['Retourdetail']['produit_id'],
							'categorieproduit_id' => $v['Retourdetail']['categorieproduit_id'],
							'declaration' => $v['Retourdetail']['declaration'],
							'description' => $v['Retourdetail']['description'],
							'prixachat' => $v['Retourdetail']['prixachat'],
							'total' => $v['Retourdetail']['total'],
							'ttc' => $v['Retourdetail']['ttc'],
							'qte' => $v['Retourdetail']['qte'],
						];
					}

					if ( $this->Retour->Avoir->saveAssociated( $avoir ) ) {
						$this->Retour->id = $retour_id;
						$this->Retour->saveField('avoir_id',$this->Retour->Avoir->id);
					}

				}else if( $retour['Retour']['etat'] == 2 ){
					$this->Retour->id = $retour_id;
					$this->Retour->saveField('date_validation',date('Y-m-d'));

					$retour_id = $retour['Retour']['id'];
					$details = $this->Retour->Retourdetail->find('all',[ 'conditions' => ['retour_id'=>$retour_id] ]);

					foreach ($details as $key => $value) {
						$this->entree($value['Retourdetail']['produit_id'],$depot_id,$value['Retourdetail']['qte']);
						/*if ( $value['Retourdetail']['declaration'] == 2 ) {
							$this->sortie($value['Retourdetail']['produit_id'],$depot_id,$value['Retourdetail']['qte']);
						} else {
							$this->transfert($value['Retourdetail']['produit_id'],$depot_id,1,$value['Retourdetail']['qte']);
						}*/
					}

					//$message = "Le stock a été mouvementé avec succès.";
				}else if( $retour['Retour']['etat'] == 3 ){
					$this->Retour->id = $retour_id;
					$this->Retour->saveField('date_validation',date('Y-m-d'));
				}
			}
			$this->Session->setFlash($message,'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function entree($produit_id = null,$depot_id = null,$quantite = 0) {
		$this->loadModel('Depotproduit');
		$depotproduit = $this->Depotproduit->find('first',[
			'conditions' => [
				'depot_id'=>$depot_id,
				'produit_id' => $produit_id,
			],
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);

		$id = (isset( $depotproduit['Depotproduit']['id'] )) ? $depotproduit['Depotproduit']['id'] : null ;
		$quantite_old = (isset( $depotproduit['Depotproduit']['id'] )) ? (int) $depotproduit['Depotproduit']['quantite'] : 0 ;
		$quantite_new = $quantite_old + $quantite ;

		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id'=>$depot_id,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'quantite' => $quantite_new,
		];

		if ( $this->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function sortie($produit_id = null,$depot_id = 1,$quantite = 0) {
		$this->loadModel('Depotproduit');
		$source = $this->Depotproduit->find('first',[
			'conditions' => [
				'produit_id'=>$produit_id,
				'depot_id'=>$depot_id,
			]
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);

		$id = (isset( $source['Depotproduit']['id'] )) ? $source['Depotproduit']['id'] : null ;
		$quantite_old = ( isset( $source['Depotproduit']['quantite'] ) ) ? (int) $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $quantite_old - $quantite;
		if ( $quantite <= 0 ) $quantite = 0;

		$save = [
			'id' => $id,
			'depot_id'=>$depot_id,
			'quantite' => $quantite,
			'date' => date('Y-m-d'),
			'produit_id'=>$produit_id,
		];

		if ( $this->Depotproduit->save($save) ) return true;
		else return false;
	}

	public function transfert($produit_id = null,$depot_source_id = 1,$depot_destination_id = 1,$quantite_saisie = 0) {
		$this->loadModel('Depotproduit');
		// Sortie du stock source
		$source = $this->Depotproduit->find('first',[
			'conditions' => [
				'produit_id'=>$produit_id,
				'depot_id'=>$depot_source_id,
			]
		]);

		$quantite_source = ( isset( $source['Depotproduit']['quantite'] ) ) ? (int) $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $quantite_source - $quantite_saisie;
		if ( $quantite <= 0 ) $quantite = 0;
		
		$source_id = (isset( $source['Depotproduit']['id'] )) ? $source['Depotproduit']['id'] : null ;

		$insert = [
			'id' => $source_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
			'depot_id'=>$depot_source_id,
		];

		// Entrée au stock destination
		$req = $this->Depotproduit->find('first',[
			'conditions'=>[
				'depot_id' => $depot_destination_id,
				'produit_id' => $produit_id,
			] 
		]);

		$quantite_destination = ( isset( $req['Depotproduit']['id'] ) ) ? (int) $req['Depotproduit']['quantite'] : 0 ;
		$quantite = $quantite_destination + $quantite_saisie;
		if ( $quantite <= 0 ) $quantite = 0;

		$destination_id = ( isset( $req['Depotproduit']['id'] ) ) ? $req['Depotproduit']['id'] : null ;
		
		$save = [
			'id' => $destination_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
			'depot_id' => $depot_destination_id,
		];

		if ( $this->Depotproduit->save($insert) );

		if ( $this->Depotproduit->save($save) );

		return true;
	}

	public function loadproduits($retour_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Retour->Retourdetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'retourdetails', 'alias' => 'Retourdetail', 'type' => 'INNER', 'conditions' => ['Retourdetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Retourdetail.retour_id'=>$retour_id,
				'Retourdetail.deleted'=>0,
			]
		]);

		$produits = $this->Retour->Retourdetail->Produit->find('list',[
			'conditions'=>[
				'Produit.categorieproduit_id'=>$categorieproduit_id,
				'Produit.id !='=>$produits_exists,
				'Produit.active'=>1,
			],
			'order' => ['libelle' => 'ASC'],
		]);

		die( json_encode( $produits ) );
	}

	public function getProduit($produit_id = null,$categorieclient_id = null) {
		$produit = $this->Retour->Retourdetail->Produit->find('first',[
			'fields' => ['Produit.*','Produitprice.*'],
			'joins' => [
				['table' => 'produitprices', 'alias' => 'Produitprice', 'type' => 'INNER', 'conditions' => ['Produitprice.produit_id = Produit.id'] ],
			],
			'conditions'=>[
				'Produit.id'=>$produit_id,
				'Produitprice.categorieclient_id'=>$categorieclient_id,
			],
		]);

		$prix_vente = ( isset( $produit['Produitprice']['id'] ) AND !empty( $produit['Produitprice']['prix_vente'] ) ) ? (float) $produit['Produitprice']['prix_vente'] : 0 ;
		$tva = ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['tva'] ) ) ? (float) $produit['Produit']['tva'] : 20 ;

		die( json_encode( [ 'tva' => $tva,'prix_vente' => $prix_vente ] ) );
	}

	public function editdetail($id = null,$retour_id = null) {
		$retour = $this->Retour->find('first', ['contain'=>['User'],'conditions' => ['Retour.id' => $retour_id]]);
		$depot_id = ( isset( $retour['User']['id'] ) AND !empty( $retour['User']['depot_id'] ) ) ? $retour['User']['depot_id'] : 1 ;
		$role_id = $this->Session->read('Auth.User.role_id');

		$produits_exists = $this->Retour->Retourdetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'retourdetails', 'alias' => 'Retourdetail', 'type' => 'INNER', 'conditions' => ['Retourdetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Retourdetail.retour_id'=>$retour_id,
				'Retourdetail.deleted'=>0,
			]
		]);

		$produits = $this->Retour->Retourdetail->Produit->find('list',[
			'conditions'=>['Produit.active'=>1,'Produit.id !='=>$produits_exists],
			'order' => ['libelle' => 'ASC'],
		]);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Retourdetail']['retour_id'] = $retour_id;
			$produit_id = ( isset( $this->request->data['Retourdetail']['produit_id'] ) AND !empty( $this->request->data['Retourdetail']['produit_id'] ) ) ? $this->request->data['Retourdetail']['produit_id'] : 0 ;
			$quantite = ( isset( $this->request->data['Retourdetail']['qte'] ) AND !empty( $this->request->data['Retourdetail']['qte'] ) ) ? $this->request->data['Retourdetail']['qte'] : 0 ;

			if ($this->Retour->Retourdetail->save($this->request->data)) {
				
				/*if ( empty( $this->request->data['Retourdetail']['id'] ) ) {
					$this->entree($produit_id,$depot_id,$quantite);
				} else {
					$detail = $this->Retour->Retourdetail->find('first', [ 'conditions' => ['Retourdetail.id' => $this->request->data['Retourdetail']['id'] ]]);
					$quantite_old = ( isset( $detail['Retourdetail']['qte'] ) AND !empty( $detail['Retourdetail']['qte'] ) ) ? $detail['Retourdetail']['qte'] : 0 ;
					$this->sortie($produit_id,$depot_id,$quantite_old);
					$this->entree($produit_id,$depot_id,$quantite);
				}*/

				$details = $this->Retour->Retourdetail->find('all',['conditions' => ['retour_id' => $retour_id]]);
				$total_a_payer = 0;
				$total_qte = 0;
				foreach ($details as $key => $value) {
					$total_a_payer = $total_a_payer + $value['Retourdetail']['ttc'];
					$total_qte = $total_qte + $value['Retourdetail']['qte'];
				}

				$data['Retour'] = [
					'id' => $retour_id,
					'total_a_payer' => $total_a_payer,
					'reste_a_payer' => $total_a_payer,
					'total_apres_reduction' => $total_a_payer,
					'total_qte' => $total_qte,
				];

				$this->Retour->save($data);

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Retour->Retourdetail->exists($id)) {
			$options = array('conditions' => array('Retourdetail.' . $this->Retour->Retourdetail->primaryKey => $id));
			$this->request->data = $this->Retour->Retourdetail->find('first', $options);
			$produits = $this->Retour->Retourdetail->Produit->find('list',[
				'conditions'=>['Produit.active'=>1],
				'order' => ['libelle' => 'ASC'],
			]);
		}
		$categorieproduits = $this->Retour->Retourdetail->Produit->Categorieproduit->find('list');
		$this->set(compact('produits','role_id','depot_id','categorieproduits'));
		$this->layout = false;
	}
}