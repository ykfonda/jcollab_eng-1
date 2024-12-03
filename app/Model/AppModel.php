<?php

App::uses('Model', 'Model');

class AppModel extends Model {
	public $recursive = -1;
	public $actsAs = array('Containable');

	
	public function beforeSave($options = array()) {
		if( empty($this->data[$this->alias][$this->primaryKey]) ){
			$this->data[$this->alias]['user_c'] = AuthComponent::user('id');
			$this->data[$this->alias]['date_c'] = date('Y-m-d H:i:s');
		}else{
			$this->data[$this->alias]['user_u'] = AuthComponent::user('id');
			$this->data[$this->alias]['date_u'] = date('Y-m-d H:i:s');
		}
	}

	public function beforeFind($queryData = array()) {
        parent::beforeFind($queryData);
        if(!isset($queryData['conditions']['deleted']) && !isset($queryData['conditions'][$this->alias.'.deleted']) ){
	        $defaultConditions = array( $this->alias.'.deleted' => 0 );
	        if( is_array( $queryData['conditions'] ) )
	        	$queryData['conditions'] = array_merge($queryData['conditions'], $defaultConditions);
	        else
	        	$queryData['conditions'] = $defaultConditions;
        }
        return $queryData;
    }

    public function flagDelete($conditions = [],$flag = "deleted") {
		if( !is_array($conditions) ) $conditions = array($this->alias.'.'.$this->primaryKey => $conditions);
		return $this->updateAll(array($flag => 1),$conditions);
	}

	public function dateFormatBeforeSave($dateString) {
	    return ( !empty($dateString) ) ? date('Y-m-d', strtotime($dateString)) : '' ;
	}

	public function dateFormatAfterFind($dateString) {
	    return ( !empty($dateString) ) ? date('d-m-Y', strtotime($dateString)) : '' ;
	}

	public function dateTimeFormatBeforeSave($dateString) {
	    return ( !empty($dateString) ) ? date('Y-m-d H:i', strtotime($dateString)) : '' ;
	}
	public function dateTimeFormatBeforeSave2($dateString) {
	    return ( !empty($dateString) ) ? date('Y-m-d H:i:s', strtotime($dateString)) : '' ;
	}

	public function dateTimeFormatAfterFind($dateString) {
	    return ( !empty($dateString) ) ? date('d-m-Y H:i', strtotime($dateString)) : '' ;
	}
	public function dateTimeFormatAfterFind2($dateString) {
	    return ( !empty($dateString) ) ? date('d-m-Y H:i:s', strtotime($dateString)) : '' ;
	}


}
