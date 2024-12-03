<?php
class AdministrateursController extends AppController {
	public $idModule = 56;
	public $uses = ['User'];

	public function index() {
		$stores = $this->User->Store->findList();
		$roles = $this->User->Role->find('list',['conditions' => ['Role.id !='=>1]]);
		$this->set(compact('roles','stores'));
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$conditions = ['User.id !='=>1];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'User.nom' )
					$conditions['User.nom LIKE '] = "%$value%";
				else if( $param_name == 'User.prenom' )
					$conditions['User.prenom LIKE '] = "%$value%";
				else if( $param_name == 'User.email' )
					$conditions['User.email LIKE '] = "%$value%";
				else if( $param_name == 'User.date1' )
					$conditions['User.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'User.date2' )
					$conditions['User.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->User->recursive = -1;
		$this->Paginator->settings = [
			'joins'=>[
				['table' => 'stores_users','alias' => 'StoreUser', 'type' => 'LEFT','conditions' => ['StoreUser.user_id = User.id','StoreUser.deleted = 0']] ,
			],
			'contain'=>['Role','Store','Creator'],
			'order'=>['User.date_c'=>'DESC'],
			'conditions'=>$conditions,
			'group'=>['User.id'],
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {

			$this->validateUsername( $this->data );
			 $findUser = $this->User->find('first',['conditions' => ['password' => AuthComponent::password($this->data['User']['password'])] ]);
			if ( isset( $this->data['User']['password'] ) AND !empty( $this->data['User']['password'] ) ) 
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			if(empty($findUser)){
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->User->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		    }else{
		    	$this->Session->setFlash('Ce mot de passe déja utilisé par un autre utilisateur','alert-danger');
				return $this->redirect(array('action' => 'index'));
		    }
		} else if ($this->User->exists($id)) {
			$options = array('contain'=>['Store'],'conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list',['conditions' => ['Role.id !='=>1]]);
		$stores = $this->User->Store->findList();
		$this->set(compact('roles','stores'));
		$this->layout = false;
	}

	public function view($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->validateUsername( $this->data );
			if ( isset( $this->data['User']['password'] ) AND !empty( $this->data['User']['password'] ) ) 
				$this->request->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->User->exists($id)) {
			$options = array('contain'=>['Store'],'conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list',['conditions' => ['Role.id !='=>1]]);
		$pays = $this->User->Pay->find('list');
		$villes = $this->User->Ville->find('list');
		$stores = $this->User->Store->findList();
		$this->set(compact('pays','villes','roles','stores'));
		$this->getPath($this->idModule);
	}

	public function changepassword(){
		if ($this->request->is(array('post', 'put'))) {
			$user = $this->User->find('first',[
				'conditions' => [
					'User.id' => $this->data['User']['id'], 
					'User.password' => AuthComponent::password($this->data['User']['Oldpassword'])
				] 
			]);

			if( !empty($user) ){
				if( $this->data['User']['Newpassword'] == $this->data['User']['Newpassword2'] && !empty($this->data['User']['Newpassword']) ){
					$data = [
						'User' => [
							'id' => $this->data['User']['id'], 
							'password' => AuthComponent::password($this->data['User']['Newpassword'])
						] 
					];
					if( $this->User->save($data) ){
						$this->Session->setFlash('Le mot de passe a été changé avec succès.','alert-success');
					}else{
						$this->Session->setFlash('Il y a un problème','alert-danger');
					}
				}else{
					$this->Session->setFlash('La confirmation du mot de passe ne correspond pas !','alert-danger');
				}
			}else{
				$this->Session->setFlash('Ancien mot de passe est incorrect','alert-danger');
			}
		}

		return $this->redirect( $this->referer() );
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			$this->Session->setFlash("Cette utilisateur n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		if ($this->User->delete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}