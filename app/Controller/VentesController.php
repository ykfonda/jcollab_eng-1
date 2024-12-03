<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class VentesController extends AppController {
	public $idModule = 66;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Vente->Client->find('list');
		$users_db = $this->Vente->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','clients','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Vente->Ventedetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function download($id = null) {
		if ($this->Vente->Piece->exists($id)) {
			$options = array('conditions' => array('Piece.' . $this->Vente->Piece->primaryKey => $id));
			$dossier = $this->Vente->Piece->find('first', $options);
			$link = str_replace('\\', '/', WWW_ROOT.'devifiles\\'.$dossier['Piece']['filename']);
			$file = ( file_exists($link) ) ? $link : ''; 
			
			if ( empty($file) ) {
				$this->Session->setFlash("Le fichier ou le dossier n’existe pas. ",'alert-danger');
				return $this->redirect( $this->referer() );
			}else{

				header("Content-Description: File Transfer"); 
				header("Content-Type: application/octet-stream"); 
				header("Content-Disposition: attachment; filename=" . basename($file) . ""); 

				readfile ($file);
				exit(); 
			}

		}else{
			$this->Session->setFlash('Il y a un problème dans votre serveur de stockage !','alert-danger');
			return $this->redirect( $this->referer() );
		}
	}

	public function getfiles($vente_id = null){
		$files = $this->Vente->Piece->find('all',[
			'conditions' => ['Piece.vente_id'=>$vente_id],
			'order' => 'Piece.date_c DESC',
			'contain' => ['Creator'],
		]);

		$this->set(compact('files'));
		$this->layout = false;
	}

	public function deletefile($id = null) {
		$this->Vente->Piece->id = $id;
		if (!$this->Vente->Piece->exists()) {
			throw new NotFoundException(__('Invalide fichier'));
		}

		if ($this->Vente->Piece->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function uploadfiles(){
		if ($this->request->is('post')) {
			$dest_dossier = str_replace('\\', '/', WWW_ROOT."devifiles/");
			if (!file_exists($dest_dossier)) mkdir($dest_dossier,true, 0700);

			if (!empty($_FILES['file'])) {
				$uploadfile = new Uploadfile();
				$filename = $uploadfile->convertBaseName($_FILES['file']['name']);
				$monRepertoire = $dest_dossier.$filename;
				$extension = strrchr($filename, '.');
				if (move_uploaded_file($_FILES['file']['tmp_name'],$monRepertoire)) {
					$data = array(
						'filename'=>$filename,
						'vente_id'=>$this->data['vente_id'],
						'extention'=>$extension,
						'path'=>$monRepertoire,
						'size'=>$_FILES['file']['size'],
					);
					if ($this->Vente->Piece->save($data)) {
						die("Importation avec succès"); 
					}else{
						die("Erreur d'importation");
					}
				}else{
					die("Erreur d'importation");
				}
			}
		}
		$this->layout = false;
	}
	
	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		/*if ( $role_id != 1 ) $conditions['Vente.user_c'] = $user_id;*/
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Vente.reference' )
					$conditions['Vente.reference LIKE '] = "%$value%";
				else if( $param_name == 'Vente.date1' )
					$conditions['Vente.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Vente.date2' )
					$conditions['Vente.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Vente->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['Vente.date'=>'DESC','Vente.id'=>'DESC'],
			'contain'=>['User','Client'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Vente->find('all',['conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
	}

	public function editavance($id = null,$vente_id = null) {
		$vente = $this->Vente->find('first',['conditions'=>['id'=>$vente_id]]);
		$total_a_payer = (isset( $vente['Vente']['reste_a_payer'] )) ? $vente['Vente']['reste_a_payer'] : 0 ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Avance']['vente_id'] = $vente_id;
			if ($this->Vente->Avance->save($this->request->data)) {
				$avances = $this->Vente->Avance->find('all',[
					'conditions' => ['Avance.vente_id'=>$vente_id],
				]);
				$total_paye = 0;
				foreach ($avances as $key => $value) {
					$total_paye = $total_paye + $value['Avance']['montant'];
				}
				$reste_a_payer = $vente['Vente']['total_apres_reduction'] - $total_paye;
				$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

				$data['Vente'] = [
					'id' => $vente_id,
					'reste_a_payer' => $reste_a_payer,
					'total_paye' => $total_paye,
				];

				if( $this->Vente->save( $data ) );
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Vente->Avance->exists($id)) {
			$options = array('conditions' => array('Avance.' . $this->Vente->Avance->primaryKey => $id));
			$this->request->data = $this->Vente->Avance->find('first', $options);
		}

		$this->set(compact('total_a_payer'));
		$this->layout = false;
	}

	public function editdetail($id = null,$vente_id = null) {
		$vente = $this->Vente->find('first', ['contain'=>['User'],'conditions' => ['Vente.id' => $vente_id]]);
		$depot_id = ( isset( $vente['User']['id'] ) AND !empty( $vente['User']['depot_id'] ) ) ? $vente['User']['depot_id'] : $this->Session->read('Auth.User.depot_id') ;
		$role_id = $this->Session->read('Auth.User.role_id');

		if ( $role_id != 1 ) {
			$produits_exists = $this->Vente->Ventedetail->Produit->find('list',[
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'ventedetails', 'alias' => 'Ventedetail', 'type' => 'INNER', 'conditions' => ['Ventedetail.produit_id = Produit.id'] ],
				],
				'conditions' => ['Ventedetail.deleted'=>0,'Ventedetail.vente_id'=>$vente_id]
			]);

			$produits = $this->Vente->Ventedetail->Produit->find('list',[
				'conditions'=>['Produit.active'=>1,'Produit.id !='=>$produits_exists,'Depotproduit.depot_id'=>$depot_id],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
				],
				'order' => ['libelle' => 'ASC']
			]);
			
		}else{
			$produits_exists = $this->Vente->Ventedetail->Produit->find('list',[
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'ventedetails', 'alias' => 'Ventedetail', 'type' => 'INNER', 'conditions' => ['Ventedetail.produit_id = Produit.id'] ],
				],
				'conditions' => ['Ventedetail.deleted'=>0,'Ventedetail.vente_id'=>$vente_id]
			]);

			$produits = $this->Vente->Ventedetail->Produit->find('list',[
				'conditions'=>['Produit.active'=>1,'Produit.id !='=>$produits_exists],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
				],
				'order' => ['libelle' => 'ASC']
			]);
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Ventedetail']['vente_id'] = $vente_id;
			if ($this->Vente->Ventedetail->save($this->request->data)) {
				$details = $this->Vente->Ventedetail->find('all',['conditions' => ['vente_id' => $vente_id]]);
				$total_a_payer = 0;
				$total_qte = 0;
				foreach ($details as $key => $value) {
					$total_a_payer = $total_a_payer + $value['Ventedetail']['ttc'];
					$total_qte = $total_qte + $value['Ventedetail']['qte'];
				}

				$data['Vente'] = [
					'id' => $vente_id,
					'total_a_payer' => $total_a_payer,
					'reste_a_payer' => $total_a_payer,
					'total_apres_reduction' => $total_a_payer,
					'total_qte' => $total_qte,
				];

				$this->Vente->save($data);

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Vente->Ventedetail->exists($id)) {
			$options = array('conditions' => array('Ventedetail.' . $this->Vente->Ventedetail->primaryKey => $id));
			$this->request->data = $this->Vente->Ventedetail->find('first', $options);
			if ( $role_id != 1 ) {
				$produits = $this->Vente->Ventedetail->Produit->find('list',[
					'conditions'=>['Produit.active'=>1,'Produit.id !='=>$produits_exists,'Depotproduit.depot_id'=>$depot_id],
					'joins' => [
						['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
					],
					'order' => ['libelle' => 'ASC']
				]);
			}else{
				$produits = $this->Vente->Ventedetail->Produit->find('list',[
					'order' => ['Produit.libelle' => 'ASC'],
					'conditions'=>['Produit.active'=>1],
				]);
			}
		}

		$depots = $this->Vente->Ventedetail->Depot->find('list');
		$categorieproduits = $this->Vente->Ventedetail->Produit->Categorieproduit->find('list');
		$this->set(compact('produits','role_id','depot_id','depots','categorieproduits'));
		$this->layout = false;
	}

	public function getProduitByDepot($vente_id = null,$depot_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Vente->Ventedetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'ventedetails', 'alias' => 'Ventedetail', 'type' => 'INNER', 'conditions' => ['Ventedetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Ventedetail.deleted'=>0,
				'Ventedetail.vente_id'=>$vente_id,
				'Ventedetail.depot_id'=>$depot_id,
			]
		]);

		$produits = $this->Vente->Ventedetail->Produit->find('list',[
			'conditions'=>[
				'Produit.categorieproduit_id'=>$categorieproduit_id,
				'Depotproduit.depot_id'=>$depot_id,
				'Produit.id !='=>$produits_exists,
				'Depotproduit.quantite >='=>0,
				'Produit.active'=>1,
			],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
			],
			'order' => ['libelle' => 'ASC']
		]);

		die( json_encode( $produits ) );
	}

	public function getProduit($produit_id = null,$depot_id = null,$categorieclient_id = null) {
		$produit = $this->Vente->Ventedetail->Produit->find('first',[
			'fields' => ['Produit.*','Depotproduit.*','Produitprice.*'],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
				['table' => 'produitprices', 'alias' => 'Produitprice', 'type' => 'INNER', 'conditions' => ['Produitprice.produit_id = Produit.id'] ],
			],
			'conditions'=>[
				'Produit.id'=>$produit_id,
				'Depotproduit.quantite >'=>0,
				'Depotproduit.depot_id'=>$depot_id,
				'Produitprice.categorieclient_id'=>$categorieclient_id,
			],
		]);

		$prix_vente = ( isset( $produit['Produitprice']['id'] ) AND !empty( $produit['Produitprice']['prix_vente'] ) ) ? (float) $produit['Produitprice']['prix_vente'] : 0 ;
		$quantite = ( isset( $produit['Depotproduit']['id'] ) AND !empty( $produit['Depotproduit']['quantite'] ) ) ? (float) $produit['Depotproduit']['quantite'] : 0 ;
		$tva = ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['tva'] ) ) ? (float) $produit['Produit']['tva'] : 20 ;

		die( json_encode( [ 'tva' => $tva,'prix_vente' => $prix_vente ,'quantite' => $quantite ] ) );
	}

	public function changestate($id = null,$etat = -1) {
		$commande = $this->Vente->find('first', ['contain'=>['User'],'conditions' => ['Vente.id' => $id]]);
		$depot_id = ( isset( $commande['User']['id'] ) AND !empty( $commande['User']['depot_id'] ) ) ? $commande['User']['depot_id'] : $this->Session->read('Auth.User.depot_id') ;		
		$role_id = $this->Session->read('Auth.User.role_id');
		$this->Vente->id = $id;
		if ($this->Vente->saveField('etat',$etat)) {
			$message = "L'enregistrement a été effectué avec succès.";
			$facture = $this->Vente->find('first', ['contain'=>['Client'],'conditions' => ['Vente.' . $this->Vente->primaryKey => $id]]);
			if ( isset( $facture['Vente']['id'] ) ) {
				if ( $facture['Vente']['etat'] == 1 ) {
					$this->loadModel('Notification');
					$users = $this->Vente->User->find('list',['fields'=>['id','id'],'conditions'=>['role_id'=>1]]);
					$GroupeNotif = [
						'Notification' => [ 'privee' => 1, 'type' => 2, 'module_id' => 66, 'module' => 'Vente' ],
						'UserList' => $users,
						'Params' => [
							'key' => 3, 
							'id' => $facture['Vente']['id'] ,
							'date' => $facture['Vente']['date'] ,
							'client' => $facture['Client']['designation'],
							'reference' => $facture['Vente']['reference'],
						],
					];
					/*if( $this->Notification->save($GroupeNotif) ){
						$message = "La notification a été bien envoyé avec succès.";
					}*/
				}else if( $facture['Vente']['etat'] == 2 ){
					
					$vente_id = $facture['Vente']['id'];

					$details = $this->Vente->Ventedetail->find('all',[
						'conditions' => ['Ventedetail.vente_id'=>$vente_id],
						'contain' => ['Produit'],
					]);

					$detail_ids = [];
					$data_to_save = [];
					$stock_apres = 0;
					foreach ($details as $key => $value) {
						$data_to_save['Mouvement'][] = [
							'produit_id' => $value['Ventedetail']['produit_id'],
							'depot_source_id' => $value['Ventedetail']['depot_id'],
							'stock_destination' => $value['Ventedetail']['qte'],
							'vente_id' => $value['Ventedetail']['vente_id'],
							'date' => date('d-m-Y'),
							'operation' => 1,
						];

						$this->sortie($value['Ventedetail']['depot_id'],$value['Ventedetail']['produit_id'],$value['Ventedetail']['qte']);
					}

					if ( !empty( $data_to_save['Mouvement'] ) ) {
						$this->Vente->Ventedetail->Produit->Mouvement->saveMany($data_to_save['Mouvement']);
					}

					$message = "Le stock a été mouvementé avec succès.";
				}
			}
			$this->Session->setFlash($message,'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function sortie($depot_id = null,$produit_id = null,$quantite = 0) {
		$depotproduit = $this->Vente->Ventedetail->Produit->Depotproduit->find('first',[
			'conditions' => [
				'depot_id'=>$depot_id,
				'produit_id' => $produit_id,
			],
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);

		$id = (isset( $depotproduit['Depotproduit']['id'] )) ? $depotproduit['Depotproduit']['id'] : null ;
		$quantite_old = (isset( $depotproduit['Depotproduit']['id'] )) ? (int) $depotproduit['Depotproduit']['quantite'] : 0 ;
		$quantite_new = $quantite_old - $quantite ;

		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id'=>$depot_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite_new,
		];

		if ( $this->Vente->Ventedetail->Produit->Depotproduit->save( $data ) );

		return true;
	}

	public function entree($depot_id = null,$produit_id = null,$quantite = 0) {
		$depotproduit = $this->Vente->Ventedetail->Produit->Depotproduit->find('first',[
			'conditions' => [
				'depot_id'=>$depot_id,
				'produit_id' => $produit_id,
			],
		]);

		$id = (isset( $depotproduit['Depotproduit']['id'] )) ? $depotproduit['Depotproduit']['id'] : null ;
		$quantite_old = (isset( $depotproduit['Depotproduit']['id'] )) ? (int) $depotproduit['Depotproduit']['quantite'] : 0 ;
		$quantite_new = $quantite_old + $quantite ;

		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id'=>$depot_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite_new,
		];

		if ( $this->Vente->Ventedetail->Produit->Depotproduit->save( $data ) );

		return true;
	}

	public function lancer($id = null) {
		$facture = $this->Vente->find('first', ['contain'=>['Client'],'conditions' => ['Vente.' . $this->Vente->primaryKey => $id]]);
		if ( isset( $facture['Vente']['id'] ) AND !empty( $facture['Vente']['id'] ) ) {				
			$vente_id = $facture['Vente']['id'];
			$details = $this->Vente->Boncommande->Ventedetail->find('all',[
				'contain' => ['Produit'],'conditions' => ['Ventedetail.vente_id'=>$id]
			]);

			$detail_ids = [];
			$data_to_save = [];
			$stock_apres = 0;
			foreach ($details as $key => $value) {
				$stock_apres = $value['Produit']['stock'] - $value['Ventedetail']['qte'];
				$detail_ids[ $value['Ventedetail']['id'] ] = $value['Ventedetail']['id'];
				$data_to_save['Mouvement'][] = [
					'produit_id' => $value['Ventedetail']['produit_id'],
					'date' => date('d-m-Y'),
					'stock_avant' => $value['Produit']['stock'],
					'typearticle' => $value['Produit']['typearticle'],
					'qte' => $value['Ventedetail']['qte'],
					'stock_apres' => $stock_apres,
					'vente_id' => $value['Ventedetail']['vente_id'],
					'type' => 2,
				];
				$data_to_save['Produit'][] = [
					'id' => $value['Ventedetail']['produit_id'],
					'stock' => $stock_apres,
				];
			}

			if ( !empty( $data_to_save['Mouvement'] ) ) {
				$this->Vente->Boncommande->Mouvement->saveMany($data_to_save['Mouvement']);
			}

			if ( !empty( $data_to_save['Produit'] ) ) {
				$this->Vente->Ventedetail->Produit->saveMany($data_to_save['Produit']);
			}

			$this->Session->setFlash('Le stock a été mouvementé avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function facture($id = null) {
		$details = [];
		if ($this->Vente->exists($id)) {
			$options = array('conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$vente = $this->Vente->find('first', $options);
			$details = $this->Vente->Ventedetail->find('all',['conditions' => ['Ventedetail.vente_id'=>$id]]);

			$data['Facture'] = [
				'id' => null,
				'date' => $vente['Vente']['date'],
				'vente_id' => $vente['Vente']['id'],
				'client_id' => $vente['Vente']['client_id'],
			];

			$data['Facturedetail'] = [];
			foreach ($details as $key => $value) {
				$data['Facturedetail'][] = [
					'id' => null,
					'ttc' => $value['Ventedetail']['ttc'],
					'qte' => $value['Ventedetail']['qte'],
					'total' => $value['Ventedetail']['total'],
					'depot_id' => $value['Ventedetail']['depot_id'],
					'prixachat' => $value['Ventedetail']['prixachat'],
					'produit_id' => $value['Ventedetail']['produit_id'],
				];
			}

			if ($this->Vente->Facture->saveAssociated($data)) {
				$facture_id = $this->Vente->Facture->id;
				$this->Vente->id = $id;
				if( $this->Vente->saveField('facture_id',$facture_id) );
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		$avances = [];
		if ($this->Vente->exists($id)) {
			$options = array('contain'=>['User','Client'],'conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$this->request->data = $this->Vente->find('first', $options);

			$details = $this->Vente->Ventedetail->find('all',[
				'contain' => ['Depot','Produit'],
				'conditions' => ['Ventedetail.vente_id'=>$id],
			]);

			$avances = $this->Vente->Avance->find('all',[
				'conditions' => ['Avance.vente_id'=>$id],
				'order' => ['date ASC'],
			]);
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('avances','details','role','user_id','societe'));
		$this->layout = false;
	}

	public function view($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		$avances = [];
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Vente->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Vente->exists($id)) {
			$options = array('contain'=>['Client','User'],'conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$this->request->data = $this->Vente->find('first', $options);

			$details = $this->Vente->Ventedetail->find('all',[
				'fields' => ['Depotproduit.*','Produit.*','Ventedetail.*','Depot.*'],
				'conditions' => ['Ventedetail.vente_id'=>$id],
				'contain' => ['Produit','Depot'],
				'group' => ['Ventedetail.id'],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.depot_id = Depot.id'] ],
				],
			]);

			$avances = $this->Vente->Avance->find('all',[
				'conditions' => ['Avance.vente_id'=>$id],
				'order' => ['date ASC'],
			]);
		}

		$clients = $this->Vente->Client->find('list');
		$this->set(compact('avances','details','role_id','user_id','flag','clients'));
		$this->getPath($this->idModule);
	}

	public function reduction($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Vente->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Vente->exists($id)) {
			$options = array('conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$this->request->data = $this->Vente->find('first', $options);
		}
		$this->layout = false;
	}

	public function edit($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Vente->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Vente->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Vente->exists($id)) {
			$options = array('conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$this->request->data = $this->Vente->find('first', $options);
		}

		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Vente->Client->find('list');
		$users_db = $this->Vente->User->find('all',['conditions'=>['role_id'=>3]]);
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$this->set(compact('users','clients','user_id','role_id','flag'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Vente->id = $id;
		if (!$this->Vente->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Vente->flagDelete()) {
			$this->Vente->Ventedetail->updateAll(['Ventedetail.deleted'=>1],['Ventedetail.vente_id'=>$id]);
			$this->Vente->Avance->updateAll(['Avance.deleted'=>1],['Avance.vente_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$vente_id = null) {
		$this->Vente->Ventedetail->id = $id;
		if (!$this->Vente->Ventedetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Vente->Ventedetail->flagDelete()) {
			$details = $this->Vente->Ventedetail->find('all',['conditions' => ['vente_id' => $vente_id]]);

			$total_a_payer = 0;
			$total_qte = 0;
			foreach ($details as $key => $value) {
				$total_a_payer = $total_a_payer + $value['Ventedetail']['ttc'];
				$total_qte = $total_qte + $value['Ventedetail']['qte'];
			}

			$data['Vente'] = [
				'id' => $vente_id,
				'total_a_payer' => $total_a_payer,
				'reste_a_payer' => $total_a_payer,
				'total_apres_reduction' => $total_a_payer,
				'total_qte' => $total_qte,
			];

			$this->Vente->save($data);

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function deleteavance($id = null,$vente_id = null) {
		$this->Vente->Avance->id = $id;
		if (!$this->Vente->Avance->exists()) {
			throw new NotFoundException(__('Invalide Avance'));
		}

		if ($this->Vente->Avance->flagDelete()) {

			$vente = $this->Vente->find('first',['conditions'=>['id'=>$vente_id]]);
			$avances = $this->Vente->Avance->find('all',[
				'conditions' => ['Avance.vente_id'=>$vente_id],
			]);
			$total_paye = 0;
			foreach ($avances as $key => $value) {
				$total_paye = $total_paye + $value['Avance']['montant'];
			}
			$reste_a_payer = $vente['Vente']['total_a_payer'] - $total_paye;
			$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer ;

			$data['Vente'] = [
				'id' => $vente_id,
				'reste_a_payer' => $reste_a_payer,
				'total_paye' => $total_paye,
			];
			if( $this->Vente->save( $data ) );

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function generatepdf($id=null,$saveToserver = true){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Vente->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Vente.' . $this->Vente->primaryKey => $id));
			$this->request->data = $this->Vente->find('first', $options);

			$details = $this->Vente->Ventedetail->find('all',[
				'contain' => ['Vente','Produit'],
				'conditions' => ['Ventedetail.vente_id'=>$id],
			]);
		}
		$societe = $this->GetSociete();
		$view = new View($this, false);
		$content = $view->element('header',['societe' => $societe,'title' => 'VENTE']);
		$ville = (isset( $this->data['Client']['Ville']['libelle'] )) ? $this->data['Client']['Ville']['libelle'] : '' ;
		$html ='
			<html>
			<head>
			    <title>Vente</title>
			</head>
			<style>
			.container{
			    padding: 10px;
			}
			.info, .data{
			    margin-top: 40px;
			}
			.data{
			    margin: auto;
			    border: 1px solid #166ab3;
			    border-spacing: 0;
			    border-collapse: collapse;
			}
			.data th{
			    background-color: #166ab3;
			    padding: 5px 10px;
			    color:#fff;
			}
			.data td{
			    border: 1px solid #166ab3;
			    padding: 8px;
			    line-height: 1.42857143;
			    vertical-align: top;
			}
			.data .hidden{
			    visibility: hidden;
			}

			.details div{
			    padding: 8px 0;
			}
			.details .ps{
			    font-size: 12px;
			    text-align:left;
			}
			.rols{
			    position: relative;
			    text-align: center;
			    font-size: 13px;
			}

			.signature{
			    text-align: center;
			    margin: auto;
			    overflow: auto;
			}
			.signature div{
			    text-align: left;
			}
			.signature .signature-left{
			    width: 48%;
			    float: left;
			    margin-right: 10px;
			    border:1px solid #166ab3;
			    min-height: 120px;
			}
			.signature .signature-right{
			    width: 50%;
			    float: right;
			    border:1px solid #166ab3;
			    min-height: 120px;
			}
			.signature h3{
			    background-color: #166ab3;
			    color: #fff;
			    padding: 3px 0;
			    text-transform: uppercase;
			    text-align: center;
			    margin-top: 0;
			}
			.signature-left div, .signature-right div{
			    padding-left: 20px;
			}
			.ps{
			    text-align: center;
			    margin-top: 10px;
			}
			.ps p{
			    margin: 0;
			    color: red;
			    font-weight: bold;
			}
			div .ps {
			    margin-top: 8px;
			    font-size: 11px;
			}
			</style>
			<body>
			    <div class="container">
			    	'.$content.'
			        <table class="info" width="100%">
			            <tbody>
			                <tr>
			                    <td width="50%">FACTURE N° : '.$this->data['Vente']['reference'].'</td>
			                    <td width="50%">Date : '.$this->data['Vente']['date'].'</td>
			                </tr>
			            </tbody>
			        </table>

			        <table class="info" width="100%">
			            <tbody>
			                <tr>
			                    <td width="50%">Nom:  '.$this->data['Client']['designation'].' </td>
			                    <td width="50%">Téléphone: '.$this->data['Client']['telmobile'].'</td>
			                </tr>
			                <tr>
			                    <td width="50%">Ville:  '.$ville.' </td>
			                    <td width="50%">ICE: '.$this->data['Client']['ice'].'</td>
			                </tr>
			                <tr>
			                    <td colspan="2">Adress: '.$this->data['Client']['adresse'].'</td>
			                </tr>
			            </tbody>
			        </table><br/>

			        <table class="info data" width="100%">
			            <thead>
			                <tr>
			                    <th width="50%">Désignation </th>
			                    <th width="16%">Quantité </th>
			                    <th width="16%">Prix Unitaire HT </th>
			                    <th width="16%">Montant Total HT</th>
			                </tr>
			            </thead>
			            <tbody>';
			                $total = 0;$total_ttc = 0;$total_tva = 0;
			                foreach ($details as $tache){
			                    $total = $total + $tache['Ventedetail']['total'];
			                    $total_ttc = $total_ttc + $tache['Ventedetail']['ttc'];
			                    $total_tva = $total_tva + $tache['Ventedetail']['ttc'] * (1 + 20/ 100);
			                    $html.='<tr>
			                        <td width="50%">'.$tache['Produit']['libelle'].'</td>
			                        <td width="16%">'.$tache['Ventedetail']['qte'].'</td>
			                        <td width="16%" style="text-align:right;">'.number_format($tache['Produit']['prixachat'], 2, ',', ' ').'</td>
			                        <td width="16%" style="text-align:right;">'.number_format($tache['Ventedetail']['total'], 2, ',', ' ').'</td>
			                    </tr>';
			                }
			                $html .= '
			                    <tr>
			                        <td width="50%" style="border:none;"></td>
			                        <td width="16%" style="border:none;"></td>
			                        <td width="16%">Total HT</td>
			                        <td width="16%" style="text-align:right;">'.number_format($total, 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td width="50%" style="border:none;"></td>
			                        <td width="16%" style="border:none;"></td>
			                        <td width="16%">TAUX DE T.V.A.</td>
			                        <td width="16%" style="text-align:right;">20%</td>
			                    </tr>
			                    <tr >
			                        <td width="50%" style="border:none;"></td>
			                        <td width="16%" style="border:none;"></td>
			                        <td width="16%">TVA</td>
			                        <td width="16%" style="text-align:right;">'.number_format($total_tva, 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td width="50%" style="border:none;"></td>
			                        <td width="16%" style="border:none;"></td>
			                        <td width="16%">Total TTC</td>
			                        <td width="16%" style="text-align:right;">'.number_format($total_ttc, 2, ',', ' ').'</td>
			                    </tr>
			            </tbody>
			        </table>
			    </div>
			    <div style="text-align: center; position: fixed;left: 0;bottom: 4;width: 100%;padding: 2px;">
			        <strong> ICE : </strong>'.$societe['Societe']['ice'].'
			        <strong>  - RC : </strong>'.$societe['Societe']['registrecommerce'].'
			        <strong> - Patente : </strong>'.$societe['Societe']['patent'].'
			        <strong> - IF : </strong>'.$societe['Societe']['idfiscale'].'
			    </div>
			</body>
		</html>';
		//echo $html;die;
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		if ( $saveToserver == true ) {
			$output = $dompdf->output();
			$destination = WWW_ROOT.'pdfs';
			if (!file_exists( $destination )){
				mkdir($destination,true, 0700);
			}
			file_put_contents($destination.DS.'Vente.'.$this->data['Vente']['date'].'-'.$this->data['Vente']['id'].'.pdf', $output);
		}
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$url = $HtmlHelper->url('/pdfs/Vente.'.$this->data['Vente']['date'].'-'.$this->data['Vente']['id'].'.pdf', true);
		die( json_encode( ['url' => $url] ) );
	}
}