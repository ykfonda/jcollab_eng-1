<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
App::import('Model', 'Parametreste');
class Notification extends AppModel {
	public $displayField = 'message';
	
	private $link = 'http://localhost/webstock';

	private $params = [
		'id', 'reference', 'libelle', 'objet', 'auteur', 'date', 'username', 'motdepasse'
	];

	private $notifs = [
		// ------------------- Nouveau compte pour tous les users ------------------- \\
		1 => [
			'message' => 'Votre compte a été bien créé le {{date}}',
			'content' => '<p>Bonjour {{auteur}} ,</p>
				<p>On vous informe que votre compte  a été bien créé le {{date}}</p>
				<p>Username : {{username}}</p>
				<p>Mot de passe : {{motdepasse}}</p>
				<p><a href="{{link}}">Cliquez ici pour accéder </a></p>
				<p>Ce mail a été généré automatiquement. Veuillez ne pas répondre à cette adresse électronique.</p>
				<p>Cordialement</p>',
			'link' => '/pages',
			'Auth' => 'User',
		],
		// ------------------- Validation facture ------------------- \\
		2 => [
			'message' => 'Facture N° {{reference}} créé le {{date}} est en attente de validation',
			'content' => '<p>Bonjour,</p>
				<p>On vous informe que la facture N° {{reference}} daté de {{date}} est en attente de validation</p>
				<p><a href="{{link}}">Cliquez ici pour consulter </a></p>
				<p>Ce mail a été généré automatiquement. Veuillez ne pas répondre à cette adresse électronique.</p>
				<p>Cordialement</p>',
			'link' => '/factures/view/{{id}}',
			'Auth' => 'User',
		],
		// ------------------- Validation vente ------------------- \\
		3 => [
			'message' => 'Vente N° {{reference}} créé le {{date}} est en attente de validation',
			'content' => '<p>Bonjour,</p>
				<p>On vous informe que la vente N° {{reference}} daté de {{date}} est en attente de validation</p>
				<p><a href="{{link}}">Cliquez ici pour consulter </a></p>
				<p>Ce mail a été généré automatiquement. Veuillez ne pas répondre à cette adresse électronique.</p>
				<p>Cordialement</p>',
			'link' => '/ventes/view/{{id}}',
			'Auth' => 'User',
		],
	];

	public $hasMany = array(
		'NotificationsVue'
	);

	public $hasAndBelongsToMany = [
		'User'
	];

	private function keyToNotif($params = []){
		$notif = [];
		if( isset($params['key']) ){
			if( isset($this->notifs[$params['key']]) ){
				$notif = $this->notifs[$params['key']];
			}
		}
		if ( !empty( $this->params ) ) {
			foreach ($this->params as $v) {
				if( isset($params[ $v ]) ) $notif = str_replace('{{'.$v.'}}', $params[ $v ], $notif);
			}
		}
		$lien = (isset( $notif['link'] )) ? $notif['link'] : '' ;
		$notif = str_replace('{{link}}', $this->link.$lien, $notif);
		return $notif;
	}

	public function beforeSave($options = array()){
		$params = (isset( $this->data['Params'] )) ? $this->data['Params'] : [] ;
		$keyToNotif = $this->keyToNotif( $params );
		$this->data['Notification'] += $keyToNotif;
		parent::beforeSave($options);
		if ( empty( $this->data['Notification']['id'] ) ) {
			$users = [];
			if( isset($this->data['UserList']) ){
				foreach ($this->data['UserList'] as $k => $v) {
					$users[] = $v;
				}
			}
			$this->data['User'] = ['User' => $users];
		}
	}

	public function afterSave($created, $options = array()){
		$thisParametreste = new Parametreste();
		$parametreSte = $thisParametreste->find('list',['fields' => ['Parametreste.key', 'Parametreste.value'] ]);

		$users = [];
		if( isset($this->data['User']['User']) && !empty($this->data['User']['User']) ){
			$users = $this->data['User']['User'];
		}

		$usersFind = $this->User->find('all',[
			'conditions'=>['User.id'=>$users],
			'fields' => ['User.email'],
		]);

		$user_notif = ( isset( $this->data['Notification']['Auth'] ) AND $this->data['Notification']['Auth'] == 'User' ) ? true : false;

		$to = $this->getEmails($usersFind);
		if( isset($parametreSte['Email_all']) && $parametreSte['Email_all'] == '1' ){
			if( !empty($to) ) {
				$config = [
					'host' => $parametreSte['SMTP_host'],
				    'port' => $parametreSte['SMTP_port'],
				    'username' => $parametreSte['SMTP_username'],
				    'password' => $parametreSte['SMTP_password'],
				    'auth' => ( isset( $parametreSte['SMTP_auth'] ) AND $parametreSte['SMTP_auth'] == "true" ) ? true : false ,
				    'tls' => true,
				    'context' => [
			            'ssl' => [
			                'verify_peer' => false,
			                'verify_peer_name' => false,
			                'allow_self_signed' => true
			            ]
			        ]
			    ];
				try{
					$Email = new CakeEmail();
					$Email->config($config);
					$from = ( isset( $parametreSte['SMTP_from'] ) AND !empty(  $parametreSte['SMTP_from'] ) ) ?  $parametreSte['SMTP_from'] : 'notification@noreply.ma';
					$Email->from(array($from => 'Apia Notification'));
					$Email->to( $to );
					$Email->emailFormat('html');
					$Email->subject($this->data[$this->alias]['message']);
					$Email->send($this->data[$this->alias]['content']);
					return true;
				}catch(Exception $e) {
					return false;
					//die('Error message : '.$e->getMessage() );
				}
			}
		}
	}

	private function getEmails($data = []){
		$emails = [];
		foreach ($data as $k => $v) {
			if( isset($v['User']['email']) && !empty($v['User']['email']) ){
				$emails[] = $v['User']['email'];
			}
		}
		return $emails;
	}

}