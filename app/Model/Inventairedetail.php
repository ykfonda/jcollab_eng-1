<?php
/**
 * 
 */
class Inventairedetail extends AppModel
{
	public $belongsTo = [
		'Produit',
		'Inventaire',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
		// "Depotproduit",     /// suite à une erreur de la mise à jour des lignes Inventairedetail on a commenté cette ligne 
	];
}
 ?>