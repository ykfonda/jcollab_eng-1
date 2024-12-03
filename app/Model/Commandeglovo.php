<?php

class Commandeglovo extends AppModel
{
    public $displayField = 'reference';
    public $useTable = 'commandes_glovo';
    public $hasMany = ['Commandeglovodetail'];
    public $belongsTo = ['Client', 'Store', 'Creator' => [
        'className' => 'User',
        'foreignKey' => 'user_c',
    ]];

    public function beforeSave($options = [])
    {
        parent::beforeSave($options);
        if (empty($this->data[$this->alias]['id']) and empty($this->data[$this->alias]['reference'])) {
            $number = $this->find('count', ['conditions' => [$this->alias.'.deleted' => [0, 1]]]) + 1;
            $this->data[$this->alias]['reference'] = 'Cmdglo-'.str_pad($number, 6, '0', STR_PAD_LEFT);
        }
        if (!empty($this->data[$this->alias]['date'])) {
            $this->data[$this->alias]['date'] = $this->dateTimeFormatBeforeSave($this->data[$this->alias]['date']);
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
                $results[$key][$this->alias]['date'] = $this->dateTimeFormatAfterFind($val[$this->alias]['date']);
            }
            if (isset($val[$this->alias]['date_c'])) {
                $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind($val[$this->alias]['date_c']);
            }            
        }

        return $results;
    }
}
