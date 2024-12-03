<?php
class CalendriersController extends AppController {
	public $idModule = 96;
	
	public $uses = ['Avance','Depence'];

	public function index() {
		$factures = $this->Avance->Facture->find('list');
		$bonlivraisons = $this->Avance->Bonlivraison->find('list');
		$clients = $this->Avance->Bonlivraison->Client->find('list');


		$events = [];

		$avances = $this->Avance->find('all',[ 
			'fields' => ['Avance.*','Bonlivraison.*','Facture.*'],
			'conditions' => [
				'Avance.date_echeance !=' => null,
				'Avance.etat' => -1,
				'Avance.mode' => 1,
			],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'LEFT', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
				['table' => 'factures', 'alias' => 'Facture', 'type' => 'LEFT', 'conditions' => ['Facture.id = Avance.facture_id','Facture.deleted = 0'] ],
			],
			'group' => ['Avance.id']
		]);

		$event_avances = [];
		foreach ($avances as $k => $v) {
			$dated = $v['Avance']['date_echeance'].' 00:00:00';
			$datef = $v['Avance']['date_echeance'].' 23:59:00';
			$url = Router::url([ 'controller'=>'avances','action'=>'index' ]);
			$reference = "";
			if ( isset( $v['Bonlivraison']['id'] ) AND !empty( $v['Bonlivraison']['id'] ) ) {
				$reference = "<br/>Bon de livraison N° : <br/>".$v['Bonlivraison']['reference'];
				$url = Router::url([ 'controller'=>'bonlivraisons','action'=>'view',$v['Bonlivraison']['id'] ]);
			}
			if ( isset( $v['Facture']['id'] ) AND !empty( $v['Facture']['id'] ) ) {
				$reference = "<br/>Facture N° : <br/>".$v['Facture']['reference'];
				$url = Router::url([ 'controller'=>'factures','action'=>'view',$v['Facture']['id'] ]);
			}
			$tip = "Référence : ".$v['Avance']['reference']."<br/>Date d'échéance : <br/>".$v['Avance']['date_echeance'].$reference;
			$title = "Réf : ".$v['Avance']['reference'];
			$start = date('c',strtotime($dated));
			$end = date('c',strtotime($datef));
			$event_avances[] = [
				'title' => trim($title), 
				'color' => "#e74c3c", 
				'tip' => trim($tip), 
				'start' => $start, 
				'dataUrl' => $url,
				'end' => $end ,
			];
		}

		$depences = $this->Depence->find('all',[ 
			'fields' => ['Depence.*','Boncommande.*','Bonreception.*'],
			'conditions' => [
				'Depence.date_echeance !=' => null,
				'Depence.etat' => -1,
				'Depence.mode' => 1,
			],
			'joins' => [
				['table' => 'boncommandes', 'alias' => 'Boncommande', 'type' => 'LEFT', 'conditions' => ['Boncommande.id = Depence.boncommande_id','Boncommande.deleted = 0'] ],
				['table' => 'bonreceptions', 'alias' => 'Bonreception', 'type' => 'LEFT', 'conditions' => ['Bonreception.id = Depence.bonreception_id','Bonreception.deleted = 0'] ],
			],
			'group' => ['Depence.id']
		]);

		$event_depences = [];
		foreach ($depences as $k => $v) {
			$dated = $v['Depence']['date_echeance'].' 00:00:00';
			$datef = $v['Depence']['date_echeance'].' 23:59:00';
			$url = Router::url([ 'controller'=>'avances','action'=>'index' ]);
			$reference = "";
			if ( isset( $v['Boncommande']['id'] ) AND !empty( $v['Boncommande']['id'] ) ) {
				$reference = "<br/>Bon de commande N° : <br/>".$v['Boncommande']['reference'];
				$url = Router::url([ 'controller'=>'boncommandes','action'=>'view',$v['Boncommande']['id'] ]);
			}
			if ( isset( $v['Bonreception']['id'] ) AND !empty( $v['Bonreception']['id'] ) ) {
				$reference = "<br/>Bon de reception N° : <br/>".$v['Bonreception']['reference'];
				$url = Router::url([ 'controller'=>'bonreceptions','action'=>'view',$v['Bonreception']['id'] ]);
			}
			$tip = "Référence : ".$v['Depence']['reference']."<br/>Date d'échéance : <br/>".$v['Depence']['date_echeance'].$reference;
			$title = "Réf : ".$v['Depence']['reference'];
			$start = date('c',strtotime($dated));
			$end = date('c',strtotime($datef));
			$event_depences[] = [
				'title' => trim($title), 
				'color' => "#e74c3c", 
				'tip' => trim($tip), 
				'start' => $start, 
				'dataUrl' => $url,
				'end' => $end ,
			];
		}

		$events = array_merge(
			$event_avances,
			$event_depences
		);

		$this->set(compact('bonlivraisons','clients','factures','events'));
		$this->getPath($this->idModule);
	}
}