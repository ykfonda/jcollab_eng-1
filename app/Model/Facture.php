<?php

class Facture extends AppModel
{
    public $displayField = 'reference';

    public $belongsTo = [
        'User', 'Client', 'Depot', 'Vente', 'Bonlivraison',
        'Creator' => [
            'className' => 'User',
            'foreignKey' => 'user_c',
        ],
    ];

    public $hasMany = ['Facturedetail', 'Piece', 'Avance', 'Email'];

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        if (empty($this->data[$this->alias]['id']) and empty($this->data[$this->alias]['reference'])) {
            App::uses('CakeSession', 'Model/Datasource');
            $options = ['conditions' => ['module' => 'Facture', 'store_id' => CakeSession::read('Auth.User.StoreSession.id')]];
            $compteur = ClassRegistry::init('Compteur');
            $compteur = $compteur->find('first', $options);
            $prefix = trim($compteur['Compteur']['prefix']);
            $numero = $compteur['Compteur']['numero'];
            $count = strlen($numero);
            $numero = intval($numero);
            $conditions['Facture.reference LIKE '] = "%$prefix%";
            $commmande = $this->find('first', ['conditions' => $conditions, 'order' => ['id' => 'DESC']]);
            //compteur deja utilisé

            if (isset($commmande['Facture']['id'])) {
                $str = explode('-', $commmande['Facture']['reference']);
                $numero = intval($str[1]) + 1;
            }
            $this->data[$this->alias]['reference'] = $prefix.'-'.str_pad($numero, $count, '0', STR_PAD_LEFT);
        }
        if (!empty($this->data[$this->alias]['date'])) {
            $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave($this->data[$this->alias]['date']);
        }
        if (!empty($this->data[$this->alias]['date_c'])) {
            $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave($this->data[$this->alias]['date_c']);
        }

        return true;
    }

    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['date'])) {
                $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind($val[$this->alias]['date']);
            }
            if (isset($val[$this->alias]['date_c'])) {
                $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind($val[$this->alias]['date_c']);
            }
        }

        return $results;
    }
}
