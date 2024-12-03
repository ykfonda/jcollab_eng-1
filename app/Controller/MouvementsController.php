<?php
class MouvementsController extends AppController {
	
	protected $idModule = 69;

	public function index() {
		$produits = $this->Mouvement->Produit->findList();
		$fournisseurs = $this->Mouvement->Fournisseur->find('list');
		$depots = $this->Mouvement->DepotSource->find('list');
		$this->set(compact('produits','depots','fournisseurs'));
		$this->getPath($this->idModule);
	}

	public function journal() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$conditions['Mouvement.operation'] = -1;
		$conditions['Mouvement.date'] = date('Y-m-d');

		$mouvements = $this->Mouvement->find('all',[
			'contain'=>['Produit','Fournisseur'],
			'order'=>['Mouvement.id'=>'DESC'],
			'conditions'=>$conditions
		]);

		$societe = $this->GetSociete();
		$this->set(compact('role_id','user_id','societe','mouvements'));
		$this->layout = false;
	}

	public function loadproduit($id = null){
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$produit = $this->Mouvement->Produit->find('first',[ 'conditions'=>['Produit.id'=>$id] ]);
		
		if (isset($produit['Produit']['image']) AND file_exists( WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image']))
			$produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
		else	
			$produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');

		die( json_encode( $produit ) );
	}

	public function editall() {
		if ($this->request->is(array('post', 'put'))) {
			$depot_id = ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id'] : 1 ;
			if ( isset( $this->data['MouvementDetail'] ) AND !empty( $this->data['MouvementDetail'] ) ) {
				$data = [];
				foreach ($this->data['MouvementDetail'] as $key => $value) {
					$data[] = [
						'id' => null,
						'depot_source_id' => $depot_id,
						'produit_id' => $value['produit_id'],
						'stock_source' =>  ( isset( $value['stock_source'] ) AND !empty( $value['stock_source'] ) ) ? $value['stock_source'] : 0 ,
						'paquet_source' =>  ( isset( $value['paquet_source'] ) AND !empty( $value['paquet_source'] ) ) ? $value['paquet_source'] : 0 ,
						'total_general' =>  ( isset( $value['total_general'] ) AND !empty( $value['total_general'] ) ) ? $value['total_general'] : 0 ,
						'num_lot' => ( isset( $this->data['Mouvement']['num_lot'] ) ) ? $this->data['Mouvement']['num_lot'] : '' ,
						'fournisseur_id' => ( isset( $this->data['Mouvement']['fournisseur_id'] ) ) ? $this->data['Mouvement']['fournisseur_id'] : '' ,
						'description' => ( isset( $this->data['Mouvement']['description'] ) ) ? $this->data['Mouvement']['description'] : 'Entrée en masse ' ,
						'date' => ( isset( $this->data['Mouvement']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : null ,
					];
				}

				if ( $this->Mouvement->saveMany($data) ) {
					foreach ($data as $key => $value) { 
						$this->entree( $value['produit_id'] , $value['depot_source_id'], $value['paquet_source'], $value['stock_source'], $value['total_general'] ); 
					}
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
				return $this->redirect( $this->referer() );
			} else {
				$this->Session->setFlash('Aucune ligne a saisie','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}
		$fournisseurs = $this->Mouvement->Fournisseur->find('list');
		$depots = $this->Mouvement->DepotSource->find('list');
		$this->set(compact('depots','fournisseurs'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0,$depot_id = null) {
		$conditions['Produit.active'] = 1;
		$produits = $this->Mouvement->Produit->findList($conditions);
		$this->set(compact('produits','depots','count'));
		$this->layout = false;
	}

	public function transaction($produit_id = null,$depot_source_id = null) {
		$entree = $this->Mouvement->find('first',[
			'fields' => ['SUM(Mouvement.paquet_source) as paquet','SUM(Mouvement.stock_source) as quantite','SUM(Mouvement.total_general) as total'],
			'conditions'=>[ 
				'depot_source_id' => $depot_source_id, 
				'produit_id' => $produit_id, 
				'operation' => -1,
			] 
		]);

		$quantite = ( isset( $entree[0]['quantite'] ) AND !empty( $entree[0]['quantite'] ) ) ? (int) $entree[0]['quantite'] : 0 ;
		$paquet = ( isset( $entree[0]['paquet'] ) AND !empty( $entree[0]['paquet'] ) ) ? (int) $entree[0]['paquet'] : 0 ;
		$total = ( isset( $entree[0]['total'] ) AND !empty( $entree[0]['total'] ) ) ? (int) $entree[0]['total'] : 0 ;		

		$sortie = $this->Mouvement->find('first',[
			'fields' => ['SUM(Mouvement.paquet_source) as paquet','SUM(Mouvement.stock_source) as quantite','SUM(Mouvement.total_general) as total'],
			'conditions'=>[ 
				'depot_source_id' => $depot_source_id, 
				'produit_id' => $produit_id, 
				'operation' => -1,
			] 
		]);

		$quantite = ( isset( $sortie[0]['quantite'] ) AND !empty( $sortie[0]['quantite'] ) ) ? (int) $sortie[0]['quantite'] : 0 ;
		$paquet = ( isset( $sortie[0]['paquet'] ) AND !empty( $sortie[0]['paquet'] ) ) ? (int) $sortie[0]['paquet'] : 0 ;
		$total = ( isset( $sortie[0]['total'] ) AND !empty( $sortie[0]['total'] ) ) ? (int) $sortie[0]['total'] : 0 ;		

		$this->loadModel('Depotproduit');
		$req = $this->Depotproduit->find('first',[
			'conditions'=>[ 
				'depot_id' => $depot_source_id, 
				'produit_id' => $produit_id,
			] 
		]);

		$id = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['id'] ) ) ? $req['Depotproduit']['id'] : null ;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'depot_id' => $depot_source_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite,
			'paquet' => $paquet,
			'total' => $total,
		];

		if ( $this->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function entree($produit_id = null,$depot_id = 1,$paquet_entree = 0,$quantite_entree = 0,$total_entree = 0) {
		$source = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[
				'depot_id' => $depot_id,
				'produit_id' => $produit_id,
			] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $paquet_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);

		$ancienne_paquet = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['paquet'] ) ) ? (int) $source['Depotproduit']['paquet'] : 0 ;
		$paquet = $ancienne_paquet + $paquet_entree;
		if( $paquet <= 0 ) $paquet = 0;

		$ancienne_quantite = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['quantite'] ) ) ? (int) $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite + $quantite_entree;
		if( $quantite <= 0 ) $quantite = 0;

		$ancienne_total = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['total'] ) ) ? (int) $source['Depotproduit']['total'] : 0 ;
		$total = $ancienne_total + $total_entree;
		if( $total <= 0 ) $total = 0;

		$id = ( isset( $source['Depotproduit']['id'] ) ) ? $source['Depotproduit']['id'] : null ;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'paquet' => $paquet,
			'total' => $total,
			'produit_id' => $produit_id,
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function sortie($produit_id = null,$depot_id = 1,$paquet_sortie = 0,$quantite_sortie = 0,$total_sortie = 0) {
		$depot = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[ 
				'depot_id' => $depot_id, 
				'produit_id' => $produit_id,
			] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $paquet_sortie,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);
		
		$ancienne_paquet = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['paquet'] ) ) ? (int) $depot['Depotproduit']['paquet'] : 0 ;
		$paquet = $ancienne_paquet - $paquet_sortie;
		if( $paquet <= 0 ) $paquet = 0;

		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['quantite'] ) ) ? (int) $depot['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite - $quantite_sortie;
		if( $quantite <= 0 ) $quantite = 0;

		$ancienne_total = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['total'] ) ) ? (int) $depot['Depotproduit']['total'] : 0 ;
		$total = $ancienne_total - $total_sortie;
		if( $total <= 0 ) $total = 0;

		$id = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		
		$data = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite,
			'paquet' => $paquet,
			'total' => $total,
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function indexAjax(){
		$conditions = ['Mouvement.operation' => -1];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE'] = "%$value%";
				else if( $param_name == 'Mouvement.num_lot' )
					$conditions['Mouvement.num_lot LIKE'] = "%$value%";
				else if( $param_name == 'Mouvement.reference' )
					$conditions['Mouvement.reference LIKE'] = "%$value%";
				else if( $param_name == 'Mouvement.date1' )
					$conditions['Mouvement.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Mouvement.date2' )
					$conditions['Mouvement.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Mouvement->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Produit','Fournisseur','Creator'],
			'order'=>['Mouvement.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Mouvement']['operation'] = -1;
			$this->request->data['Mouvement']['date_sortie'] = ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : null;
			if ($this->Mouvement->save($this->request->data)) {

				if ( isset( $this->data['Mouvement']['produit_id'] ) AND isset( $this->data['Mouvement']['depot_source_id'] ) ) {
					$this->entree($this->data['Mouvement']['produit_id'],$this->data['Mouvement']['depot_source_id'],$this->data['Mouvement']['paquet_source'],$this->data['Mouvement']['stock_source'],$this->data['Mouvement']['total_general']);
				}
				
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Mouvement->exists($id)) {
			$options = array('conditions' => array('Mouvement.' . $this->Mouvement->primaryKey => $id));
			$this->request->data = $this->Mouvement->find('first', $options);
		}

		$produits = $this->Mouvement->Produit->findList();
		$fournisseurs = $this->Mouvement->Fournisseur->find('list');
		$depots = $this->Mouvement->DepotSource->find('list');
		$this->set(compact('produits','depots','fournisseurs'));
		$this->layout = false;
	}

	public function delete($id = null,$produit_id = null) {
		$this->Mouvement->id = $id;
		if (!$this->Mouvement->exists()) {
			throw new NotFoundException(__('Invalide produit'));
		}

		$mouvement = $this->Mouvement->find('first', ['conditions' => ['id' => $id]]);

		if ($this->Mouvement->flagDelete()) {
			
			if ( isset( $mouvement['Mouvement']['produit_id'] ) AND isset( $mouvement['Mouvement']['depot_source_id'] ) ) {
				$this->sortie($mouvement['Mouvement']['produit_id'],$mouvement['Mouvement']['depot_source_id'],$mouvement['Mouvement']['paquet_source'],$mouvement['Mouvement']['stock_source'],$mouvement['Mouvement']['total_general']);
			}

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}