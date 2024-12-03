<?php

class Permission extends AppModel{
	public $useTable = 'permission';
	public $belongsTo = array('Module','Role');

	private $modulesSte = [];

	public function saveAll2($data = []) {
		foreach ($data as $k => $v) {
			if(isset($v['module_id'])) {
			if( in_array($v['module_id'], $this->modulesSte) ) {

			} else {
				$this->deleteAll(array('module_id' => $v['module_id'],'role_id' => $v['role_id']/*,'site_id' => $v['site_id']*/));
				$this->create();
				$this->save( ['Permission' => $v] );
			}
		}
		}
	}

	public function afterSave($created,$options = array()) {
		$list = ['a' => 'a', 'm1' => 'm1', 'v' => 'v', 's' => 's', 'i' => 'i', 'e' => 'e', 'h' => 'h'];
		
		$formulaire = $this->data;
		$formulaire['Permission']['module_id'] = 0;
		unset( $formulaire['Permission']['id'] );
		unset( $formulaire['Permission']['created'] );
			
		foreach ($formulaire['Permission'] as $k => $v) {
			if($k != 'id' && $k != 'role_id' && $k != 'module_id' && $k != 'site_id' && $k != 'created' &&  $k != 'deleted'){
				$formUpdate['Permission'][$k] = 0;
			}else{
				if( $k != 'created' &&  $k != 'deleted' )
					$formSearch[$k] = $v;
			}
		}

		if( $this->data['Permission']['c'] == '1' ) {
			$parent = $this->Module->getParentNode( $this->data['Permission']['module_id'] );
			if( !empty($parent) ){
				$formSearch['module_id'] = $parent['Module']['id'];
				$p = $this->find('first', ['fields' => ['id','c'], 'conditions' => $formSearch ]);

				if( empty($p) || (isset($p['Permission']['c']) && $p['Permission']['c'] == '0') ) {
					if( isset($p['Permission']['c']) ){
						$pSave = ['Permission' => ['id' => $p['Permission']['id'], 'c' => 1] ];
					}else{
						$pSave = ['Permission' => $formSearch + ['c' => 1] ];
					}
					$this->save( $pSave );
				}
			}
		} else if ( $this->data['Permission']['c'] == '0' ) {

			$children = $this->Module->children( $this->data['Permission']['module_id'], false );

			foreach( $children as $module ){
				$formSearch['module_id'] = $module['Module']['id'];
				$p = $this->find('first', ['fields' => ['id','c'], 'conditions' => $formSearch ]);
				if( !empty($p) && isset($p['Permission']['c']) && $p['Permission']['c'] == '1' ){
					$pSave = ['Permission' => ['id' => $p['Permission']['id']]+$formUpdate['Permission'] ];
					$this->save($pSave);
				}
			}

		}
	}
	
}