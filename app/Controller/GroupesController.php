<?php
class GroupesController extends AppController {
	public $idModule = 112;
	

	public function index() {
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Groupe.libelle' )
					$conditions['Groupe.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Groupe.date1' )
					$conditions['Groupe.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Groupe.date2' )
					$conditions['Groupe.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Groupe->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User'],'order'=>['Groupe.date_c'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Groupe->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Groupe->exists($id)) {
			$options = array('contain'=>['User'],'conditions' => array('Groupe.' . $this->Groupe->primaryKey => $id));
			$this->request->data = $this->Groupe->find('first', $options);
		}
		$users = [];
		$users_db = $this->Groupe->User->find('all');
		foreach ($users_db as $key => $value) { $users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom']; }
		$this->layout = false;
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Groupe->id = $id;
		if (!$this->Groupe->exists()) {
			throw new NotFoundException(__('Invalide groupe'));
		}

		if ($this->Groupe->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}