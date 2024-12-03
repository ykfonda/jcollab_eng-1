<?php
App::uses('AppController', 'Controller');

class VillesController extends AppController {
	public $idModule = 26;
	

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('getVilles');
	}

	public function getVilles($pay = 0){
		$villes = $this->Ville->find('list',['conditions' => ['Ville.pay_id' => $pay] ]);
		header('Content-Type: application/json; charset=UTF-8');
		die(json_encode( $villes ));
	}

	public function index() {
		$pays = $this->Ville->Pay->find('list');
		$this->getPath($this->idModule);
		$this->set(compact('pays'));
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Ville.abr' )
					$conditions['Ville.abr LIKE '] = "%$value%";
				else if( $param_name == 'Ville.libelle' )
					$conditions['Ville.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Ville.date1' )
					$conditions['Ville.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Ville.date2' )
					$conditions['Ville.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Ville->recursive = -1;
		$this->Paginator->settings = ['contain'=>['Pay'],'limit'=>15,'order'=>['Ville.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ville->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else if ($this->Ville->exists($id)) {
			$options = array('conditions' => array('Ville.' . $this->Ville->primaryKey => $id));
			$this->request->data = $this->Ville->find('first', $options);
		}

		$pays = $this->Ville->Pay->find('list');
		$this->set(compact('pays'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Ville->id = $id;
		if (!$this->Ville->exists()) {
			throw new NotFoundException(__('Invalide ville'));
		}

		if ($this->Ville->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
