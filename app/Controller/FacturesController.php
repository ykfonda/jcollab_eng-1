<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class FacturesController extends AppController {
	public $idModule = 87;
	

	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$clients = $this->Facture->Client->find('list');
		$users = $this->Facture->User->findList();
		$this->set(compact('users','clients','user_id','role_id','admins'));
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

				$produit = $this->Facture->Facturedetail->Produit->find('first',['fields'=>['id','prix_vente','stockactuel','unite_id','prixachat'],'conditions' => [ 'Produit.type' => 2,'Produit.code_barre' => $code_article ]]);
				if( !isset($produit['Produit']['id']) ) {
					$response['message'] = "Code a barre incorrect produit introuvable !";
				}
				
				$produit = $this->Facture->Facturedetail->Produit->find('first',[
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
	public function editbonlivraison() {
		//var_dump($this->request->data["Facture"]["bonlivraison_id"]);die();
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ( isset($this->request->data['Facture']['bonlivraison_id']) AND !empty($this->request->data['Facture']['bonlivraison_id']) ) {
				$facturedetail['facturedetail'] = [];
				$bonlivraison = $this->Facture->Bonlivraison->find('first', ['conditions' => ['Bonlivraison.id' => $this->request->data['Facture']['bonlivraison_id'] ]]);
				$this->request->data['Facture']['depot_id'] = ( isset($bonlivraison['Bonlivraison']['depot_id']) AND !empty($boncommande['Bonlivraison']['depot_id']) ) ? $bonlivraison['Boncommande']['depot_id'] : 1 ;
				$this->request->data['Facture']['client_id'] = $this->request->data["Facture"]["client_id"];
				
				//$this->request->data['Bonreception']['fournisseur_id'] = ( isset($boncommande['Boncommande']['fournisseur_id']) AND !empty($boncommande['Boncommande']['fournisseur_id']) ) ? $boncommande['Boncommande']['fournisseur_id'] : null ;
				
				$bonlivraisons = $this->request->data["Facture"]["bonlivraison_id"];
				unset($this->request->data["Facture"]["bonlivraison_id"]);
                foreach ($bonlivraisons as $k => $v) {
                    $details = $this->Facture->Bonlivraison->Bonlivraisondetail->find('all', ['conditions'=>[ 'Bonlivraisondetail.bonlivraison_id'=>$v ]]);
                
                    foreach ($details as $k => $v) {
                        $facturedetail['Facturedetail'][] = [
                        //'boncommandedetail_id' => $v['Boncommandedetail']['id'],
                        'produit_id' => $v['Bonlivraisondetail']['produit_id'],
                        'prix_vente' => $v['Bonlivraisondetail']['prix_vente'],
                        //'qte_cmd' => $v['Bonlivraisondetail']['qte'],
                        'qte' => $v['Bonlivraisondetail']['qte'],
                        'total' => $v['Bonlivraisondetail']['total'],
                        'ttc' => $v['Bonlivraisondetail']['ttc'],
                    ];
                    }
                }
				if ( !empty( $facturedetail ) ) $this->request->data['Facturedetail'] = $facturedetail['Facturedetail'];
			}
			if ($this->Facture->saveAssociated($this->request->data)) {
				$this->calculatrice($this->Facture->getLastInsertID());
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Facture->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		}

		$clients = $this->Facture->Client->find('list');
		//$bonlivraisons = $this->Facture->Bonlivraison->find("list",["conditions" => ['Bonlivraison.facture_id'=>null]]);
		$this->set(compact('clients'/* ,'bonlivraisons' */,'user_id','role_id'));
		$this->layout = false;
	}

	public function getBonlivraisonClient($client_id = null) 
	{
		$bonlivraisons = $this->Facture->Bonlivraison->find("list",["conditions" => ['Bonlivraison.client_id'=> $client_id,'Bonlivraison.facture_id'=>null]]);

		die( json_encode( $bonlivraisons ) );
	}

	public function getclient($client_id = null) {
		/* $req = $this->Facture->Client->find('first',['conditions' => ['id'=>$client_id]]);
		$remise = ( isset( $req['Client']['id'] ) AND !empty( $req['Client']['remise'] ) ) ? (float) $req['Client']['remise'] : 0 ;
		die( json_encode( $remise ) ); */
		$this->loadModel("Remiseclient");
		$remisegloable = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "globale"]]);
		
		if(isset($remisegloable["Remiseclient"]["id"])) {
			
			$remise = intval($remisegloable["Remiseclient"]["montant"]);		
		}
		else $remise = 0;
		die( json_encode( $remise ) );
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Facture->Facturedetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$admins = $this->Session->read('admins');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		if ( !in_array($role_id, $admins) ) $conditions['Facture.user_c'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Facture.reference' )
					$conditions['Facture.reference LIKE '] = "%$value%";
				else if( $param_name == 'Facture.date1' )
					$conditions['Facture.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Facture.date2' )
					$conditions['Facture.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
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
			
		$conditions['Facture.depot_id'] = $depots;

		$this->Facture->recursive = -1;
		$settings = [
			'contain'=>['Creator','User','Client'=>['Ville','Categorieclient']],
			'order'=>['Facture.date'=>'DESC','Facture.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$this->Paginator->settings = $settings;
		$taches = $this->Paginator->paginate();
		$factures = $this->Facture->find('all',$settings);
		$this->set(compact('taches','factures','user_id'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');
		$this->loadModel("Module");
		$module = $this->Module->find('first',array('conditions' => array('Module.libelle' => "Remise")));
		
		$permission = $this->getPermissionByModule($module["Module"]["id"]);

		if ($this->request->is(array('post', 'put'))) {
			//$this->request->data['Facture']['user_id'] = $user_id;
			$this->request->data['Facture']['active_remise'] = ( isset( $this->request->data['Facture']['active_remise'] ) AND !empty( $this->request->data['Facture']['active_remise'] ) ) ? 1 : -1 ;
			if ( $this->request->data['Facture']['active_remise'] == -1 ) $this->request->data['Facture']['remise'] = 0;
			if ($this->Facture->save($this->request->data)) {
				if ( isset( $this->request->data['Facture']['id'] ) AND !empty( $this->request->data['Facture']['id'] ) ) {
					$this->calculatrice($this->request->data['Facture']['id']);
				}
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Facture->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Facture->exists($id)) {
			$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);
		}

		$depots = $this->Facture->Depot->findList([/* 'Depot.vente'=>1, */'Depot.id'=>$depots]);
		$clients = $this->Facture->Client->find('list');
		$users = $this->Facture->User->findList();
		$this->set(compact('depots','permission','users','clients','user_id','role_id','admins'));
		$this->layout = false;
	}

	public function editstatut($facture_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Facture->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Facture->exists($facture_id)) {
			$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $facture_id));
			$this->request->data = $this->Facture->find('first', $options);
		}
		$this->layout = false;
	}

	public function reduction($facture_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Facture->save($this->request->data)) {
				$this->calculatrice($facture_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Facture->exists($facture_id)) {
			$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $facture_id));
			$this->request->data = $this->Facture->find('first', $options);
		}
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Facture->id = $id;
		if (!$this->Facture->exists()) {
			throw new NotFoundException(__('Invalide facture'));
		}

		if ($this->Facture->flagDelete()) {
			$this->Facture->Facturedetail->updateAll(['Facturedetail.deleted'=>1],['Facturedetail.facture_id'=>$id]);
			$this->Facture->Avance->updateAll(['Avance.deleted'=>1],['Avance.facture_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$facture_id = null) {
		$this->Facture->Facturedetail->id = $id;
		if (!$this->Facture->Facturedetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Facture->Facturedetail->flagDelete()) {
			$this->calculatrice($facture_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function view($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		//$depot_id = $this->Session->read('Auth.User.depot_id');

		

		$details = [];
		$avances = [];
		if ($this->Facture->exists($id)) {
			$options = array('contain'=>['Client','Depot','User'],'conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);

			$details = $this->Facture->Facturedetail->find('all',[
				'fields' => [/* 'Depotproduit.*', */'Produit.*','Facturedetail.*','Depot.*'],
				'conditions' => ['Facturedetail.facture_id'=>$id],
				'contain' => ['Produit','Depot'],
				/* 'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.depot_id = Depot.id','Depotproduit.depot_id = '.$depot_id] ],
				], */
				'group'=>['Facturedetail.id']
			]);

			$avances = $this->Facture->Avance->find('all',[
				'conditions' => ['Avance.facture_id'=>$id],
				'order' => ['date ASC'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$this->set(compact('details','role_id','user_id','avances'));
		$this->getPath($this->idModule);
	}

	public function getProduitByDepot($facture_id = null,$depot_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Facture->Facturedetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'facturedetails', 'alias' => 'Facturedetail', 'type' => 'INNER', 'conditions' => ['Facturedetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Facturedetail.deleted'=>0,
				/* 'Facturedetail.depot_id'=>$depot_id, */
				'Facturedetail.facture_id'=>$facture_id,
			]
		]);

		$produits = $this->Facture->Facturedetail->Produit->findList(
			/* 'Produit.categorieproduit_id'=>$categorieproduit_id, */
			/* 'Depotproduit.depot_id'=>$depot_id,
			'Depotproduit.quantite >'=>0, */
		);

		die( json_encode( $produits ) );
	}

	public function getProduit($produit_id = null,$depot_id = null,$client_id = null) {
		$article = $this->Facture->Facturedetail->Produit->find('first',[
			'fields' => ['Produit.*'/* ,'Depotproduit.*' */],
			/* 'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
			], */
			'conditions'=>[
				'Produit.id'=>$produit_id,
				/* 'Depotproduit.depot_id'=>$depot_id */
			],
		]);

		//add
		$this->loadModel("Remiseclient");
		$remisearticle = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "article","produit_id" => $produit_id]]);
		$remisecategories = $this->Remiseclient->find("all", ["conditions" => ["client_id" => $client_id,"type" => "categorie"]]);
		$remisegloable = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "globale"]]);
		$remise= 0;

        if (isset($remisegloable["Remiseclient"]["id"])) {
            if (isset($remisearticle["Remiseclient"]["id"])) {
                $remise = floatval($remisearticle["Remiseclient"]["montant"]);
            }
        

            else if (isset($remisecategories[0]["Remiseclient"]["id"])) {
                $produit = $this->Facture->Facturedetail->Produit->find("first", ["conditions" => ["id" => $produit_id]]);
            
                foreach ($remisecategories as $remisecategorie) {
                    if ($produit["Produit"]["categorieproduit_id"] == $remisecategorie["Remiseclient"]["categorie_id"]) {
                        $remise = floatval($remisecategorie["Remiseclient"]["montant"]);
                    }
                }
            }
        }
		$article["remise"] = $remise;
		die( json_encode( $article ) );
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Facture->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);

			$details = $this->Facture->Facturedetail->find('all',[
				'conditions' => ['Facturedetail.facture_id'=>$id],
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
		if ($this->Facture->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);

			$details = $this->Facture->Facturedetail->find('all',[
				'conditions' => ['Facturedetail.facture_id'=>$id],
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

	public function editdetail($id = null,$facture_id = null) {
		$commande = $this->Facture->find('first', ['contain'=>['User'],'conditions' => ['Facture.id' => $facture_id]]);
		/* $depot_id = $this->Session->read('Auth.User.depot_id'); */
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		$this->loadModel("Module");
		$module = $this->Module->find('first',array('conditions' => array('Module.libelle' => "Remise")));
		
		$permission = $this->getPermissionByModule($module["Module"]["id"]);


		/* $produits = $this->Facture->Facturedetail->Produit->findList([
			'Depotproduit.depot_id'=>$depot_id,
			'Depotproduit.quantite >'=>0,
		]);
 */

$produits = $this->Facture->Facturedetail->Produit->findList(
	/* 'Produit.categorieproduit_id'=>$categorieproduit_id, */
	/* 'Depotproduit.depot_id'=>$depot_id,
	'Depotproduit.quantite >'=>0, */
);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Facturedetail']['facture_id'] = $facture_id;
			$this->request->data["Facturedetail"]["ttc"] = $this->request->data["Facturedetail"]["total"] - $this->request->data["Facturedetail"]["montant_remise"]; 
			if ($this->Facture->Facturedetail->save($this->request->data)) {
				$this->calculatrice($facture_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Facture->Facturedetail->exists($id)) {
			$options = array('conditions' => array('Facturedetail.' . $this->Facture->Facturedetail->primaryKey => $id));
			$this->request->data = $this->Facture->Facturedetail->find('first', $options);
			$produits = $this->Facture->Facturedetail->Produit->findList();
		}

		$depots = $this->Facture->Facturedetail->Depot->find('list');
		$categorieproduits = $this->Facture->Facturedetail->Produit->Categorieproduit->find('list');
		$this->set(compact('permission','role_id','produits','depot_id','depots','categorieproduits'));
		$this->layout = false;
	}

	public function changestate($facture_id = null,$etat = -1) {
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$facture = $this->Facture->find('first', ['contain'=>['User'],'conditions' => ['Facture.id' => $facture_id]]);

		$details = $this->Facture->Facturedetail->find('all',[
			'fields' => ['Depotproduit.*','Produit.*','Facturedetail.*','Depot.*'],
			'conditions' => ['Facturedetail.facture_id'=>$facture_id],
			'contain' => ['Produit','Depot'],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.depot_id = Depot.id'] ],
			],
			'group'=>['Facturedetail.id']
		]);
		
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}

		/* $error = false;
		foreach ($details as $key => $value) {
			$stock_actuel = ( isset( $value['Depotproduit']['quantite'] ) AND !empty( $value['Depotproduit']['quantite'] ) ) ? $value['Depotproduit']['quantite'] : 0;
			if ( $stock_actuel < $value['Facturedetail']['qte'] ) $error = true;
		}

		if ( $etat == 2 AND $error ) {
			$this->Session->setFlash('Opération impossible stock insuffisant','alert-danger');
			return $this->redirect( $this->referer() );
		} */

		$this->Facture->id = $facture_id;
		if ($this->Facture->saveField('etat',$etat)) {
			$facture = $this->Facture->find('first', ['conditions' => ['id' => $facture_id]]);
			
			if( isset( $facture['Facture']['id'] ) AND $facture['Facture']['etat'] == 2 ){ // Valider facture
				foreach ($details as $key => $value) {
					$this->sortie($value['Facturedetail']['produit_id'],$depot_id,$value['Facturedetail']['qte'],$value['Facturedetail']['paquet']);
				}
			}

			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function sortie($produit_id = null,$depot_id = 1,$quantite_sortie = 0,$paquet_sortie = 0) {
		$this->loadModel('Depotproduit');
		$req = $this->Depotproduit->find('first',[
			'conditions'=>[ 'depot_id' => $depot_id, 'produit_id' => $produit_id ] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_sortie,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);

		$old_quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (int) $req['Depotproduit']['quantite'] : 0 ;
		$old_paquet = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['paquet'] ) ) ? (int) $req['Depotproduit']['paquet'] : 0 ;
		$old_total = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['total'] ) ) ? (int) $req['Depotproduit']['total'] : 0 ;
		
		$quantite = $old_quantite  -  $quantite_sortie;
		if( $quantite <= 0 ) $quantite = 0;

		$paquet = $old_paquet  -  $paquet_sortie;
		if( $paquet <= 0 ) $paquet = 0;

		$total = $old_total - ( $quantite_sortie*$paquet_sortie );
		if( $total <= 0 ) $total = 0;

		$id = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['id'] ) ) ? $req['Depotproduit']['id'] : null ;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'quantite' => $quantite,
			'paquet' => $paquet,
			'total' => $total,
		];

		if ( $this->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function mail($facture_id = null) {
		$facture = $this->Facture->find('first',['contain'=>['Client'],'conditions'=>['Facture.id'=>$facture_id]]);
		$email = ( isset( $facture['Client']['email'] ) AND !empty( $facture['Client']['email'] ) ) ? $facture['Client']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['facture_id'] = $facture_id;
			if ($this->Facture->Email->save($this->request->data)) {
				$url = $this->generatepdf($facture_id);
				$email_id = $this->Facture->Email->id;
				if ( $this->Facture->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Facture' => ['mimetype' => 'application/pdf','file' => $url ] ];
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

	public function editavance($id = null,$facture_id = null) {
		$facture = $this->Facture->find('first',['conditions'=>['id'=>$facture_id]]);
		$reste_a_payer = ( isset( $facture['Facture']['reste_a_payer'] ) ) ? $facture['Facture']['reste_a_payer'] : 0 ;
		$client_id = ( isset( $facture['Facture']['client_id'] ) ) ? $facture['Facture']['client_id'] : null ;
		$user_id = $this->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Avance']['user_id'] = $user_id;
			$this->request->data['Avance']['facture_id'] = $facture_id;
			$this->request->data['Avance']['client_id'] = $client_id;
			if ($this->Facture->Avance->save($this->request->data)) {
				$this->calculatrice($facture_id);

				if ( isset( $facture['Facture']['bonlivraison_id'] ) AND !empty( $facture['Facture']['bonlivraison_id'] ) ) {
					$this->Facture->Avance->updateAll([ 'Avance.bonlivraison_id'=>$facture['Facture']['bonlivraison_id'] ],[ 'Avance.facture_id'=>$facture_id ]);
					$this->calculatrice($facture_id);
				}

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Facture->Avance->exists($id)) {
			$options = array('conditions' => array('Avance.' . $this->Facture->Avance->primaryKey => $id));
			$this->request->data = $this->Facture->Avance->find('first', $options);
		}

		$this->set(compact('reste_a_payer'));
		$this->layout = false;
	}

	public function deleteavance($id = null,$facture_id = null) {
		$this->Facture->Avance->id = $id;
		if (!$this->Facture->Avance->exists()) {
			throw new NotFoundException(__('Invalide Avance'));
		}

		if ($this->Facture->Avance->flagDelete()) {
			$this->calculatrice($facture_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function calculatricebonlivraison($bonlivraison_id = null) {
		$this->loadModel('Bonlivraison');
		$bonlivraison = $this->Bonlivraison->find('first',['conditions'=>['id'=>$bonlivraison_id]]);
		$remise = ( isset( $bonlivraison['Bonlivraison']['remise'] ) AND !empty( $bonlivraison['Bonlivraison']['remise'] ) ) ? (float) $bonlivraison['Bonlivraison']['remise'] : 0 ;
		$etat = ( isset( $bonlivraison['Bonlivraison']['etat'] ) AND !empty( $bonlivraison['Bonlivraison']['etat'] ) ) ? (int) $bonlivraison['Bonlivraison']['etat'] : -1 ;
		$details = $this->Bonlivraison->Bonlivraisondetail->find('all',['contain' => ["Produit"],'conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
		$avances = $this->Bonlivraison->Avance->find('all',['conditions' => ['bonlivraison_id' => $bonlivraison_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100); */

		
		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Bonlivraisondetail']['qte'];
			$total_paquet = $total_paquet + $value['Bonlivraisondetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonlivraisondetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ? (int) $value['Produit']['tva_vente'] : 0 ;
		}
		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		//$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$reduction = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);
		
		$total_paye = 0;
		foreach ($avances as $k => $value) {
			$total_paye = $total_paye + $value['Avance']['montant'];
		}

		$total_apres_reduction = round( ($total_a_payer_ht - $reduction)+$montant_tva ,2);

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		if ( $total_apres_reduction == $total_paye ) $paye = 2;
		else if( $total_paye == 0 ) $paye = -1;
		else $paye = 1;

		$data['Bonlivraison'] = [
			'paye' => $paye,
			'id' => $bonlivraison_id,
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

		if( $this->Bonlivraison->save($data) ) return true;
		else return false;
	}

	public function calculatrice($facture_id = null) {
		$facture = $this->Facture->find('first',['conditions'=>['id'=>$facture_id]]);
		$remise = ( isset( $facture['Facture']['remise'] ) AND !empty( $facture['Facture']['remise'] ) ) ? (float) $facture['Facture']['remise'] : 0 ;
		$etat = ( isset( $facture['Facture']['etat'] ) AND !empty( $facture['Facture']['etat'] ) ) ? (int) $facture['Facture']['etat'] : -1 ;
		$details = $this->Facture->Facturedetail->find('all',['contain' => ["Produit"],'conditions' => ['facture_id' => $facture_id]]);
		$avances = $this->Facture->Avance->find('all',['conditions' => ['facture_id' => $facture_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100); */

		
		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Facturedetail']['qte'];
			$total_paquet = $total_paquet + $value['Facturedetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Facturedetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ? (int) $value['Produit']['tva_vente'] : 0 ;
		}
		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		//$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$reduction = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);

		$total_paye = 0;
		foreach ($avances as $k => $value) {
			$total_paye = $total_paye + $value['Avance']['montant'];
		}

		$total_apres_reduction = round( ($total_a_payer_ht - $reduction)+$montant_tva ,2);

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		//add 
		$montant_remise = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;

		if ( $total_apres_reduction == $total_paye ) $paye = 2;
		else if( $total_paye == 0 ) $paye = -1;
		else $paye = 1;

		$data['Facture'] = [
			'paye' => $paye,
			'id' => $facture_id,
			'reduction' => $reduction,
			'total_qte' => $total_qte,
			'total_paye' => $total_paye,
			'montant_tva' => $montant_tva,
			'total_paquet' => $total_paquet,
			'reste_a_payer' => $reste_a_payer,
			'total_a_payer_ht' => $total_a_payer_ht,
			'total_a_payer_ttc' => $total_a_payer_ttc,
			'total_apres_reduction' => $total_apres_reduction,
			'montant_remise' => $montant_remise,
		];

		if( $this->Facture->save($data) ) {

			if ( isset( $facture['Facture']['bonlivraison_id'] ) AND !empty( $facture['Facture']['bonlivraison_id'] ) ) {
				$this->Facture->Avance->updateAll([ 'Avance.bonlivraison_id'=>$facture['Facture']['bonlivraison_id'] ],[ 'Avance.facture_id'=>$facture_id ]);
				$this->calculatricebonlivraison( $facture['Facture']['bonlivraison_id'] );
			}

			return true;
		} else return false;
	}

	public function generatepdf($facture_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Facture->exists($facture_id)) {
			$options = array('contain'=>['Client'=>['Ville']],'conditions' => array('Facture.' . $this->Facture->primaryKey => $facture_id));
			$data = $this->Facture->find('first', $options);

			$details = $this->Facture->Facturedetail->find('all',[
				'conditions' => ['Facturedetail.facture_id'=>$facture_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'FACTURE']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $this->data['Client']['Ville']['id'] ) AND !empty( $this->data['Client']['Ville']['id'] )) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '' ;
		$ice = (isset( $this->data['Client']['ice'] ) AND !empty( $this->data['Client']['ice'] )) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '' ;
		
		$html = '
		<html>
			<head>
				<title>Facture</title>
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
				                    <h4 class="container">FACTURE N° : '.$data['Facture']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">DATE : '.$data['Facture']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'
		                    			'.$ice.'
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
				                <th>Remise(%)</th>
				                <th>Montant total TTC</th>
				            </tr>
				        </thead>
				        <tbody>';
				            foreach ($details as $tache){
				                $html.='<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Facturedetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Facturedetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.(int)$tache['Facturedetail']['remise'].'%</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Facturedetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
				            }
				            $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Facture']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
				                    <td class="total">'.number_format($data['Facture']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TTC</td>
				                    <td class="total">'.number_format($data['Facture']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">REMISE('.(int)$data['Facture']['remise'].'%)</td>
				                    <td class="total">'.number_format($data['Facture']['reduction'], 2, ',', ' ').'%</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Facture']['total_apres_reduction'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente facture à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper( $LettreHelper->NumberToLetter( strval($data['Facture']['total_apres_reduction']) ) ).' DHS
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
		file_put_contents($destination.DS.'Facture.'.$data['Facture']['date'].'-'.$data['Facture']['id'].'.pdf', $output);
		return $destination.DS.'Facture.'.$data['Facture']['date'].'-'.$data['Facture']['id'].'.pdf';
	}
	
}