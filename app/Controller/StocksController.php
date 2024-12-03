<?php
class StocksController extends AppController {
	public $idModule = 81;
	
	public $uses = ['Produit','User'];

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$depot_id = $this->Session->read('Auth.User.depot_id');

		if( $role_id == 1 ) $depots = $this->User->Depot->find('list');
		else {
			if ( $role_id == 2 ) {
				$depot_superviseurs = $this->User->find('list',['fields'=>['depot_id','depot_id'],'conditions' =>['role_id'=>3,'manager_id' => $user_id]]);
				$superviseurs = $this->User->find('list',['fields'=>['id','id'],'conditions' =>['role_id'=>3,'manager_id' => $user_id]]);
				$ambasadeurs = $this->User->find('list',['fields'=>['depot_id','depot_id'],'conditions' =>['role_id'=>4,'superviseur_id' => $superviseurs]]);
				$ambasadeurs = $ambasadeurs + [$depot_id => $depot_id] + $depot_superviseurs;
				$depots = $this->User->Depot->find('list',['conditions'=>['id'=>$ambasadeurs]]);
			} else {
				$ambasadeurs = $this->User->find('list',['fields'=>['depot_id','depot_id'],'conditions' =>['role_id'=>4,'superviseur_id' => $user_id]]);
				$ambasadeurs = $ambasadeurs + [$depot_id => $depot_id];
				$depots = $this->User->Depot->find('list',['conditions'=>['id'=>$ambasadeurs]]);				
			}
		}
		
		$this->set(compact('depots','role_id','user_id'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$user_id = $this->Session->read('Auth.User.id');
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$conditions = ['Produit.active' => 1,'Depotproduit.depot_id' => $depot_id];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Produit.reference' )
					$conditions['Produit.reference LIKE '] = "%$value%";
				else if( $param_name == 'Produit.date1' )
					$conditions['Produit.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Produit.date2' )
					$conditions['Produit.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$settings = [
			'fields' => [
				'Produit.id',
				'Produit.libelle',
				'Produit.image',
				'Produit.reference',
				'Depotproduit.id',
				'Depotproduit.quantite',
				'Depotproduit.depot_id',
				'Depot.libelle',
			],
			'conditions'=>$conditions,
			'joins'=>[
				['table' => 'depotproduits','alias' => 'Depotproduit', 'type' => 'INNER','conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0']] ,
				['table' => 'depots','alias' => 'Depot', 'type' => 'INNER','conditions' => ['Depot.id = Depotproduit.depot_id','Depot.deleted = 0']] ,
			],
		];
		$taches = $this->Produit->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}
	
	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$depot_id = $this->Session->read('Auth.User.depot_id');
		$conditions = ['Produit.active' => 1,'Depotproduit.depot_id' => $depot_id];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Produit.reference' )
					$conditions['Produit.reference LIKE '] = "%$value%";
				else if( $param_name == 'Produit.date1' )
					$conditions['Produit.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Produit.date2' )
					$conditions['Produit.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Produit->recursive = -1;
		$this->Paginator->settings = [
			'fields' => [
				'Produit.id',
				'Produit.libelle',
				'Produit.image',
				'Produit.reference',
				'Depotproduit.id',
				'Depotproduit.quantite',
				'Depotproduit.depot_id',
				'Depot.libelle',
			],
			'conditions'=>$conditions,
			'joins'=>[
				['table' => 'depotproduits','alias' => 'Depotproduit', 'type' => 'INNER','conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0']] ,
				['table' => 'depots','alias' => 'Depot', 'type' => 'INNER','conditions' => ['Depot.id = Depotproduit.depot_id','Depot.deleted = 0']] ,
			],
		];
		$taches = $this->Paginator->paginate('Produit');
		$this->set(compact('taches'));
		$this->layout = false;
	}
}