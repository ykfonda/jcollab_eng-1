<?php
class ExpeditionsController extends AppController {
	public $idModule = 95;
	
	public $uses = ['Expedition'];

	public function index() {
		$depots = $this->Session->read('depots');
        $stores = $this->Session->read('stores');
        $stores = $this->Expedition->DepotDestination->findList(['DepotDestination.id'=>$stores]);
		$produits = $this->Expedition->Produit->findList();
		$depots = $this->Expedition->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('produits','depots','stores'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$depots = $this->Session->read('depots');
		$conditions['Expedition.operation' ] = 1;
		$conditions['DepotSource.id' ] = $depots;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE'] = "%$value%";
				else if( $param_name == 'Expedition.num_lot' )
					$conditions['Expedition.num_lot LIKE'] = "%$value%";
				else if( $param_name == 'Expedition.reference' )
					$conditions['Expedition.reference LIKE'] = "%$value%";
				else if( $param_name == 'Expedition.date1' )
					$conditions['Expedition.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Expedition.date2' )
					$conditions['Expedition.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		$this->Expedition->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Produit','DepotSource','DepotDestination','Creator'],
			'order'=>['Expedition.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate('Expedition');
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$depots = $this->Session->read('depots');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Expedition']['operation'] = 1;
			$this->request->data['Expedition']['date_sortie'] = ( isset( $this->data['Expedition']['date_sortie'] ) AND !empty( $this->data['Expedition']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Expedition']['date_sortie'] ) ) : date('Y-m-d');
			$this->request->data['Expedition']['date'] = ( isset( $this->data['Expedition']['date'] ) AND !empty( $this->data['Expedition']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Expedition']['date'] ) ) : null;
			if ($this->Expedition->save($this->request->data)) {

				if ( isset( $this->data['Expedition']['produit_id'] ) AND isset( $this->data['Expedition']['depot_source_id'] ) ) {
					$this->sortie($this->data['Expedition']['produit_id'],$this->data['Expedition']['depot_source_id'],$this->data['Expedition']['stock_source']);
				}

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Expedition->exists($id)) {
			$options = array('conditions' => array('Expedition.' . $this->Expedition->primaryKey => $id));
			$this->request->data = $this->Expedition->find('first', $options);
		}

		$produits = $this->Expedition->Produit->findList();
		$depots = $this->Expedition->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('produits','depots','fournisseurs'));
		$this->layout = false;
	}

	public function sortie($produit_id = null,$depot_id = 1,$quantite_sortie = 0) {
		$depot = $this->Expedition->Produit->Depotproduit->find('first',[
			'conditions'=>[ 
				'depot_id' => $depot_id, 
				'produit_id' => $produit_id,
			] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_sortie,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Sortie"
		];
		$this->Entree->save($donnees);

		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['quantite'] ) ) ? (int) $depot['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite - $quantite_sortie;
		if( $quantite <= 0 ) $quantite = 0;

		$id = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		
		$data = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite,
		];

		if ( $this->Expedition->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function entree($produit_id = null,$depot_id = 1,$quantite_entree = 0) {
		$source = $this->Expedition->Produit->Depotproduit->find('first',[
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
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
		];

		if ( $this->Expedition->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function loadproduit($produit_id = null,$depot_id = null){
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$produit = [];
		if ( !empty( $produit_id ) AND !empty( $depot_id ) ) {
			$produit = $this->Expedition->Produit->find('first',[
				'fields' => ['Depotproduit.*','Produit.*','Unite.*'],
				'conditions'=>['Produit.id'=>$produit_id],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
					['table' => 'unites', 'alias' => 'Unite', 'type' => 'LEFT', 'conditions' => ['Unite.id = Produit.unite_id','Unite.deleted = 0']],
				],
			]);

			$produit['Produit']['unite'] = ( isset( $produit['Unite']['id'] ) AND !empty( $produit['Unite']['id'] ) ) ? strtolower( $produit['Unite']['libelle'] ) : '' ;
			$produit['Produit']['stock'] = ( isset( $produit['Depotproduit']['quantite'] ) AND !empty( $produit['Depotproduit']['quantite'] ) ) ? $produit['Depotproduit']['quantite'] : 0 ;
			
			if (isset($produit['Produit']['image']) AND file_exists( WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image']))
				$produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
			else	
				$produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');
		}

		die( json_encode( $produit ) );
	}

	public function loaddepots($produit_id = null) {
		$depots = $this->Session->read('depots');
		$depots = $this->Expedition->DepotSource->find('list',[
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = DepotSource.id','Depotproduit.deleted = 0']],
				['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id','Produit.deleted = 0']],
			],
			'conditions' => [
				'Depotproduit.quantite >'=>0,
				'Produit.id' => $produit_id,
				'DepotSource.id'=>$depots,
			],
		]);

		die( json_encode( $depots ) );
	}

	public function editexp() {
		$stores = $this->Session->read('stores');
		$depots = $this->Session->read('depots');
		if ($this->request->is(array('post', 'put'))) {
			$depot_id = ( isset( $this->data['Expedition']['depot_id'] ) ) ? $this->data['Expedition']['depot_id'] : 1 ;
			if ( isset( $this->data['ExpeditionDetail'] ) AND !empty( $this->data['ExpeditionDetail'] ) ) {
				$data = [];
				foreach ($this->data['ExpeditionDetail'] as $key => $value) {
					$data[] = [
						'id' => null,
						'operation' => 1,
						'depot_source_id' => $depot_id,
						'store_id' => ( isset( $this->data['Expedition']['store_id'] ) ) ? $this->data['Expedition']['store_id'] : 1,
						'produit_id' => $value['produit_id'],
						'num_lot' =>  ( isset( $value['num_lot'] ) AND !empty( $value['num_lot'] ) ) ? $value['num_lot'] : null ,
						'stock_source' =>  ( isset( $value['stock_source'] ) AND !empty( $value['stock_source'] ) ) ? $value['stock_source'] : 0 ,
						'fournisseur_id' => ( isset( $this->data['Expedition']['fournisseur_id'] ) ) ? $this->data['Expedition']['fournisseur_id'] : null ,
						'description' => ( isset( $this->data['Expedition']['description'] ) ) ? $this->data['Expedition']['description'] : 'Sortie en masse ' ,
						'date' => ( isset( $this->data['Expedition']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Expedition']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Expedition']['date_sortie'] ) AND !empty( $this->data['Expedition']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Expedition']['date_sortie'] ) ) : date('Y-m-d') ,
					];
				}

				if ( $this->Expedition->saveMany($data) ) {
					foreach ($data as $key => $value) { 
						$this->sortie( $value['produit_id'] , $value['depot_source_id'], $value['stock_source']); 
					}
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');

				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
				return $this->redirect( $this->referer() );
			} else {
				$this->Session->setFlash('Aucune ligne a saisie p','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}
		$stores = $this->Expedition->DepotDestination->findList();
		$depots = $this->Expedition->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('depots','fournisseurs','stores'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0,$depot_id = null) {
		$conditions['Produit.active'] = 1;
		$produits = $this->Expedition->Produit->findList($conditions);
		$this->set(compact('produits','depots','count'));
		$this->layout = false;
	}

	public function delete($id = null,$produit_id = null) {
		$this->Expedition->id = $id;
		if (!$this->Expedition->exists()) throw new NotFoundException(__('Invalide expedition'));

		$expedition = $this->Expedition->find('first', ['conditions' => ['Expedition.id' => $id]]);

		if ($this->Expedition->delete()) {
			
			if ( isset( $expedition['Expedition']['produit_id'] ) AND isset( $expedition['Expedition']['depot_source_id'] ) ) {
				$this->entree($expedition['Expedition']['produit_id'],$expedition['Expedition']['depot_source_id'],$expedition['Expedition']['stock_source']);
			}

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}