<?php
App::uses('AppModel', 'Model');
App::import('Model','Loging');
class Module extends AppModel {

	public $displayField = 'libelle';
	public $actsAs = array('Tree');

	public $belongsTo = array(
		'ParentModule' => array(
			'className' => 'Module',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'ChildModule' => array(
			'className' => 'Module',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Permission' => array(
			'className' => 'Permission',
			'foreignKey' => 'module_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function beforeSave($options = array()){}
	//public function beforeFind($queryData = array()){}
	public function afterSave($created, $options = array()){
		parent::afterSave($created, $options);
		/* Logs */
		$logs = [
			'module' => 'Module' ,
			'date_c' => date('Y-m-d H:i:s') ,
			'user_c' => AuthComponent::user('id') ,
			'transaction' => (empty($this->data[$this->alias][$this->primaryKey])) ? 'Ajout' : 'Modification' ,
		];
		$Loging = new Loging();
		$Loging->save( $logs );
		/* Logs */
	}

}
