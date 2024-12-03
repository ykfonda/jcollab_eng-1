<?php
class AdminsController extends AppController {
	public $idModule = 26;

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Admin.abr' )
					$conditions['Admin.abr LIKE '] = "%$value%";
				else if( $param_name == 'Admin.libelle' )
					$conditions['Admin.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Admin.date1' )
					$conditions['Admin.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Admin.date2' )
					$conditions['Admin.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Admin->recursive = -1;
		$this->Paginator->settings = ['contain'=>['Role'],'order'=>['Admin.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Admin->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Admin->exists($id)) {
			$options = array('conditions' => array('Admin.' . $this->Admin->primaryKey => $id));
			$this->request->data = $this->Admin->find('first', $options);
		}
		$roles = $this->Admin->Role->find('list');
		$this->set(compact('roles'));
		$this->layout = false;
	}

	public function delete($id = null) {
		$this->Admin->id = $id;
		if (!$this->Admin->exists()) {
			throw new NotFoundException(__('Invalide Admin'));
		}

		if ($this->Admin->delete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}