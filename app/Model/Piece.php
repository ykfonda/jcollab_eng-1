<?php 
class Piece extends AppModel
{
	public $displayField = 'filename';
	public $belongsTo = [
		'Devi',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];
}
 ?>