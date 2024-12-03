<?php 
/**
 * 
 */
class Bonentreedetail extends AppModel
{
	public $belongsTo = [
		'Bonentree','Produit','Client',
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
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'BED-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	
	    if (!empty($this->data[$this->alias]['date_sortie'])){
	        $this->data[$this->alias]['date_sortie'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_sortie'] );
	    }	
	    if (!empty($this->data[$this->alias]['date_fabrication'])){
	        $this->data[$this->alias]['date_fabrication'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_fabrication'] );
	    }	  
	    if (!empty($this->data[$this->alias]['date_peremption'])){
	        $this->data[$this->alias]['date_peremption'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_peremption'] );
	    }	    
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	        if (isset($val[$this->alias]['date_sortie'])) {
	            $results[$key][$this->alias]['date_sortie'] = $this->dateFormatAfterFind( $val[$this->alias]['date_sortie'] );
	        }
	        if (isset($val[$this->alias]['date_fabrication'])) {
	            $results[$key][$this->alias]['date_fabrication'] = $this->dateFormatAfterFind( $val[$this->alias]['date_fabrication'] );
	        }
	        if (isset($val[$this->alias]['date_peremption'])) {
	            $results[$key][$this->alias]['date_peremption'] = $this->dateFormatAfterFind( $val[$this->alias]['date_peremption'] );
	        }
	    }
	    return $results;
	}
}
 ?>