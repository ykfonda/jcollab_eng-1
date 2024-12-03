<?php 
/**
 * 
 */
class Souscategorieproduit extends AppModel
{
	public $displayField = 'libelle';
	public $belongsTo = ['Categorieproduit'];
}
 ?>