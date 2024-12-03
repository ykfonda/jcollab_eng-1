<?php 
class Bonreceptiondetail extends AppModel
{
	public $belongsTo = ['Bonreception','Produit','Depot','Boncommandedetail'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
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
		if( isset($this->data[$this->alias]['id']) AND !empty($this->data[$this->alias]['id']) ){
			$reception = $this->find('first',['conditions' => ['Bonreceptiondetail.id'=>$this->data[$this->alias]['id']] ]);
			$qte_recu = ( isset($reception['Bonreceptiondetail']['qte']) AND !empty($reception['Bonreceptiondetail']['qte']) ) ? $reception['Bonreceptiondetail']['qte'] : 0 ;
			if( isset($reception[$this->alias]['boncommandedetail_id']) AND !empty($reception[$this->alias]['boncommandedetail_id']) ){
				$commande = $this->Boncommandedetail->find('first',['conditions' => ['Boncommandedetail.id'=>$reception[$this->alias]['boncommandedetail_id']] ]);
				$qte_cmd = ( isset($commande['Boncommandedetail']['qte']) AND !empty($commande['Boncommandedetail']['qte']) ) ? $commande['Boncommandedetail']['qte'] : 0 ;
				// do i should save the qte_recu ??
				if ( $qte_recu > 0 AND $qte_cmd == $qte_recu ) {
					$this->Boncommandedetail->id = $reception[$this->alias]['boncommandedetail_id'];
					$this->Boncommandedetail->saveField('recu',2);
				} else if( $qte_cmd > $qte_recu ){
					$this->Boncommandedetail->id = $reception[$this->alias]['boncommandedetail_id'];
					$this->Boncommandedetail->saveField('recu',1);
				} else if( $qte_recu == 0 ){
					$this->Boncommandedetail->id = $reception[$this->alias]['boncommandedetail_id'];
					$this->Boncommandedetail->saveField('recu',-1);
				}
			}
		}
	}
}
 ?>