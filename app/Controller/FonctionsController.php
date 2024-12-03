<?php
App::uses('AppController', 'Controller');

class FonctionsController extends AppController {

	public $idModule = 1;
	

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Fonction.abr' )
					$conditions['Fonction.abr LIKE '] = "%$value%";
				else if( $param_name == 'Fonction.libelle' )
					$conditions['Fonction.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Fonction.date1' )
					$conditions['Fonction.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Fonction.date2' )
					$conditions['Fonction.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Fonction->recursive = -1;
		$this->Paginator->settings = ['order'=>['Fonction.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Fonction->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		} else if ($this->Fonction->exists($id)) {
			$options = array('conditions' => array('Fonction.' . $this->Fonction->primaryKey => $id));
			$this->request->data = $this->Fonction->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Fonction->id = $id;
		if (!$this->Fonction->exists()) {
			throw new NotFoundException(__('Invalide Fonction'));
		}

		if ($this->Fonction->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un probleme','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

}
