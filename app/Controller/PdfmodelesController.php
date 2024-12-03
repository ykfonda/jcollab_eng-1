<?php
App::uses('Uploadfile', 'Lib');
class PdfmodelesController extends AppController {
	public $idModule = 115;

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Pdfmodele.abr' )
					$conditions['Pdfmodele.abr LIKE '] = "%$value%";
				else if( $param_name == 'Pdfmodele.designation' )
					$conditions['Pdfmodele.designation LIKE '] = "%$value%";
				else if( $param_name == 'Pdfmodele.date1' )
					$conditions['Pdfmodele.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Pdfmodele.date2' )
					$conditions['Pdfmodele.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Pdfmodele->recursive = -1;
		$this->Paginator->settings = ['order'=>['Pdfmodele.designation'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {

			if ( isset( $this->data['Pdfmodele']['image'] ) ) unset( $this->request->data['Pdfmodele']['image'] );
			if ( isset( $_FILES['data']['name']['Pdfmodele']['image'] ) AND !empty( $_FILES['data']['name']['Pdfmodele']['image'] ) ) {
				$uploadfile = new Uploadfile();
				$file_name = $uploadfile->convertBaseName($_FILES['data']['name']['Pdfmodele']['image']);
				$file_tmp = $_FILES['data']['tmp_name']['Pdfmodele']['image'];
				$size = $_FILES['data']['size']['Pdfmodele']['image'];
				$dest_dossier = str_replace('\\', '/', WWW_ROOT."uploads".DS."modeles".DS."");
				if ( !is_dir( $dest_dossier ) ) { mkdir($dest_dossier, 0777, true); }
				if (!empty($this->data['Pdfmodele']['id'])){
					$options = array('conditions' => array('Pdfmodele.' . $this->Pdfmodele->primaryKey => $id));
					$produit = $this->Pdfmodele->find('first', $options);
					if(empty($file_name) AND !empty($produit['Pdfmodele']['image'])) {
						$this->request->data['Pdfmodele']['image'] = $produit['Pdfmodele']['image'];
					}else if(!empty($file_name)){
						$this->request->data['Pdfmodele']['image'] = $file_name;
					}
				}else{
					if (empty($file_name)) $file_name = null;
					else $this->request->data['Pdfmodele']['image'] = $file_name;
				}

				if (!empty($file_name)) move_uploaded_file($file_tmp, $dest_dossier.$file_name);
			}

			if ($this->Pdfmodele->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Pdfmodele->exists($id)) {
			$options = array('conditions' => array('Pdfmodele.' . $this->Pdfmodele->primaryKey => $id));
			$this->request->data = $this->Pdfmodele->find('first', $options);
		}

		$this->layout = false;
	}

	public function view($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Pdfmodele->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Pdfmodele->exists($id)) {
			$options = array('conditions' => array('Pdfmodele.' . $this->Pdfmodele->primaryKey => $id));
			$this->request->data = $this->Pdfmodele->find('first', $options);
		}

		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		$this->Pdfmodele->id = $id;
		if (!$this->Pdfmodele->exists()) {
			throw new NotFoundException(__('Invalide Pdfmodele'));
		}

		if ($this->Pdfmodele->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}