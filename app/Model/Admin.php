<?php 
class Admin extends AppModel
{
	public $displayField = 'role_id';
	public $belongsTo = array('Role');

	public function findList($conditions = []){
		$list = [];
		$admins = $this->find('all',['conditions' => $conditions]);
		foreach ($admins as $k => $v) { $list[ $v[$this->alias]['role_id'] ] = $v[$this->alias]['role_id']; }
		return $list;
	}
}
 ?>