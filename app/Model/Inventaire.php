<?php 
/**
 * 
 */
class Inventaire extends AppModel
{
	public $displayField = 'reference';
	public $belongsTo = [
		'Depot',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];

	public $hasMany = ['Inventairedetail'];

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
	
		if (empty($this->data[$this->alias]['id']) && empty($this->data[$this->alias]['reference'])) { 
			$number = $this->find('count', ['conditions' => [$this->alias . '.deleted' => [0, 1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	
		if (empty($this->data[$this->alias]['date'])) {
			$this->data[$this->alias]['date'] = date("Y-m-d H:i:s");
		} else {
			$this->data[$this->alias]['date'] = date("Y-m-d H:i:s", strtotime($this->data[$this->alias]['date']));
		}
	
		return true;
	}

	
	

	


	public function findList($conditions = []){
		$inventaires = $this->find('all',['order' => [$this->alias.'.id' => 'desc'],'conditions' => $conditions]);
		foreach ($inventaires as $k => $v) $list[ $v[$this->alias]['id'] ] = $v[$this->alias]['reference'].' - '.$v[$this->alias]['date'];
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

/* 	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	    }
	    return $results;
	} */
}
 ?>