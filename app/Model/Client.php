<?php

class Client extends AppModel
{
    public $displayField = 'designation';
    public $belongsTo = [
        'Categorieclient', 'User', 'Ville', 'Clienttype',
        'Creator' => [
            'className' => 'User',
            'foreignKey' => 'user_c',
        ],
    ];

    // JCOLLAB V4.x
    public $hasMany = [
        'Commandeglovo', 
        'Vente', 
        'Remiseclient', 
        'Avoir', 
        'Objectifclient', 
        'Bonlivraison', 
        'Bonavoir', 
        'Facture',
        'Wallet' => [
            'className' => 'Wallet',
            'foreignKey' => 'client_id',
            'dependent' => true
        ]
    ];
    
    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        if (empty($this->data[$this->alias]['id']) and empty($this->data[$this->alias]['reference'])) {
            $number = $this->find('count', ['conditions' => [$this->alias.'.deleted' => [0, 1]]]) + 1;
            $this->data[$this->alias]['reference'] = 'CLT-'.str_pad($number, 6, '0', STR_PAD_LEFT);
        }
        if (!empty($this->data[$this->alias]['date'])) {
            $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave($this->data[$this->alias]['date']);
        }
        if (!empty($this->data[$this->alias]['date_naissance'])) {
            $this->data[$this->alias]['date_naissance'] = date('Y-m-d', strtotime($this->data[$this->alias]['date_naissance']));
        } elseif (empty($this->data[$this->alias]['date_naissance'])) {
            $this->data[$this->alias]['date_naissance'] = '';
        }

        return true;
    }

    public function findList($conditions = [])
    {
        $clients = $this->find('all', ['order' => [$this->alias.'.designation' => 'asc'], 'conditions' => [$this->alias.'.designation !=' => ''] + $conditions]);
        foreach ($clients as $k => $v) {
            $list[$v[$this->alias]['id']] = $v[$this->alias]['designation'];
        }

        return (isset($list) and !empty($list)) ? $list : [];
    }

    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['date'])) {
                $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind($val[$this->alias]['date']);
            }
            if (isset($val[$this->alias]['date_naissance'])) {
                $results[$key][$this->alias]['date_naissance'] = $this->dateFormatAfterFind($val[$this->alias]['date_naissance']);
            }
        }

        return $results;
    }
}
