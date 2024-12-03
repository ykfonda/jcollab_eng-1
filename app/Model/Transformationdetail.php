<?php 
class Transformationdetail extends AppModel
{
	public $belongsTo = [
		'Transformation',
		'ProduitATransformer' => [
			'className' => 'Produit',
            'foreignKey' => 'produit_a_transformer_id'
		],
		'ProduitTransforme' => [
			'className' => 'Produit',
            'foreignKey' => 'produit_transforme_id'
		],
	];
}
 ?>