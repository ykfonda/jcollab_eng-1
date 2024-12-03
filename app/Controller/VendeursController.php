<?php
class VendeursController extends AppController {
	public $idModule = 56;
	public $uses = ['User'];

	public function index() {
		$depots = $this->User->Depot->find('list');
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles','depots'));
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$conditions = ['User.id !='=>1];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'User.key' ){
					$conditions['OR'] = [ 
						'User.code LIKE ' => "%$value%" , 
						'User.nom LIKE ' => "%$value%" , 
						'User.prenom LIKE ' => "%$value%" , 
						'User.email LIKE ' => "%$value%" 
					];
				}else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->User->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['User.date_c'=>'DESC'],
			'contain'=>['Role','Depot'],
			'conditions'=>$conditions,
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->validateUsername( $this->data );
			if ( isset( $this->data['User']['password'] ) AND empty( $this->data['User']['id'] ) ) 
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->User->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->User->exists($id)) {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$depots = $this->User->Depot->find('list');
		$this->set(compact('roles','depots'));
		$this->layout = false;
	}

	public function view($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->validateUsername( $this->data );
			if ( isset( $this->data['User']['password'] ) AND empty( $this->data['User']['id'] ) ) 
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->User->exists($id)) {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$pays = $this->User->Pay->find('list',['fields'=>['Pay.id','Pay.libelle']]);
		$villes = $this->User->Ville->find('list');
		$depots = $this->User->Depot->find('list');
		$roles = $this->User->Role->find('list');
		$this->set(compact('pays','villes','roles','depots'));
		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalide vendeur !'));
		}

		if ($this->User->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}