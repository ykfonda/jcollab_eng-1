<?php
class AvancesController extends AppController {
	public $idModule = 71;
	

	public function index() {
		$factures = $this->Avance->Facture->find('list');
		$bonlivraisons = $this->Avance->Bonlivraison->find('list');
		$clients = $this->Avance->Bonlivraison->Client->find('list');
		$this->set(compact('bonlivraisons','clients','factures'));
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$dateConditions = [];
		$conditions['Avance.etat'] = -1;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Avance.reference' )
					$conditions['Avance.reference LIKE '] = "%$value%";
				else if( $param_name == 'Avance.emeteur' )
					$conditions['Avance.emeteur LIKE '] = "%$value%";
				else if( $param_name == 'Avance.etat' ){
					if( $value == 2 ) $conditions['Avance.etat'] = [-1,1];
					else $conditions['Avance.etat'] = $value;
				}else if( $param_name == 'Avance.date1' ){
					$conditions['Avance.date >='] = date('Y-m-d',strtotime($value));
					$dateConditions['Avance.date >='] = date('Y-m-d',strtotime($value));
				}else if( $param_name == 'Avance.date2' ){
					$conditions['Avance.date <='] = date('Y-m-d',strtotime($value));
					$dateConditions['Avance.date <='] = date('Y-m-d',strtotime($value));
				}else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$chiffre_valide = $this->Avance->find('first',[
			'fields' => ['SUM(Avance.montant) as montant'],
			'conditions' => [ 'Bonlivraison.etat !='=>3, 'Avance.etat' => 1 ] + $dateConditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
		]);

		$chiffre_encours = $this->Avance->find('first',[
			'fields' => ['SUM(Avance.montant) as montant'],
			'conditions' => [ 'Bonlivraison.etat !='=>3, 'Avance.etat' => -1 ] + $dateConditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
		]);

		$chiffre_total = $this->Avance->find('first',[
			'fields' => ['SUM(Avance.montant) as montant'],
			'conditions' => [ 'Bonlivraison.etat !='=>3, 'Avance.etat' => [-1,1] ] + $dateConditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
		]);

		$chiffre_affaire_valide = (isset( $chiffre_valide[0]['montant'] )) ? $chiffre_valide[0]['montant'] : 0 ;
		$chiffre_affaire_encours = (isset( $chiffre_encours[0]['montant'] )) ? $chiffre_encours[0]['montant'] : 0 ;
		$chiffre_affaire_total = (isset( $chiffre_total[0]['montant'] )) ? $chiffre_total[0]['montant'] : 0 ;

		$this->Avance->recursive = -1;
		$settings = [
			'fields' => array('Bonlivraison.*','Facture.*','Avance.*','Client.*'),
			'conditions'=> [ 'Bonlivraison.etat !='=>3 ] + $conditions,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
				['table' => 'factures', 'alias' => 'Facture', 'type' => 'LEFT', 'conditions' => ['Facture.id = Avance.facture_id','Facture.deleted = 0','Facture.etat != 3'] ],
				['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Client.id = Bonlivraison.client_id','Client.deleted = 0'] ],
			],
			'order'=>['Avance.id'=>'DESC'],
			'group'=>['Avance.id'],
		];

		$this->Paginator->settings = $settings;
		$taches = $this->Paginator->paginate();

		$avances = $this->Avance->find('all',$settings);
		$this->set(compact('avances','taches','chiffre_affaire_valide','chiffre_affaire_encours','chiffre_affaire_total'));
		$this->layout = false;
	}

	public function changestate($id = null,$etat = -1) {
		$this->Avance->id = $id;
		if ($this->Avance->saveField('etat',$etat)) {
			die('L\'enregistrement a été effectué avec succès.');
		} else {
			die('Il y a un problème');
		}
	}

	public function validateAll() {
		$settings = [
			'fields' => array('Avance.id','Avance.id'),
			'conditions'=> [ 'Bonlivraison.etat !='=>3 ],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
				['table' => 'factures', 'alias' => 'Facture', 'type' => 'LEFT', 'conditions' => ['Facture.id = Avance.facture_id','Facture.deleted = 0'] ],
				['table' => 'clients', 'alias' => 'Client', 'type' => 'LEFT', 'conditions' => ['Client.id = Bonlivraison.client_id','Client.deleted = 0'] ],
			],
			'order'=>['Avance.id'=>'DESC'],
			'group'=>['Avance.id'],
		];
		$avances = $this->Avance->find('list',$settings);
		if ( $this->Avance->updateAll(['Avance.etat'=>1],['Avance.id'=>$avances]) ) {
			die('L\'enregistrement a été effectué avec succès.');
		} else {
			die('Il y a un problème');
		}
	}

}