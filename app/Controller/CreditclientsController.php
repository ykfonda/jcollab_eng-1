<?php
class CreditclientsController extends AppController {
	public $idModule = 104;
	public $uses = array('Client');

	public function index() {
		$clients = $this->Client->findList();
		$this->getPath($this->idModule);
		$this->set(compact('clients'));
	}

	public function excel(){
		$conditions['Bonlivraison.etat'] = 2;
		$conditions['Bonlivraison.reste_a_payer >'] = 0;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Client.reference' )
					$conditions['Client.reference LIKE '] = "%$value%";
				else if( $param_name == 'Client.designation' )
					$conditions['Client.designation LIKE '] = "%$value%";
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

		$this->Client->recursive = -1;
		$settings = [
			'fields' => ['Client.*','SUM(Bonlivraison.reste_a_payer) as reste_a_payer'],
			'conditions' => $conditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.client_id = Client.id','Bonlivraison.deleted = 0'] ],
			],
			'group' => ['Client.id']
		];
		$taches = $this->Client->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions['Bonlivraison.etat'] = 2;
		$conditions['Bonlivraison.reste_a_payer >'] = 0;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Client.reference' )
					$conditions['Client.reference LIKE '] = "%$value%";
				else if( $param_name == 'Client.designation' )
					$conditions['Client.designation LIKE '] = "%$value%";
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

		$this->Client->recursive = -1;
		$this->Paginator->settings = [
			'fields' => ['Client.*','SUM(Bonlivraison.reste_a_payer) as reste_a_payer'],
			'conditions' => $conditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.client_id = Client.id','Bonlivraison.deleted = 0'] ],
			],
			'group' => ['Client.id']
		];
		$taches = $this->Paginator->paginate('Client');
		$this->set(compact('taches'));
		$this->layout = false;
	}
}