<?php

class Etiquette extends AppModel {
    public $useTable = 'etiquettes'; // Lier au nom de la table SQL

    public $belongsTo = array(
        'Production' => array(
            'className' => 'Production',
            'foreignKey' => 'production_id'
        )
    );
}




?>