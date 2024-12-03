<?php 
class Productiondetail extends AppModel
{
	public $hasMany = ['Produitingredient'];
	public $belongsTo = ['Produit','Production'];
}
 ?>