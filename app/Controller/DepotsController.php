<?php
class DepotsController extends AppController {
	public $idModule = 110;

	public function index() {
		$stores = $this->Depot->Store->findList();
		$this->set(compact('stores'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$conditions = ['Depot.store_id' => $selected_store];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page', 'sort', 'direction', 'limit'))){
				if( $param_name == 'Depot.reference' )
					$conditions['Depot.reference LIKE '] = "%$value%";
				else if( $param_name == 'Depot.libelle' )
					$conditions['Depot.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Depot.date1' )
					$conditions['Depot.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Depot.date2' )
					$conditions['Depot.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Depot->recursive = -1;
		$this->Paginator->settings = ['contain'=>['Store','Societe'], 'order'=>['Depot.reference'=>'ASC'], 'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function societe($store_id = null) {
		$store = $this->Depot->Store->find('first', ['conditions' => ['Store.id' => $store_id]]);
		$societe_id = ( isset( $store['Store']['societe_id'] ) AND !empty( $store['Store']['societe_id'] ) ) ? $store['Store']['societe_id'] : '' ;
		die( json_encode( [ 'societe_id' => $societe_id ] ) );
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
		 	$this->request->data['Depot']['principal'] = ( isset( $this->request->data['Depot']['principal'] ) AND $this->request->data['Depot']['principal'] == 1 ) ? 1 : -1 ;
		 	$this->request->data['Depot']['vente'] = ( isset( $this->request->data['Depot']['vente'] ) AND $this->request->data['Depot']['vente'] == 1 ) ? 1 : -1 ;
			if ($this->Depot->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Depot->exists($id)) {
			$options = array('conditions' => array('Depot.' . $this->Depot->primaryKey => $id));
			$this->request->data = $this->Depot->find('first', $options);
		 	$this->request->data['Depot']['principal'] = ( isset( $this->request->data['Depot']['principal'] ) AND $this->request->data['Depot']['principal'] == 1 ) ? true : false ;
		 	$this->request->data['Depot']['vente'] = ( isset( $this->request->data['Depot']['vente'] ) AND $this->request->data['Depot']['vente'] == 1 ) ? true : false ;
		}
		$stores = $this->Depot->Store->findList();
		$societes = $this->Depot->Societe->findList();
		$this->set(compact('stores','societes'));
		$this->layout = false;
	}
	

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}

		$this->Depot->id = $id;
		if (!$this->Depot->exists()) {
			throw new NotFoundException(__('Invalide dépot'));
		}

		if ($this->Depot->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}