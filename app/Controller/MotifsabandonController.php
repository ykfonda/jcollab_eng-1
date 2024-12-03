<?php
class MotifsabandonController extends AppController {

	public $idModule = 26;
	
	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Motifsabandon.libelle' )
					$conditions['Motifsabandon.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Motifsabandon.date1' )
					$conditions['Motifsabandon.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Motifsabandon.date2' )
					$conditions['Motifsabandon.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Motifsabandon->recursive = -1;
		$this->Paginator->settings = ['order'=> ['Motifsabandon.id'=>'DESC'], 'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Motifsabandon->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème', 'alert-danger');
			}
		} else if ($this->Motifsabandon->exists($id)) {
			$options = array('conditions' => array('Motifsabandon.' . $this->Motifsabandon->primaryKey => $id));
			$this->request->data = $this->Motifsabandon->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Motifsabandon->id = $id;
		if (!$this->Motifsabandon->exists()) {
			throw new NotFoundException(__('Invalide catégorie client'));
		}

		if ($this->Motifsabandon->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
