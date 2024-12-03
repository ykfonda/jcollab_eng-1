<?php
App::uses('AppController', 'Controller');
class SocietesController extends AppController {
	public $idModule = 37;
	 

	public function index(){
		if( $this->request->is('put') ){
			if( $this->Societe->save( $this->data ) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}

		$this->request->data = $this->Societe->find('first',['conditions' => ['Societe.id' => 1 ] ]);
		$this->getPath($this->idModule);
	}

	public function pdf($id = null) {
		$this->request->data = $this->Societe->find('first',['conditions' => ['Societe.id' => 1 ] ]);
		$this->layout = false;
	}

	public function edit(){
		if( $this->request->is('put') ){
			if( $this->Societe->save( $this->data ) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function saveImage(){
		$idS = 1;
		if( $this->request->is(['put','post']) ){
			$data = $this->data;
			$filename = $this->convertBaseName( $this->data['Societe']['avatar']['name'] , $idS );
			$path = 'img'.DS.'logo'.DS.$filename;
			$b = move_uploaded_file($this->data['Societe']['avatar']['tmp_name'],WWW_ROOT.$path);
			
			if( $b ){
				$this->Societe->id = $idS;
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
