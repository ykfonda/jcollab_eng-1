<?php
App::uses('AppModel', 'Model');
App::import('Model','Loging');
class Role extends AppModel {

	public $useTable = 'role';

	public $displayField = 'libelle';

	public $hasMany = array(
		'Permission' => array(
			'className' => 'Permission',
			'foreignKey' => 'role_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'role_id',
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

	public function afterSave($created, $options = array()){
		parent::afterSave($created, $options);
		/* Logs */
		$logs = [
			'module' => 'Liste des roles' ,
			'date_c' => date('Y-m-d H:i:s') ,
			'user_c' => AuthComponent::user('id') ,
			'transaction' => (empty($this->data[$this->alias][$this->primaryKey])) ? 'Ajout' : 'Modification' ,
		];
		$Loging = new Loging();
		$Loging->save( $logs );
		/* Logs */
	}
}
