<?php
class FabricationsController extends AppController {
	public $idModule = 122;
	

	public function index() {
		$users = $this->Fabrication->User->findList();
		$this->getPath($this->idModule);
		$this->set(compact('users'));
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Fabrication.reference' )
					$conditions['Fabrication.reference LIKE '] = "%$value%";
				else if( $param_name == 'Fabrication.libelle' )
					$conditions['Fabrication.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Fabrication.date1' )
					$conditions['Fabrication.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Fabrication.date2' )
					$conditions['Fabrication.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Fabrication->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User'],'order'=>['Fabrication.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Fabrication->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Fabrication->exists($id)) {
			$options = array('conditions' => array('Fabrication.' . $this->Fabrication->primaryKey => $id));
			$this->request->data = $this->Fabrication->find('first', $options);
		}
		$users = $this->Fabrication->User->findList();
		$this->set(compact('users'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Fabrication->id = $id;
		if (!$this->Fabrication->exists()) throw new NotFoundException(__('Invalide Fabrication'));

		if ($this->Fabrication->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}