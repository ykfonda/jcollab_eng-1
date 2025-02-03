<?php
class Balance extends AppModel {
    public $useTable = 'balances';

    public $validate = [
        'libelle' => ['rule' => 'notBlank', 'message' => 'Le libellé est requis'],
        'adresse_ip' => ['rule' => 'notBlank', 'message' => 'L\'adresse IP est requise'],
        'port' => ['rule' => 'numeric', 'message' => 'Le port doit être un nombre']
    ];
}



?>