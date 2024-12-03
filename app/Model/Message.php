<?php
App::uses('AppModel', 'Model');

class Message extends AppModel {

	public $displayField = 'subject';

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

	public $hasMany = array(
		'Attachment',
		'MessagesUser'
	);

	public $hasAndBelongsToMany = array(
		'User'
	);

}
