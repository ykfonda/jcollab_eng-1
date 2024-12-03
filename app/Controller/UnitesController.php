<?php
class UnitesController extends AppController {
	public $idModule = 26;
	
	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Unite.abr' )
					$conditions['Unite.abr LIKE '] = "%$value%";
				else if( $param_name == 'Unite.libelle' )
					$conditions['Unite.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Unite.date1' )
					$conditions['Unite.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Unite.date2' )
					$conditions['Unite.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Unite->recursive = -1;
		$this->Paginator->settings = ['order'=>['Unite.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Unite->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Unite->exists($id)) {
			$options = array('conditions' => array('Unite.' . $this->Unite->primaryKey => $id));
			$this->request->data = $this->Unite->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Unite->id = $id;
		if (!$this->Unite->exists()) {
			throw new NotFoundException(__('Invalide unité'));
		}

		if ($this->Unite->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}