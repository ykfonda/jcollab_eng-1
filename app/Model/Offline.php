<?php 

class Offline extends AppModel{

	
	public $belongsTo = array(
		'Store','Societe'
	);

	
	
	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    	    
	    return true;
	}

	

}

 ?>