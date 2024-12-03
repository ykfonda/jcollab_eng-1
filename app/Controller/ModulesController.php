<?php
class ModulesController extends AppController {

	
	protected $idModule = 2;

	public function getSidebarMenu($Search = null){
		$permissionModules = $this->Module->Permission->find('list',[
			'fields' => ['Module.id','Module.id'], 
			'joins' => [
				['table' => 'modules', 'alias' => 'Module', 'type' => 'INNER', 'conditions' => ['Module.id = Permission.module_id'] ],
			],
			'conditions' => [
				'Permission.role_id' => $this->Session->read('Auth.User.role_id'),
				'Permission.c' => '1'
			]
		]);
		if($Search === null){
			$data = $this->Module->find('threaded',array(
				'fields' => array('Module.id','Module.libelle','Module.parent_id','Module.niveau','Module.link','Module.icon'),
				'conditions' => ['Module.id' => $permissionModules],
				'order' => 'Module.lft')
			);
		}else{
			$data = $this->Module->find('all',array(
					'fields' => array('Module.id','Module.libelle','Module.parent_id','Module.niveau','Module.link','Module.icon'),
					'conditions' => ['Module.libelle LIKE' => '%'.$Search.'%','Module.link !=' => null, 'Module.id' => $permissionModules] ,
					'order' => 'Module.lft'
				)
			);
		}

		return $data;
	}

	public function getAjaxTuto($id = null){
		$this->loadModel('Tuto');
		$data = $this->Tuto->find('first', ['conditions' => ['Tuto.id' => $id]]);
		$this->set( compact('data') );
		$this->layout = false;
	}

	public function getAjaxSidebarSearch($Search = null){
		$menus = $this->getSidebarMenu( $Search );
		$this->set(compact('menus'));

		$this->layout = false;
	}

	public function index(){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}

		$treeModule = $this->Module->generateTreeList(null,null,null,'--- ');

		$this->Module->recursive = 0;
		$this->Paginator->settings = array('order' => 'Module.lft','limit' => 1000);
		$this->set(array('modules'=>$this->Paginator->paginate(),'treeModule' => $treeModule));

		$this->getPath($this->idModule);
	}

	public function moveup($id = null){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}
		if( $this->request->is('ajax') ){
			$this->Module->moveUp($id);
		}else{
			return $this->redirect(array('action' => 'index'));
		}
		die;
	}

	public function movedown($id = null){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}
		if( $this->request->is('ajax') ){
			$this->Module->moveDown($id);
		}else{
			return $this->redirect(array('action' => 'index'));
		}
		die;
	}

	public function verifyByParent($id = null){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}
		$this->Module->recover('parent');
		return $this->redirect($this->referer());
	}

	public function verifyByBoth($id = null){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}

		$modulesBefore[0] = null;
		$count = 0;
		do {
			$list = $this->getModules($modulesBefore[$count]);
			if( !empty($list) ) $modulesBefore[$count+1] = $list;
			$count++;
		} while ( !empty($list) );

		$this->Module->recover('parent');

		foreach ($modulesBefore as $k => $v) {
			if( !empty($k) ){
				$modulesList = $this->getModules($modulesBefore[$k-1]);

				for ($i=0; $i < count($modulesBefore[$k]); $i++) {
					for ($j=0; $j < count($modulesList); $j++) { 
						if($modulesBefore[$k][$i] != $modulesList[$i] ){
							$this->Module->moveUp($modulesBefore[$k][$i]);
							$modulesList = $this->getModules($modulesBefore[$k-1]);
						}
					}
				}
			}
		}

		return $this->redirect($this->referer());
	}

	private function getModules($parents = null){
		$modulesFind = $this->Module->find('list', [
			'fields' => ['Module.id', 'Module.id'],
			'conditions' => ['Module.parent_id' => $parents] , 
			'order' => 'lft'
		]);

		$modules = [];
		foreach ($modulesFind as $v) {
			$modules[] = $v;
		}
		return $modules;
	}

	public function verifyByTree($id = null){
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}

		$this->Module->recover('tree');
		return $this->redirect($this->referer());
	}

	public function add() {
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}

		if ($this->request->is('post')) {
			$this->Module->create();
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		}
		$parentModules = $this->Module->generateTreeList();
		$this->set(compact('parentModules'));

		$this->getPath($this->idModule);
	}

	public function edit($id = null) {
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}

		if (!$this->Module->exists($id)) {
			throw new NotFoundException(__('Invalid module'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Module->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		} else {
			$options = array('conditions' => array('Module.' . $this->Module->primaryKey => $id));
			$this->request->data = $this->Module->find('first', $options);
		}
		$parentModules = $this->Module->ParentModule->find('list');
		$this->set(compact('parentModules'));

		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		if ($this->Session->read('Auth.User.role_id') != 2){
			$this->Session->setFlash('Vous n\'avez pas les permissions !','alert-danger');
			return $this->redirect(array('controller'=>'pages','action' => 'index'));
		}
		
		$this->Module->id = $id;
		if (!$this->Module->exists()) {
			throw new NotFoundException(__('Invalid Module'));
		}
		
		if($this->request->is('ajax')){
			if ($this->Module->flagDelete()){
				$this->saveLogs('Module');
	    		header('Content-Type: application/json; charset=UTF-8');
	    		die(json_encode(array('error' => false,'message' => 'La suppression a été effectué avec succès')));
			}else{
				header('HTTP/1.1 500 Internal Server');
		    	header('Content-Type: application/json; charset=UTF-8');
		    	die(json_encode(array('message' => 'Il y a un probleme !')));
			}
		}

		if ($this->Module->flagDelete()) {
			$this->saveLogs('Module');
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un probleme','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
