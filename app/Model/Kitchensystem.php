<?php 
class Kitchensystem extends AppModel
{
	public $displayField = 'libelle';
	public $belongsTo = ['Store','Societe'];
	public $hasMany = ['Kitchensystemproduit'];
	public $hasAndBelongsToMany = ['Produit'];

	public function findList($conditions = []){
		$records = $this->find('all',['order' => [$this->alias.'.id' => 'desc'],'conditions' => $conditions]);
		foreach ($records as $k => $v) { $list[ $v[$this->alias]['id'] ] = $v[$this->alias]['reference'].' - '.$v[$this->alias]['libelle']; }
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'KDS-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	}
}
 ?>