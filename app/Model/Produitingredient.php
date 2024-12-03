<?php 

class Produitingredient extends AppModel
{
	public $displayField = 'libelle';
	public $belongsTo = [
		'Produit' => [
			'className' => 'Produit',
            'foreignKey' => 'ingredient_id'
		],
		'Ingredient' => [
			'className' => 'Produit',
            'foreignKey' => 'ingredient_id'
		],
	];

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
			$this->data[$this->alias]['reference'] = 'ING-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	}
}
 ?>