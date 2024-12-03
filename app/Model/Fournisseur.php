<?php 
/**
 * 
 */
class Fournisseur extends AppModel
{
	public $displayField = 'designation';
	public $belongsTo = [
		'Ville',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];
	public $hasMany = ['Boncommande'];

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'FRS-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
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
}
 ?>