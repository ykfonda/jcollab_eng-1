<?php
require '../../vendor/autoload.php';
class GenerateurticketController extends AppController {
	public $idModule = 362;
	 
    public function beforeFilter() {
        parent::beforeFilter();
        // Autoriser l'accès à la fonction 'install' sans authentification
    }


	public function index(){
		$this->loadModel('Produit');



		if ($this->request->is('post')) {

			// Récupérez les données soumises du formulaire
			$formData = $this->request->data;
			$produitId = $formData['Generateurticket']['produit_id'];


			$conditions = array('id' => $produitId);
			$fields = array('libelle', 'code_barre', 'pese');

			$produit = $this->Produit->find('first', array(
				'conditions' => $conditions,
				'fields' => $fields
			));

			if (!empty($produit)) {
				$codeBarre 	= '2900'; // initialisation
				$libelle 	= $produit['Produit']['libelle'];
				$pese 		= $produit['Produit']['pese'];
				$codeBarre .= $produit['Produit']['code_barre'];

				$this->set(compact('libelle', 'codeBarre'));
 
			} else {
				// NOTHING TODO HERE!
			}




			$this->set(compact('formData','libelle'));
		}





		$produits = $this->Produit->findList();
		$this->set(compact('produits'));
		
		$this->getPath($this->idModule);
	}

	public function install(){

			if ($this->request->is('post') || $this->request->is('put')) {
				// Récupérer les données du formulaire
				$data = $this->request->data;
		
				// Modifier la configuration avec l'ID spécifié
				if ($this->Config->save($data)) {
					$this->Session->setFlash('Les informations de configuration ont été mises à jour avec succès.','green');
					$this->redirect('/users/login');
				} else {
					$this->Session->setFlash('Une erreur est survenue lors de la mise à jour des informations de configuration.','red');
				}
			} 

		$details = $this->Config->find('first', [
			'conditions' => ['Config.id' => 1],
			'fields' => [
				'Config.id', 
				'Config.admin_link', 
				'Config.pos_link', 
				'Config.type_app',
				'Config.adresse_ip',
				'Config.caisse_id',
				'Config.store_id',
				'Config.server_link'
			]
		]);
		
		$configID 	= $details['Config']['id'];
		$adminLink 	= $details['Config']['admin_link'];
		$posLink 	= $details['Config']['pos_link'];
		$typeApp 	= $details['Config']['type_app'];
		$adresse_ip = $details['Config']['adresse_ip'];
		$caisse_id 	= $details['Config']['caisse_id'];
		$store_id 	= $details['Config']['store_id'];
		$server_link= $details['Config']['server_link'];
		
		$this->loadModel('Store');
		$storeOptions = $this->Store->find('list');

		$this->loadModel('Caisse');
		$caisseOptions = $this->Caisse->find('list');

		// $this->set(compact('details'));
		$this->set(compact('details', 'storeOptions', 'caisseOptions'));
		$this->getPath($this->idModule);


		$this->layout = 'install';
	}



	public function Getinfo(){
		$details = $this->request->data = $this->Config->find('first',['conditions' => ['Config.id' => 1 ] ]);
		$this->set(compact('details'));

		$config_id 			= $details['Config']['id'];
		$name_app 			= $details['Config']['name_app'];
		$version_app 		= $details['Config']['version_app'];
		$type_app 			= $details['Config']['type_app'];
		$app_last_commit 	= $details['Config']['app_last_commit'];
		$server_link 		= $details['Config']['server_link'];
		$store_id	 		= $details['Config']['store_id'];
		$caisse_id 			= $details['Config']['caisse_id'];
		$adresse_ip 		= $details['Config']['adresse_ip'];
		
		
		return array('name_app' => $name_app, 'adresse_ip' => $adresse_ip, 'server_link' => $server_link, 'version_app' => $version_app, 'type_app' => $type_app, 'app_last_commit' => $app_last_commit, 'caisse_id' => $caisse_id, 'store_id' => $store_id);

		$this->layout = false;
	}


	public function pdf($id = null) {
		$this->request->data = $this->Societe->find('first',['conditions' => ['Societe.id' => 1 ] ]);
		$this->layout = false;
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
