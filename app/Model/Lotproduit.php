<?php 
class Lotproduit extends AppModel
{
	public $belongsTo = [
		'Produit',
		'DepotSource' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_source_id',
		),
		'DepotDestination' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_destination_id',
		),
	];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	    
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	    }
	    return $results;
	}
}
 ?>