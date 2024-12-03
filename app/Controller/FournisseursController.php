<?php
class FournisseursController extends AppController {
	public $idModule = 58;
	

	public function index() {
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Fournisseur.designation' )
					$conditions['Fournisseur.designation LIKE '] = "%$value%";
				else if( $param_name == 'Fournisseur.date1' )
					$conditions['Fournisseur.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Fournisseur.date2' )
					$conditions['Fournisseur.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Fournisseur->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['Fournisseur.date_c'=>'DESC'],
			'contain'=>['Ville','Creator'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Fournisseur->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else if ($this->Fournisseur->exists($id)) {
			$options = array('conditions' => array('Fournisseur.' . $this->Fournisseur->primaryKey => $id));
			$this->request->data = $this->Fournisseur->find('first', $options);
		}
		$villes = $this->Fournisseur->Ville->find('list');
		$this->set(compact('villes'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Fournisseur->id = $id;
		if (!$this->Fournisseur->exists()) {
			throw new NotFoundException(__('Invalide Fournisseur'));
		}

		if ($this->Fournisseur->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}