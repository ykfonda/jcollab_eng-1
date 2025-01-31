<?php 
class Mouvementprincipal extends AppModel
{
	
	public $hasMany = array(
		'Bonreception',
        'Bonreception' => array(
            'className' => 'Bonreception',
            'foreignKey' => 'id_mouvementprincipal'
		),
		'Sortiedetail' => array(
			'className' => 'Sortiedetail', // Nom du modèle associé
			'foreignKey' => 'mouvementprincipal_id', // Clé étrangère dans la table Sortiedetail
		),
    );

	public $belongsTo = [
		'Produit','Client','Fournisseur',
		'DepotSource' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_source_id',
		),
		'DepotDestination' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_destination_id',
		),
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
		'Motifsretour' => [
			'className' => 'Motifsretour',
			'foreignKey' => 'motifsretour_id'
		],
	]; 
	
	
	public function beforeSave($options = array()){
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'S-'.str_pad($number, 6, '0', STR_PAD_LEFT);
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