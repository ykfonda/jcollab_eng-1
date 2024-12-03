<?php 
class Attentedetail extends AppModel
{
	public $belongsTo = ['Attente','Produit'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    if (!empty($this->data[$this->alias]['date_c'])){
	        $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date_c'] );
	    }	   
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}
}
 ?>