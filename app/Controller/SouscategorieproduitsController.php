<?php
class SouscategorieproduitsController extends AppController {
	public $idModule = 26;
	

	public function index() {
		$categorieproduits = $this->Souscategorieproduit->Categorieproduit->find('list',['order'=>'libelle asc']);
		$this->set(compact('categorieproduits'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Souscategorieproduit.abr' )
					$conditions['Souscategorieproduit.abr LIKE '] = "%$value%";
				else if( $param_name == 'Souscategorieproduit.libelle' )
					$conditions['Souscategorieproduit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Souscategorieproduit.date1' )
					$conditions['Souscategorieproduit.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Souscategorieproduit.date2' )
					$conditions['Souscategorieproduit.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Souscategorieproduit->recursive = -1;
		$this->Paginator->settings = ['contain'=>['Categorieproduit'],'order'=>['Souscategorieproduit.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Souscategorieproduit->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Souscategorieproduit->exists($id)) {
			$options = array('conditions' => array('Souscategorieproduit.' . $this->Souscategorieproduit->primaryKey => $id));
			$this->request->data = $this->Souscategorieproduit->find('first', $options);
		}
		$categorieproduits = $this->Souscategorieproduit->Categorieproduit->find('list',['order'=>'libelle asc']);
		$this->set(compact('categorieproduits'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Souscategorieproduit->id = $id;
		if (!$this->Souscategorieproduit->exists()) {
			throw new NotFoundException(__('Invalide catégorie client'));
		}

		if ($this->Souscategorieproduit->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}