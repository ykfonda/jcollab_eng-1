<?php 
class Depot extends AppModel
{
	public $displayField = 'libelle';

	// add dans la mise à jour 4.1 (pour récuprer les infos entrees afin de les synchornisées)
	public $hasMany = array(
        'Entree' => array(
            'className' => 'Entree',
            'foreignKey' => 'depot_id'
        )
    );

	public $belongsTo = array('Store','Societe');

	public function findList($conditions = []){
		$depots = $this->find('all',['order' => [$this->alias.'.libelle' => 'asc'],'conditions' => $conditions]);
		foreach ($depots as $k => $v) { $list[ $v[$this->alias]['id'] ] = $v[$this->alias]['libelle']; }
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if ( empty($this->data[$this->alias]['id']) AND empty( $this->data[$this->alias]['reference'] ) ){ 
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'DP-'.str_pad($number, 6, '0', STR_PAD_LEFT);
		}
	}
}
 ?>