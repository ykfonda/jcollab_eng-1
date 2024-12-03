<?php 
/**
* 
*/
class NotificationsVue extends AppModel
{
	public $belongsTo = array(
		'Notification' => array(
			'className' => 'Notification',
			'foreignKey' => 'notification_id',
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
		),
	);
}
 ?>