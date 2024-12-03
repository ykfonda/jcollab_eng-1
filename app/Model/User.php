<?php 
App::import('Model','Notification');
class User extends AppModel{

	public $displayField = 'nom';

	public $belongsTo = array(
		'Role','Ville','Pay','Depot',
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
		'StoreSession' => [
			'className' => 'Store',
            'foreignKey' => 'store_id'
		],
	);

	public $hasMany = array(
		'ChatmessageFrom' => array(
			'className' => 'Chatmessage',
			'foreignKey' => 'from_id',
			'dependent' => false,
		),
		'ChatmessageTo' => array(
			'className' => 'Chatmessage',
			'foreignKey' => 'to_id',
			'dependent' => false,
		)
	);

	public $hasAndBelongsToMany = ['Store'];

	public function beforeSave($options = array()){
		parent::beforeSave($options);
	    if (!empty($this->data[$this->alias]['date_naissance'])){
	        $this->data[$this->alias]['date_naissance'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_naissance'] );
	    }
	    if (!empty($this->data[$this->alias]['date_visite'])){
	        $this->data[$this->alias]['date_visite'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date_visite'] );
	    }
	    if (!empty($this->data[$this->alias]['date_c'])){
	        $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date_c'] );
	    }	    
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date_naissance'])) {
	            $results[$key][$this->alias]['date_naissance'] = $this->dateFormatAfterFind( $val[$this->alias]['date_naissance'] );
	        }
	        if (isset($val[$this->alias]['date_visite'])) {
	            $results[$key][$this->alias]['date_visite'] = $this->dateFormatAfterFind( $val[$this->alias]['date_visite'] );
	        }
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}

	public function findList($conditions = [],$flagAll = false){
		$list = [];
		$options['User.id !='] = 1;
		if ( $flagAll == true ) $options = [];
		$users = $this->find('all',['conditions' => $options + $conditions ]);
		foreach ($users as $k => $v) { $list[ $v[$this->alias]['id'] ] = $v[$this->alias]['nom'].' '.$v[$this->alias]['prenom']; }
		return $list;
	}

	public function findUsernames($conditions = [],$flagAll = false){
		$options['User.id !='] = 1;
		if ( $flagAll == true ) $options = [];
		$users = $this->find('all',['conditions' => $options + $conditions ]);
		foreach ($users as $k => $v) { $list[ $v[$this->alias]['username'] ] = $v[$this->alias]['nom'].' '.$v[$this->alias]['prenom']; }
		return ( isset($list) AND !empty($list) ) ? $list : [] ;
	}

	public function afterSave($created, $options = array()){
		parent::afterSave($created, $options);
		// --------------------------------- Notifications ---------------------------------------
		if ( isset($this->data[$this->alias]['id']) AND isset($this->data[$this->alias]['check']) AND $this->data[$this->alias]['check'] == 1 ) {
			$options = array('conditions' => array($this->alias . 'id' => $this->data[$this->alias]['id']));
			$user = $this->find('first', $options);
			$Notification = new Notification();

			$NewUserNotif = [
				'Notification' => [ 
					'privee' => 1 
				],
				'UserList' => [ $user[$this->alias]['id'] ],
				'Params' => [
					'key' => 1, 
					'id' => $user[$this->alias]['id'] ,
					'auteur' => $user[$this->alias]['nom'].' '.$user[$this->alias]['prenom'] ,
					'date' => date('d/m/Y H:i',strtotime($user[$this->alias]['date_c'])) ,
					'username' => $user[$this->alias]['username'] ,
				],
			];
			$Notification->save($NewUserNotif);

		}
	}

}

 ?>