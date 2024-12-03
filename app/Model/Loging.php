<?php 

class Loging extends AppModel
{
	public $useTable = 'logings';
	public $belongsTo = [
		'User' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];
}

?>