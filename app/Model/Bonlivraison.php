<?php

class Bonlivraison extends AppModel
{
    public $displayField = 'reference';

    public $belongsTo = [
        'User', 'Client', 'Fournisseur', 'Facture', 'Depot', 'Devi',
        'Creator' => [
            'className' => 'User',
            'foreignKey' => 'user_c',
        ],
    ];

    public $hasMany = ['Bonlivraisondetail', 'Avance', 'Email'];

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);

        $storeId = CakeSession::read('Auth.User.StoreSession.id');
        // Vérifie si $storeId est vide et remplace par 19
        if (empty($storeId)) {
            $storeId = 19;
        }


        if (empty($this->data[$this->alias]['id']) and empty($this->data[$this->alias]['reference'])) {
            App::uses('CakeSession', 'Model/Datasource');

            // $options = ['conditions' => ['module' => 'Bon livraison', 'store_id' => CakeSession::read('Auth.User.StoreSession.id')]];

            $options = ['conditions' => ['module' => 'Bon livraison', 'store_id' => $storeId]];


            $compteur = ClassRegistry::init('Compteur');
            $compteur = $compteur->find('first', $options);
            if (!isset($compteur['Compteur']['prefix'])) {
                $this->error = __('Le compteur pour ce store n\'existe pas');
                return false;
            }
            $prefix = trim($compteur['Compteur']['prefix']);
            $numero = $compteur['Compteur']['numero'];
            $count = strlen($numero);
            $numero = intval($numero);

            $conditions['Bonlivraison.reference LIKE '] = "%$prefix%";
            $commmande = $this->find('first', ['conditions' => $conditions, 'order' => ['id' => 'DESC']]);
            if (isset($commmande['Bonlivraison']['id'])) {
                $str = explode('-', $commmande['Bonlivraison']['reference']);
                $numero = intval($str[1]) + 1;
            }

            $this->data[$this->alias]['reference'] = $prefix.'-'.str_pad($numero, $count, '0', STR_PAD_LEFT);

            /* $number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1;
            $this->data[$this->alias]['reference'] = 'BL-'.str_pad($number, 6, '0', STR_PAD_LEFT);
     */
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
