<?php
App::uses('AppController', 'Controller');
class PagesController extends AppController {
	public $components = array('Session');
	public $uses = array('Bonlivraison','Facture','Client','User','Produit','Avance','Depence','Fournisseur');

	public function display() {
		//add 
		if(!$this->Session->check('Auth.User')) 
		return $this->redirect('/users/login');

		////////////////

		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Auth->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$date = ['start' => date('Y-m-d', strtotime(date('Y-01-01'))), 'end' => date('Y-m-d')];

		$dateConditions = [];
		if( $this->request->is(['post', 'put']) ){
			if (isset($this->data['typeSubmit']) && $this->data['typeSubmit'] == 'RangeDate' ) {
				if( isset($this->data['Date']['start']) && !empty($this->data['Date']['start']) )
					$date['start'] = $this->data['Date']['start'];
				if( isset($this->data['Date']['end']) && !empty($this->data['Date']['end']) )
					$date['end'] = $this->data['Date']['end'];
			}
		}

		$annee = date('Y', strtotime($date['start']));

		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Bonlivraison', 'date');
		$nbr_bonlivraisons = $this->Bonlivraison->find('count',['conditions' => $dateConditions]);

		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Facture', 'date');
		$nbr_factures = $this->Facture->find('count',['conditions' => $dateConditions]);

		/* Block */
		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Fournisseur', 'date_c');
		$nbr_fournisseurs = $this->Fournisseur->find('count'); //,['conditions'=>$dateConditions]

		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Client', 'date_c');
		$nbr_clients = $this->Client->find('count'); // ,['conditions'=>['Client.type'=>1] + $dateConditions ]

		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'User', 'date_c');
		$nbr_users = $this->User->find('count',['conditions'=>['User.id !='=>1]]); // + $dateConditions 
		/* Block */

		/* Chiffre d'affaire */
		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Avance', 'date');
		$conditions = ['Avance.etat'=>1] + $dateConditions;
		$ChiffreAffaireValide = $this->getChiffreAffaireByStatut($conditions);
		$conditions = ['Avance.etat'=>-1] + $dateConditions;
		$ChiffreAffaireEnCours = $this->getChiffreAffaireByStatut($conditions);
		$ChiffreAffaireTotal = $ChiffreAffaireEnCours+$ChiffreAffaireValide;

		$societe = $this->GetSociete();
		$tva = ( isset( $societe['Societe']['tva'] ) AND !empty( $societe['Societe']['tva'] ) ) ? (int) $societe['Societe']['tva'] : 20 ;
		$division_tva = (1+$tva/100);
		$ChiffreAffaireTotalHt = round($ChiffreAffaireTotal/$division_tva,2);

		$dataAffaireValide = [];
		$conditions = ['Avance.etat'=>1];
		$ChiffreAffaireChart['Valide']['name'] = "Chiffre d'affaire validé";
		$ChiffreAffaireChart['Valide']['marker'] = ['symbol' => 'square'];
		for ($mois=1; $mois <= 12 ; $mois++) { 
			$dataAffaireValide[ $mois ] = $this->getChiffreAffaireByMonth( $mois , $annee , $conditions );
		}
		$ChiffreAffaireChart['Valide']['data'] = array_values( $dataAffaireValide );

		$dataAffaireEnCours = [];
		$conditions = ['Avance.etat'=>-1];
		$ChiffreAffaireChart['EnCours']['name'] = "Chiffre d'affaire en cours";
		$ChiffreAffaireChart['EnCours']['marker'] = ['symbol' => 'square'];
		for ($mois=1; $mois <= 12 ; $mois++) { 
			$dataAffaireEnCours[ $mois ] = $this->getChiffreAffaireByMonth( $mois , $annee , $conditions );
		}
		$ChiffreAffaireChart['EnCours']['data'] = array_values( $dataAffaireEnCours );
		/* Chiffre d'affaire */

		/* Valeur du stock */

		$depotproduits = $this->Produit->Depotproduit->find('all',[
			'fields' => ['Depotproduit.*','Produit.*'],
			'conditions'=>[
				'Produit.active'=>1,
				'Produit.prix_vente >'=>0,
				'Depotproduit.quantite >'=>0,
			],
			'joins' => [
				['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id','Produit.deleted = 0'] ],
				['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id','Depot.deleted = 0'] ],
			],
			'group' => ['Produit.id']
		]);

		$total_stock = 0;
		foreach ($depotproduits as $k => $v) {
			$total_stock = $total_stock + ($v['Depotproduit']['quantite']*$v['Produit']['prix_vente']);
		}

		$total_stock_ht = round($total_stock/$division_tva,2);
		/* Valeur du stock */

		/* Crédit restant */

		$soldes = $this->Client->Bonlivraison->find('all',[
			'fields' => ['Client.id','Client.designation','SUM(Bonlivraison.reste_a_payer) as reste_a_payer'],
			'conditions' => [
				'YEAR(Bonlivraison.date)' => $annee,
				'Bonlivraison.reste_a_payer >'=>0,
				'Bonlivraison.deleted'=>0,
				'Bonlivraison.etat'=>2,
			],
			'joins' => [
				['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Bonlivraison.client_id = Client.id','Client.deleted = 0'] ],
			],
			'group' => ['Client.id']
		]);

		/* Crédit restant */

		/* Alert stock */

		$produitsalerts = $this->Produit->find('all',[
			'fields' => ['Depotproduit.*','Produit.*'],
			'conditions'=>[
				'Produit.active'=>1,
				'Depotproduit.quantite'=>0,
			],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0'] ],
				['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = Depot.id','Depot.deleted = 0'] ],
			],
			'group' => ['Produit.id']
		]);

		/* Alert stock */

		/* Dépence */
		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Depence', 'date');
		$chiffre_depence = $this->Depence->find('first',[
			'fields' => ['SUM(Depence.montant) as montant'] ,
			'conditions' => $dateConditions
		]);

		$chiffre_affaire_depence = (isset( $chiffre_depence[0]['montant'] )) ? $chiffre_depence[0]['montant'] : 0 ;

		$chiffre_depence = $this->Depence->find('first',[
			'fields' => ['SUM(Depence.montant) as montant'] ,
			'conditions' => $dateConditions
		]);
		$chiffre_affaire_depence = (isset( $chiffre_depence[0]['montant'] )) ? $chiffre_depence[0]['montant'] : 0 ;
		$dataDepences = [];
		$depenceChart['name'] = "Chiffre d'affaire des dépences";
		$depenceChart['marker'] = ['symbol' => 'square'];
		for ($mois=1; $mois <= 12 ; $mois++) { 
			$dataDepences[ $mois ] = $this->getDepenceByMonth( $mois , $annee , [] );
		}
		$depenceChart['data'] = array_values( $dataDepences );

		$depences = $this->Depence->find('all',[
			'fields' => ['Categoriedepence.id','Categoriedepence.libelle','SUM(Depence.montant) as montant'] ,
			'conditions' => $dateConditions,
			'joins' => [
				['table' => 'categoriedepences', 'alias' => 'Categoriedepence', 'type' => 'INNER', 'conditions' => ['Categoriedepence.id = Depence.categoriedepence_id','Categoriedepence.deleted = 0'] ],
			],
			'group' => ['Categoriedepence.id'],
		]);

		$depencePie = [];
		foreach ($depences as $key => $value) {
			$montant = ( isset( $value[0]['montant'] ) AND !empty( $value[0]['montant'] ) ) ? (float) $value[0]['montant'] : 0 ;
			$depencePie[ $value['Categoriedepence']['id'] ] = [ 'name' => $value['Categoriedepence']['libelle'] ,'y' => $montant ];
		}
		/* Dépence */

		/* Client */

		$dateConditions = $this->generateDatesArray($date['start'], $date['end'], 'Avance', 'date');
		$chiffreClients = $this->Client->find('all',[
			'fields' => ['Client.id','Client.designation','SUM(Avance.montant) as montant'] ,
			'conditions' => [
				'Bonlivraison.etat !='=>3,
				'Avance.etat'=>1,
			] + $dateConditions,
			'joins' => [
				['table' => 'avances', 'alias' => 'Avance', 'type' => 'INNER', 'conditions' => ['Avance.client_id = Client.id','Avance.deleted = 0'] ],
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
			],
			'order' => ['SUM(Avance.montant)'=>'desc'],
			'group' => ['Client.id'],
			'limit' => 10
		]);


		$clientPie = [];
		App::uses('TextHelper', 'View/Helper');
		$TextHelper = new TextHelper(new View());
		foreach ($chiffreClients as $key => $value) {
			$montant = ( isset( $value[0]['montant'] ) AND !empty( $value[0]['montant'] ) ) ? (float) $value[0]['montant'] : 0 ;
			$name = $TextHelper->truncate( strtoupper( $value['Client']['designation'] ) ,20);
			$clientPie[ $value['Client']['id'] ] = [ 'name' => $name,'y' => $montant ];
		}

		/* Client */



		 // Charger le modèle Entree
		 $this->loadModel('Entree');

		 // Récupérer les données depuis la table entrees
		 $data = $this->Entree->find('all', array(
			 'conditions' => array('deleted' => 0),
			 'order' => array('date_c ASC'),
			 'limit' => 4
		 ));
	 
		// Préparer les données pour le graphique
		$labels = array();
		$entreesCumulees = 0;
		$sortiesCumulees = 0;
		$datasets = array();

		foreach ($data as $entry) {
			$labels[] = date('F', strtotime($entry['Entree']['date_c']));
			if ($entry['Entree']['type'] == 'Entree') {
				$entreesCumulees += $entry['Entree']['quantite'];
			} else {
				$sortiesCumulees += $entry['Entree']['quantite'];
			}
		}

		$datasets[] = array(
			'label' => 'Entrées',
			'data' => array($entreesCumulees),
			'backgroundColor' => 'rgba(54, 162, 235, 0.5)'
		);
		
		$datasets[] = array(
			'label' => 'Sorties',
			'data' => array($sortiesCumulees),
			'backgroundColor' => 'rgba(255, 99, 132, 0.5)'
		);

		// Charger la vue avec les données nécessaires
		$this->set(compact('labels', 'datasets'));









		

// Dans votre contrôleur approprié
$this->loadModel('User');
$this->loadModel('Salepoint');

// Déterminer la date de début de la semaine dernière
$startDate = date('Y-m-d', strtotime('last week monday'));

// Déterminer la date de fin de la semaine dernière (dimanche inclus)
$endDate = date('Y-m-d', strtotime('last week sunday'));

// Effectuer la requête pour récupérer les données de vente de la semaine dernière
$data = $this->User->find('all', array(
    'conditions' => array(
        'User.role_id' => 8,
        'DATE(Salepoint.date) >=' => $startDate,
        'DATE(Salepoint.date) <=' => $endDate
    ),
    'fields' => array(
        'User.code_bouchier',
        'User.nom',
        'User.prenom',
        'COUNT(*) AS total_ventes',
        'SUM(Salepoint.total_paye) AS total_montant'
    ),
    'joins' => array(
        array(
            'table' => 'salepoints',
            'alias' => 'Salepoint',
            'type' => 'INNER',
            'conditions' => array(
                'Salepoint.boucher = User.code_bouchier'
            )
        )
    ),
    'group' => array('User.code_bouchier', 'User.nom', 'User.prenom')
));

$this->set('data', $data);




$results_double_tickets = $this->Salepoint->find('all', array(
    'fields' => array(
        'Salepoint.reference AS numero_ticket',
        'Store.libelle AS store_libelle',
        'Salepoint.total_apres_reduction AS montant_ticket',
        'DATE(Salepoint.date) AS date',
        "DATE_FORMAT(Salepoint.date, '%H:%i:%s') AS heure_ticket"
    ),
    'joins' => array(
        array(
            'table' => 'stores',
            'alias' => 'Store',
            'type' => 'INNER',
            'conditions' => array(
                'Store.id = Salepoint.store'
            )
        )
    ),
    'conditions' => array(
        'Salepoint.date >=' => '2024-01-01',
        'Salepoint.date <' => date('Y-m-d'),
        'Salepoint.glovo_id =' => NULL,
        'Salepoint.etat' => 2,
    )
));




		$this->set( compact('results_double_tickets','depenceChart','depencePie','clientPie','chiffre_affaire_depence','produitsalerts','soldes','total_stock','ChiffreAffaireChart','nbr_bonlivraisons','nbr_factures','nbr_clients','nbr_users','date','role_id','ChiffreAffaireValide','ChiffreAffaireEnCours','ChiffreAffaireTotal','ChiffreAffaireTotalHt','total_stock_ht','nbr_fournisseurs') );
	} // END DISPLAY

	private function getDepenceByMonth($mois = null,$annee = null,$conditions = []){
		$bonlivraison = $this->Depence->find('first',[
			'fields' => ['SUM(Depence.montant) as montant'],
			'conditions' => [
				'MONTH(Depence.date)' => $mois,
				'YEAR(Depence.date)' => $annee,
			] + $conditions ,
			'group' => ['MONTH(Depence.date)'],
		]);

		return (isset( $bonlivraison[0]['montant'] )) ? (int) $bonlivraison[0]['montant'] : 0 ;
	}

	private function getChiffreAffaireByStatut($conditions){
		$bonlivraison = $this->Avance->find('first',[
			'fields' => ['SUM(Avance.montant) as count'],
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
				['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Client.id = Avance.client_id','Client.deleted = 0'] ],
			],
			'conditions' => ['Bonlivraison.etat !='=>3] + $conditions,
		]);

		return (isset( $bonlivraison[0]['count'] )) ? (int) $bonlivraison[0]['count'] : 0 ;
	}

	private function getChiffreAffaireByMonth($mois = null,$annee = null,$conditions = []){
		$bonlivraison = $this->Avance->find('first',[
			'fields' => ['SUM(Avance.montant) as count'],
			'conditions' => [
				'MONTH(Avance.date)' => $mois,
				'YEAR(Avance.date)' => $annee,
				'Bonlivraison.etat !='=>3
			] + $conditions ,
			'joins' => [
				['table' => 'bonlivraisons', 'alias' => 'Bonlivraison', 'type' => 'INNER', 'conditions' => ['Bonlivraison.id = Avance.bonlivraison_id','Bonlivraison.deleted = 0'] ],
				['table' => 'clients', 'alias' => 'Client', 'type' => 'INNER', 'conditions' => ['Client.id = Avance.client_id','Client.deleted = 0'] ],
			],
			'group' => ['MONTH(Avance.date)'],
		]);

		return (isset( $bonlivraison[0]['count'] )) ? (int) $bonlivraison[0]['count'] : 0 ;
	}

	private function generateDatesArray($dateD = null, $dateF = null, $model = '', $column = 'date'){
		$ret = [];
		if( !empty($model) ){
			if( !empty($dateD) ){
				$ret[$model.'.'.$column.' >='] = date('Y-m-d',strtotime($dateD));;
			}
			if( !empty($dateD) ){
				$ret[$model.'.'.$column.' <='] = date('Y-m-d',strtotime($dateF));;
			}
		}
		return $ret;
	}
}
