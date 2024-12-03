<?php

class Store extends AppModel{
	
	public $displayField = 'libelle';

	public $belongsTo = array('Societe','Fraislivraison');
	public $hasMany = array('Depot','Store');

	public function findList($conditions = []){
		$clients = $this->find('all',['order' => [$this->alias.'.libelle' => 'asc'],'conditions' => $conditions]);
		foreach ($clients as $k => $v) { 
			$list[ $v[$this->alias]['id'] ] = $v[$this->alias]['reference'].' - '.$v[$this->alias]['libelle']; 
		}

		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'ST-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
		if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }
	}

	public function afterFind($results, $primary = false) {
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	    }
	    return $results;
	}

}