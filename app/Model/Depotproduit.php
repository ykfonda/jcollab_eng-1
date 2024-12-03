<?php 
class Depotproduit extends AppModel
{
	public $belongsTo = ['Depot','Produit'];

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

	public function afterSave($created, $options = array()) {
		if ( isset( $this->data[$this->alias]['produit_id'] ) AND !empty( $this->data[$this->alias]['produit_id'] ) ) {
			$find = $this->find('first',[ 'fields' => ['SUM(quantite) as stockactuel'], 'conditions' => [ 'produit_id' => $this->data[$this->alias]['produit_id'] ] ]);

			$this->Produit->id = $this->data[$this->alias]['produit_id'];
			$stockactuel = (isset( $find[0]['stockactuel'] )) ? $find[0]['stockactuel'] : 0 ;
		
			$mvts = $this->Produit->Mouvement->find('all',['conditions' => [ 'produit_id' => $this->data[$this->alias]['produit_id'],'operation' => -1 ]]);
			$prix_achat_total = 0;
			foreach ($mvts as $v) { 
				$total = $v['Mouvement']['stock_source']*$v['Mouvement']['prix_achat'];
				$prix_achat_total = $prix_achat_total + $total; 
			}
			$pmp = ( $stockactuel > 0 ) ? round($prix_achat_total/$stockactuel,2) : 0 ;
			if( $this->Produit->saveField('stockactuel', $stockactuel) ) $this->Produit->saveField('pmp', $pmp);
		}
	}
}
 ?>