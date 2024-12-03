<?php 
class Produit extends AppModel
{
	public $displayField = 'libelle';

	public $belongsTo = [
		'Categorieproduit', 
		'Unite', 
		'Souscategorieproduit',
		'Typeconditionnement',
		'Options',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
		'TvaAchat' => [
			'className' => 'Tva',
            'foreignKey' => 'tva_achat'
		],
		'TvaVente' => [
			'className' => 'Tva',
            'foreignKey' => 'tva_vente'
		],
	];

	public $hasMany = [
		'Depotproduit',
		'Typeconditionnementtproduit',
		'Optionproduit',
		'Mouvement',
		'Produitprice',
		'Produitingredient'
	];

	//public $hasAndBelongsToMany = ['Segment'];

	public function findList($conditions = []){
		$produits = $this->find('all',[
			'conditions' => [$this->alias.'.active'=>1] + $conditions,
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = '.$this->alias.'.id'] ],
			],
			'order' => [$this->alias.'.libelle' => 'ASC']
		]);
		foreach ($produits as $k => $v) { 
			$string = "";
			if ( empty( $v[$this->alias]['code_barre'] ) ) $string = $v[$this->alias]['libelle'];
			else $string = $v[$this->alias]['code_barre'].' - '.$v[$this->alias]['libelle'];
			$list[ $v[$this->alias]['id'] ] = $string; 
		}
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function findCodes($conditions = []){
		$produits = $this->find('all',[
			'conditions' => [$this->alias.'.active'=>1] + $conditions,
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = '.$this->alias.'.id'] ],
			],
			'order' => [$this->alias.'.libelle' => 'ASC']
		]);
		foreach ($produits as $k => $v) { 
			$list[ (int) $v[$this->alias]['code_barre'] ] = $v[$this->alias]['libelle'];
		}
		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}

	public function beforeSave($options = array()){
		parent::beforeSave($options);
		if ( empty( $this->data[$this->alias]['id'] ) AND empty( $this->data[$this->alias]['reference'] )){
			$number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'PROD-'.str_pad($number, 6, '0', STR_PAD_LEFT);
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
			$ctrObj = Router::getRequest();
			//var_dump($ctrObj);die();
			$selected_store  = CakeSession::read('Auth.User.StoreSession.id');
			
            if ($ctrObj["controller"] != "ingredients") {
                if (isset($val[$this->alias]['id'])) {
                    $options = array('conditions' => array("produit_id" => $results[$key][$this->alias]['id'],"store_id" => $selected_store));
                    $produitprice = ClassRegistry::init('Produitprice');
                    $produitprice = $produitprice->find('first', $options);
                    if (isset($produitprice) and !empty($produitprice)) {
                        $results[$key][$this->alias]['prix_vente'] = $produitprice["Produitprice"]["prix_vente"];
                    }
                }
            }
			
		}
		
	    return $results;
		
	}
}
 ?>