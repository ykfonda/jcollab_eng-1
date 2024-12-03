<?php
class Synchronisation extends AppModel{
	
	public function findList($conditions = []){
		$depots = $this->find('all',['order' => [$this->alias.'.designation' => 'asc'],'conditions' => [$this->alias.'.designation !='=>''] + $conditions]);
		foreach ($depots as $k => $v) { $list[ $v[$this->alias]['id'] ] = $v[$this->alias]['designation']; }
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
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