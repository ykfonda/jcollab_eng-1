<?php 
class Typeconditionnement extends AppModel
{
	public $displayField = 'libelle';
	public function findList($conditions = []){
		$clients = $this->find('all',['order' => [$this->alias.'.id' => 'desc'],'conditions' => $conditions]);
		foreach ($clients as $k => $v) { 
			$list[ $v[$this->alias]['code_type'] ] = $v[$this->alias]['libelle']; 
		}

		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	/*public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count', ['conditions'=> [$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'TYPE-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	}*/
	public $hasMany = [
		'Typecondionnementtproduit'
	];
}
 ?>