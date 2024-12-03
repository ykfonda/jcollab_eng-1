<?php
class HistoryController extends AppController {
	
	protected $idModule = 106;
	public $uses = ['Mouvement'];

	public function index() {
		$depots = $this->Session->read('depots');
		$produits = $this->Mouvement->Produit->findList();
		$depots = $this->Mouvement->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('produits','depots'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$depots = $this->Session->read('depots');
		$conditions['DepotSource.id' ] = $depots;
		// $conditions['DepotDestination.id' ] = $depots;
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
		$settings = [
			'contain'=>['Produit','Creator','DepotSource','DepotDestination'],
			'order'=>['Mouvement.id'=>'DESC'],
			'conditions'=>$conditions,
		];
		$taches = $this->Mouvement->find('all',$settings);
			
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$depots = $this->Session->read('depots');
	/* 	$conditions['DepotSource.id' ] = $depots;
		$conditions['DepotDestination.id' ] = $depots; */
		$conditions = [];
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
		$selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]);

		$conditions["DepotSource.id"] = $depots;
		/* $conditions["DepotDestination.id"] = $depots; */
		$this->Mouvement->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Produit','Creator','DepotSource','DepotDestination'],
			'order'=>['Mouvement.id'=>'DESC'],
			'conditions'=>$conditions,
		];
		$taches = $this->Paginator->paginate('Mouvement');
		$this->set(compact('taches'));
		$this->layout = false;
	}
}