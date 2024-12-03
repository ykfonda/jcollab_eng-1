<?php
App::uses('AppController', 'Controller');
class SynchronisationsController extends AppController {
	public $idModule = 358;
	 

	public function index(){
		if( $this->request->is('put') ){
			if( $this->Societe->save( $this->data ) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}

		$details = $this->request->data = $this->Synchronisation->find('first');
		$this->set(compact('details'));
		$this->getPath($this->idModule);
	}

	public function add(){
		if( $this->request->is('put') ){
			if( $this->Societe->save( $this->data ) ){
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}

		$details = $this->request->data = $this->Synchronisation->find('first');
		$this->set(compact('details'));
		$this->getPath($this->idModule);
	}

	public function Getinfo(){
		$details = $this->request->data = $this->Config->find('first',['conditions' => ['Config.id' => 1 ] ]);
		$this->set(compact('details'));

		$name_app 			= $details['Config']['name_app'];
		$version_app 		= $details['Config']['version_app'];
		$type_app 			= $details['Config']['type_app'];
		$app_last_commit 	= $details['Config']['app_last_commit'];
		$server_link 	= $details['Config']['server_link'];
		
		 
	
		return array('name_app' => $name_app,'server_link' => $server_link, 'version_app' => $version_app, 'type_app' => $type_app, 'app_last_commit' => $app_last_commit);

		$this->layout = false;
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
