<?php
class SessionsController extends AppController {
	public $idModule = 26;
	
	public $uses = ['Lastsession'];

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$admins = $this->Auth->Session->read('admins');
		$user_id = $this->Auth->Session->read('Auth.User.id');
		$role_id = $this->Auth->Session->read('Auth.User.role_id');
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Lastsession.login' )
					$conditions['Lastsession.login LIKE '] = "%$value%";
				else if( $param_name == 'Lastsession.date1' )
					$conditions['Lastsession.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Lastsession.date2' )
					$conditions['Lastsession.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Lastsession->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User'],'order'=>['Lastsession.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches','admins','role_id'));
		$this->layout = false;
	}

	public function disconnect($id = null) {
		$this->Lastsession->id = $id;
		if ($this->Lastsession->saveField('logout',-1)) {
			$this->Session->setFlash("L'action a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}