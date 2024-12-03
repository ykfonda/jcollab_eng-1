<?php
class TablesController extends AppController {
	public $idModule = 128;

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Table.reference' )
					$conditions['Table.reference LIKE '] = "%$value%";
				else if( $param_name == 'Table.libelle' )
					$conditions['Table.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Table.date1' )
					$conditions['Table.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Table.date2' )
					$conditions['Table.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Table->recursive = -1;
		$this->Paginator->settings = ['order'=>['Table.id'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Table->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else if ($this->Table->exists($id)) {
			$options = array('conditions' => array('Table.' . $this->Table->primaryKey => $id));
			$this->request->data = $this->Table->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Table->id = $id;
		if (!$this->Table->exists()) {
			throw new NotFoundException(__('Invalide table'));
		}

		if ($this->Table->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}