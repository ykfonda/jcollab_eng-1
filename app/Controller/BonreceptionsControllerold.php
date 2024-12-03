<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class BonreceptionsController extends AppController {
	public $idModule = 94;
	
	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$depots = $this->Bonreception->Depot->findList(['Depot.principal'=>1]);
		$fournisseurs = $this->Bonreception->Fournisseur->find('list');
		$users = $this->Bonreception->User->findList();
		$this->set(compact('depots','users','fournisseurs','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Bonreception->Bonreceptiondetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$admins = $this->Session->read('admins');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		if ( !in_array($role_id, $admins) );
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonreception.reference' )
					$conditions['Bonreception.reference LIKE '] = "%$value%";
				else if( $param_name == 'Bonreception.date1' )
					$conditions['Bonreception.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonreception.date2' )
					$conditions['Bonreception.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
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
			
		$conditions[] = array('OR' => array(
			array(
				'Bonreception.depot_id' => $depots,
			),
			array(
				'Bonreception.type' => "Expedition",
				'Bonreception.depot_id' => $selected_store
			),
		));
		

		$this->Bonreception->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Creator','User','Fournisseur'=>['Ville']],
			'order'=>['Bonreception.date'=>'DESC','Bonreception.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Bonreception->find('all',['contain'=>['User','Fournisseur'],'conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
	}

	public function editstatut($boncommande_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bonreception->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Bonreception->exists($boncommande_id)) {
			$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $boncommande_id));
			$this->request->data = $this->Bonreception->find('first', $options);
		}
		$this->layout = false;
	}

	public function editcommande() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ( isset($this->request->data['Bonreception']['boncommande_id']) AND !empty($this->request->data['Bonreception']['boncommande_id']) ) {
				$bonreceptiondetail['Bonreceptiondetail'] = [];
				$boncommande = $this->Bonreception->Boncommande->find('first', ['conditions' => ['Boncommande.id' => $this->request->data['Bonreception']['boncommande_id'] ]]);
				$this->request->data['Bonreception']['depot_id'] = ( isset($boncommande['Boncommande']['depot_id']) AND !empty($boncommande['Boncommande']['depot_id']) ) ? $boncommande['Boncommande']['depot_id'] : 1 ;
				$this->request->data['Bonreception']['fournisseur_id'] = ( isset($boncommande['Boncommande']['fournisseur_id']) AND !empty($boncommande['Boncommande']['fournisseur_id']) ) ? $boncommande['Boncommande']['fournisseur_id'] : null ;
				$details = $this->Bonreception->Boncommande->Boncommandedetail->find('all',['conditions'=>[ 'Boncommandedetail.boncommande_id'=>$this->request->data['Bonreception']['boncommande_id'] ]]);
				foreach ($details as $k => $v) {
					$bonreceptiondetail['Bonreceptiondetail'][] = [
						'boncommandedetail_id' => $v['Boncommandedetail']['id'],
						'produit_id' => $v['Boncommandedetail']['produit_id'],
						'prix_vente' => $v['Boncommandedetail']['prix_vente'],
						'qte_cmd' => $v['Boncommandedetail']['qte'],
						'total' => 0,
						'ttc' => 0,
						'qte' => 0,
					];
				}
				if ( !empty( $bonreceptiondetail ) ) $this->request->data['Bonreceptiondetail'] = $bonreceptiondetail['Bonreceptiondetail'];
			}
			if ($this->Bonreception->saveAssociated($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Bonreception->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		}

		$boncommandes = $this->Bonreception->Boncommande->findList(['Boncommande.etat'=>2,'Boncommande.recu'=>[-1,1]]);
		$this->set(compact('boncommandes','user_id','role_id'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bonreception->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Bonreception->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Bonreception->exists($id)) {
			$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);
		}

		$depots = $this->Bonreception->Depot->findList(['Depot.principal'=>1]);
		$fournisseurs = $this->Bonreception->Fournisseur->find('list');
		$users = $this->Bonreception->User->findList();
		$this->set(compact('users','fournisseurs','user_id','role_id','depots'));
		$this->layout = false;
	}

	public function editavance($id = null,$bonreception_id = null) {
		$boncommande = $this->Bonreception->find('first',['conditions'=>['id'=>$bonreception_id]]);
		$reste_a_payer = ( isset( $boncommande['Bonreception']['reste_a_payer'] ) ) ? $boncommande['Bonreception']['reste_a_payer'] : 0 ;
		$user_id = $this->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Depence']['user_id'] = $user_id;
			$this->request->data['Depence']['bonreception_id'] = $bonreception_id;
			if ($this->Bonreception->Depence->save($this->request->data)) {
				$this->calculatrice($bonreception_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Bonreception->Depence->exists($id)) {
			$options = array('conditions' => array('Depence.' . $this->Bonreception->Depence->primaryKey => $id));
			$this->request->data = $this->Bonreception->Depence->find('first', $options);
		}

		$this->set(compact('reste_a_payer'));
		$this->layout = false;
	}

	public function deleteavance($id = null,$bonreception_id = null) {
		$this->Bonreception->Depence->id = $id;
		if (!$this->Bonreception->Depence->exists()) {
			throw new NotFoundException(__('Invalide Depence'));
		}

		if ($this->Bonreception->Depence->flagDelete()) {
			$this->calculatrice($bonreception_id);
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
		$this->Bonreception->id = $id;
		if (!$this->Bonreception->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Bonreception->flagDelete()) {
			$this->Bonreception->Bonreceptiondetail->updateAll(['Bonreceptiondetail.deleted'=>1],['Bonreceptiondetail.bonreception_id'=>$id]);
			$this->Bonreception->Depence->updateAll(['Depence.deleted'=>1],['Depence.bonreception_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$bonreception_id = null) {
		$this->Bonreception->Bonreceptiondetail->id = $id;
		if (!$this->Bonreception->Bonreceptiondetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Bonreception->Bonreceptiondetail->flagDelete()) {
			$this->calculatrice($bonreception_id);
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
		if ($this->Bonreception->exists($id)) {
			$options = array('contain'=>['Fournisseur','Depot'],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);
			
			$details = $this->Bonreception->Bonreceptiondetail->find('all',[
				'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
				'fields' => ['Produit.*','Bonreceptiondetail.*'],
				'contain' => ['Produit'],
			]);

			$avances = $this->Bonreception->Depence->find('all',[
				'conditions' => ['Depence.bonreception_id'=>$id],
				'order' => ['date ASC'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}
        if ($this->request->data["Bonreception"]["type"] == "Expedition") {
            $depot_src = $this->Bonreception->Depot->find('first', ["conditions" => ["id" => $this->request->data["Bonreception"]["depot_source_id"], "deleted" => 0]]);
            
            $store_src = $this->Bonreception->Depot->Store->find('first', ["conditions" => ["id" => $depot_src["Depot"]["store_id"]]]);
            
            $societe_src = $this->Bonreception->Depot->Store->Societe->find('first', ["contain" => ["Client"],"conditions" => ["Societe.id" => $depot_src["Depot"]["societe_id"]]]);

            if (isset($societe_src["Client"]["id"])) {
                $client = $this->Bonreception->Depot->Store->Societe->Client->find('first', ["conditions" => ["id" => $societe_src["Client"]["id"]]]);
            
				$client_name = $client["Client"]["designation"];
			}
            
			
			else $client_name = null;


		/* 	$total = 0;
			
			for($i = 0; $i < count($details); $i++) {
				
				$details[$i]["Bonreceptiondetail"]["total"] = $details[$i]["Bonreceptiondetail"]["prix_vente"] * $details[$i]["Bonreceptiondetail"]["qte"]; 
				
				$this->Bonreception->Bonreceptiondetail->id = $details[$i]["Bonreceptiondetail"]["id"];
				$this->Bonreception->Bonreceptiondetail->savefield("total",$details[$i]["Bonreceptiondetail"]["total"]);	
			}
			
			$this->calculatrice($id); */
			$this->set(compact('store_src','client_name','societe_src','details','role_id','user_id','avances'));
			
		}
		else {
            $this->set(compact('details', 'role_id', 'user_id', 'avances'));
        }
			$this->getPath($this->idModule);
	}

	public function getProduit($produit_id = null,$depot_id = null) {
		$produit = $this->Bonreception->Bonreceptiondetail->Produit->find('first',[ 'conditions'=>['Produit.id'=>$produit_id] ]);
		$tva = ( isset( $produit['Produit']['tva_vente'] ) AND !empty( $produit['Produit']['tva_vente'] ) ) ? $produit['Produit']['tva_vente'] : 20 ;
		$prix_vente = ( isset( $produit['Produit']['prixachat'] ) AND !empty( $produit['Produit']['prixachat'] ) ) ? $produit['Produit']['prixachat'] : 20 ;
		die( json_encode( ['tva' => $tva , 'prix_vente' => $prix_vente ] ) );
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonreception->exists($id)) {
			$options = array('contain'=>['User','Fournisseur'=>['Ville']],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);

			$details = $this->Bonreception->Bonreceptiondetail->find('all',[
				'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
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
		if ($this->Bonreception->exists($id)) {
			$options = array('contain'=>['User','Fournisseur'=>['Ville']],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);

			$details = $this->Bonreception->Bonreceptiondetail->find('all',[
				'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
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

	public function editdetail($id = null,$bonreception_id = null) {
		$reception = $this->Bonreception->find('first', ['contain'=>['User'],'conditions' => ['Bonreception.id' => $bonreception_id]]);
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		if ( isset($reception['Bonreception']['boncommande_id']) AND !empty($reception['Bonreception']['boncommande_id']) ) {
			$produits_commandes = $this->Bonreception->Boncommande->Boncommandedetail->Produit->find('list',[
				'conditions' => [ 'Boncommandedetail.boncommande_id'=>$reception['Bonreception']['boncommande_id'] ],
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'boncommandedetails', 'alias' => 'Boncommandedetail', 'type' => 'INNER', 'conditions' => ['Boncommandedetail.produit_id = Produit.id','Boncommandedetail.deleted = 0'] ],
				],
			]);
			$produits_exists = $this->Bonreception->Bonreceptiondetail->Produit->find('list',[
				'conditions' => [ 'Bonreceptiondetail.bonreception_id'=>$bonreception_id ],
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'bonreceptiondetails', 'alias' => 'Bonreceptiondetail', 'type' => 'INNER', 'conditions' => ['Bonreceptiondetail.produit_id = Produit.id','Bonreceptiondetail.deleted = 0'] ],
				],
			]);
			$produits = $this->Bonreception->Bonreceptiondetail->Produit->findList(['Produit.id'=>$produits_commandes,'Produit.id !='=>$produits_exists]);
		} else {		
			$produits_exists = $this->Bonreception->Bonreceptiondetail->Produit->find('list',[
				'conditions' => [ 'Bonreceptiondetail.bonreception_id'=>$bonreception_id ],
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'bonreceptiondetails', 'alias' => 'Bonreceptiondetail', 'type' => 'INNER', 'conditions' => ['Bonreceptiondetail.produit_id = Produit.id','Bonreceptiondetail.deleted = 0'] ],
				],
			]);
			$produits = $this->Bonreception->Bonreceptiondetail->Produit->findList(['Produit.id !='=>$produits_exists]);
		}
		$qte_cmd = 0;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Bonreceptiondetail']['bonreception_id'] = $bonreception_id;
			if ($this->Bonreception->Bonreceptiondetail->save($this->request->data)) {
				$this->calculatrice($bonreception_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Bonreception->Bonreceptiondetail->exists($id)) {
			$options = array('conditions' => array('Bonreceptiondetail.' . $this->Bonreception->Bonreceptiondetail->primaryKey => $id));
			$this->request->data = $this->Bonreception->Bonreceptiondetail->find('first', $options);
			$produits = $this->Bonreception->Bonreceptiondetail->Produit->findList();
			if ( isset($this->request->data['Bonreceptiondetail']['boncommandedetail_id']) AND !empty($this->request->data['Bonreceptiondetail']['boncommandedetail_id']) ) {
				$qte_cmd = $this->request->data['Bonreceptiondetail']['qte_cmd'];
			}
		}

		$this->set(compact('produits','role_id','qte_cmd'));
		$this->layout = false;
	}
	public function chooseDepot($bonreception_id) {
		if ($this->request->is(array('post', 'put'))) {
			
			$this->Bonreception->id = $bonreception_id;
			$this->Bonreception->saveField("depot_id",$this->request->data["Validerexp"]["depots"]);
			$this->loadModel("Bonreceptiondetail");
			$depot_dest = $this->request->data["Validerexp"]["depots"];
			$this->Bonreception->Bonreceptiondetail->query("Update bonreceptiondetails set depot_id=$depot_dest where bonreception_id=$bonreception_id");
		
			$this->changestate($bonreception_id,2);
        }
		$entree = $this->Bonreception->find('first', [ 'conditions' => ['Bonreception.id' => $bonreception_id] ]);
		$depot_dest = $this->Bonreception->Depot->find("first",["conditions" => ["Depot.id" => $entree["Bonreception"]["depot_id"]]]);
		$depots = $this->Bonreception->Depot->find("list",["conditions" => ["Depot.store_id" => $depot_dest["Depot"]["store_id"]]]);
		//$depots = $this->Bonreception->Depot->find("list",["conditions" => ["Depot.id !=" => $entree["Bonreception"]["depot_id"]]]);
		$this->set(compact('depots','bonreception_id'));
		$this->layout = false;
	}
	public function changestate($bonreception_id = null,$etat = -1) {
		$reception = $this->Bonreception->find('first',['conditions'=>['Bonreception.id'=>$bonreception_id]]);
		$depot_id = ( !empty($reception['Bonreception']['depot_id']) ) ? $reception['Bonreception']['depot_id'] : 1;
		$details = $this->Bonreception->Bonreceptiondetail->find('all',['conditions' => ['bonreception_id'=>$bonreception_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonreception->id = $bonreception_id;
		if ($this->Bonreception->saveField('etat',$etat)) {
			$boncommande = $this->Bonreception->find('first', ['conditions' => ['Bonreception.id' => $bonreception_id]]);
			
			if ( isset( $boncommande['Bonreception']['id'] ) AND $boncommande['Bonreception']['etat'] == 2 ) {
				foreach ($details as $key => $value) $this->entree($value['Bonreceptiondetail']['produit_id'],$depot_id,$value['Bonreceptiondetail']['qte_cmd'],$value['Bonreceptiondetail']['prix_vente']);
			}
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function entree($produit_id = null,$depot_id = 1,$quantite_entree = 0,$prix_achat = 0) {
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

		$ancienne_quantite = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['quantite'] ) ) ? (int) $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite + $quantite_entree;
		if( $quantite <= 0 ) $quantite = 0;

		$id = ( isset( $source['Depotproduit']['id'] ) ) ? $source['Depotproduit']['id'] : null ;

		// Entrée 
		$entree = [
			'id' => null,
			'operation' => -1,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'prix_achat' => $prix_achat,
			'stock_source' => $quantite_entree,
			'depot_source_id' => $depot_id,
		];

		if ( $this->Mouvement->save($entree) ) unset( $entree );
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'quantite' => $quantite,
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) { unset( $data ); return true;
		} else return false;
	}

	public function mail($bonreception_id = null) {
		$boncommande = $this->Bonreception->find('first',['contain'=>['Fournisseur'],'conditions'=>['Bonreception.id'=>$bonreception_id]]);
		$email = ( isset( $boncommande['Fournisseur']['email'] ) AND !empty( $boncommande['Fournisseur']['email'] ) ) ? $boncommande['Fournisseur']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['bonreception_id'] = $bonreception_id;
			if ($this->Bonreception->Email->save($this->request->data)) {
				$url = $this->generatepdf($bonreception_id);
				$email_id = $this->Bonreception->Email->id;
				if ( $this->Bonreception->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Bonreception' => ['mimetype' => 'application/pdf','file' => $url ] ];
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

	public function calculatriceboncommande($boncommande_id = null) {
		$this->loadModel('Boncommande');
		$boncommande = $this->Boncommande->find('first',['conditions'=>['id'=>$boncommande_id]]);
		$remise = ( isset( $boncommande['Boncommande']['remise'] ) AND !empty( $boncommande['Boncommande']['remise'] ) ) ? (float) $boncommande['Boncommande']['remise'] : 0 ;
		$details = $this->Boncommande->Boncommandedetail->find('all',['conditions' => ['boncommande_id' => $boncommande_id]]);
		$avances = $this->Boncommande->Depence->find('all',['conditions' => ['boncommande_id' => $boncommande_id]]);
		$societe = $this->GetSociete();
		$tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100);

		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Boncommandedetail']['qte'];
			$total_paquet = $total_paquet + $value['Boncommandedetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Boncommandedetail']['total'];
		}

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

		$data['Boncommande'] = [
			'paye' => $paye,
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

		if( $this->Boncommande->save($data) ) return true;
		else return false;
	}

	public function calculatrice($bonreception_id = null) {
		$bonreception = $this->Bonreception->find('first',['conditions'=>['id'=>$bonreception_id]]);
		$remise = ( isset( $bonreception['Bonreception']['remise'] ) AND !empty( $bonreception['Bonreception']['remise'] ) ) ? (float) $bonreception['Bonreception']['remise'] : 0 ;
		$details = $this->Bonreception->Bonreceptiondetail->find('all',['conditions' => ['bonreception_id' => $bonreception_id]]);
		$avances = $this->Bonreception->Depence->find('all',['conditions' => ['bonreception_id' => $bonreception_id]]);
		$societe = $this->GetSociete();
		$tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100);
		
		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Bonreceptiondetail']['qte'];
			$total_paquet = $total_paquet + $value['Bonreceptiondetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonreceptiondetail']['total'];
		}

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

		if( $this->Bonreception->save($data) ) {

			if ( isset( $bonreception['Bonreception']['boncommande_id'] ) AND !empty( $bonreception['Bonreception']['boncommande_id'] ) ) {
				$this->Bonreception->Depence->updateAll([ 'Depence.boncommande_id'=>$bonreception['Bonreception']['boncommande_id'] ],[ 'Depence.bonreception_id'=>$bonreception_id ]);
				$this->calculatriceboncommande( $bonreception['Bonreception']['boncommande_id'] );
			}

			return true;
		} else return false;
	}

	public function generatepdf($bonreception_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonreception->exists($bonreception_id)) {
			$options = array('contain'=>['Fournisseur'=>['Ville']],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $bonreception_id));
			$data = $this->Bonreception->find('first', $options);

			$details = $this->Bonreception->Bonreceptiondetail->find('all',[
				'conditions' => ['Bonreceptiondetail.bonreception_id'=>$bonreception_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'BON DE RECEPTION']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $data['Fournisseur']['Ville']['libelle'] )) ? $data['Fournisseur']['Ville']['libelle'] : '' ;
		
		$html = '
		<html>
			<head>
				<title>BON DE RECEPTION N° : '.$data['Bonreception']['reference'].'</title>
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
			                    <h4 class="container">BON DE RECEPTION N° : '.$data['Bonreception']['reference'].'</h4>
			                </td>
			                <td style="width:50%;text-align:center;">
			                    <h4 class="container">DATE : '.$data['Bonreception']['date'].'</h4>
			                </td>
			            </tr>
			            <tr>
			                <td style="width:50%;text-align:center;"></td>
			                <td style="width:50%;text-align:left;">
			                    <h4 class="container">
				                    '.strtoupper($data['Fournisseur']['designation']).'<br/>
				                    '.strtoupper($data['Fournisseur']['adresse']).'<br/>
				                    '.$ville.'<br/>
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
			                    <td nowrap style="text-align:right;">'.$tache['Bonreceptiondetail']['qte'].'</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Bonreceptiondetail']['prix_vente'], 2, ',', ' ').'</td>
			                    <td nowrap style="text-align:right;">'.number_format($tache['Bonreceptiondetail']['total'], 2, ',', ' ').'</td>
			                </tr>';
			            }
			            $html .= '
			                <tr class="hide_total">
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="hide_total">TOTAL HT</td>
			                    <td class="hide_total">'.number_format($data['Bonreception']['total_a_payer_ht'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
			                    <td class="total">'.number_format($data['Bonreception']['montant_tva'], 2, ',', ' ').'</td>
			                </tr>
			                <tr >
			                    <td style="border:none;"></td>
			                    <td style="border:none;"></td>
			                    <td class="total">NET A PAYER</td>
			                    <td class="total">'.number_format($data['Bonreception']['total_a_payer_ttc'], 2, ',', ' ').'</td>
			                </tr>
			        </tbody>
			    </table>

			    <table width="100%">
			        <tbody>
			            <tr>
			                <td style="width:60%;text-align:left;font-weight:bold;">
			                    <u>Arrêtée la présente bon de récéption à la somme de :</u>
			                </td>
			                <td style="width:40%;text-align:left;font-weight:bold;">
			                    '.strtoupper( $LettreHelper->NumberToLetter( strval($data['Bonreception']['total_a_payer_ttc']) ) ).' DHS
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
		file_put_contents($destination.DS.'Bonreception.'.$data['Bonreception']['date'].'-'.$data['Bonreception']['id'].'.pdf', $output);
		return $destination.DS.'Bonreception.'.$data['Bonreception']['date'].'-'.$data['Bonreception']['id'].'.pdf';
	}
}