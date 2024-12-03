<?php
class CategoriedepencesController extends AppController {
	public $idModule = 108;
	

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions['Categoriedepence.id !='] = 1;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Categoriedepence.reference' )
					$conditions['Categoriedepence.reference LIKE '] = "%$value%";
				else if( $param_name == 'Categoriedepence.libelle' )
					$conditions['Categoriedepence.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Categoriedepence.date1' )
					$conditions['Categoriedepence.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Categoriedepence.date2' )
					$conditions['Categoriedepence.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Categoriedepence->recursive = -1;
		$this->Paginator->settings = ['order'=>['Categoriedepence.id'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Categoriedepence->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Categoriedepence->exists($id)) {
			$options = array('conditions' => array('Categoriedepence.' . $this->Categoriedepence->primaryKey => $id));
			$this->request->data = $this->Categoriedepence->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Categoriedepence->id = $id;
		if (!$this->Categoriedepence->exists()) {
			throw new NotFoundException(__('Invalide catégorie dépence'));
		}

		if ($this->Categoriedepence->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}