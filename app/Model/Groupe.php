<?php 
class Groupe extends AppModel
{
	public $displayField = 'libelle';
	public $hasAndBelongsToMany = ['User'];
}
 ?>