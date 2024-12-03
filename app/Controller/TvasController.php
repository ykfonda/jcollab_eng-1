<?php
class TvasController extends AppController {
	public $idModule = 26;
	

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Tva.reference' )
					$conditions['Tva.reference LIKE '] = "%$value%";
				else if( $param_name == 'Tva.libelle' )
					$conditions['Tva.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Tva.date1' )
					$conditions['Tva.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Tva.date2' )
					$conditions['Tva.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Tva->recursive = -1;
		$this->Paginator->settings = ['order'=>['Tva.id'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tva->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else if ($this->Tva->exists($id)) {
			$options = array('conditions' => array('Tva.' . $this->Tva->primaryKey => $id));
			$this->request->data = $this->Tva->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Tva->id = $id;
		if (!$this->Tva->exists()) {
			throw new NotFoundException(__('Invalide catégorie client'));
		}

		if ($this->Tva->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
