<?php 
class Compteur extends AppModel
{

	public $belongsTo = ['Store'];
	
	
    /*
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'CS-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	} */
}
 ?>