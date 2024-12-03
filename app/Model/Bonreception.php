<?php 
class Bonreception extends AppModel
{
	public $displayField = 'reference';

	public $belongsTo = [
		'User','Fournisseur','Depot','Boncommande',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];

	public $hasMany = ['Bonreceptiondetail','Email','Depence'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'BR-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
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
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}

	public function afterSave($created, $options = array()){
		parent::afterSave($created, $options);
		if( isset($this->data['Bonreception']['id']) AND !empty($this->data['Bonreception']['id']) ){
			$reception = $this->find('first',[
				'conditions' => [
					'Bonreception.id' => $this->data['Bonreception']['id'] 
				] 
			]);
			
			$total_qte_reception = ( isset($reception['Bonreception']['total_qte']) AND !empty($reception['Bonreception']['total_qte']) ) ? $reception['Bonreception']['total_qte'] : 0 ;

			if( isset($reception[$this->alias]['boncommande_id']) AND !empty($reception[$this->alias]['boncommande_id']) ){
				$commande = $this->Boncommande->find('first',[ 'conditions' => [ 'Boncommande.id'=>$reception[$this->alias]['boncommande_id'] ] ]);
				$total_qte_commande = ( isset($commande['Boncommande']['total_qte']) AND !empty($commande['Boncommande']['total_qte']) ) ? $commande['Boncommande']['total_qte'] : 0 ;
				
				if( $total_qte_reception >= $total_qte_commande ){
					$this->Boncommande->id = $reception[$this->alias]['boncommande_id'];
					$this->Boncommande->saveField('recu',2);
				} else if( $total_qte_commande > $total_qte_reception ){
					$this->Boncommande->id = $reception[$this->alias]['boncommande_id'];
					$this->Boncommande->saveField('recu',1);
				} else if($total_qte_reception == 0){
					$this->Boncommande->id = $reception[$this->alias]['boncommande_id'];
					$this->Boncommande->saveField('recu',-1);
				}
			}
		}
	}
}
 ?>