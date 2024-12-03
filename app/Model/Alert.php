<?php 
class Alert extends AppModel
{
	public $displayField = 'libelle';
	public $hasMany = ['AlertUser'];
	public $hasAndBelongsToMany = ['User'];
}
 ?>