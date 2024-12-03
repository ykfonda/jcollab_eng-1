<?php

class Typeconditionnementtproduit extends AppModel
{
    public $useTable = 'typeconditionnementtproduits';
    public $belongsTo = ['Typeconditionnement' => [
        'className' => 'Typeconditionnement',
        'foreignKey' => 'id_typeconditionnement',
        ], 'Produit'];

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        $typeconditionnement_produit = $this->find('first', ['order' => ['id' => 'DESC']]);
        if (isset($typeconditionnement_produit['Typeconditionnementtproduit']['id'])) {
            $lastid = $typeconditionnement_produit['Typeconditionnementtproduit']['id'];
            $this->data[$this->alias]['id'] = $lastid + 1;
        } else {
            $this->data[$this->alias]['id'] = 1;
        }
    }
}
