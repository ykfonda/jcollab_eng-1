<?php
App::uses('Uploadfile', 'Lib');
class CategorieproduitsController extends AppController {
	public $idModule = 26;
	

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Categorieproduit.abr' )
					$conditions['Categorieproduit.abr LIKE '] = "%$value%";
				else if( $param_name == 'Categorieproduit.libelle' )
					$conditions['Categorieproduit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Categorieproduit.date1' )
					$conditions['Categorieproduit.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Categorieproduit.date2' )
					$conditions['Categorieproduit.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Categorieproduit->recursive = -1;
		$this->Paginator->settings = ['order'=>['Categorieproduit.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {

			if ( isset( $this->data['Categorieproduit']['image'] ) ) unset( $this->request->data['Categorieproduit']['image'] );
			if ( isset( $_FILES['data']['name']['Categorieproduit']['image'] ) AND !empty( $_FILES['data']['name']['Categorieproduit']['image'] ) ) {
				$uploadfile = new Uploadfile();
				$basenameSlug = $uploadfile->convertBaseName($_FILES['data']['name']['Categorieproduit']['image']);
				$file_name = $basenameSlug;
				$file_tmp = $_FILES['data']['tmp_name']['Categorieproduit']['image'];
				$size = $_FILES['data']['size']['Categorieproduit']['image'];
				$dest_dossier = str_replace('\\', '/', WWW_ROOT."uploads\\category_images\\");
				if ( !is_dir( $dest_dossier ) ) { mkdir($dest_dossier, 0777, true); }
				if (!empty($this->data['Categorieproduit']['id'])){
					$options = array('conditions' => array('Categorieproduit.' . $this->Categorieproduit->primaryKey => $id));
					$produit = $this->Categorieproduit->find('first', $options);
					if(empty($file_name) AND !empty($produit['Categorieproduit']['image'])) {
						$this->request->data['Categorieproduit']['image'] = $produit['Categorieproduit']['image'];
					}else if(!empty($file_name)){
						$this->request->data['Categorieproduit']['image'] = $file_name;
					}
				}else{
					if (empty($file_name)) $file_name = 'default.jpg';
					else $this->request->data['Categorieproduit']['image'] = $file_name;
				}

				if (!empty($file_name)) move_uploaded_file($file_tmp, $dest_dossier.$file_name);
			}
			
			if ($this->Categorieproduit->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		} else if ($this->Categorieproduit->exists($id)) {
			$options = array('conditions' => array('Categorieproduit.' . $this->Categorieproduit->primaryKey => $id));
			$this->request->data = $this->Categorieproduit->find('first', $options);
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Categorieproduit->id = $id;
		if (!$this->Categorieproduit->exists()) {
			throw new NotFoundException(__('Invalide catégorie client'));
		}

		if ($this->Categorieproduit->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}