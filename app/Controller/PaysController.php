<?php
App::uses('AppController', 'Controller');

class PaysController extends AppController {
	public $idModule = 26;
	

	public function index() {
		$this->Pay->recursive = 0;
		$this->Paginator->settings = ['limit'=>15];
		$this->set('pays', $this->Paginator->paginate());

		$this->getPath($this->idModule);
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Pay->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un probleme','alert-danger');
			}
		} else if ($this->Pay->exists($id)) {
			$options = array('conditions' => array('Pay.' . $this->Pay->primaryKey => $id));
			$this->request->data = $this->Pay->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Pay->id = $id;
		if (!$this->Pay->exists()) {
			throw new NotFoundException(__('Invalide pay'));
		}
		if ($this->Pay->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un probleme','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
