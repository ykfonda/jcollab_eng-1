<?php
App::uses('AppModel', 'Model');

class Chatmessage extends AppModel {

	/*var $virtualFields = array(
	    'from_count' => 'COUNT(from_id)'
	);*/

	public $displayField = 'message';

	public $belongsTo = array(
		'From' => array(
			'className' => 'User',
			'foreignKey' => 'from_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'To' => array(
			'className' => 'User',
			'foreignKey' => 'to_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
