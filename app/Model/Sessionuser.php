<?php 
class Sessionuser extends AppModel
{
	//public $displayField = 'reference';

	public $belongsTo = [
		'User','Store','Caisse','Site' => [
			'className' => 'Store',
            'foreignKey' => 'site_id'
		],
	];


	public function beforeSave($options = array()){
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'Session-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	    if (!empty($this->data[$this->alias]['date_debut'])){
	        $this->data[$this->alias]['date_debut'] = date('Y-m-d H:i:s', strtotime($this->data[$this->alias]['date_debut']));
	    }
	    if (!empty($this->data[$this->alias]['date_fin'])){
	        $this->data[$this->alias]['date_fin'] = date('Y-m-d H:i:s', strtotime($this->data[$this->alias]['date_fin']));
	    }	   
	    return true;
	}
}
 ?>