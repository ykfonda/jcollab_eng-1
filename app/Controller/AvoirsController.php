<?php
class AvoirsController extends AppController {
	public $idModule = 82;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Avoir->Client->find('list');
		$users = $this->Avoir->User->findList(['role_id'=>3]);
		$this->set(compact('users','clients','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		if ( $role_id != 1 ) //$conditions['Avoir.user_c'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Avoir.reference' )
					$conditions['Avoir.reference LIKE '] = "%$value%";
				else if( $param_name == 'Avoir.date1' )
					$conditions['Avoir.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Avoir.date2' )
					$conditions['Avoir.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Avoir->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['Avoir.date'=>'DESC','Avoir.id'=>'DESC'],
			'contain'=>['User','Client'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches','user_id'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Avoir->id = $id;
		if (!$this->Avoir->exists()) {
			throw new NotFoundException(__('Invalide return'));
		}

		if ($this->Avoir->flagDelete()) {
			$this->Avoir->Avoirdetail->updateAll(['Avoirdetail.deleted'=>1],['Avoirdetail.avoir_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function view($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Avoir->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Avoir->exists($id)) {
			$options = array('contain'=>['Client','User'],'conditions' => array('Avoir.' . $this->Avoir->primaryKey => $id));
			$this->request->data = $this->Avoir->find('first', $options);

			$details = $this->Avoir->Avoirdetail->find('all',[
				'conditions' => ['Avoirdetail.avoir_id'=>$id],
				'contain' => ['Produit'],
			]);
		}

		$this->set(compact('details','role_id','user_id','flag'));
		$this->getPath($this->idModule);
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$details = [];
		if ($this->Avoir->exists($id)) {
			$options = array('contain'=>['User','Client'],'conditions' => array('Avoir.' . $this->Avoir->primaryKey => $id));
			$this->request->data = $this->Avoir->find('first', $options);
			$details = $this->Avoir->Avoirdetail->find('all',[
				'conditions' => ['Avoirdetail.avoir_id'=>$id],
				'contain' => ['Produit'],
			]);
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('details','user_id','societe'));
		$this->layout = false;
	}
}