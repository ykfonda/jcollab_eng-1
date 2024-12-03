<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class BoncommandesController extends AppController {
	public $idModule = 89;

	public function index() {
		$depots = $this->Session->read('depots');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');

		$fournisseurs = $this->Boncommande->Fournisseur->find('list');

		//---  recupérer uniquement les dépots de site en cours 
		// 	$depots = $this->Boncommande->Depot->findList(['Depot.principal'=>1,'Depot.id'=>$depots]);
		$this->loadModel("Depot");
		$depots = $this->Depot->find("list", ["conditions" => ["store_id" => $selected_store]]);


		$users = $this->Boncommande->User->findList();
		$this->set(compact('users','fournisseurs','user_id','role_id', 'depots'));
		$this->getPath($this->idModule);
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Boncommande->Boncommandedetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$admins = $this->Session->read('admins');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		if ( !in_array($role_id, $admins) ) $conditions['Boncommande.user_c'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Boncommande.reference' )
					$conditions['Boncommande.reference LIKE '] = "%$value%";
				else if( $param_name == 'Boncommande.date1' )
					$conditions['Boncommande.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Boncommande.date2' )
					$conditions['Boncommande.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");
		$depots = $this->Depot->find("list", ["conditions" => ["store_id" => $selected_store],
		'fields' => ['id']]);
			
		$conditions['Boncommande.depot_id'] = $depots;

		$this->Boncommande->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Creator','User','Fournisseur'=>['Ville']],
			'order'=>['Boncommande.date'=>'DESC','Boncommande.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Boncommande->find('all',['contain'=>['User','Fournisseur'],'conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
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

				$produit = $this->Boncommande->Boncommandedetail->Produit->find('first',['fields'=>['id','prix_vente','stockactuel','unite_id','prixachat'],'conditions' => [ 'Produit.type' => 2,'Produit.code_barre' => $code_article ]]);
				if( !isset($produit['Produit']['id']) ) {
					$response['message'] = "Code a barre incorrect produit introuvable !";
				}
				
				$produit = $this->Boncommande->Boncommandedetail->Produit->find('first',[
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
	public function editstatut($boncommande_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Boncommande->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Boncommande->exists($boncommande_id)) {
			$options = array('conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $boncommande_id));
			$this->request->data = $this->Boncommande->find('first', $options);
		}
		$this->layout = false;
	}

	public function edit($id = null) {
		$depots = $this->Session->read('depots');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Boncommande->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Boncommande->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Boncommande->exists($id)) {
			$options = array('conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $id));
			$this->request->data = $this->Boncommande->find('first', $options);
		}
		$depots = $this->Boncommande->Depot->findList(['Depot.principal'=>1,'Depot.id'=>$depots]);
		$fournisseurs = $this->Boncommande->Fournisseur->find('list');
		$users = $this->Boncommande->User->findList();
		$this->set(compact('depots','users','fournisseurs','user_id','role_id'));
		$this->layout = false;
	}

	public function editavance($id = null,$boncommande_id = null) {
		$boncommande = $this->Boncommande->find('first',['conditions'=>['id'=>$boncommande_id]]);
		$reste_a_payer = ( isset( $boncommande['Boncommande']['reste_a_payer'] ) ) ? $boncommande['Boncommande']['reste_a_payer'] : 0 ;
		$user_id = $this->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Depence']['user_id'] = $user_id;
			$this->request->data['Depence']['boncommande_id'] = $boncommande_id;
			if ($this->Boncommande->Depence->save($this->request->data)) {
				$this->calculatrice($boncommande_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Boncommande->Depence->exists($id)) {
			$options = array('conditions' => array('Depence.' . $this->Boncommande->Depence->primaryKey => $id));
			$this->request->data = $this->Boncommande->Depence->find('first', $options);
		}

		$this->set(compact('reste_a_payer'));
		$this->layout = false;
	}

	public function deleteavance($id = null,$boncommande_id = null) {
		$this->Boncommande->Depence->id = $id;
		if (!$this->Boncommande->Depence->exists()) {
			throw new NotFoundException(__('Invalide Depence'));
		}

		if ($this->Boncommande->Depence->flagDelete()) {
			$this->calculatrice($boncommande_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Boncommande->id = $id;
		if (!$this->Boncommande->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Boncommande->flagDelete()) {
			$this->Boncommande->Boncommandedetail->updateAll(['Boncommandedetail.deleted'=>1],['Boncommandedetail.boncommande_id'=>$id]);
			$this->Boncommande->Depence->updateAll(['Depence.deleted'=>1],['Depence.boncommande_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$boncommande_id = null) {
		$this->Boncommande->Boncommandedetail->id = $id;
		if (!$this->Boncommande->Boncommandedetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Boncommande->Boncommandedetail->flagDelete()) {
			$this->calculatrice($boncommande_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function view($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		$avances = [];
		if ($this->Boncommande->exists($id)) {
			$options = array('contain'=>['Depot','Fournisseur'],'conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $id));
			$this->request->data = $this->Boncommande->find('first', $options);

			$details = $this->Boncommande->Boncommandedetail->find('all',[
				'conditions' => ['Boncommandedetail.boncommande_id'=>$id],
				'fields' => ['Produit.*','Boncommandedetail.*'],
				'contain' => ['Produit'],
			]);

			$avances = $this->Boncommande->Depence->find('all',[
				'conditions' => ['Depence.boncommande_id'=>$id],
				'order' => ['date ASC'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$this->set(compact('details','role_id','user_id','avances'));
		$this->getPath($this->idModule);
	}

	public function getProduit($produit_id = null,$depot_id = null) {
		$produit = $this->Boncommande->Boncommandedetail->Produit->find('first',[ 'conditions'=>['Produit.id'=>$produit_id] ]);
		$tva = ( isset( $produit['Produit']['tva_vente'] ) AND !empty( $produit['Produit']['tva_vente'] ) ) ? $produit['Produit']['tva_vente'] : 20 ;
		$prix_vente = ( isset( $produit['Produit']['prixachat'] ) AND !empty( $produit['Produit']['prixachat'] ) ) ? $produit['Produit']['prixachat'] : 20 ;
		die( json_encode( ['tva' => $tva , 'prix_vente' => $prix_vente ] ) );
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Boncommande->exists($id)) {
			$options = array('contain'=>['User','Fournisseur'=>['Ville']],'conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $id));
			$this->request->data = $this->Boncommande->find('first', $options);

			$details = $this->Boncommande->Boncommandedetail->find('all',[
				'conditions' => ['Boncommandedetail.boncommande_id'=>$id],
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
		$this->set(compact('details_tva', 'store_data','caisse_data','details','role','user_id','societe'));
		$this->layout = false;
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Boncommande->exists($id)) {
			$options = array('contain'=>['User','Fournisseur'=>['Ville']],'conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $id));
			$this->request->data = $this->Boncommande->find('first', $options);

			$details = $this->Boncommande->Boncommandedetail->find('all',[
				'conditions' => ['Boncommandedetail.boncommande_id'=>$id],
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

	public function editdetail($id = null,$boncommande_id = null) {
		$commande = $this->Boncommande->find('first', ['contain'=>['User'],'conditions' => ['Boncommande.id' => $boncommande_id]]);
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		$produits_exists = $this->Boncommande->Boncommandedetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'boncommandedetails', 'alias' => 'Boncommandedetail', 'type' => 'INNER', 'conditions' => ['Boncommandedetail.produit_id = Produit.id','Boncommandedetail.deleted = 0'] ],
			],
			'conditions' => [ 'Boncommandedetail.boncommande_id'=>$boncommande_id ]
		]);

		$produits = $this->Boncommande->Boncommandedetail->Produit->findList([
			'Produit.id !='=>$produits_exists
		]);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Boncommandedetail']['boncommande_id'] = $boncommande_id;
			if ($this->Boncommande->Boncommandedetail->save($this->request->data)) {
				$this->calculatrice($boncommande_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Boncommande->Boncommandedetail->exists($id)) {
			$options = array('conditions' => array('Boncommandedetail.' . $this->Boncommande->Boncommandedetail->primaryKey => $id));
			$this->request->data = $this->Boncommande->Boncommandedetail->find('first', $options);
			$produits = $this->Boncommande->Boncommandedetail->Produit->findList();
		}

		$this->set(compact('produits','role_id'));
		$this->layout = false;
	}

	public function changestate($boncommande_id = null,$etat = -1) {
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$details = $this->Boncommande->Boncommandedetail->find('all',['conditions' => ['boncommande_id'=>$boncommande_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Boncommande->id = $boncommande_id;
		if ($this->Boncommande->saveField('etat',$etat)) {
			if($etat == 2) $this->Boncommande->saveField('paye',2);
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function mail($boncommande_id = null) {
		$boncommande = $this->Boncommande->find('first',['contain'=>['Fournisseur'],'conditions'=>['Boncommande.id'=>$boncommande_id]]);
		$email = ( isset( $boncommande['Fournisseur']['email'] ) AND !empty( $boncommande['Fournisseur']['email'] ) ) ? $boncommande['Fournisseur']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['boncommande_id'] = $boncommande_id;
			if ($this->Boncommande->Email->save($this->request->data)) {
				$url = $this->generatepdf($boncommande_id);
				$email_id = $this->Boncommande->Email->id;
				if ( $this->Boncommande->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Boncommande' => ['mimetype' => 'application/pdf','file' => $url ] ];
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

	public function calculatricebonreception($bonreception_id = null) {
		$this->loadModel('Bonreception');
		$bonreception = $this->Bonreception->find('first',['conditions'=>['id'=>$bonreception_id]]);
		$remise = ( isset( $bonreception['Bonreception']['remise'] ) AND !empty( $bonreception['Bonreception']['remise'] ) ) ? (float) $bonreception['Bonreception']['remise'] : 0 ;
		$details = $this->Bonreception->Bonreceptiondetail->find('all',['contain' => ["Produit"],'conditions' => ['bonreception_id' => $bonreception_id]]);
		$avances = $this->Bonreception->Depence->find('all',['conditions' => ['bonreception_id' => $bonreception_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100);
 */
		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Bonreceptiondetail']['qte'];
			$total_paquet = $total_paquet + $value['Bonreceptiondetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonreceptiondetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ? (int) $value['Produit']['tva_vente'] : 0 ;
		}
		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);
		
		$total_paye = 0;
		foreach ($avances as $k => $value) {
			$total_paye = $total_paye + $value['Depence']['montant'];
		}

		$total_apres_reduction = round( ($total_a_payer_ht - $reduction)+$montant_tva ,2);

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		if ( $total_apres_reduction == $total_paye ) $paye = 2;
		else if( $total_paye == 0 ) $paye = -1;
		else $paye = 1;

		$data['Bonreception'] = [
			'paye' => $paye,
			'id' => $bonreception_id,
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

		if( $this->Bonreception->save($data) ) return true;
		else return false;
	}

	public function calculatrice($boncommande_id = null) {
		$boncommande = $this->Boncommande->find('first',['conditions'=>['id'=>$boncommande_id]]);
		$remise = ( isset( $boncommande['Boncommande']['remise'] ) AND !empty( $boncommande['Boncommande']['remise'] ) ) ? (float) $boncommande['Boncommande']['remise'] : 0 ;
		$details = $this->Boncommande->Boncommandedetail->find('all',['contain' => ["Produit"],'conditions' => ['boncommande_id' => $boncommande_id]]);
		//$avances = $this->Boncommande->Depence->find('all',['conditions' => ['boncommande_id' => $boncommande_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100); */

		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Boncommandedetail']['qte'];
			$total_paquet = $total_paquet + $value['Boncommandedetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Boncommandedetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ? (int) $value['Produit']['tva_vente'] : 0 ;
		}

		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);
		
		/* $total_paye = 0;
		foreach ($avances as $k => $value) {
			$total_paye = $total_paye + $value['Depence']['montant'];
		} */

		

		$total_apres_reduction = round( ($total_a_payer_ht - $reduction)+$montant_tva ,2);

		//add
		$total_paye = $total_apres_reduction;

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

	/* 	if ( $total_apres_reduction == $total_paye ) $paye = 2;
		else if( $total_paye == 0 ) $paye = -1;
		else $paye = 1;
 */
		$data['Boncommande'] = [
			//'paye' => $paye,
			'id' => $boncommande_id,
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

		if( $this->Boncommande->save($data) ) {

			if ( isset( $boncommande['Boncommande']['bonreception_id'] ) AND !empty( $boncommande['Boncommande']['bonreception_id'] ) ) {
				$this->Boncommande->Depence->updateAll([ 'Depence.bonreception_id'=>$boncommande['Boncommande']['bonreception_id'] ],[ 'Depence.boncommande_id'=>$boncommande_id ]);
				$this->calculatricebonreception( $boncommande['Boncommande']['bonreception_id'] );
			}

			return true;
		} else return false;
	}

	public function bonreception($boncommande_id = null) {
		if ($this->Boncommande->exists($boncommande_id)) {
			$options = array('conditions' => array('Boncommande.id' => $boncommande_id));
			$boncommande = $this->Boncommande->find('first', $options);
			$details = $this->Boncommande->Boncommandedetail->find('all',['conditions' => ['boncommande_id'=>$boncommande_id]]);
			$avances = $this->Boncommande->Depence->find('all',['conditions' => ['boncommande_id' => $boncommande_id]]);

			$data['Bonreception'] = [
				'etat' => 1,
				'id' => null,
				'boncommande_id' => $boncommande_id,
				'date' => $boncommande['Boncommande']['date'],
				'remise' => $boncommande['Boncommande']['remise'],
				'reduction' => $boncommande['Boncommande']['reduction'],
				'montant_tva' => $boncommande['Boncommande']['montant_tva'],
				'active_remise' => $boncommande['Boncommande']['active_remise'],
				'fournisseur_id' => $boncommande['Boncommande']['fournisseur_id'],
				'total_qte' => $boncommande['Boncommande']['total_qte'],
				'total_paye' => $boncommande['Boncommande']['total_paye'],
				'total_paquet' => $boncommande['Boncommande']['total_paquet'],
				'reste_a_payer' => $boncommande['Boncommande']['reste_a_payer'],
				'total_a_payer_ht' => $boncommande['Boncommande']['total_a_payer_ht'],
				'total_a_payer_ttc' => $boncommande['Boncommande']['total_a_payer_ttc'],
				'total_apres_reduction' => $boncommande['Boncommande']['total_apres_reduction'],
			];

			$data['Depence'] = [];
			foreach ($avances as $key => $value) {
				$data['Depence'][] = [
					'id' => $value['Depence']['id'],
				];
			}

			$data['Bonreceptiondetail'] = [];
			foreach ($details as $key => $value) {
				$data['Bonreceptiondetail'][] = [
					'id' => null,
					'depot_id' => 1,
					'ttc' => $value['Boncommandedetail']['ttc'],
					'qte' => $value['Boncommandedetail']['qte'],
					'total' => $value['Boncommandedetail']['total'],
					'paquet' => $value['Boncommandedetail']['paquet'],
					'prix_vente' => $value['Boncommandedetail']['prix_vente'],
					'produit_id' => $value['Boncommandedetail']['produit_id'],
					'total_unitaire' => $value['Boncommandedetail']['total_unitaire'],
				];
			}

			if ($this->Boncommande->Bonreception->saveAssociated($data)) {
				$bonreception_id = $this->Boncommande->Bonreception->id;
				$this->Boncommande->id = $boncommande_id;
				if( $this->Boncommande->saveField('bonreception_id',$bonreception_id) );
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}
	}

	public function generatepdf($boncommande_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Boncommande->exists($boncommande_id)) {
			$options = array('contain'=>['Fournisseur'=>['Ville']],'conditions' => array('Boncommande.' . $this->Boncommande->primaryKey => $boncommande_id));
			$data = $this->Boncommande->find('first', $options);

			$details = $this->Boncommande->Boncommandedetail->find('all',[
				'conditions' => ['Boncommandedetail.boncommande_id'=>$boncommande_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'BON DE COMMANDE']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $data['Fournisseur']['Ville']['libelle'] )) ? $data['Fournisseur']['Ville']['libelle'] : '' ;
		
		$html = '
		<html>
			<head>
				<title>Bon de commande</title>
			    '.$style.'
			</head>
			<body>

			    '.$header.'

			    '.$footer.'

			    <table class="info" width="100%">
			        <tbody>
			            <tr>
			                <td style="width:50%;text-align:center;">
			                    <h4 class="container">BON DE COMMANDE N° : '.$data['Boncommande']['reference'].'</h4>
			                </td>
			                <td style="width:50%;text-align:center;">
			                    <h4 class="container">DATE : '.$data['Boncommande']['date'].'</h4>
			                </td>
			            </tr>
			            <tr>
			                <td style="width:50%;text-align:center;"></td>
			                <td style="width:50%;text-align:left;">
			                    <h4 class="container">
				                    '.strtoupper($data['Fournisseur']['designation']).'<br/>
				                    '.strtoupper($data['Fournisseur']['adresse']).'<br/>
				                    '.$ville.'<br/><br/>
				                    ICE : '.strtoupper($data['Fournisseur']['ice']).'
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
			                    <td nowrap style="text-align:right;">'.$tache['Boncommandedetail']['qte'].'</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Boncommandedetail']['prix_vente'], 2, ',', ' ').'</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Boncommandedetail']['total'], 2, ',', ' ').'</td>
			                </tr>';
			            }
			            $html .= '
			                <tr class="hide_total">
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="hide_total">TOTOL HT</td>
			                    <td class="hide_total">'.number_format($data['Boncommande']['total_a_payer_ht'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">TOTAL TVA ('.$data['Boncommande']['remise'].'%)</td>
			                    <td class="total">'.number_format($data['Boncommande']['montant_tva'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">NET A PAYER</td>
			                    <td class="total">'.number_format($data['Boncommande']['total_a_payer_ttc'], 2, ',', ' ').'</td>
			                </tr>
			        </tbody>
			    </table>

			    <table width="100%">
			        <tbody>
			            <tr>
			                <td style="width:60%;text-align:left;font-weight:bold;">
			                    <u>Arrêtée la présente bon de commande à la somme de :</u>
			                </td>
			                <td style="width:40%;text-align:left;font-weight:bold;">
			                    '.strtoupper( $LettreHelper->NumberToLetter( strval($data['Boncommande']['total_a_payer_ttc']) ) ).' DHS
			                </td>
			            </tr>
			        </tbody>
			    </table>

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
		file_put_contents($destination.DS.'Boncommande.'.$data['Boncommande']['date'].'-'.$data['Boncommande']['id'].'.pdf', $output);
		return $destination.DS.'Boncommande.'.$data['Boncommande']['date'].'-'.$data['Boncommande']['id'].'.pdf';
	}
}