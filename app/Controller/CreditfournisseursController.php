<?php
class CreditfournisseursController extends AppController {
	public $idModule = 105;
	public $uses = array('Fournisseur');

	public function index() {
		$fournisseurs = $this->Fournisseur->find('list');
		$this->getPath($this->idModule);
		$this->set(compact('fournisseurs'));
	}

	public function excel(){
		$conditions['Boncommande.etat'] = 2;
		$conditions['Boncommande.reste_a_payer >'] = 0;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Fournisseur.reference' )
					$conditions['Fournisseur.reference LIKE '] = "%$value%";
				else if( $param_name == 'Fournisseur.designation' )
					$conditions['Fournisseur.designation LIKE '] = "%$value%";
				else if( $param_name == 'Boncommande.date1' )
					$conditions['Boncommande.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Boncommande.date2' )
					$conditions['Boncommande.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Fournisseur->recursive = -1;
		$settings = [
			'fields' => ['Fournisseur.*','SUM(Boncommande.reste_a_payer) as reste_a_payer'],
			'conditions' => $conditions,
			'joins' => [
				['table' => 'boncommandes', 'alias' => 'Boncommande', 'type' => 'INNER', 'conditions' => ['Boncommande.fournisseur_id = Fournisseur.id','Boncommande.deleted = 0'] ],
			],
			'group' => ['Fournisseur.id']
		];
		$taches = $this->Fournisseur->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions['Boncommande.etat'] = 2;
		$conditions['Boncommande.reste_a_payer >'] = 0;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Fournisseur.reference' )
					$conditions['Fournisseur.reference LIKE '] = "%$value%";
				else if( $param_name == 'Fournisseur.designation' )
					$conditions['Fournisseur.designation LIKE '] = "%$value%";
				else if( $param_name == 'Boncommande.date1' )
					$conditions['Boncommande.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Boncommande.date2' )
					$conditions['Boncommande.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Fournisseur->recursive = -1;
		$this->Paginator->settings = [
			'fields' => ['Fournisseur.*','SUM(Boncommande.reste_a_payer) as reste_a_payer'],
			'conditions' => $conditions,
			'joins' => [
				['table' => 'boncommandes', 'alias' => 'Boncommande', 'type' => 'INNER', 'conditions' => ['Boncommande.fournisseur_id = Fournisseur.id','Boncommande.deleted = 0'] ],
			],
			'group' => ['Fournisseur.id']
		];
		$taches = $this->Paginator->paginate('Fournisseur');
		$this->set(compact('taches'));
		$this->layout = false;
	}
}