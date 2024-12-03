<?php

class Optionproduit extends AppModel
{
    public $belongsTo = ['Options' => [
        'className' => 'Options',
        'foreignKey' => 'id_option',
        ], 'Produit'];

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        $optionproduit = $this->find('first', ['order' => ['id' => 'DESC']]);
        if (isset($optionproduit['Optionproduit']['id'])) {
            $lastid = $optionproduit['Optionproduit']['id'];
            $this->data[$this->alias]['id'] = $lastid + 1;
        } else {
            $this->data[$this->alias]['id'] = 1;
        }
    }
}
