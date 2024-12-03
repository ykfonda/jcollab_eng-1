<?php
App::uses('Uploadfile', 'Lib');
class ProduitsController extends AppController {
	
	protected $idModule = 67;

	public function index() {
		$categorieproduits = $this->Produit->Categorieproduit->find('list',['order'=>['libelle'=>'ASC'] ]);
		$souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order'=>'id asc']);
		$unites = $this->Produit->Unite->find('list', ['order'=>'libelle asc']);
		$this->set(compact('categorieproduits', 'unites', 'souscategorieproduits'));
		$this->getPath($this->idModule);
	}

	public function pdf($id=null){
		if ($this->Produit->exists($id)) {
			$options = array('conditions' => array('Produit.' . $this->Produit->primaryKey => $id));
			$this->request->data = $this->Produit->find('first', $options);
		} else {
			$this->Session->setFlash("Ce produit n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}
		$this->set(compact('params'));
		$this->layout = false;
	}
	
	public function excel(){
		$conditions['Produit.type'] = 1;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.reference' )
					$conditions['Produit.reference LIKE '] = "%$value%";
				else if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Produit.code_barre' )
					$conditions['Produit.code_barre LIKE '] = "%$value%";
				else if( $param_name == 'Produit.date1' )
					$conditions['Produit.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Produit.date2' )
					$conditions['Produit.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$settings = [
			'contain'=>['Categorieproduit', 'Souscategorieproduit', 'Unite','Creator','Segment'],
			'order'=>['Produit.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Produit->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}
	
	public function indexAjax(){
		$conditions['Produit.type'] = 1;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.reference' )
					$conditions['Produit.reference LIKE '] = "%$value%";
				else if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Produit.code_barre' )
					$conditions['Produit.code_barre LIKE '] = "%$value%";
				else if( $param_name == 'Produit.date1' )
					$conditions['Produit.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Produit.date2' )
					$conditions['Produit.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Produit->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Categorieproduit', 'Souscategorieproduit', 'Unite','Creator','Segment'],
			'order'=>['Produit.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function ingredients($produit_id = null) {
		$ingredients = $this->Produit->Produitingredient->find('all',[
			'conditions'=> ['Produitingredient.produit_id' => $produit_id],
			'order' => ['Produitingredient.id'=>'DESC'],
			'contain' => ['Ingredient'],
		]);
		$this->set(compact('ingredients','produit_id'));
		$this->layout = false;
	}

	public function editingredient($id = null,$produit_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Produitingredient']['produit_id'] = $produit_id;
			if ($this->Produit->Produitingredient->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Produit->Produitingredient->exists($id)) {
			$options = array('conditions' => array('Produitingredient.' . $this->Produit->Produitingredient->primaryKey => $id));
			$this->request->data = $this->Produit->Produitingredient->find('first', $options);
		}
		$ingredients = $this->Produit->findList(['type'=>2]);
		$this->set(compact('ingredients','produit_id'));
		$this->layout = false;
	}

	public function deleteingredient($id = null) {
		$this->Produit->Produitingredient->id = $id;
		if (!$this->Produit->Produitingredient->exists()) throw new NotFoundException(__('Invalide Ingredient'));

		if ($this->Produit->Produitingredient->delete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect($this->referer());
	}

	public function societeprices($produit_id = null) {
		$prices = $this->Produit->Produitprice->find('all',[
			'fields' => ['Produitprice.*','Societe.designation'],
			'conditions'=> ['Produitprice.produit_id' => $produit_id],
			'joins' => [
				['table' => 'societes', 'alias' => 'Societe', 'type' => 'INNER', 'conditions' => ['Produitprice.societe_id = Societe.id'] ],
			],
			'order' => ['Produitprice.id'=>'DESC']
		]);

		$this->set(compact('prices','produit_id'));
		$this->layout = false;
	}

	public function fournisseurprices($produit_id = null) {
		$prices = $this->Produit->Produitprice->find('all',[
			'fields' => ['Produitprice.*','Fournisseur.designation'],
			'conditions'=> ['Produitprice.produit_id' => $produit_id],
			'joins' => [
				['table' => 'fournisseurs', 'alias' => 'Fournisseur', 'type' => 'INNER', 'conditions' => ['Produitprice.fournisseur_id = Fournisseur.id'] ],
			],
			'order' => ['Produitprice.id'=>'DESC']
		]);

		$this->set(compact('prices','produit_id'));
		$this->layout = false;
	}

	public function editsocieteprice($id = null,$produit_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Produitprice']['produit_id'] = $produit_id;
			if ($this->Produit->Produitprice->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Produit->Produitprice->exists($id)) {
			$options = array('conditions' => array('Produitprice.' . $this->Produit->Produitprice->primaryKey => $id));
			$this->request->data = $this->Produit->Produitprice->find('first', $options);
		}
		$societes = $this->Produit->Produitprice->Societe->find('list');
		$this->set(compact('societes','produit_id'));
		$this->layout = false;
	}

	public function editfournisseurprice($id = null,$produit_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Produitprice']['produit_id'] = $produit_id;
			if ($this->Produit->Produitprice->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Produit->Produitprice->exists($id)) {
			$options = array('conditions' => array('Produitprice.' . $this->Produit->Produitprice->primaryKey => $id));
			$this->request->data = $this->Produit->Produitprice->find('first', $options);
		}
		$fournisseurs = $this->Produit->Produitprice->Fournisseur->find('list');
		$this->set(compact('fournisseurs','produit_id'));
		$this->layout = false;
	}

	public function deleteprice($id = null) {
		$this->Produit->Produitprice->id = $id;
		if (!$this->Produit->Produitprice->exists()) throw new NotFoundException(__('Invalide price'));

		if ($this->Produit->Produitprice->delete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect($this->referer());
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {		
			if ( isset( $this->data['Produit']['image'] ) ) unset( $this->request->data['Produit']['image'] );
			if ( isset( $_FILES['data']['name']['Produit']['image'] ) AND !empty( $_FILES['data']['name']['Produit']['image'] ) ) {
				$uploadfile = new Uploadfile();
				$basenameSlug = $uploadfile->convertBaseName($_FILES['data']['name']['Produit']['image']);
				$file_name = $basenameSlug;
				$file_tmp = $_FILES['data']['tmp_name']['Produit']['image'];
				$size = $_FILES['data']['size']['Produit']['image'];
				$dest_dossier = str_replace('\\', '/', WWW_ROOT."uploads\\articles_images\\");
				if ( !is_dir( $dest_dossier ) ) { mkdir($dest_dossier, 0777, true); }
				if (!empty($this->data['Produit']['id'])){
					$options = array('conditions' => array('Produit.' . $this->Produit->primaryKey => $id));
					$produit = $this->Produit->find('first', $options);
					if(empty($file_name) AND !empty($produit['Produit']['image'])) {
						$this->request->data['Produit']['image'] = $produit['Produit']['image'];
					}else if(!empty($file_name)){
						$this->request->data['Produit']['image'] = $file_name;
					}
				}else{
					if (empty($file_name)) $file_name = 'default.jpg';
					else $this->request->data['Produit']['image'] = $file_name;
				}

				if (!empty($file_name)) move_uploaded_file($file_tmp, $dest_dossier.$file_name);
			}
			$this->request->data['Produit']['type'] = 1;
			if ($this->Produit->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Produit->exists($id)) {
			$options = array('conditions' => array('Produit.' . $this->Produit->primaryKey => $id));
			$this->request->data = $this->Produit->find('first', $options);
		}

		$tvas = $this->Produit->TvaAchat->findList();
		$unites = $this->Produit->Unite->find('list',['order'=>'libelle asc']);
		$segments = $this->Produit->Segment->find('list',['order'=>'libelle asc']);
		$categorieproduits = $this->Produit->Categorieproduit->find('list', ['order'=>'libelle asc']);
		$souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order'=>'libelle asc']);
		$this->set(compact('categorieproduits', 'categorieproduits', 'unites', 'segments', 'tvas'));
		$this->layout = false;
	}

	public function view($id = null) {
		$sortie = [];
		$mouvements = [];
		$quantite_general = 0;
		$depotproduits = 0;
		if ($this->request->is(array('post', 'put'))) {
			if ( isset( $this->data['Produit']['image'] ) ) unset( $this->request->data['Produit']['image'] );
			if ( isset( $_FILES['data']['name']['Produit']['image'] ) AND !empty( $_FILES['data']['name']['Produit']['image'] ) ) {
				$uploadfile = new Uploadfile();
				$basenameSlug = $uploadfile->convertBaseName($_FILES['data']['name']['Produit']['image']);
				$file_name = $basenameSlug;
				$file_tmp = $_FILES['data']['tmp_name']['Produit']['image'];
				$size = $_FILES['data']['size']['Produit']['image'];
				$dest_dossier = str_replace('\\', '/', WWW_ROOT."uploads\\articles_images\\");
				if ( !is_dir( $dest_dossier ) ) { mkdir($dest_dossier, 0777, true); }
				if (!empty($this->data['Produit']['id'])){
					$options = array('conditions' => array('Produit.' . $this->Produit->primaryKey => $id));
					$produit = $this->Produit->find('first', $options);
					if(empty($file_name) AND !empty($produit['Produit']['image'])) {
						$this->request->data['Produit']['image'] = $produit['Produit']['image'];
					}else if(!empty($file_name)){
						$this->request->data['Produit']['image'] = $file_name;
					}
				}else{
					if (empty($file_name)) $file_name = 'default.jpg';
					else $this->request->data['Produit']['image'] = $file_name;
				}

				if (!empty($file_name)) move_uploaded_file($file_tmp, $dest_dossier.$file_name);
			}
			$this->request->data['Produit']['type'] = 1;
			if ($this->Produit->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Produit->exists($id)) {
			$options = array('contain'=>['Segment'],'conditions' => array('Produit.' . $this->Produit->primaryKey => $id));
			$this->request->data = $this->Produit->find('first', $options);

			$depotproduits = $this->Produit->Depotproduit->find('all',[
				'fields' => ['Depotproduit.*','Depot.*'],
				'conditions'=>[ 'produit_id'=>$id ],
				'joins' => [
					['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id'] ],
				],
				'order'=>['Depotproduit.date'=>'DESC'],
			]);

			$mouvements = $this->Produit->Mouvement->find('all',[
				'contain'=>['DepotSource','DepotDestination'],
				'conditions'=>[
					'Mouvement.produit_id'=>$id,
					'Mouvement.operation'=>-1
				],
				'order'=>['Mouvement.id'=>'DESC'],
			]);

			$sortie = $this->Produit->Mouvement->find('all',[
				'contain'=>['DepotSource','DepotDestination'],
				'conditions'=>[
					'Mouvement.produit_id'=>$id,
					'Mouvement.operation'=>1
				],
				'order'=>['Mouvement.id'=>'DESC'],
			]);

			$quantite_actual_entree = 0;
			foreach ($mouvements as $key => $value) {
				$quantite_actual_entree = $quantite_actual_entree + $value['Mouvement']['stock_source'];
			}

			$quantite_actual_sortie = 0;
			foreach ($sortie as $key => $value) {
				$quantite_actual_sortie = $quantite_actual_sortie + $value['Mouvement']['stock_source'];
			}

			$quantite_general = ( isset( $this->request->data['Produit']['stockactuel'] ) AND !empty( $this->request->data['Produit']['stockactuel'] ) ) ? (int) $this->request->data['Produit']['stockactuel'] : 0 ;

			$total_stock = ( !empty( $quantite_general ) AND !empty( $this->request->data['Produit']['prix_vente'] ) ) ? (float) $quantite_general*$this->request->data['Produit']['prix_vente'] : 0;
			$societe = $this->GetSociete();
			$tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
			$division_tva = (1+$tva/100);
			$total_stock_ht = round($total_stock/$division_tva,2);
		}

		$tvas = $this->Produit->TvaAchat->findList();
		$unites = $this->Produit->Unite->find('list',['order'=>'libelle asc']);
		$segments = $this->Produit->Segment->find('list',['order'=>'libelle asc']);
		$categorieproduits = $this->Produit->Categorieproduit->find('list',['order'=>'libelle asc']);
		$souscategorieproduits = $this->Produit->Souscategorieproduit->find('list', ['order'=>'libelle asc']);
		$this->set(compact('depotproduits','mouvements','categorieproduits','total_stock','sortie','quantite_general','souscategorieproduits','total_stock_ht','unites','segments','tvas'));
		$this->getPath($this->idModule);
	}

	private function CsvToArray($file,$delimiter) { 
	    ini_set('memory_limit', '-1');
		$data2DArray = [];
        if (($handle = fopen($file, "r")) !== FALSE) { 
            $i = 0; 
            while (($lineArray = fgetcsv($handle, 4000, $delimiter)) !== FALSE) { 
            	$tab = count($lineArray);
                for ($j=0; $j<$tab; $j++) { 
                    $data2DArray[$i][$j] = utf8_encode($lineArray[$j]); 
                } 
                $i++; 
            } 
            fclose($handle); 
        } 
        return $data2DArray; 
    }

    public function importer(){
    	$champs = array();
    	ini_set('memory_limit', '-1');
    	if ($this->request->is(array('post', 'put'))) {
    		$ImportedFile = $this->CsvToArray($this->data['Produit']['file']['tmp_name'],";");
    		$produits = $this->Produit->find('list',['fields' => ['Produit.id','Produit.code_barre']]);
    		$categorieproduits = $this->Produit->Categorieproduit->find('list',['order'=>'libelle asc']);
    		$souscategorieproduits = $this->Produit->Souscategorieproduit->find('list',['order'=>'libelle asc']);

			array_shift($ImportedFile);

			$result = (isset( $this->data['csv'] ) AND !empty( $this->data['csv'] )) ? $this->data['csv'] :  array_flip($champs);

			$tab = array();
			foreach ($ImportedFile as $key => $value) {
				foreach ($result as $k => $v) {
					if ( isset( $value[$v] ) ) {
						$tab[$key][$k] = trim($value[$v]);
					}
				}	
			}

			$insert = array();
			foreach ($tab as $key => $value) { // Filter
				if ( empty( $value['code_barre'] ) AND empty( $value['libelle'] ) ){
					unset( $tab[$key] );
				}
			}

			foreach ($tab as $key => $value) {
				$value['id'] = null;
				$value['date']  = date('Y-m-d');
				$value['categorieproduit_id'] = null;
				$value['souscategorieproduit_id'] = null;
				$value['type'] = 1;


				if ( isset( $value['prixachat'] ) AND !empty( $value['prixachat'] ) ){
					$value['prixachat'] = trim( $value['prixachat'] );
					$value['prixachat'] = (float) str_replace(',', '.', $value['prixachat']);
				}

				if ( isset( $value['prix_vente'] ) AND !empty( $value['prix_vente'] ) ){
					$value['prix_vente'] = trim( $value['prix_vente'] );
					$value['prix_vente'] = (float) str_replace(',', '.', $value['prix_vente']);
				}

				if ( isset( $value['code_barre'] ) AND !empty( $value['code_barre'] ) ){
					$value['code_barre'] = trim( $value['code_barre'] );
					$value['code_barre'] = str_replace(' ', '', $value['code_barre']);
					foreach ($produits as $k => $v) {
						if ( $value['code_barre'] == trim($v) ) {
							$value['id'] = $k;
						}
					}
				}
				if ( isset( $value['categorie'] ) AND !empty( $value['categorie'] ) ){
					$value['categorie'] = trim( $value['categorie'] );
					$value['categorie'] = str_replace('Ã©', 'é', $value['categorie']);
					$value['categorie'] = str_replace('Ã¨', 'è', $value['categorie']);
					$value['categorie'] = str_replace('Ãª', 'ê', $value['categorie']);
					$value['categorie'] = str_replace('Ã§', 'â', $value['categorie']);
					$value['categorie'] = str_replace('Ã¢', 'â', $value['categorie']);
					$value['categorie'] = str_replace('Ã', 'à', $value['categorie']);
					foreach ($categorieproduits as $k => $v) {
						if ( $value['categorie'] == trim($v) ) {
							$value['categorieproduit_id'] = $k;
						}
					}
				}
				if ( isset( $value['souscategorie'] ) AND !empty( $value['souscategorie'] ) ){
					$value['souscategorie'] = trim( $value['souscategorie'] );
					$value['souscategorie'] = str_replace('Ã©', 'é', $value['souscategorie']);
					$value['souscategorie'] = str_replace('Ã¨', 'è', $value['souscategorie']);
					$value['souscategorie'] = str_replace('Ãª', 'ê', $value['souscategorie']);
					$value['souscategorie'] = str_replace('Ã§', 'â', $value['souscategorie']);
					$value['souscategorie'] = str_replace('Ã¢', 'â', $value['souscategorie']);
					$value['souscategorie'] = str_replace('Ã', 'à', $value['souscategorie']);
					foreach ($souscategorieproduits as $k => $v) {
						if ( $value['souscategorie'] == trim($v) ) {
							$value['souscategorieproduit_id'] = $k;
						}
					}
				}

				if ( isset( $value['libelle'] ) AND !empty( $value['libelle'] ) ){
					$value['libelle'] = trim( $value['libelle'] );
					$value['libelle'] = str_replace('Ã©', 'é', $value['libelle']);
					$value['libelle'] = str_replace('Ã¨', 'è', $value['libelle']);
					$value['libelle'] = str_replace('Ãª', 'ê', $value['libelle']);
					$value['libelle'] = str_replace('Ã§', 'â', $value['libelle']);
					$value['libelle'] = str_replace('Ã¢', 'â', $value['libelle']);
					$value['libelle'] = str_replace('Ã', 'à', $value['libelle']);
				}

				$insert[]['Produit'] = $value;
			}

			$datasource = $this->Produit->getDataSource();
			try {

				if ( isset( $this->data['Produit']['check'] ) AND $this->data['Produit']['check'] == 1 ) $this->Produit->query("DELETE FROM produits WHERE type = 1");

			    $datasource->begin();

	    		if (!$this->Produit->saveMany($insert)) throw new Exception();

			    $datasource->commit();
			    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} catch(Exception $e) {
			    $datasource->rollback();
			    $this->Session->setFlash('Il y a un problème','alert-danger');
			}

			return $this->redirect( ['action'=>'index'] );
		}

		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Produit->id = $id;
		if (!$this->Produit->exists()) throw new NotFoundException(__('Invalide produit'));

		if ($this->Produit->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}	
}