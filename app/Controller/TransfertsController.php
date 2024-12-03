<?php
class TransfertsController extends AppController {
	public $idModule = 111;
	 
	public $uses = ['Mouvement'];

	public function index() {
		$produits = $this->Mouvement->Produit->findList();
		$this->set(compact('produits'));
		$this->getPath($this->idModule);
	}

	public function loadproduit($id = null){
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$produit = $this->Mouvement->Produit->find('first',[ 'conditions'=>['Produit.id'=>$id] ]);
		
		if (isset($produit['Produit']['image']) AND file_exists( WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image'])){
			$produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
		}else{	
			$produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');
		}

		die( json_encode( $produit ) );
	}

	public function transfert($produit_id = null,$depot_source_id = 1,$depot_destination_id = 1,$quantite_saisie = 0) {
		// Sortie du stock source
		$source = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions' => [
				'produit_id'=>$produit_id,
				'depot_id'=>$depot_source_id,
			]
		]);

		$quantite_source = ( isset( $source['Depotproduit']['quantite'] ) ) ? (int) $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $quantite_source - $quantite_saisie;
		if ( $quantite <= 0 ) $quantite = 0;
		
		$source_id = (isset( $source['Depotproduit']['id'] )) ? $source['Depotproduit']['id'] : null ;

		$insert = [
			'id' => $source_id,
			'quantite' => $quantite,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
			'depot_id' => $depot_source_id,
		];

		// Entrée au stock destination
		$req = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[
				'depot_id' => $depot_destination_id,
				'produit_id' => $produit_id,
			] 
		]);

		$quantite_destination = ( isset( $req['Depotproduit']['id'] ) ) ? (int) $req['Depotproduit']['quantite'] : 0 ;
		$quantite = $quantite_destination + $quantite_saisie;
		if ( $quantite <= 0 ) $quantite = 0;

		$destination_id = ( isset( $req['Depotproduit']['id'] ) ) ? $req['Depotproduit']['id'] : null ;
		
		$save = [
			'id' => $destination_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
			'depot_id' => $depot_destination_id,
		];

		$transfert = [
			'id' => null,
			'operation' => 2,
			'date' => date('Y-m-d'),
			'produit_id' => $produit_id,
			'stock_source' => $quantite_saisie,
			'depot_source_id' => $depot_source_id,
			'stock_destination' => $quantite_saisie,
			'depot_destination_id' => $depot_destination_id,
			'description' => 'Transfert en masse',
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($insert) ){
			$this->Mouvement->save($transfert);
			$this->Mouvement->Produit->Depotproduit->save($save);
		}

		return true;
	}
	
	public function editall() {
		$user_id = $this->Auth->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			$depot_source_id = ( isset( $this->data['Mouvement']['depot_source_id'] ) ) ? $this->data['Mouvement']['depot_source_id'] : null ;
			$depot_destination_id = ( isset( $this->data['Mouvement']['depot_destination_id'] ) ) ? $this->data['Mouvement']['depot_destination_id'] : null ;
			if ( isset( $this->data['MouvementDetail'] ) AND !empty( $this->data['MouvementDetail'] ) ) {
				$data = [];
				foreach ($this->data['MouvementDetail'] as $key => $value) {
					$data = [
						'id' => null,
						'produit_id' => $value['produit_id'],
						'depot_source_id' => $depot_source_id,
						'stock_source' => $value['stock_source'],
						'stock_destination' => $value['stock_source'],
						'depot_destination_id' => $depot_destination_id,
						'num_lot' => ( isset( $this->data['Mouvement']['num_lot'] ) ) ? $this->data['Mouvement']['num_lot'] : '' ,
						'date' => ( isset( $this->data['Mouvement']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : '' ,
						'description' => 'Transfert en masse ',
					];
					$this->transfert($value['produit_id'],$depot_source_id ,$depot_destination_id,$value['stock_source']);
				}
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect( $this->referer() );
			} else {
				$this->Session->setFlash('Aucune ligne a saisie','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}
		$depots = $this->Mouvement->DepotSource->find('list');
		$this->getPath($this->idModule);
		$this->set(compact('depots'));
	}

	public function newrow($count = 0,$depot_id = null) {
		$conditions['Produit.active'] = 1;
		if( $depot_id != null ) {
			$conditions['Depotproduit.depot_id'] = $depot_id;
			$conditions['Depotproduit.quantite >'] = 0;
		}
		$produits = $this->Mouvement->Produit->find('list',[
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id']],
			],
			'conditions' => $conditions,
		]);
		$this->set(compact('produits','depots','count'));
		$this->layout = false;
	}
	
	public function indexAjax(){
		$conditions = ['Mouvement.operation' => 2];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Mouvement.libelle' )
					$conditions['Mouvement.libelle LIKE '] = "%$value%";
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
			'contain'=>['Produit','DepotSource','DepotDestination'],
			'order'=>['Mouvement.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Mouvement']['operation'] = 2;
			if ($this->Mouvement->save($this->request->data)) {
				
				if ( isset( $this->request->data['Mouvement']['produit_id'] ) AND isset( $this->request->data['Mouvement']['depot_source_id'] ) ) {

					$depot_source = $this->Mouvement->Produit->Depotproduit->find('first',[
						'conditions' => [
							'depot_id'=>$this->request->data['Mouvement']['depot_source_id'],
							'produit_id'=>$this->request->data['Mouvement']['produit_id'],
						]
					]);
					
					$depot_destination = $this->Mouvement->Produit->Depotproduit->find('first',[
						'conditions' => [
							'depot_id'=>$this->request->data['Mouvement']['depot_destination_id'],
							'produit_id'=>$this->request->data['Mouvement']['produit_id'],
						]
					]);

					$quantite_depot_source = ( isset( $depot_source['Depotproduit']['quantite'] ) ) ? (int) $depot_source['Depotproduit']['quantite'] : 0 ;
					$quantite_minus = ( isset( $this->request->data['Mouvement']['stock_destination'] ) ) ? (int) $this->request->data['Mouvement']['stock_destination'] : 0 ;
					$quantite = $quantite_depot_source - $quantite_minus;
					if ( $quantite <= 0 ) $quantite = 0;
					
					$id = (isset( $depot_source['Depotproduit']['id'] )) ? $depot_source['Depotproduit']['id'] : null ;

					$data['Depotproduit'] = [
						'id' => $id,
						'quantite' => $quantite,
					];

					if ( $this->Mouvement->Produit->Depotproduit->save($data) );

					$id = (isset( $depot_destination['Depotproduit']['id'] )) ? $depot_destination['Depotproduit']['id'] : null ;
					$quantite_depot_destination = ( isset( $depot_destination['Depotproduit']['quantite'] ) ) ? (int) $depot_destination['Depotproduit']['quantite'] : 0 ;
					$quantite_plus = ( isset( $this->request->data['Mouvement']['stock_destination'] ) ) ? (int) $this->request->data['Mouvement']['stock_destination'] : 0 ;
					$quantite = $quantite_depot_destination + $quantite_plus;
					if ( $quantite <= 0 ) $quantite = 0;
					
					$data['Depotproduit'] = [
						'id' => $id,
						'quantite' => $quantite,
						'produit_id' => $this->data['Mouvement']['produit_id'],
						'depot_id' => $this->data['Mouvement']['depot_destination_id'],
						'date' => $this->data['Mouvement']['date'],
					];

					if ( $this->Mouvement->Produit->Depotproduit->save($data) );
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
		$depots = $this->Mouvement->DepotSource->find('list');
		$produits = $this->Mouvement->Produit->findList();
		$this->set(compact('produits','depots'));
		$this->layout = false;
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Mouvement->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (int) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function loaddepots($produit_id = null) {
		$depots = $this->Mouvement->DepotSource->find('list',[
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = DepotSource.id']],
				['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id']],
			],
			'conditions' => ['Produit.id' => $produit_id],
		]);

		die( json_encode( $depots ) );
	}

	public function delete($id = null,$produit_id = null) {
		$this->Mouvement->id = $id;
		if (!$this->Mouvement->exists()) {
			throw new NotFoundException(__('Invalide produit'));
		}

		$mouvement = $this->Mouvement->find('first', ['conditions' => ['id' => $id]]);
		if ( isset( $mouvement['Mouvement']['produit_id'] ) AND isset( $mouvement['Mouvement']['depot_source_id'] ) ) {
			$depot_source = $this->Mouvement->Produit->Depotproduit->find('first',[
				'conditions' => [
					'depot_id'=>$mouvement['Mouvement']['depot_source_id'],
					'produit_id'=>$mouvement['Mouvement']['produit_id'],
				]
			]);
			
			$depot_destination = $this->Mouvement->Produit->Depotproduit->find('first',[
				'conditions' => [
					'depot_id'=>$mouvement['Mouvement']['depot_destination_id'],
					'produit_id'=>$mouvement['Mouvement']['produit_id'],
				]
			]);

			$quantite_depot_source = ( isset( $depot_source['Depotproduit']['quantite'] ) ) ? (int) $depot_source['Depotproduit']['quantite'] : 0 ;
			$quantite_plus = ( isset( $mouvement['Mouvement']['stock_destination'] ) ) ? (int) $mouvement['Mouvement']['stock_destination'] : 0 ;
			$quantite = $quantite_depot_source + $quantite_plus;
			if ( $quantite <= 0 ) $quantite = 0;
			
			$id = (isset( $depot_source['Depotproduit']['id'] )) ? $depot_source['Depotproduit']['id'] : null ;

			$data['Depotproduit'] = [
				'id' => $id,
				'quantite' => $quantite,
			];

			if ( $this->Mouvement->Produit->Depotproduit->save($data) );

			$id = (isset( $depot_destination['Depotproduit']['id'] )) ? $depot_destination['Depotproduit']['id'] : null ;
			$quantite_depot_destination = ( isset( $depot_destination['Depotproduit']['quantite'] ) ) ? (int) $depot_destination['Depotproduit']['quantite'] : 0 ;
			$quantite_minus = ( isset( $mouvement['Mouvement']['stock_destination'] ) ) ? (int) $mouvement['Mouvement']['stock_destination'] : 0 ;
			$quantite = $quantite_depot_destination - $quantite_minus;
			if ( $quantite <= 0 ) $quantite = 0;
			
			$data['Depotproduit'] = [
				'id' => $id,
				'quantite' => $quantite,
				'produit_id' => $mouvement['Mouvement']['produit_id'],
				'depot_id' => $mouvement['Mouvement']['depot_destination_id'],
				'date' => $mouvement['Mouvement']['date'],
			];

			if ( $this->Mouvement->Produit->Depotproduit->save($data) );
		}
		if ($this->Mouvement->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}