<?php

class Entree extends AppModel{
	

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
	}

	public $belongsTo = array(
        'Depot' => array(
            'className' => 'Depot',
            'foreignKey' => 'depot_id'
        )
    );

	

}