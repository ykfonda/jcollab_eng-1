<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class BonretoursController extends AppController {
	public $idModule = 86;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Bonretour->Client->find('list');
		$users = $this->Bonretour->User->findList(['role_id'=>3]);
		$this->set(compact('users','clients','user_id','role_id'));
		$this->getPath($this->idModule);
	}
	public function scan($code_barre = null, $depot_id = null) {
		$response['error'] = true;
		$response['message'] = "";
		$response['data']['prix_achat'] = 0;
		$response['data']['stock_source'] = 0;
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

				$produit = $this->Bonretour->Bonretourdetail->Produit->find('first',['fields'=>['id','prix_vente','stockactuel','unite_id','prixachat'],'conditions' => [ 'Produit.type' => 2,'Produit.code_barre' => $code_article ]]);
				if( !isset($produit['Produit']['id']) ) {
					$response['message'] = "Code a barre incorrect produit introuvable !";
				}
				
				$produit = $this->Bonretour->Bonretourdetail->Produit->find('first',[
					'fields' => [/* 'Depotproduit.*', */'Produit.*'],
					'conditions'=>['Produit.code_barre' => $code_article],
					/* 'joins' => [
						['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
					], */
				]);
				/* if(!isset($produit['Depotproduit']['id'])) {
					$response['message'] = "Le produit n'existe pas dans ce dépôt !";
				} */
				$quantite =  (float) $quantite;
				/* else */ if ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['id'] ) ) {
					if ( isset( $produit['Produit']['pese'] ) AND $produit['Produit']['pese'] == "1" ) $qte = round($quantite/$cb_div_kg,3); // autre  
					else $qte =  $quantite; // piéce

					if ( $qte < 0 ) $response['message'] = "Opération impossible la quantité doit étre supérieur a zéro !";
					else {
						$response['error'] = false;
						$response['data']['quantite_sortie'] = $qte;
						$response['data']['produit_id'] = $produit['Produit']['id'];
						//$response['data']['stock'] =  $produit['Depotproduit']['quantite'];
						$response['data']['prix'] =  $produit['Produit']['prix_vente'];
						
					}
				}  
			}
		}

		header('Content-Type: application/json; charset=UTF-8');
		die( json_encode( $response ) );
	}
	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Bonretour->Bonretourdetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');
		$conditions = [];
		if ( !in_array($role_id, $admins) ) $conditions['Bonretour.user_c'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonretour.reference' )
					$conditions['Bonretour.reference LIKE '] = "%$value%";
				else if( $param_name == 'Bonretour.date1' )
					$conditions['Bonretour.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonretour.date2' )
					$conditions['Bonretour.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Bonretour->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Creator','User','Client'=>['Ville','Categorieclient']],
			'order'=>['Bonretour.date'=>'DESC','Bonretour.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Bonretour->find('all',['contain'=>['User','Client'],'conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bonretour->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Bonretour->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Bonretour->exists($id)) {
			$options = array('conditions' => array('Bonretour.' . $this->Bonretour->primaryKey => $id));
			$this->request->data = $this->Bonretour->find('first', $options);
		}

		$clients = $this->Bonretour->Client->find('list');
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");
		$depots = $this->Depot->find("list", ["conditions" => ["store_id" => $selected_store]]);
		$users = $this->Bonretour->User->findList(['role_id'=>3]);
		$this->set(compact('users','depots','clients','user_id','role_id'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonretour->id = $id;
		if (!$this->Bonretour->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Bonretour->flagDelete()) {
			$this->Bonretour->Bonretourdetail->updateAll(['Bonretourdetail.deleted'=>1],['Bonretourdetail.bonretour_id'=>$id]);
			//$this->Bonretour->Avance->updateAll(['Avance.deleted'=>1],['Avance.bonretour_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$bonretour_id = null) {
		$this->Bonretour->Bonretourdetail->id = $id;
		if (!$this->Bonretour->Bonretourdetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Bonretour->Bonretourdetail->flagDelete()) {
			$this->calculatrice($bonretour_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function view($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		if ($this->Bonretour->exists($id)) {
			$options = array('contain'=>['Client','Depot'],'conditions' => array('Bonretour.' . $this->Bonretour->primaryKey => $id));
			$this->request->data = $this->Bonretour->find('first', $options);

			$details = $this->Bonretour->Bonretourdetail->find('all',[
				'conditions' => ['Bonretourdetail.bonretour_id'=>$id],
				'contain' => ['Produit'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$this->set(compact('details','role_id','user_id','flag'));
		$this->getPath($this->idModule);
	}

	public function getProduitByDepot($bonretour_id = null,$depot_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Bonretour->Bonretourdetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'bonretourdetails', 'alias' => 'Bonretourdetail', 'type' => 'INNER', 'conditions' => ['Bonretourdetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Bonretourdetail.deleted'=>0,
				'Bonretourdetail.bonretour_id'=>$bonretour_id,
			]
		]);

		$produits = $this->Bonretour->Bonretourdetail->Produit->findList([
			'Produit.categorieproduit_id'=>$categorieproduit_id,
			//'Produit.id !='=>$produits_exists
		]);

		die( json_encode( $produits ) );
	}

	public function getProduit($produit_id = null,$depot_id = null) {
		$article = $this->Bonretour->Bonretourdetail->Produit->find('first',[
			'conditions'=>['Produit.id'=>$produit_id],
		]);

		die( json_encode( $article ) );
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonretour->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Bonretour.' . $this->Bonretour->primaryKey => $id));
			$this->request->data = $this->Bonretour->find('first', $options);

			$details = $this->Bonretour->Bonretourdetail->find('all',[
				'conditions' => ['Bonretourdetail.bonretour_id'=>$id],
				'contain' => ['Depot','Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('details','role','user_id','societe'));
		$this->layout = false;
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonretour->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Bonretour.' . $this->Bonretour->primaryKey => $id));
			$this->request->data = $this->Bonretour->find('first', $options);

			$details = $this->Bonretour->Bonretourdetail->find('all',[
				'conditions' => ['Bonretourdetail.bonretour_id'=>$id],
				'contain' => ['Depot','Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('details','role','user_id','societe'));
		$this->layout = false;
	}

	public function editdetail($id = null,$bonretour_id = null) {
		$commande = $this->Bonretour->find('first', ['contain'=>['User'],'conditions' => ['Bonretour.id' => $bonretour_id]]);
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		$produits_exists = $this->Bonretour->Bonretourdetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'bonretourdetails', 'alias' => 'Bonretourdetail', 'type' => 'INNER', 'conditions' => ['Bonretourdetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Bonretourdetail.deleted'=>0,
				'Bonretourdetail.bonretour_id'=>$bonretour_id
			]
		]);

		$produits = $this->Bonretour->Bonretourdetail->Produit->findList([
			//'Produit.id !='=>$produits_exists
		]);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Bonretourdetail']['bonretour_id'] = $bonretour_id;
			if ($this->Bonretour->Bonretourdetail->save($this->request->data)) {
				$this->calculatrice($bonretour_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Bonretour->Bonretourdetail->exists($id)) {
			$options = array('conditions' => array('Bonretourdetail.' . $this->Bonretour->Bonretourdetail->primaryKey => $id));
			$this->request->data = $this->Bonretour->Bonretourdetail->find('first', $options);
			$produits = $this->Bonretour->Bonretourdetail->Produit->findList();
		}

		$depots = $this->Bonretour->Bonretourdetail->Depot->find('list');
		$categorieproduits = $this->Bonretour->Bonretourdetail->Produit->Categorieproduit->find('list');
		$this->set(compact('produits','role_id','depot_id','depots','categorieproduits'));
		$this->layout = false;
	}

	public function calculatrice($bonretour_id = null) {

		$bonretour = $this->Bonretour->find('first',['conditions'=>['id'=>$bonretour_id]]);
		$remise = ( isset( $bonretour['Bonretour']['remise'] ) AND !empty( $bonretour['Bonretour']['remise'] ) ) ? (float) $bonretour['Bonretour']['remise'] : 0 ;
		$details = $this->Bonretour->Bonretourdetail->find('all',['contain' => ["Produit"],'conditions' => ['bonretour_id' => $bonretour_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100); */
		$avances = [];

		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Bonretourdetail']['qte'];
			$total_paquet = $total_paquet + $value['Bonretourdetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonretourdetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ?  $value['Produit']['tva_vente'] : 0 ;
		}
		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);


		$total_paye = 0;
		foreach ($avances as $k => $value) {
			$total_paye = $total_paye + $value['Avance']['montant'];
		}

		$total_apres_reduction = ($total_a_payer_ht - $reduction)+$montant_tva;

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		$data['Bonretour'] = [
			'id' => $bonretour_id,
			'reduction' => $reduction,
			'total_qte' => $total_qte,
			'total_paye' => $total_paye,
			'montant_tva' => $montant_tva,
			'total_paquet' => $total_paquet,
			'reste_a_payer' => $reste_a_payer,
			'total_a_payer_ht' => $total_a_payer_ht,
			'total_a_payer_ttc' => $total_a_payer_ttc,
			'total_apres_reduction' => $total_apres_reduction,
		];

		if( $this->Bonretour->save($data) ) return true;
		else return false;
	}

	public function avoir($bonretour_id = null) {
		$depot_id = $this->Session->read('Auth.User.depot_id');
		if ($this->Bonretour->exists($bonretour_id)) {
			$bonretour = $this->Bonretour->find('first', ['conditions' => array('Bonretour.id' => $bonretour_id)]);
			$details = $this->Bonretour->Bonretourdetail->find('all',['conditions' => ['bonretour_id'=>$bonretour_id]]);

			$data['Bonavoir'] = [
				'etat' => 2,
				'id' => null,
				'bonretour_id' => $bonretour_id,
				'date' => $bonretour['Bonretour']['date'],
				'remise' => $bonretour['Bonretour']['remise'],
				'reduction' => $bonretour['Bonretour']['reduction'],
				'montant_tva' => $bonretour['Bonretour']['montant_tva'],
				'active_remise' => $bonretour['Bonretour']['active_remise'],
				'client_id' => $bonretour['Bonretour']['client_id'],
				'total_qte' => $bonretour['Bonretour']['total_qte'],
				'total_paye' => $bonretour['Bonretour']['total_paye'],
				'total_paquet' => $bonretour['Bonretour']['total_paquet'],
				'reste_a_payer' => $bonretour['Bonretour']['reste_a_payer'],
				'total_a_payer_ht' => $bonretour['Bonretour']['total_a_payer_ht'],
				'total_a_payer_ttc' => $bonretour['Bonretour']['total_a_payer_ttc'],
				'total_apres_reduction' => $bonretour['Bonretour']['total_apres_reduction'],
			];

			$data['Bonavoirdetail'] = [];
			foreach ($details as $k => $v) {
				$data['Bonavoirdetail'][] = [
					'id' => null,
					'depot_id' => $depot_id,
					'ttc' => $v['Bonretourdetail']['ttc'],
					'qte' => $v['Bonretourdetail']['qte'],
					'total' => $v['Bonretourdetail']['total'],
					'paquet' => $v['Bonretourdetail']['paquet'],
					'prix_vente' => $v['Bonretourdetail']['prix_vente'],
					'produit_id' => $v['Bonretourdetail']['produit_id'],
					'total_unitaire' => $v['Bonretourdetail']['total_unitaire'],
				];
			}

			if ($this->Bonretour->Bonavoir->saveAssociated($data)) {
				$bonavoir_id = $this->Bonretour->Bonavoir->id;
				$this->Bonretour->id = $bonretour_id;
				if( $this->Bonretour->saveField('bonavoir_id',$bonavoir_id) );
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}
	}

	public function changestate($bonretour_id = null,$etat = -1) {
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$details = $this->Bonretour->Bonretourdetail->find('all',['conditions' => ['Bonretourdetail.bonretour_id'=>$bonretour_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonretour->id = $bonretour_id;
		if ($this->Bonretour->saveField('etat',$etat)) {
			$bonretour = $this->Bonretour->find('first', ['conditions' => array('Bonretour.id' => $bonretour_id)]);
			if( isset( $bonretour['Bonretour']['id'] ) AND $bonretour['Bonretour']['etat'] == 2 ){ // Valider bon de retour
				foreach ($details as $key => $value) {
					$this->entree($value['Bonretourdetail']['produit_id'],$depot_id,$value['Bonretourdetail']['paquet'],$value['Bonretourdetail']['qte'],$value['Bonretourdetail']['total_unitaire']);
				}
			}
			
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
	public function editbonlivraison() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ( isset($this->request->data['Bonretour']['bonlivraison_id']) AND !empty($this->request->data['Bonretour']['bonlivraison_id']) ) {
				$bonretourdetail['facturedetail'] = [];
				$bonlivraison = $this->Bonretour->Bonlivraison->find('first', ['conditions' => ['Bonlivraison.id' => $this->request->data['Bonretour']['bonlivraison_id'] ]]);
				$this->request->data['Bonretour']['depot_id'] = ( isset($bonlivraison['Bonlivraison']['depot_id']) AND !empty($boncommande['Bonlivraison']['depot_id']) ) ? $bonlivraison['Boncommande']['depot_id'] : 1 ;
				$this->request->data['Bonretour']['client_id'] = $bonlivraison['Bonlivraison']['client_id'];
				
				
				//$this->request->data['Bonreception']['fournisseur_id'] = ( isset($boncommande['Boncommande']['fournisseur_id']) AND !empty($boncommande['Boncommande']['fournisseur_id']) ) ? $boncommande['Boncommande']['fournisseur_id'] : null ;
				$details = $this->Bonretour->Bonlivraison->Bonlivraisondetail->find('all',['conditions'=>[ 'Bonlivraisondetail.bonlivraison_id'=>$this->request->data['Bonretour']['bonlivraison_id'] ]]);
				
				foreach ($details as $k => $v) {
					$bonretourdetail['Bonretourdetail'][] = [
						//'boncommandedetail_id' => $v['Boncommandedetail']['id'],
						'produit_id' => $v['Bonlivraisondetail']['produit_id'],
						'prix_vente' => $v['Bonlivraisondetail']['prix_vente'],
						//'qte_cmd' => $v['Bonlivraisondetail']['qte'],
						'qte' => $v['Bonlivraisondetail']['qte'],
						'total' => $v['Bonlivraisondetail']['total'],
						'ttc' => $v['Bonlivraisondetail']['ttc'],
					];
				}
				if ( !empty( $bonretourdetail ) ) $this->request->data['Bonretourdetail'] = $bonretourdetail['Bonretourdetail'];
			}
			if ($this->Bonretour->saveAssociated($this->request->data)) {
				$this->calculatrice($this->Bonretour->getLastInsertID());
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Bonretour->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		}

		$bonlivraisons = $this->Bonretour->Bonlivraison->find("list",["conditions" => ['Bonlivraison.etat'=>2]]);
		$this->set(compact('bonlivraisons','user_id','role_id'));
		$this->layout = false;
	}
	public function entree($produit_id = null,$depot_id = 1,$paquet_entree = 0,$quantite_entree = 0,$total_entree = 0) {
		$this->loadModel('Mouvement');
		$source = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[
				'depot_id' => $depot_id,
				'produit_id' => $produit_id,
			] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);

		$ancienne_paquet = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['paquet'] ) ) ? (int) $source['Depotproduit']['paquet'] : 0 ;
		$paquet = $ancienne_paquet + $paquet_entree;
		if( $paquet <= 0 ) $paquet = 0;

		$ancienne_quantite = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['quantite'] ) ) ?  $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite + $quantite_entree;
	/* 	if( $quantite <= 0 ) $quantite = 0; */

		$ancienne_total = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['total'] ) ) ? (int) $source['Depotproduit']['total'] : 0 ;
		$total = $ancienne_total + $total_entree;
		if( $total <= 0 ) $total = 0;

		$id = ( isset( $source['Depotproduit']['id'] ) ) ? $source['Depotproduit']['id'] : null ;

		// Entrée 
		$entree = [
			'id' => null,
			'operation' => -1,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'paquet_source' => $paquet_entree,
			'stock_source' => $quantite_entree,
			'total_general' => $total_entree,
			'depot_source_id' => $depot_id,
		];

		$this->Mouvement->save($entree);
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'quantite' => $quantite,
			'paquet' => $paquet,
			'total' => $total,
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) {
			unset( $entree );
			unset( $data );
			return true;
		} else return false;
	}

	public function mail($bonretour_id = null) {
		$bonretour = $this->Bonretour->find('first',['contain'=>['Client'],'conditions'=>['Bonretour.id'=>$bonretour_id]]);
		$email = ( isset( $bonretour['Client']['email'] ) AND !empty( $bonretour['Client']['email'] ) ) ? $bonretour['Client']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['bonretour_id'] = $bonretour_id;
			if ($this->Bonretour->Email->save($this->request->data)) {
				$url = $this->generatepdf($bonretour_id);
				$email_id = $this->Bonretour->Email->id;
				if ( $this->Bonretour->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Bonretour' => ['mimetype' => 'application/pdf','file' => $url ] ];
					if ( $this->sendEmail($settings,$objet, $content, $to , $attachments) ) {
						$this->Session->setFlash('Votre email a été anvoyer avec succès.','alert-success');
					}else{
						$this->Session->setFlash("Problème d'envoi de mail",'alert-danger');
					}
				}
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}

		$this->set(compact('email'));
		$this->layout = false;
	}

	public function generatepdf($bonretour_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonretour->exists($bonretour_id)) {
			$options = array('contain'=>['Client'=>['Ville']],'conditions' => array('Bonretour.' . $this->Bonretour->primaryKey => $bonretour_id));
			$data = $this->Bonretour->find('first', $options);

			$details = $this->Bonretour->Bonretourdetail->find('all',[
				'conditions' => ['Bonretourdetail.bonretour_id'=>$bonretour_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'BON DE RETOUR']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $data['Client']['Ville']['libelle'] )) ? $data['Client']['Ville']['libelle'] : '' ;
		
		$html = '
		<html>
			<head>
				<title>Bon de retour</title>
			    '.$style.'
			</head>
			<body>

			    '.$header.'

			    '.$footer.'

			    <div>

				    <table class="info" width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">BON DE RETOUR N° : '.$data['Bonretour']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">DATE : '.$data['Bonretour']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'<br/>
					                    ICE : '.strtoupper($data['Client']['ice']).'
				                    </h4>
				                </td>
				            </tr>
				        </tbody>
				    </table>

				    <table class="details" width="100%">
				        <thead>
				            <tr>
				                <th>Désignation </th>
				                <th>Quantité </th>
				                <th>Prix TTC</th>
				                <th>Montant total TTC</th>
				            </tr>
				        </thead>
				        <tbody>';
				            foreach ($details as $tache){
				                $html.='<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Bonretourdetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonretourdetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonretourdetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
				            }
				            $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Bonretour']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
				                    <td class="total">'.number_format($data['Bonretour']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Bonretour']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente de don de retour à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper( $LettreHelper->NumberToLetter( strval( $data['Bonretour']['total_a_payer_ttc'] ) ) ).' DHS
				                </td>
				            </tr>
				        </tbody>
				    </table>

			    </div>

			    '.$footer.'

			</body>
		</html>';

		//echo $html;die;
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$canvas = $dompdf->get_canvas(); 
		$font = Font_Metrics::get_font("helvetica", "bold"); 
		$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
		$output = $dompdf->output();
		$destination = WWW_ROOT.'pdfs';
		if (!file_exists( $destination )) mkdir($destination,true, 0700);
		file_put_contents($destination.DS.'Bonretour.'.$data['Bonretour']['date'].'-'.$data['Bonretour']['id'].'.pdf', $output);
		return $destination.DS.'Bonretour.'.$data['Bonretour']['date'].'-'.$data['Bonretour']['id'].'.pdf';
	}
}