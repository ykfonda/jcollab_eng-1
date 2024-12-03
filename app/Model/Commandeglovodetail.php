<?php

class Commandeglovodetail extends AppModel
{
    public $belongsTo = ['Commandeglovo' => [
        'className' => 'Commandeglovo',
        'foreignKey' => 'commandes_glovo_id',
    ], 'Produit'];
    public $useTable = 'commande_glovo_details';

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        if (!empty($this->data[$this->alias]['date_c'])) {
            $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave($this->data[$this->alias]['date_c']);
        }

        return true;
    }

    public function afterFind($results, $primary = false)
    {
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['date_c'])) {
                $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind($val[$this->alias]['date_c']);
            }
        }

        return $results;
    }
}
