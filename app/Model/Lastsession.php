<?php 
class Lastsession extends AppModel
{
	public $belongsTo = [
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'id',
		),
	];
	
	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	    
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date'] );
	        }
	    }
	    return $results;
	}	
}

 ?>