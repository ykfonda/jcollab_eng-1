<?php
class ApiController extends AppController {
	public $idModule = 0;
	public $uses = ['User'];

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(['signin']);
	}

	public function signin() {
		$response = [];
		$this->beforeRender();
		$this->autoRender=false;
		$data = $this->request->input ( 'json_decode', true) ;
		if ( isset( $data['username'] ) AND isset( $data['password'] ) ) {
			$this->request->data['User']['username'] = $data['username'];
			$this->request->data['User']['password'] = $data['password'];

			$user = $this->User->find('first',[
				'conditions'=>[
					'User.active' => 1,
					'User.username' => $this->data['User']['username'],
					'User.password' => AuthComponent::password( $this->data['User']['password'] ),
				]
			]);

			if ( isset( $user['User']['id'] ) AND !empty( $user['User']['id'] ) ) {
				$response = [
					'response'=> true,
					'message'=>'Bienvenu '.$user['User']['nom'].' '.$user['User']['prenom'],
					'user' => [
						'id' => $user['User']['id'],
						'nom' => $user['User']['nom'],
						'email' => $user['User']['email'],
						'prenom' => $user['User']['prenom'],
						'token' => $user['User']['password'],
						'username' => $user['User']['username'],
					],
				];
			}else{
				$response = [
					'response'=> false,
					'message'=>'Username ou mot de passe est incorrect',
					'token' => '',
					'user' => [],
				];
			}
		}else{
			$response = [
				'response'=> false,
				'message'=>'Veuillez remplire les champs username et mot de passe',
				'token' => '',
				'user' => [],
			];
		}

		header('Content-Type: application/json; charset=UTF-8');
		die( json_encode( $response ) );
	}
}