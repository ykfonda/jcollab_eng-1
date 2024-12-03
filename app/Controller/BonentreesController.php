<?php
class BonentreesController extends AppController {
	protected $idModule = 113;

	public function index() {
		$depots = $this->Session->read('depots');
		$depots = $this->Bonentree->DepotSource->findList(['DepotSource.principal'=>1,'DepotSource.id'=>$depots]);
		$produits = $this->Bonentree->Produit->findList();
		$this->set(compact('produits','depots'));
		$this->getPath($this->idModule);
	}

	public function loadproduit($id = null){
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$produit = $this->Bonentree->Produit->find('first',[ 'conditions'=>['Produit.id'=>$id] ]);
		
		if (isset($produit['Produit']['image']) AND file_exists( WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image']))
			$produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
		else	
			$produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');

		die( json_encode( $produit ) );
	}

	public function scan($code_barre = null) {
		$response['error'] = true;
		$response['message'] = "";
		$response['data']['prix_achat'] = 0;
		$response['data']['stock_source'] = 0;
		$response['data']['produit_id'] = null;
		$response['data']['produit_id'] = null;
		$longeur = strlen($code_barre);
		if ( $longeur != 13 ) $response['message'] = "Code a barre est incorrect , produit introuvable !";
		else {
			$this->loadModel('Parametreste');
			$params = $this->Parametreste->findList();
			$cb_identifiant = ( isset($params['cb_identifiant']) AND !empty($params['cb_identifiant']) ) ? $params['cb_identifiant'] : '2900' ;
			$cb_produit_depart = ( isset($params['cb_produit_depart']) AND !empty($params['cb_produit_depart']) ) ? $params['cb_produit_depart'] : 4 ;
			$cb_produit_longeur = ( isset($params['cb_produit_longeur']) AND !empty($params['cb_produit_longeur']) ) ? $params['cb_produit_longeur'] : 3 ;
			$cb_quantite_depart = ( isset($params['cb_quantite_depart']) AND !empty($params['cb_quantite_depart']) ) ? $params['cb_quantite_depart'] : 7 ;
			$cb_quantite_longeur = ( isset($params['cb_quantite_longeur']) AND !empty($params['cb_quantite_longeur']) ) ? $params['cb_quantite_longeur'] : 5 ;
			$cb_div_kg = ( isset($params['cb_div_kg']) AND !empty($params['cb_div_kg']) AND $params['cb_div_kg'] > 0 ) ? (int) $params['cb_div_kg'] : 1000 ;
			$identifiant = substr(trim( $code_barre ),0,4);
			if ( $cb_identifiant != $identifiant ) $response['message'] = "Identifiant du code à barre est incorrect , veuillez vérifier votre paramétrage d'application !";
			else{
				$code_article = substr(trim( $code_barre ),$cb_produit_depart,$cb_produit_longeur);
				$quantite = substr(trim( $code_barre ),$cb_quantite_depart,$cb_quantite_longeur);

				$produit = $this->Bonentree->Produit->find('first',['fields'=>['id','prix_vente','pese','unite_id','prixachat'],'conditions' => [ 'Produit.type' => 2,'Produit.code_barre' => $code_article ]]);

				if ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['id'] ) ) {
					if ( isset( $produit['Produit']['pese'] ) AND $produit['Produit']['pese'] == "1" ) $qte = $quantite/$cb_div_kg; // autre  
					else $qte =  $quantite; // piéce

					if ( $qte <= 0 ) $response['message'] = "Opération impossible la quantité doit étre supérieur a zéro !";
					else {
						$response['error'] = false;
						$response['data']['stock_source'] = $qte;
						$response['data']['produit_id'] = $produit['Produit']['id'];
						$response['data']['prix_vente'] = $produit['Produit']['prix_vente'];
						$response['data']['valeur'] = $produit['Produit']['prix_vente']*$qte;
					}
				} else $response['message'] = "Code a barre incorrect produit introuvable !";
			}
		}

		header('Content-Type: application/json; charset=UTF-8');
		die( json_encode( $response ) );
	}

	public function newrow($count = 0,$produit_id = null,$stock_source = 0,$prix_achat = 0,$valeur = 0) {
		$stock_source = ( !isset($stock_source) ) ? 0 : $stock_source ;
		$produit_id = ( !isset($produit_id) ) ? 0 : $produit_id ;
		$prix_achat = ( !isset($prix_achat) ) ? 0 : $prix_achat ;
		$valeur = ( !isset($valeur) ) ? 0 : $valeur ;
		$produits = $this->Bonentree->Produit->findList();
		$this->set(compact('produits','count','produit_id','stock_source','prix_achat','valeur'));
		$this->layout = false;
	}

	public function editall() {
		$depots = $this->Session->read('depots');
		if ($this->request->is(array('post', 'put'))) {
			$data['Bonentree']['id'] = null;
			$data['Bonentreedetail'] = [];
			if ( isset( $this->request->data['Bonentree']['code_barre'] ) ) unset( $this->request->data['Bonentree']['code_barre'] );
			$data['Bonentree']['date'] = ( isset( $this->data['Bonentree']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date'] ) ) : date('Y-m-d');
			$data['Bonentree']['depot_source_id'] = ( isset( $this->data['Bonentree']['depot_id'] ) ) ? $this->data['Bonentree']['depot_id'] : 1;
			$data['Bonentree']['date_sortie'] = ( isset( $this->data['Bonentree']['date_sortie'] ) AND !empty( $this->data['Bonentree']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_sortie'] ) ) : null ;
			$data['Bonentree']['date_fabrication'] = ( isset( $this->data['Bonentree']['date_fabrication'] ) AND !empty( $this->data['Bonentree']['date_fabrication'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_fabrication'] ) ) : null ;
			$data['Bonentree']['date_peremption'] = ( isset( $this->data['Bonentree']['date_peremption'] ) AND !empty( $this->data['Bonentree']['date_peremption'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_peremption'] ) ) : null ;
			$data['Bonentree']['description'] = ( isset( $this->data['Bonentree']['description'] ) ) ? $this->data['Bonentree']['description'] : null ;
			if ( isset( $this->data['Bonentreedetail'] ) AND !empty( $this->data['Bonentreedetail'] ) ) {
				foreach ($this->data['Bonentreedetail'] as $key => $value) {
					$data['Bonentreedetail'][] = [
						'id' => null,
						'operation' => -1,
						'num_lot' => $value['num_lot'],
						'prix_achat' => $value['prix_achat'],
						'produit_id' => $value['produit_id'],
						'stock_source' => $value['stock_source'],
						'depot_source_id' => ( isset( $this->data['Bonentree']['depot_id'] ) ) ? $this->data['Bonentree']['depot_id'] : 1,
						'date' => ( isset( $this->data['Bonentree']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Bonentree']['date_sortie'] ) AND !empty( $this->data['Bonentree']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_sortie'] ) ) : null ,
						'date_fabrication' => ( isset( $this->data['Bonentree']['date_fabrication'] ) AND !empty( $this->data['Bonentree']['date_fabrication'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_fabrication'] ) ) : null ,
						'date_peremption' => ( isset( $this->data['Bonentree']['date_peremption'] ) AND !empty( $this->data['Bonentree']['date_peremption'] ) ) ? date('Y-m-d', strtotime( $this->data['Bonentree']['date_peremption'] ) ) : null ,
						'description' => ( isset( $this->data['Bonentree']['description'] ) ) ? $this->data['Bonentree']['description'] : null ,
					];
				}

				if ( $this->Bonentree->saveAssociated($data) ) {
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
				return $this->redirect( ['action'=>'index'] );
			} else {
				$this->Session->setFlash('Opération impossible : Aucun produit saisie !','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}
		$depots = $this->Bonentree->DepotSource->findList(['DepotSource.principal'=>1,'DepotSource.id'=>$depots]);
		$this->set(compact('depots'));
		$this->getPath($this->idModule);
	}


	public function indexAjax(){
		$depots = $this->Session->read('depots');
		$conditions['Bonentree.operation'] = -1;
		$conditions['DepotSource.id'] = $depots;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE'] = "%$value%";
				else if( $param_name == 'Bonentree.num_lot' )
					$conditions['Bonentree.num_lot LIKE'] = "%$value%";
				else if( $param_name == 'Bonentree.reference' )
					$conditions['Bonentree.reference LIKE'] = "%$value%";
				else if( $param_name == 'Bonentree.date1' )
					$conditions['Bonentree.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonentree.date2' )
					$conditions['Bonentree.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Bonentree->recursive = -1;
		$this->Paginator->settings = [
			'order'=>['Bonentree.id'=>'DESC'],
			'contain'=>[
				'DepotSource',
				'Bonentreedetail' => ['conditions' => ['Bonentreedetail.deleted'=>0] ]
			],
			'conditions'=>$conditions,
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null,$bonentree_id = null) {
		$entree = $this->Bonentree->find('first', [ 'conditions' => ['Bonentree.id' => $bonentree_id] ]);
		$depot_source_id = ( isset( $entree['Bonentree']['depot_source_id'] ) AND !empty( $entree['Bonentree']['depot_source_id'] ) ) ? (int) $entree['Bonentree']['depot_source_id'] : 1 ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Bonentreedetail']['bonentree_id'] = $bonentree_id;
			if ($this->Bonentree->Bonentreedetail->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Bonentree->Bonentreedetail->exists($id)) {
			$options = array('conditions' => array('Bonentreedetail.' . $this->Bonentree->Bonentreedetail->primaryKey => $id));
			$this->request->data = $this->Bonentree->Bonentreedetail->find('first', $options);
		}
		$this->set(compact('depot_source_id'));
		$this->layout = false;
	}

	public function view($bonentree_id = null) {
		$details = [];
		if ($this->Bonentree->exists($bonentree_id)) {
			$options = array("contain" => "DepotSource",'conditions' => array('Bonentree.' . $this->Bonentree->primaryKey => $bonentree_id));
			$this->request->data = $this->Bonentree->find('first', $options);

			$details = $this->Bonentree->Bonentreedetail->find('all',[
				'conditions' => ['Bonentreedetail.bonentree_id' => $bonentree_id ], 
				'order'=>['Bonentreedetail.id'=>'DESC'],
				'contain'=>['Produit','DepotSource'],
			]);

		}

		$depots = $this->Bonentree->DepotSource->findList();
		$produits = $this->Bonentree->Produit->findList();
		$this->set(compact('produits','depots','details'));
		$this->getPath($this->idModule);
	}

	public function valider($bonentree_id = null) {
		if ( isset( $this->globalPermission['Permission']['v'] ) AND $this->globalPermission['Permission']['v'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de valider !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$mouvement = []; $details = [];
		$entree = $this->Bonentree->find('first', [ 'conditions' => ['Bonentree.id' => $bonentree_id] ]);
		$details = $this->Bonentree->Bonentreedetail->find('all',[
			'conditions' => ['Bonentreedetail.bonentree_id' => $bonentree_id ], 
			'order'=>['Bonentreedetail.id'=>'DESC'],
		]);

		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : Aucun produit saisie !!','alert-danger');
			return $this->redirect( $this->referer() );
		}

		if ( isset( $entree['Bonentree']['id'] ) AND !empty( $entree['Bonentree']['id'] ) AND $entree['Bonentree']['valide'] == -1 ) {
			foreach ($details as $bonentree) {
				$mouvement[] = [
					'id' => null,
					'operation' => -1,
					'num_lot' => $bonentree['Bonentreedetail']['num_lot'],
					'prix_achat' => $bonentree['Bonentreedetail']['prix_achat'],
					'produit_id' => $bonentree['Bonentreedetail']['produit_id'],
					'stock_source' => $bonentree['Bonentreedetail']['stock_source'],
					'depot_source_id' => ( isset( $bonentree['Bonentreedetail']['depot_source_id'] ) ) ? $bonentree['Bonentreedetail']['depot_source_id'] : 1,
					'date' => ( isset( $bonentree['Bonentreedetail']['date'] ) ) ? date('Y-m-d', strtotime( $bonentree['Bonentreedetail']['date'] ) ) : date('Y-m-d') ,
					'date_sortie' => ( isset( $bonentree['Bonentreedetail']['date_sortie'] ) AND !empty( $bonentree['Bonentreedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $bonentree['Bonentreedetail']['date_sortie'] ) ) : null ,
					'date_fabrication' => ( isset( $bonentree['Bonentreedetail']['date_fabrication'] ) AND !empty( $bonentree['Bonentreedetail']['date_fabrication'] ) ) ? date('Y-m-d', strtotime( $bonentree['Bonentreedetail']['date_fabrication'] ) ) : null ,
					'date_peremption' => ( isset( $bonentree['Bonentreedetail']['date_peremption'] ) AND !empty( $bonentree['Bonentreedetail']['date_peremption'] ) ) ? date('Y-m-d', strtotime( $bonentree['Bonentreedetail']['date_peremption'] ) ) : null ,
					'description' => "Numéro du bon d'entrée : ".$entree['Bonentree']['reference'],
				];
			}

			$this->loadModel('Mouvement');
			$this->loadModel('Depotproduit');
			$this->loadModel('Entree');

			if ($this->Mouvement->saveMany($mouvement)) {

					foreach ($details as $bonentree) { 

					$produit_id_tosave 			= $bonentree['Bonentreedetail']['produit_id'];
					$depot_id_tosave			= $bonentree['Bonentreedetail']['depot_source_id'];
					$quantite_entree_tosave 	= $bonentree['Bonentreedetail']['stock_source'];

					$save_data_entree = $this->entree($produit_id_tosave, $depot_id_tosave, $quantite_entree_tosave); 
							
					$depot = $this->Depotproduit->find('first',[ 'conditions'=>[ 'depot_id' => $depot_id_tosave, 'produit_id' => $produit_id_tosave ] ]);
					
					$donnees['Entree'] = [
						'quantite' => $quantite_entree_tosave,
						'depot_id' => $depot_id_tosave,
						'produit_id' => $produit_id_tosave,
						"type" => "Entree"
					];
					$this->Entree->saveMany($donnees);
				}

				$this->Bonentree->id = $bonentree_id;
				$this->Bonentree->saveField('valide',1);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );

		} else {
			$this->Session->setFlash('Opération impossible : bon déja validé','alert-danger');
		}
		
		return $this->redirect( $this->referer() );
	}

	public function entree($produit_id = null,$depot_id = null,$quantite_entree = 0) {
		$this->loadModel('Depotproduit');
		$depot = $this->Depotproduit->find('first',[ 'conditions'=>[ 'depot_id' => $depot_id, 'produit_id' => $produit_id ] ]);

		/* 
		// OLD CODE 
		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);
		*/

		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) ) ?  $depot['Depotproduit']['quantite'] : 0 ;
		$id = ( isset( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		$quantite = $ancienne_quantite + $quantite_entree;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
		];

		if ( $this->Depotproduit->save($data) ) {
			unset( $data ); return true;
		} else {
			unset( $data ); return false;
		}
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}

		$this->Bonentree->id = $id;
		if (!$this->Bonentree->exists()) {
			throw new NotFoundException(__('Invalide bon entree'));
		}
		if ($this->Bonentree->flagDelete()) {
			$this->Bonentree->Bonentreedetail->updateAll(['Bonentreedetail.deleted'=>1],['Bonentreedetail.bonentree_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonentree->Bonentreedetail->id = $id;
		if (!$this->Bonentree->Bonentreedetail->exists()) {
			throw new NotFoundException(__('Invalide detail bon entree'));
		}
		if ($this->Bonentree->Bonentreedetail->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}