<?php
class EtatventesController extends AppController {
	public $components = array('Session');
	public $uses = array('Bonlivraison');
	public $idModule = 107;

	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$clients = $this->Bonlivraison->Client->find('list',array('order'=>'designation asc'));
		$produits = $this->Bonlivraison->Bonlivraisondetail->Produit->findList();
		$users = $this->Bonlivraison->User->findList(['User.role_id !='=>5]);
		$this->set(compact('users','clients','produits','user_id','role_id','admins'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$conditions['Bonlivraison.etat'] = 2;
		$conditions['Bonlivraison.deleted'] = 0;
		$conditions['Bonlivraison.date >='] = date('Y-m-01');
		$conditions['Bonlivraison.date <='] = date('Y-m-d 23:59:59');
		/*if ( !in_array($role_id, $admins) ) $conditions['Bonlivraison.user_c'] = $user_id;*/

		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonlivraison.reference' )
					$conditions['Bonlivraison.reference LIKE '] = "%$value%";
				else if( $param_name == 'Bonlivraison.date1' )
					$conditions['Bonlivraison.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonlivraison.date2' )
					$conditions['Bonlivraison.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Bonlivraison->recursive = -1;
		$settings = [
			'order'=>['Bonlivraisondetail.id'=>'DESC'],
			'contain'=>['Bonlivraison','Produit'],
			'conditions'=>$conditions,
		];
		$taches = $this->Bonlivraison->Bonlivraisondetail->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$conditions['Bonlivraison.etat'] = 2;
		$conditions['Bonlivraison.deleted'] = 0;
		$conditions['Bonlivraison.date >='] = date('Y-m-01');
		$conditions['Bonlivraison.date <='] = date('Y-m-d 23:59:59');
		if ( !in_array($role_id, $admins) ) $conditions['Bonlivraison.user_c'] = $user_id;

		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonlivraison.reference' )
					$conditions['Bonlivraison.reference LIKE '] = "%$value%";
				else if( $param_name == 'Bonlivraison.date1' )
					$conditions['Bonlivraison.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonlivraison.date2' )
					$conditions['Bonlivraison.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$remises = $this->Bonlivraison->find('first',['fields'=>['SUM(Bonlivraison.reduction) as TotalRemise'],'conditions'=>$conditions]);
		$remise = ( isset( $remises[0]['TotalRemise'] ) AND !empty( $remises[0]['TotalRemise'] ) ) ? round($remises[0]['TotalRemise'],1) : 0 ;

		$this->Bonlivraison->recursive = -1;
		$settings = [
			'order'=>['Bonlivraisondetail.id'=>'DESC'],
			'contain'=>['Bonlivraison','Produit'],
			'conditions'=>$conditions,
		];
		$details = $this->Bonlivraison->Bonlivraisondetail->find('all',$settings);

		$settings['limit'] = 10;
		$this->Paginator->settings = $settings;
		$taches = $this->Paginator->paginate('Bonlivraisondetail');
		$this->set(compact('taches','user_id','details','remise'));
		$this->layout = false;
	}
}