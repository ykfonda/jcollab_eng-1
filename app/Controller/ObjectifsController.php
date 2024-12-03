<?php
class ObjectifsController extends AppController {
	public $idModule = 76;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$users_db = $this->Objectif->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Objectif.abr' )
					$conditions['Objectif.abr LIKE '] = "%$value%";
				else if( $param_name == 'Objectif.libelle' )
					$conditions['Objectif.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Objectif.date1' )
					$conditions['Objectif.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Objectif.date2' )
					$conditions['Objectif.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Objectif->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User'],'order'=>['Objectif.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function view($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Objectif->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Objectif->exists($id)) {
			$options = array('conditions' => array('Objectif.' . $this->Objectif->primaryKey => $id));
			$this->request->data = $this->Objectif->find('first', $options);
		}

		$users_db = $this->Objectif->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Objectif->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Objectif->exists($id)) {
			$options = array('conditions' => array('Objectif.' . $this->Objectif->primaryKey => $id));
			$this->request->data = $this->Objectif->find('first', $options);
		}

		$users_db = $this->Objectif->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','user_id','role_id'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Objectif->id = $id;
		if (!$this->Objectif->exists()) {
			throw new NotFoundException(__('Invalide Objectif'));
		}

		if ($this->Objectif->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}