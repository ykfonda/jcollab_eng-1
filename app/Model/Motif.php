<?php 
class Motif extends AppModel
{
	//public $displayField = 'reference';
	public $belongsTo = [
		'Motifsabandon'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    return true;
	}
}
 ?>