<?php 
class Avance extends AppModel
{
	public $belongsTo = [
		'Facture' => array(
			'className' => 'Facture',
			'foreignKey' => 'facture_id',
		),
		'Boncommande' => array(
			'className' => 'Boncommande',
			'foreignKey' => 'boncommande_id',
		),
		'Bonlivraison' => array(
			'className' => 'Bonlivraison',
			'foreignKey' => 'bonlivraison_id',
		),
		'Bonreception' => array(
			'className' => 'Bonreception',
			'foreignKey' => 'bonreception_id',
		),
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
		),
		'Vendeur' => array(
			'className' => 'User',
			'foreignKey' => 'user_c',
		),
		'Salepoint'
	];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'AV-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	    
	    if (!empty($this->data[$this->alias]['date_echeance'])){
	        $this->data[$this->alias]['date_echeance'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_echeance'] );
	    }	    
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	        if (isset($val[$this->alias]['date_echeance'])) {
	            $results[$key][$this->alias]['date_echeance'] = $this->dateFormatAfterFind( $val[$this->alias]['date_echeance'] );
	        }
	    }
	    return $results;
	}
}
 ?>