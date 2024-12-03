<?php
App::uses('AppController', 'Controller');
class RolesController extends AppController {
	public $idModule = 3;
	
	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$user_id = $this->Auth->Session->read('Auth.User.id');
		$conditions['Role.id !='] = 1;
		if ( $user_id == 1 ) $conditions= [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){

				if( $param_name == 'Role.libelle' )
					$conditions['Role.libelle LIKE'] = '%'.$value.'%';
				else if( $param_name == 'Role.date1' )
					$conditions['Role.created >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Role.date2' )
					$conditions['Role.created <='] = date('Y-m-d',strtotime($value));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		
		$this->Role->recursive = -1;
		$this->Paginator->settings = array(
			'limit' => 15,
			'conditions' => $conditions,
			'order' => 'Role.id ASC',
		);
		$roles = $this->Paginator->paginate();

		$this->set(compact('roles'));
		$this->layout = false;
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Role->create();
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		}
		$this->layout = false;
	}

	public function duplique($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$role = [];
			$dataToSave = [];
			if (isset($this->data['Role']['id'])) {
				$options = array('contain' => ['Permission'],'conditions' => array('Role.id'=>$this->data['Role']['id']));
				$role = $this->Role->find('first', $options);
				$role['Role']['libelle'] = $this->data['Role']['libelle'];
				unset($role['Role']['id']);
				unset($role['Role']['created']);
				$permissions = [];
				foreach ($role['Permission'] as $key => $value) {
					unset($value['role_id']);
					unset($value['created']);
					unset($value['id']);
					$permissions[] = $value;
				}

				$dataToSave['Role'] = $role['Role'];
				$dataToSave['Permission'] = $permissions;
			}
			if (!empty($dataToSave)) {
				if ($this->Role->saveAssociated($dataToSave)) {
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
			}else{
				$this->Session->setFlash('Aucune nouvelle informations a dupliqué','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
		}
		$this->layout = false;
	}

	public function edit($id = null) {
		if (!$this->Role->exists($id)) {
			throw new NotFoundException(__('Invalid role'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Role->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else {
			$options = array('conditions' => array('Role.' . $this->Role->primaryKey => $id));
			$this->request->data = $this->Role->find('first', $options);
		}
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Role->id = $id;
		if (!$this->Role->exists()) {
			throw new NotFoundException(__('Invalid Role'));
		}
		
		if($this->request->is('ajax')){
			if ($this->Role->flagDelete()){
				$this->saveLogs('Role');
	    		header('Content-Type: application/json; charset=UTF-8');
	    		die(json_encode(array('error' => false,'message' => 'La suppression a été effectué avec succès')));
			}else{
				header('HTTP/1.1 500 Internal Server');
		    	header('Content-Type: application/json; charset=UTF-8');
		    	die(json_encode(array('message' => 'Il y a un problème !')));
			}
		}

		//$this->request->allowMethod('post', 'delete');
		if ($this->Role->flagDelete()) {
			$this->saveLogs('Role');
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
