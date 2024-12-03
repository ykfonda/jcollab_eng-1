<?php

class PermissionsController extends AppController{
	protected $idModule = 3;

	protected $modulesPermissions = [
		0 => ['c', 'a', 'm1', 's', 'i', 'e' , 'v'],
	];

	public function index() {
		if($this->request->is('post')){
			if( isset( $this->data['Permission']['Module'] ) )
				$this->Redirect(['action' => 'setpermissions',$this->data['Permission']['Role'], 1,$this->data['Permission']['Module']]);
			else
				$this->Redirect(['action' => 'setpermissions',$this->data['Permission']['Role'], 1]);
		}else{
			if( empty($this->data['Permission']['Role']) ){
				$roles = $this->Permission->Role->find('list');
				reset($roles);
				$this->Redirect(['action' => 'setpermissions',key($roles), 1]);
			}
		}
		$roles = $this->Permission->Role->find('list');
		$this->set( compact('sites','roles') );

		$this->getPath($this->idModule);
	}

	public function setpermissions($role = null,$site = 1,$module = null) {

		if($this->request->is('post')){
	
			foreach ($this->data['Permission'] as $key => $val) {
				if(isset($val['module_id']))
				$modulesToDelete[$val['module_id']] = $val['module_id'];
			}
			if(!isset($modulesToDelete)) $this->Session->setFlash('Il y a un problème','alert-danger');
			$this->Permission->saveAll2($this->data['Permission']);
			$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
		}

		$roles = $this->Permission->Role->find('list',['conditions'=>['Role.id !='=>1]]);

		if(empty($role)){
			$data = $this->Permission->Role->find('all');
		}else if(empty($site)){
			$data = $this->Permission->Site->find('all');
		}else if(empty($module)){
			$data = $this->Permission->Module->find('threaded',array('fields' => array('Module.id','Module.libelle','Module.parent_id','Module.niveau'),'order' => 'Module.lft'));
		}else{
			$checkParents = $this->Permission->Module->getPath($module);
			$parents = [];
			$lastparent = 0;
			foreach ($checkParents as $k => $v) {
				if( $v['Module']['id'] != $module ){
					$parents[] = $v['Module']['id'];
					$lastparent = $v['Module']['id'];
				}
			}
			$deny = $this->Permission->find('list',['fields' => ['Permission.id','Permission.module_id'], 'conditions' => ['Permission.module_id' => $parents, 'Permission.site_id' => $site, 'Permission.role_id' => $role, 'Permission.c' => '0'] ]);

			if( !empty($deny) ){
				$this->Session->setFlash('Le niveau supérieur doit être rendu accessible !','alert-danger');
				$this->redirect(['action' => 'setpermissions', $role, $site, reset($deny)]);
			}

			$data = $this->Permission->Module->find('first',array('conditions' => array('Module.id' => $module)));
			$moduleChilds = $this->Permission->Module->children($data['Module']['id'],true);

			$allChilds = $this->Permission->Module->children($data['Module']['id']);
			$childParents = [];
			foreach ($allChilds as $key => $val) {
				$childParents[] = $val['Module']['parent_id'];
			}
			unset($allChilds);
			
			$getModules = array($data['Module']['id'] => $data['Module']['id']);
			foreach ($moduleChilds as $k => $v) {
				$getModules[$v['Module']['id']] = $v['Module']['id'];
				$childrenBool = in_array($v['Module']['id'], $childParents);
				$moduleChilds[$k]['Module']['children'] = $childrenBool;
			}
			$getPermissions = $this->Permission->find('all',array('conditions' => array('role_id' => $role,'site_id' => $site, 'module_id' => $getModules)));
		}
		$this->set(compact('data','role','site','module','moduleChilds','getPermissions'));

		$modules = $this->Permission->Module->generateTreeList(null, null, null, '-- ');
		$modulesPermissions = $this->modulesPermissions;
		$this->set( compact('sites','roles','modules','modulesPermissions','lastparent') );

		$this->getPath($this->idModule);
	}

}