<?php
class KitchensystemsController extends AppController {
	public $idModule = 133;
	
	public function index() {
		$stores = $this->Kitchensystem->Store->findList();
		$societes = $this->Kitchensystem->Societe->findList();
		$this->set(compact('stores','societes'));
		$this->getPath($this->idModule);
	}

	public function societe($store_id = null) {
		$store = $this->Kitchensystem->Store->find('first',['conditions' => ['Store.id' => $store_id]]);
		$societe_id = ( isset( $store['Store']['societe_id'] ) AND !empty( $store['Store']['societe_id'] ) ) ? $store['Store']['societe_id'] : '' ;
		die( json_encode( [ 'societe_id' => $societe_id ] ) );
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Kitchensystem.reference' )
					$conditions['Kitchensystem.reference LIKE '] = "%$value%";
				else if( $param_name == 'Kitchensystem.libelle' )
					$conditions['Kitchensystem.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Kitchensystem.date1' )
					$conditions['Kitchensystem.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Kitchensystem.date2' )
					$conditions['Kitchensystem.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Paginator->settings = ['contain'=>['Store','Societe','Produit'],'order'=>['Kitchensystem.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate('Kitchensystem');
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function view($kitchensystem_id = null) {
		$details = [];
		if ($this->Kitchensystem->exists($kitchensystem_id)) {
			$options = array('contain'=>['Store','Societe','Produit'],'conditions' => array('Kitchensystem.' . $this->Kitchensystem->primaryKey => $kitchensystem_id));
			$this->request->data = $this->Kitchensystem->find('first', $options);
			$details = $this->Kitchensystem->Produit->find('all',[
				'fields' => ['Produit.id','Produit.reference','Produit.libelle','Kitchensystemproduit.id','Kitchensystemproduit.date_c'],
				'joins'=>[
					['table' => 'kitchensystems_produits','alias' => 'Kitchensystemproduit', 'type' => 'INNER','conditions' => ['Kitchensystemproduit.produit_id = Produit.id','Kitchensystemproduit.deleted = 0']] ,
				],
				'conditions' => ['Kitchensystemproduit.kitchensystem_id' => $kitchensystem_id]
			]);
		}
		$this->getPath($this->idModule);
		$this->set(compact('details'));
	}

	public function edit($id = null) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Kitchensystem->saveAssociated($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Kitchensystem->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Kitchensystem->exists($id)) {
			$options = array('contain'=>['Produit'],'conditions' => array('Kitchensystem.' . $this->Kitchensystem->primaryKey => $id));
			$this->request->data = $this->Kitchensystem->find('first', $options);
		}
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];
		$produits = $this->Kitchensystem->Produit->findList($settings);
		$societes = $this->Kitchensystem->Societe->findList();
		$stores = $this->Kitchensystem->Store->findList();
		$this->set(compact('stores','societes','produits'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Kitchensystem->id = $id;
		if (!$this->Kitchensystem->exists()) throw new NotFoundException(__('Invalide KDS'));

		if ($this->Kitchensystem->flagDelete()) $this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		else $this->Session->setFlash('Il y a un problème','alert-danger');
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Kitchensystem->Kitchensystemproduit->id = $id;
		if (!$this->Kitchensystem->Kitchensystemproduit->exists()) throw new NotFoundException(__('Invalide KDS'));

		if ($this->Kitchensystem->Kitchensystemproduit->delete()) $this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		else $this->Session->setFlash('Il y a un problème','alert-danger');
		return $this->redirect($this->referer());
	}
}