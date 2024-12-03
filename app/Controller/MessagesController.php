<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('ParametreSteLib', 'Lib');

class MessagesController extends AppController {
	

	public function view($id = 0){
		$message = $this->Message->find('first',['conditions' => ['Message.id' => $id], 'contain' => ['From', 'MessagesUser' => ['User'], 'Attachment'] ]);
		
		$toUserKey = -1;
		foreach ($message['MessagesUser'] as $key => $messageUser) {
			if( $messageUser['user_id'] == $this->Session->read('Auth.User.id')){
				$toUserKey = $key;
				break;
			}
		}

		if ( $toUserKey !== -1 && $message['MessagesUser'][$toUserKey]['isread'] == 0) {
			$this->Message->MessagesUser->id = $message['MessagesUser'][$toUserKey]['id'];
			$this->Message->MessagesUser->saveField('isread',1);
		}

		$this->set( compact('message','toUserKey') );

		$this->getCounts();
	}

	public function index(){
		$filter = [];
		if( $this->request->is('post') ){
			$filter = ['OR' => ['Message.subject LIKE' => '%'.$this->data['Filter']['keyword'].'%'], ['Message.message LIKE' => '%'.$this->data['Filter']['keyword'].'%'] ];
		}

		$this->Paginator->settings = array(
			'fields' => ['Message.*','MessagesUser.*'],
			'conditions' => ['MessagesUser.user_id' => $this->Session->read('Auth.User.id'), 'MessagesUser.istrash' => '0'] + $filter,
	        'joins' => [
	        	['table' => 'messages_users', 'alias' => 'MessagesUser', 'type' => 'INNER', 'conditions' => ['MessagesUser.message_id = Message.id']]
	        ],
	        'order' => 'Message.date_c DESC',
	    );
		$messages = $this->Paginator->paginate();

		$this->set( compact('messages') );

		$this->getCounts();
	}

	public function sent(){
		$this->Paginator->settings = array(
	        'conditions' => ['from_id' => $this->Session->read('Auth.User.id'), 'istrash' => 0]
	    );

		$messages = $this->Paginator->paginate();
		//$messages = $this->Message->find('all',['conditions' => ['from_id' => $this->Session->read('Auth.User.id')] ]);
		$this->set( compact('messages') );

		$this->getCounts();
	}

	public function trash(){

		$this->Paginator->settings = array(
			'conditions' => [
				'OR' => [
					['Message.from_id' => $this->Session->read('Auth.User.id'), 'Message.istrash' => '1'],
					['MessagesUser.user_id' => $this->Session->read('Auth.User.id'), 'MessagesUser.istrash' => '1']
				]
			],
	        'joins' => [
	        	['table' => 'messages_users', 'alias' => 'MessagesUser', 'type' => 'INNER', 'conditions' => ['MessagesUser.message_id = Message.id']]
	        ],
	        'order' => 'Message.date_c DESC',
	        'group' => 'Message.id'
	    );

		$messages = $this->Paginator->paginate();

		//$messages = $this->Message->find('all',['conditions' => ['to_id' => $this->Session->read('Auth.User.id'), 'istrash' => '1'] ]);
		$this->set( compact('messages') );

		$this->getCounts();
	}

	public function add(){
		if( $this->request->is('post') ){
			$this->request->data['Message']['from_id'] = $this->Session->read('Auth.User.id');
			if( $this->Message->saveAssociated( $this->data ) ){
				if ( !empty( $this->data['User']['User'] ) ) {
					$users = $this->Message->User->find('list',['fields' => ['User.email'], 'conditions' => ['User.id' => $this->data['User']['User'] ] ]);
					try{
						$to = [];
						foreach ($users as $k => $v) {
							$to[] = $v;
						}
						$attachments = [];
						if( isset($this->data['Attachment']) ){
							foreach ($this->data['Attachment'] as $v) {
								$attachments[] = WWW_ROOT.'/attachments/'.$v['name'];
							}
						}

						$this->sendEmailOnAdd($this->data['Message']['subject'], $this->data['Message']['message'], $to, [], $attachments);

						$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
					}catch(Exeption $e) {
						$this->Session->setFlash('Il y a un probleme','alert-danger');
					}
				}
				return $this->redirect(array('action' => 'index'));
			}else{
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		}

		$users_db = $this->Message->From->find('all',['conditions' => ['From.id !=' => $this->Session->read('Auth.User.id')]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['From']['id'] ] = $value['From']['nom'].' '.$value['From']['prenom'];
		}

		$this->set( compact('users') );

		$this->getCounts();
	}


	public function sendEmailOnAdd($subject = '', $content = '', $to = [], $cc = [], $attachments = []){
		if( !empty( $to ) /*$parametreSte[ 'Email_all' ] == 1 && $parametreSte[ $keyParametre ] == 1*/ ){
			$this->sendEmail($subject, $content, $to, [], $attachments);
		}
	}

	public function sendEmail($subject = '', $content = '', $to = [], $cc = [], $attachments = []){
		if( !empty($to) ){
			try{
				$Email = new CakeEmail('smtp');
				$Email->from(array('test@gmail.com' => 'Notification'));
				$Email->to( $to );
				$Email->cc( $cc );
				$Email->subject($subject);
				$Email->attachments( $attachments );
				$Email->send($content);

				$this->Session->setFlash('Relance a été bien efectué','alert-success');
			}catch(Exception $e) {
		    	$this->Session->setFlash('Le message a été envoyé en interne mais il a été bloqué en externe !.','alert-danger');
			}
		}
	}

	public function getCounts(){
		$inbox = $this->Message->find('count',['conditions' => ['to_id' => $this->Session->read('Auth.User.id'), 'isread' => '0', 'istrash' => '0'] ]);
		$trash = $this->Message->find('count',['conditions' => ['to_id' => $this->Session->read('Auth.User.id'), 'isread' => '0', 'istrash' => '1'] ]);
		$this->set( compact('inbox','trash') );
	}

	public function uploadAttachment(){
		App::uses('UploadHandler', 'Vendor/UploadHandler');
		$upload_handler = new UploadHandler();
		die;
		$this->layout = false;
	}

	public function trashMessage($id = 0){
		$userSession = $this->Session->read('Auth.User.id');
		$message = $this->Message->find('first',[
			'fields' => ['Message.*','MessagesUser.*'],
			'conditions' => ['Message.id' => $id, 'OR' => ['MessagesUser.user_id' => $userSession, 'Message.from_id' => $userSession] ],
			'joins' => [
	        	['table' => 'messages_users', 'alias' => 'MessagesUser', 'type' => 'INNER', 'conditions' => ['MessagesUser.message_id = Message.id']]
	        ]
		]);

		if( $message['Message']['from_id'] == $userSession ){
			$this->Message->id = $message['Message']['id'];
			if( $this->Message->saveField('istrash',1) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		}else if( $message['MessagesUser']['user_id'] == $userSession ){
			$this->Message->MessagesUser->id = $message['MessagesUser']['id'];
			if( $this->Message->MessagesUser->saveField('istrash',1) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		}else{
				$this->Session->setFlash('Il y a un probleme','alert-danger');
		}
		return $this->redirect(['action' => 'trash']);
	}

}
