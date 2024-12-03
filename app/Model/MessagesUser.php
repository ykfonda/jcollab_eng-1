<?php
App::uses('AppModel', 'Model');
/**
 * MessagesUser Model
 *
 * @property Message $Message
 * @property User $User
 */
class MessagesUser extends AppModel {
 
 	public $useTable = 'messages_users';

	public $belongsTo = array(
		'Message' => array(
			'className' => 'Message',
			'foreignKey' => 'message_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
