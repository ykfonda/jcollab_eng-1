<?php
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'jcollab_4x_gauthier',
		'encoding' => 'utf8',
	);


	// Syncronisation - Configuration de la deuxième base de données
	public $sync_server = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'iafsys.app',
		'login' => 'iafsy7j9_jco4uzr',
		'password' => 'PS9Q0^Xzw-}v',
		'database' => 's',
		'prefix' => '',
		'encoding' => 'utf8'
	);
	

}
