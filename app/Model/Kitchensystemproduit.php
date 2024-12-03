<?php 
class Kitchensystemproduit extends AppModel
{
	public $useTable = 'kitchensystems_produits';
	public $belongsTo = ['Produit','Kitchensystem'];
}
 ?>