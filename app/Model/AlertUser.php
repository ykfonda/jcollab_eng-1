<?php

class AlertUser extends AppModel
{
    public $useTable = 'alerts_users';
    public $belongsTo = ['Alert', 'User'];
}
