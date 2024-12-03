<?php
App::uses('AppModel', 'Model');
/**
 * Diver Model
 *
 * @property Module $Module
 */
class Diver extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'libelle';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
