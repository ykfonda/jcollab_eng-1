<?php
class EntreprisesController extends AppController {
	public $idModule = 37;
	public $uses = ['Societe'];

	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Societe.abr' )
					$conditions['Societe.abr LIKE '] = "%$value%";
				else if( $param_name == 'Societe.designation' )
					$conditions['Societe.designation LIKE '] = "%$value%";
				else if( $param_name == 'Societe.date1' )
					$conditions['Societe.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Societe.date2' )
					$conditions['Societe.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Societe->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Pdfmodele'],
			'conditions'=>$conditions,
			'order'=>['Societe.designation'=>'ASC'],
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Societe->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Societe->exists($id)) {
			$options = array('conditions' => array('Societe.' . $this->Societe->primaryKey => $id));
			$this->request->data = $this->Societe->find('first', $options);
		}
		$clients = $this->Societe->Client->find('list');
		$fournisseurs = $this->Societe->Fournisseur->find('list');
		$pdfmodeles = $this->Societe->Pdfmodele->find('list');
		$this->set(compact('pdfmodeles','clients','fournisseurs'));
		$this->layout = false;
	}

	public function view($id = null) {

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Societe->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Societe->exists($id)) {
			$options = array('conditions' => array('Societe.' . $this->Societe->primaryKey => $id));
			$this->request->data = $this->Societe->find('first', $options);
		}

		$pdfmodeles = $this->Societe->Pdfmodele->find('list');
		$this->set(compact('pdfmodeles'));
		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		$this->Societe->id = $id;
		if (!$this->Societe->exists()) {
			throw new NotFoundException(__('Invalide Societe'));
		}

		if ($this->Societe->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function saveImage($id = null){
		if( $this->request->is(['put','post']) ){
			$data = $this->data;
			$filename = $this->convertBaseName( $this->data['Societe']['avatar']['name'] , $id );
			$path = '/img'.DS.'logo'.DS.$filename;
			$b = move_uploaded_file($this->data['Societe']['avatar']['tmp_name'],WWW_ROOT.$path);
			
			if( $b ){
				$this->Societe->id = $id;
				$this->Societe->saveField('avatar', $path);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		}
	}

	private function convertBaseName($basename,$id = null){
		$time = date('i');
		$file_info = pathinfo($basename);
		$basenameSlug = $id.'-'.$time.'.'.$file_info['extension'];
		return $basenameSlug;
	}
}