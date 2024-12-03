<?php
class TransformationsController extends AppController {
	public $idModule = 122;
	
	public function index() {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		$users = $this->Transformation->User->findList();
		$depots = $this->Transformation->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Transformation.reference' )
					$conditions['Transformation.reference LIKE '] = "%$value%";
				else if( $param_name == 'Transformation.libelle' )
					$conditions['Transformation.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Transformation.date1' )
					$conditions['Transformation.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Transformation.date2' )
					$conditions['Transformation.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Transformation->recursive = -1;
		$settings = ['contain'=>['User','Depot'],'order'=>['Transformation.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Transformation->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Transformation.reference' )
					$conditions['Transformation.reference LIKE '] = "%$value%";
				else if( $param_name == 'Transformation.libelle' )
					$conditions['Transformation.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Transformation.date1' )
					$conditions['Transformation.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Transformation.date2' )
					$conditions['Transformation.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Transformation->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User','Depot'],'order'=>['Transformation.date'=>'DESC'],'conditions'=>$conditions];
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
			if( empty($this->request->data['Transformationdetail']) ){
				$this->Session->setFlash('Opération impossible : Aucun produit saisie !','alert-danger');
				return $this->redirect($this->referer());
			}
			if ($this->Transformation->saveAssociated($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(['action'=>'view',$this->Transformation->id]);
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect($this->referer());
			}
		}

		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Transformation->User->findList();
		$produits = $this->Transformation->Produit->findList($settings);
		$depots = $this->Transformation->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];
		$produits = $this->Transformation->Produit->findList($settings);
		$this->set(compact('produits','count'));
		$this->layout = false;
	}

	public function view($id = null) {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');
		$details = [];
		if ($this->Transformation->exists($id)) {
			$options = array('contain'=>['Produit','User','Depot'],'conditions' => array('Transformation.' . $this->Transformation->primaryKey => $id));
			$this->request->data = $this->Transformation->find('first', $options);
			$details = $this->Transformation->Transformationdetail->find('all',[
				'conditions' => ['Transformationdetail.transformation_id' => $id],
				'contain'=>['ProduitATransformer','ProduitTransforme'],
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
		$this->Transformation->id = $id;
		if (!$this->Transformation->exists()) throw new NotFoundException(__('Invalide Transformation'));

		if ($this->Transformation->flagDelete()) {
			$this->Transformation->Transformationdetail->updateAll(['Transformationdetail.deleted'=>1],['Transformationdetail.transformation_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function changestate($transformation_id = null,$statut = -1) {
		$transformation = $this->Transformation->find('first', [ 'conditions' => ['Transformation.id' => $transformation_id] ]);
		$depot_id = ( isset($transformation['Transformation']['depot_id']) AND !empty($transformation['Transformation']['depot_id']) ) ? $transformation['Transformation']['depot_id'] : 1 ;
		$details = $this->Transformation->Transformationdetail->find('all',['conditions' => ['Transformationdetail.transformation_id'=>$transformation_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : aucun détail à produire ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Transformation->id = $transformation_id;
		if ($this->Transformation->saveField('statut',$statut)) {
			foreach ($details as $transformation) { 
				$this->sortie($transformation['Transformationdetail']['produit_a_transformer_id'],$depot_id,$transformation['Transformationdetail']['quantite_a_transformer']); 
				$this->entree($transformation['Transformationdetail']['produit_transforme_id'],$depot_id,$transformation['Transformationdetail']['quantite_transforme']); 
			}
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function sortie($produit_id = null,$depot_id = null,$quantite_sortie = 0) {
		$this->loadModel('Depotproduit');
		$depot = $this->Depotproduit->find('first',[ 'conditions'=>[ 'depot_id' => $depot_id, 'produit_id' => $produit_id ] ]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_sortie,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);

		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) ) ? (int) $depot['Depotproduit']['quantite'] : 0 ;
		$id = ( isset( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		$quantite = $ancienne_quantite - $quantite_sortie;
		if( $quantite <= 0 ) $quantite = 0;
		
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

	public function editdetail($id = null,$transformation_id = null) {
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Transformation->Transformationdetail->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Transformation->Transformationdetail->exists($id)) {
			$options = array('conditions' => array('Transformationdetail.' . $this->Transformation->Transformationdetail->primaryKey => $id));
			$this->request->data = $this->Transformation->Transformationdetail->find('first', $options);
		}

		$produits = $this->Transformation->Transformationdetail->ProduitTransforme->findList();
		$this->set(compact('produits','role_id'));
		$this->layout = false;
	}

	public function deletedetail($id = null,$transformation_id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Transformation->Transformationdetail->id = $id;
		if (!$this->Transformation->Transformationdetail->exists()) throw new NotFoundException(__('Invalide produit'));

		if ($this->Transformation->Transformationdetail->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}
