<?php 
class Avoir extends AppModel
{
	public $displayField = 'reference';

	public $belongsTo = 
		'User','Client','Retour',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];

	public $hasMany = ['Avoirdetail'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; $this->data[$this->alias]['reference'] = 'AVR-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	
	    if (!empty($this->data[$this->alias]['date_envoi'])){
	        $this->data[$this->alias]['date_envoi'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_envoi'] );
	    }		
	    if (!empty($this->data[$this->alias]['date_validation'])){
	        $this->data[$this->alias]['date_validation'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_validation'] );
	    }	
	    if (!empty($this->data[$this->alias]['date_c'])){
	        $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date_c'] );
	    }	   
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	        if (isset($val[$this->alias]['date_envoi'])) {
	            $results[$key][$this->alias]['date_envoi'] = $this->dateFormatAfterFind( $val[$this->alias]['date_envoi'] );
	        }
	        if (isset($val[$this->alias]['date_validation'])) {
	            $results[$key][$this->alias]['date_validation'] = $this->dateFormatAfterFind( $val[$this->alias]['date_validation'] );
	        }
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}
}

 ?>