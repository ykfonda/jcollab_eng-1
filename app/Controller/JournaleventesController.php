<?php
class JournaleventesController extends AppController {
	public $idModule = 101;
	
	public $uses = ['Bonlivraison'];

	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		if ($this->request->is(array('post', 'put'))) {
			$this->journal($this->data['Bonlivraison']['date']);
		}

		$this->set(compact('users','clients','user_id','role_id','admins'));
		$this->getPath($this->idModule);
	}

	public function callIndexAjax($page = 1){
    	App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		if( $this->request->is('post') ){
			$filter_url['controller'] = $this->request->params['controller'];
			$filter_url['action'] = 'journal';

			if(isset($this->data['Filter']) && is_array($this->data['Filter'])){
				foreach($this->data['Filter'] as $name => $value){
					if( is_array($value) ){
						foreach ($value as $k => $v) {
							if($v) $filter_url[$name.'.'.$k] = $v;
						}
					}else{
						if($value) $filter_url[$name] = urlencode($value);
					}
				}
			}
			die( $HtmlHelper->url($filter_url) ); 
		}
	}

	public function journal() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions['Bonlivraison.etat'] = 2;
		$date = date('d-m-Y');
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonlivraison.date' ) {
					$conditions['Bonlivraison.date'] = date('Y-m-d',strtotime($value));
					$date = date('d-m-Y',strtotime($value));
				} else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$bonlivraisons = $this->Bonlivraison->find('all',[
			'conditions' => $conditions,
			'contain'=>['Client'],
		]);

		$avances = $this->Bonlivraison->Avance->find('all',[
			'conditions' => ['Avance.date' => date('Y-m-d',strtotime($date)) ],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
		]);

		$reglements = $this->Bonlivraison->Avance->find('all',[
			'fields'=>['SUM(Avance.montant) as paiment','Avance.mode'],
			'conditions' => ['Avance.date' => date('Y-m-d',strtotime($date)) ],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
			'group' => ['Avance.mode']
		]);

		$groupements = [];
		$modes = array(1 => 'Chèque', 2 => 'Espèce', 3 => 'Virement', 4 => 'Crédit', 5 => 'Effet');
		foreach ($reglements as $key => $value) {
			$groupements[ $value['Avance']['mode'] ] = [
				'montant' => ( isset( $value[0]['paiment'] ) ) ? (float) $value[0]['paiment'] : 0,
				'mode' => ( isset( $modes[ $value['Avance']['mode'] ] ) ) ? $modes[ $value['Avance']['mode'] ] : 'Indéfinie' 
			];
		}

		$details = $this->Bonlivraison->Bonlivraisondetail->find('all',[
			'conditions' => $conditions,
			'contain' => ['Produit'],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Bonlivraisondetail.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
		]);

		$req = $this->Bonlivraison->find('first',[
			'fields'=>['SUM(total_paye) as total_paye','SUM(reste_a_payer) as reste_a_payer','SUM(total_apres_reduction) as total_apres_reduction'],
			'conditions' => $conditions,
		]);

		$total_paye = ( isset( $req[0]['total_paye'] ) AND !empty( $req[0]['total_paye'] ) ) ? (float) $req[0]['total_paye'] : 0 ;
		$reste_a_payer = ( isset( $req[0]['reste_a_payer'] ) AND !empty( $req[0]['reste_a_payer'] ) ) ? (float) $req[0]['reste_a_payer'] : 0 ;
		$total_apres_reduction = ( isset( $req[0]['total_apres_reduction'] ) AND !empty( $req[0]['total_apres_reduction'] ) ) ? (float) $req[0]['total_apres_reduction'] : 0 ;

		$societe = $this->GetSociete();
		$this->set(compact('details','role_id','user_id','societe','total_paye','reste_a_payer','total_apres_reduction','date','bonlivraisons','avances','groupements'));
		$this->layout = false;
	}

}
