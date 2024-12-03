<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class DevisController extends AppController {
	public $idModule = 90;
	
	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		$users = $this->Devi->User->findList();
		$clients = $this->Devi->Client->findList();
		$depots = $this->Devi->Depot->findList(['Depot.vente'=>1,'Depot.id'=>$depots]);
		$this->set(compact('users','clients','depots','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function getclient($client_id = null) {
		/* $req = $this->Devi->Client->find('first',['conditions' => ['id'=>$client_id]]);
		$remise = ( isset( $req['Client']['id'] ) AND !empty( $req['Client']['remise'] ) ) ? (float) $req['Client']['remise'] : 0 ; */
		$this->loadModel("Remiseclient");
		$remisegloable = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "globale"]]);
		
		if(isset($remisegloable["Remiseclient"]["id"])) {
			
			$remise = intval($remisegloable["Remiseclient"]["montant"]);		
		}
		else $remise = 0;
		die( json_encode( $remise ) );
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Devi->Devidetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$admins = $this->Session->read('admins');
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions = [];
		if ( !in_array($role_id, $admins) ) $conditions['Devi.user_c'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Devi.reference' )
					$conditions['Devi.reference LIKE '] = "%$value%";
				else if( $param_name == 'Devi.date1' )
					$conditions['Devi.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Devi.date2' )
					$conditions['Devi.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$data['Filter'][$param_name] = $value;
				}
			}
		}

		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");
		$depots = $this->Depot->find("list", ["conditions" => ["store_id" => $selected_store],
		'fields' => ['id']]);
			
		$conditions['Devi.depot_id'] = $depots;

		$this->Devi->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Creator','User','Client'=>['Ville','Categorieclient']],
			'order'=>['Devi.date'=>'DESC','Devi.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Devi->find('all',['contain'=>['User','Client'],'conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$this->loadModel("Module");
		$module = $this->Module->find('first',array('conditions' => array('Module.libelle' => "Remise")));
		
		$permission = $this->getPermissionByModule($module["Module"]["id"]);

		
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Devi']['active_remise'] = ( isset( $this->request->data['Devi']['active_remise'] ) AND !empty( $this->request->data['Devi']['active_remise'] ) ) ? 1 : -1 ;
			if ( $this->request->data['Devi']['active_remise'] == -1 ) $this->request->data['Devi']['remise'] = 0;
			if ($this->Devi->save($this->request->data)) {
				if ( isset( $this->request->data['Devi']['id'] ) AND !empty( $this->request->data['Devi']['id'] ) ) {
					$this->calculatrice($this->request->data['Devi']['id']);
				}
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Devi->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Devi->exists($id)) {
			$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);
		}

		$users = $this->Devi->User->findList();
		$clients = $this->Devi->Client->findList();
		$depots = $this->Devi->Depot->findList(['Depot.vente'=>1]);
		$this->set(compact('permission','users','clients','depots','user_id','role_id'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Devi->id = $id;
		if (!$this->Devi->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Devi->flagDelete()) {
			$this->Devi->Devidetail->updateAll(['Devidetail.deleted'=>1],['Devidetail.devi_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$devi_id = null) {
		$this->Devi->Devidetail->id = $id;
		if (!$this->Devi->Devidetail->exists()) {
			throw new NotFoundException(__('Invalide produit'));
		}

		if ($this->Devi->Devidetail->flagDelete()) {
			$this->calculatrice($devi_id);
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
		if ($this->Devi->exists($id)) {
			$options = array('contain'=>['Client','Depot'],'conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);

			$details = $this->Devi->Devidetail->find('all',[
				'conditions' => ['Devidetail.devi_id'=>$id],
				'contain' => ['Produit'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$this->set(compact('details','role_id','user_id','flag'));
		$this->getPath($this->idModule);
	}

	public function getProduitByDepot($devi_id = null,$depot_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Devi->Devidetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'devidetails', 'alias' => 'Devidetail', 'type' => 'INNER', 'conditions' => ['Devidetail.produit_id = Produit.id','Devidetail.deleted = 0'] ],
			],
			'conditions' => [ 'Devidetail.devi_id'=>$devi_id ]
		]);

		$produits = $this->Devi->Devidetail->Produit->findList([
			'Produit.categorieproduit_id'=>$categorieproduit_id,
			'Produit.id !='=>$produits_exists
		]);

		die( json_encode( $produits ) );
	}

	public function getproduit($produit_id = null,$client_id = null) {
		$produit = $this->Devi->Devidetail->Produit->find('first',[ 'conditions'=>[ 'Produit.id'=>$produit_id ] ]);
		$tva = ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['tva_vente'] ) ) ? (float) $produit['Produit']['tva_vente'] : 0 ;
		$prix_vente = ( isset( $produit['Produit']['prix_vente'] ) AND !empty( $produit['Produit']['prix_vente'] ) ) ? (float) $produit['Produit']['prix_vente'] : 0 ;
		//add
		$this->loadModel("Remiseclient");
		$remisearticle = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "article","produit_id" => $produit_id]]);
		$remisecategories = $this->Remiseclient->find("all", ["conditions" => ["client_id" => $client_id,"type" => "categorie"]]);
		$remisegloable = $this->Remiseclient->find("first", ["conditions" => ["client_id" => $client_id,"type" => "globale"]]);
		$remise= 0;

        if (!isset($remisegloable["Remiseclient"]["id"])) {
            if (isset($remisearticle["Remiseclient"]["id"])) {
                $remise = floatval($remisearticle["Remiseclient"]["montant"]);
            }
        

            else if (isset($remisecategories[0]["Remiseclient"]["id"])) {
                $produit = $this->Devi->Devidetail->Produit->find("first", ["conditions" => ["id" => $produit_id]]);
            
                foreach ($remisecategories as $remisecategorie) {
                    if ($produit["Produit"]["categorieproduit_id"] == $remisecategorie["Remiseclient"]["categorie_id"]) {
                        $remise = floatval($remisecategorie["Remiseclient"]["montant"]);
                    }
                }
            }
        }
		
		die( json_encode( ['tva' => $tva , 'prix_vente' => $prix_vente,
		'remise' => $remise] ) );
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Devi->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);

			$details = $this->Devi->Devidetail->find('all',[
				'conditions' => ['Devidetail.devi_id'=>$id],
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

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Devi->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);

			$details = $this->Devi->Devidetail->find('all',[
				'conditions' => ['Devidetail.devi_id'=>$id],
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

	public function reduction($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Devi->save($this->request->data)) {
				$this->calculatrice($devi_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else if ($this->Devi->exists($id)) {
			$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);
		}
		$this->layout = false;
	}

	public function editdetail($id = null,$devi_id = null) {
		$devis = $this->Devi->find('first', ['contain'=>['User'],'conditions' => ['Devi.id' => $devi_id]]);
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');
		$depot_id = ( isset( $devis['Devi']['depot_id'] ) AND !empty( $devis['Devi']['depot_id'] ) ) ? $devis['Devi']['depot_id'] : 1;

		$this->loadModel("Module");
		$module = $this->Module->find('first',array('conditions' => array('Module.libelle' => "Remise")));
		
		$permission = $this->getPermissionByModule($module["Module"]["id"]);


		$produits_exists = $this->Devi->Devidetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'devidetails', 'alias' => 'Devidetail', 'type' => 'INNER', 'conditions' => ['Devidetail.produit_id = Produit.id','Devidetail.deleted = 0'] ],
			],
			'conditions' => [ 'Devidetail.devi_id'=>$devi_id ]
		]);

		$produits = $this->Devi->Devidetail->Produit->findList(['Produit.id !='=>$produits_exists]);

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Devidetail']['devi_id'] = $devi_id;
			$this->request->data["Devidetail"]["ttc"] = $this->request->data["Devidetail"]["ttc"] - $this->request->data["Devidetail"]["montant_remise"]; 
			if ($this->Devi->Devidetail->save($this->request->data)) {
				$this->calculatrice($devi_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Devi->Devidetail->exists($id)) {
			$options = array('conditions' => array('Devidetail.' . $this->Devi->Devidetail->primaryKey => $id));
			$this->request->data = $this->Devi->Devidetail->find('first', $options);
			$produits = $this->Devi->Devidetail->Produit->findList();
		}

		$depots = $this->Devi->Devidetail->Depot->find('list');
		$categorieproduits = $this->Devi->Devidetail->Produit->Categorieproduit->find('list');
		$this->set(compact('permission','produits','role_id','depot_id','depots','categorieproduits'));
		$this->layout = false;
	}

	public function changestate($devi_id = null,$etat = -1) {
		$details = $this->Devi->Devidetail->find('all',['conditions' => ['Devidetail.devi_id'=>$devi_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Devi->id = $devi_id;
		if ($this->Devi->saveField('etat',$etat)) {
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function calculatrice($devi_id = null) {
		$devi = $this->Devi->find('first',['conditions'=>['id'=>$devi_id]]);
		$remise = ( isset( $devi['Devi']['remise'] ) AND !empty( $devi['Devi']['remise'] ) ) ? (float) $devi['Devi']['remise'] : 0 ;
		$details = $this->Devi->Devidetail->find('all',['contain' => ["Produit"],'conditions' => ['devi_id' => $devi_id]]);
		$societe = $this->GetSociete();
		/* $tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100); */
		
		$total_qte = 0;
		$total_paquet = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$tva = 0;
		foreach ($details as $k => $value) {
			$total_qte = $total_qte + $value['Devidetail']['qte']; 
			$total_paquet = $total_paquet + $value['Devidetail']['paquet'];
			$total_a_payer_ttc = $total_a_payer_ttc + $value['Devidetail']['ttc'];
			$tva += ( isset( $value['Produit']['tva_vente'] ) AND !empty( $value['Produit']['tva_vente'] ) ) ? (int) $value['Produit']['tva_vente'] : 0 ;
		}
		$division_tva = (1+$tva/100);
		$total_a_payer_ht = round($total_a_payer_ttc/$division_tva,2);
		//$reduction = ( $total_a_payer_ht >= 0 ) ? (float) ($total_a_payer_ht*$remise)/100 : 0 ;
		$reduction = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;
		$montant_tva = round( $total_a_payer_ht * $tva/100 ,2);

		$total_paye = 0;

		$total_apres_reduction = ($total_a_payer_ht - $reduction)+$montant_tva;

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		$montant_remise = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;
		$data['Devi'] = [
			'id' => $devi_id,
			'reduction' => $reduction,
			'total_qte' => $total_qte,
			'total_paye' => $total_paye,
			'montant_tva' => $montant_tva,
			'total_paquet' => $total_paquet,
			'reste_a_payer' => $reste_a_payer,
			'montant_remise' => $montant_remise,
			'total_a_payer_ht' => $total_a_payer_ht,
			'total_a_payer_ttc' => $total_a_payer_ttc,
			'total_apres_reduction' => $total_apres_reduction,
		];

		if( $this->Devi->save($data) ) return true;
		else return false;
	}

	public function bonlivraison($devi_id = null) {
		if ($this->Devi->exists($devi_id)) {
			$devi = $this->Devi->find('first', [ 'conditions' => ['Devi.id' => $devi_id] ]);
			$details = $this->Devi->Devidetail->find('all',[ 'conditions' => ['devi_id'=>$devi_id] ]);

			$data['Bonlivraison'] = [
				'etat' => 1,
				'id' => null,
				'devi_id' => $devi_id,
				'date' => $devi['Devi']['date'],
				'remise' => $devi['Devi']['remise'],
				'user_id' => $devi['Devi']['user_id'],
				'reduction' => $devi['Devi']['reduction'],
				'client_id' => $devi['Devi']['client_id'],
				'total_qte' => $devi['Devi']['total_qte'],
				'total_paye' => $devi['Devi']['total_paye'],
				'montant_tva' => $devi['Devi']['montant_tva'],
				'total_paquet' => $devi['Devi']['total_paquet'],
				'active_remise' => $devi['Devi']['active_remise'],
				'reste_a_payer' => $devi['Devi']['reste_a_payer'],
				'total_a_payer_ht' => $devi['Devi']['total_a_payer_ht'],
				'total_a_payer_ttc' => $devi['Devi']['total_a_payer_ttc'],
				'total_apres_reduction' => $devi['Devi']['total_apres_reduction'],
			];

			$data['Bonlivraisondetail'] = [];
			foreach ($details as $key => $value) {
				$data['Bonlivraisondetail'][] = [
					'id' => null,
					'depot_id' => 1,
					'ttc' => $value['Devidetail']['ttc'],
					'qte' => $value['Devidetail']['qte'],
					'total' => $value['Devidetail']['total'],
					'paquet' => $value['Devidetail']['paquet'],
					'prix_vente' => $value['Devidetail']['prix_vente'],
					'produit_id' => $value['Devidetail']['produit_id'],
					'total_unitaire' => $value['Devidetail']['total_unitaire'],
				];
			}

			if ($this->Devi->Bonlivraison->saveAssociated($data)) {
				$bonlivraison_id = $this->Devi->Bonlivraison->id;
				$this->Devi->id = $devi_id;
				$this->Devi->saveField('bonlivraison_id',$bonlivraison_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}
	}

	public function mail($devi_id = null) {
		$devi = $this->Devi->find('first',['contain'=>['Client'],'conditions'=>['Devi.id'=>$devi_id]]);
		$email = ( isset( $devi['Client']['email'] ) AND !empty( $devi['Client']['email'] ) ) ? $devi['Client']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['devi_id'] = $devi_id;
			if ($this->Devi->Email->save($this->request->data)) {
				$url = $this->generatepdf($devi_id);
				$email_id = $this->Devi->Email->id;
				if ( $this->Devi->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Devis' => ['mimetype' => 'application/pdf','file' => $url ] ];
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

	public function generatepdf($devi_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Devi->exists($devi_id)) {
			$options = array('contain'=>['Client'=>['Ville']],'conditions' => array('Devi.' . $this->Devi->primaryKey => $devi_id));
			$data = $this->Devi->find('first', $options);

			$details = $this->Devi->Devidetail->find('all',[
				'conditions' => ['Devidetail.devi_id'=>$devi_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'DEVIS']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $data['Client']['Ville']['libelle'] )) ? $data['Client']['Ville']['libelle'] : '' ;
		
		$html = '
			<html>
			<head>
				<title>Devis</title>
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
				                    <h4 class="container"">DEVIS N° : '.$data['Devi']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container"">DATE : '.$data['Devi']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:50%;text-align:center;"></td>
				                <td style="width:50%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'<br/><br/>
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
				                <th>Remise(%)</th>
				                <th>Montant total TTC</th>
				            </tr>
				        </thead>
				        <tbody>';
				            foreach ($details as $tache){
				                $html.='<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Devidetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Devidetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.(int)$tache['Devidetail']['remise'].'%</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Devidetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
				            }
				            $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Devi']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA (20%)</td>
				                    <td class="total">'.number_format($data['Devi']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TTC</td>
				                    <td class="total">'.number_format($data['Devi']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">REMISE ('.$data['Devi']['remise'].'%)</td>
				                    <td class="total">'.number_format($data['Devi']['reduction'], 2, ',', ' ').' %</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Devi']['total_apres_reduction'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente devis à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper( $LettreHelper->NumberToLetter( strval( $data['Devi']['total_apres_reduction'] ) ) ).' DHS
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
		file_put_contents($destination.DS.'Devi.'.$data['Devi']['date'].'-'.$data['Devi']['id'].'.pdf', $output);
		return $destination.DS.'Devi.'.$data['Devi']['date'].'-'.$data['Devi']['id'].'.pdf';
	}

}