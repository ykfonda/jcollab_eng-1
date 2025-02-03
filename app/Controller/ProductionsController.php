<?php

App::import('Vendor', 'Escpos', array('file' => 'escpos-php/autoload.php'));
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class ProductionsController extends AppController {
	public $idModule = 131;
	// public $uses = ['Produit','Production','Productiondetail'];


	public function index() {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function excel(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Production.reference' )
					$conditions['Production.reference LIKE '] = "%$value%";
				else if( $param_name == 'Production.libelle' )
					$conditions['Production.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Production.date1' )
					$conditions['Production.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Production.date2' )
					$conditions['Production.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Production->recursive = -1;
		$settings = ['contain'=>['User','Depot','Produit'],'order'=>['Production.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Production->find('all',$settings);
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Production.reference' )
					$conditions['Production.reference LIKE '] = "%$value%";
				else if( $param_name == 'Production.libelle' )
					$conditions['Production.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Production.date1' )
					$conditions['Production.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Production.date2' )
					$conditions['Production.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Production->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User','Depot','Produit'],'order'=>['Production.date'=>'DESC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function editall() {

		

		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		if ($this->request->is(array('post', 'put'))) {
			$data = [];
			if (isset($this->data['Productiondetail']) AND !empty($this->data['Productiondetail'])) {
				foreach ($this->data['Productiondetail'] as $k => $v) {
					$i = $k+1;
					$data[$k]['Production'] = [
						'libelle' => $this->data['Production']['libelle'].' '.$i,
						'depot_id' => $this->data['Production']['depot_id'],
						'user_id' => $this->data['Production']['user_id'],
						'date' => $this->data['Production']['date'],
						'produit_id' => $v['produit_id'],
						'quantite' => $v['quantite'],
					];
					$data[$k]['Productiondetail'] = [];

					if ( isset($data[$k]['Production']['produit_id']) AND !empty($data[$k]['Production']['produit_id']) ) {
						$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('all',[
							'conditions' => [ 'produit_id' => $data[$k]['Production']['produit_id'] ],
							'fields' => [ 'ingredient_id' ],
						]);
						foreach ($ingredients as $value) {
							$data[$k]['Productiondetail'][] = [
								'produit_id' => $value['Produitingredient']['ingredient_id'],
								'quantite_theo' => $v['quantite'],
							];
						}
					}
				}
			}

			if (empty($data)) {
				$this->Session->setFlash('Opération impossible : Aucun produit saisie !','alert-danger');
				return $this->redirect($this->referer());
			}

			foreach ($data as $production) { $this->Production->saveAssociated($production); }
			$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			return $this->redirect($this->referer());
		}

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];
		$produits = $this->Production->Produit->findList($settings);
		$this->set(compact('produits','count'));
		$this->layout = false;
	}

	// Sauvegarde de la production
	public function updateProduction() {

		// Récupérer les données soumises
		$quantite_prod = $this->request->data['Production']['quantite_prod'];
		$recette_dlc_jour = $this->request->data['Production']['recette_dlc_jour'];
		$quantite_prod_old = $this->request->data['Production']['quantite_prod_old'];
		
		// Vérifier que la quantité produite est valide
		if (empty($quantite_prod) || !is_numeric($quantite_prod) || $quantite_prod <= 0) {
			$this->Session->setFlash('Quantité produite invalide.', 'alert-danger');
			return $this->redirect(['action' => 'view', $this->request->data['Production']['id']]);
		}

		// Récupérer la configuration de l'application
		$this->loadModel('Config');
		$Config_app = $this->Config->find('first');
		// 1 - Compteur de lots
		$lot_counter 		= $Config_app['Config']['lot_counter'];
		$lotNumber = $this->generateLotNumber($lot_counter);

		// 2 - Date de production
		$currentDate = date('Y-m-d'); // Format MySQL date

		// 3 - Date de péremption
		$dlc_date = $this->calculateDlc($currentDate, $recette_dlc_jour);


			// Mettre à jour les données de production
			$this->request->data['Production']['quantite_prod'] = $quantite_prod;

			if ($quantite_prod_old == null or empty($quantite_prod_old)) {
				// Si la quantité produite est nulle, incrémenter le compteur de lots et mettre à jour la date de production
				$this->request->data['Production']['date'] = $currentDate;
				$this->request->data['Production']['numlot'] = $lotNumber;
				$this->request->data['Production']['dlc'] = $dlc_date;

				 // Sauvegarder la nouvelle valeur dans la table config
				 $lot_counter_add_one = $lot_counter + 1;
				 $this->Config->id = $Config_app['Config']['id']; // Définir l'ID de l'enregistrement
				 if ($this->Config->saveField('lot_counter', $lot_counter_add_one)) {
					 echo "Compteur de lots mis à jour avec succès.";
				 } else {
					 echo "Erreur lors de la mise à jour du compteur de lots.";
				 }
			}

			// Sauvegarder toutes les données en une seule fois
			if ($this->Production->save($this->request->data['Production'])) {
				$this->Session->setFlash('La production a été mise à jour avec succès.', 'alert-success');
			} else {
				$this->Session->setFlash('Erreur lors de la mise à jour de la production.', 'alert-danger');
			}

	
		// Trouver les détails de la production
		$details = $this->Production->Productiondetail->find('all', [
			'conditions' => ['Productiondetail.production_id' => $this->request->data['Production']['id']],
			'contain' => ['Produit' => ['Unite'], 'Production'],
		]);
			
		$total_prod = 0; // Initialiser le total
		foreach ($details as $v) {
			// Trouver les ingrédients associés
			$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('first', [
				'conditions' => ['produit_id' => $v['Production']['produit_id'], 'ingredient_id' => $v['Productiondetail']['produit_id']],
				'contain' => ["Produit"],
			]);
	
			// Calculer la quantité réelle (désactivé dans votre code, à réactiver si nécessaire)
			// $quantite_reel = $this->request->data['Production']['quantite_prod'] * $ingredients['Produitingredient']['quantite'];
			// $this->Production->Productiondetail->id = $v['Productiondetail']['id'];
			// $this->Production->Productiondetail->saveField("quantite_reel", $quantite_reel);
	
			// Ajouter au total
			$total_prod += ($v['Productiondetail']['quantite_reel'] * $v['Productiondetail']['prix_achat']);
		}
	
		// Éviter la division par zéro
		if ($quantite_prod > 0) {
			$total_prod /= $quantite_prod;
		} else {
			$total_prod = 0; // Si la quantité produite est zéro, mettre un total par défaut
		}
	
		// Vérifier que le total est valide avant de sauvegarder
		if (is_numeric($total_prod)) {
			$this->Production->saveField("prix_prod", $total_prod);
		} else {
			$this->Session->setFlash('Le calcul du prix de production a échoué.', 'alert-danger');
			return $this->redirect(['action' => 'view', $this->request->data['Production']['id']]);
		}
	
		// Message de confirmation
		$this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
		return $this->redirect(['action' => 'view', $this->Production->id]);
	}
	
	


	// public function : Ajouter une nouvel OF {
	public function edit($id = null) {
		$store_type = $this->Session->read('Auth.User.StoreSession.type');
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');

		if ($this->request->is(array('post', 'put'))) {
			if( empty($this->request->data['Production']['id']) ){			
				$this->request->data['Productiondetail'] = [];
				 
				if ( isset($this->request->data['Production']['produit_id']) AND !empty($this->request->data['Production']['produit_id']) ) {
					$ingredients = $this->Production->Productiondetail->Produit->Produitingredient->find('all',[
						'conditions' => [ 'produit_id' => $this->request->data['Production']['produit_id'] ],
						'contain' => ["Produit"],
					]);
					$total_theo = 0;

					// Retrieve qteofeco from the Produit table
					$produit = $this->Production->Productiondetail->Produit->find('first', [
						'conditions' => ['Produit.id' => $this->request->data['Production']['produit_id']],
						'fields' => ['qteofeco']
					]);
					$qteofeco = $produit['Produit']['qteofeco'];
					$coefficient = $this->request->data['Production']['quantite'] / $qteofeco;

					// recuperation des ingredients
					foreach ($ingredients as $v) {
						$this->request->data['Productiondetail'][] = [
							'quantite_theo' => $coefficient * $v['Produitingredient']['quantite']*(1+$v['Produitingredient']['pourcentage_perte']/100),
							'produit_id' => $v['Produitingredient']['ingredient_id'],
							'prix_achat' => $v['Produit']['prixachat'],
						];
						$total_theo += ($coefficient * $v['Produitingredient']['quantite'] * $v['Produit']['prixachat']*(1+$v['Produitingredient']['pourcentage_perte']/100));
					}

					$total_theo /= $this->request->data['Production']['quantite'];
					$this->request->data['Production']['prix_theo'] = $total_theo;
					$this->request->data['Production']['user_id'] = $this->Session->read('Auth.User.id');
				}
				if( empty($this->request->data['Productiondetail']) ){
					$this->Session->setFlash('Opération impossible : Aucun produit trouvé','alert-danger');
					return $this->redirect($this->referer());
				}
			}



			// Récupérer l'ID du produit depuis les données soumises
			$produit_id = $this->request->data['Production']['produit_id'];

			// Récupérer la valeur de dlc_jours directement depuis la table Produit
			$this->loadModel('Produit');
			$produit_details = $this->Produit->find('first', [
				'conditions' => ['Produit.id' => $produit_id],
				'fields' => ['dlc_jours']
			]);

			// Test et affichage de dlc_jours
			if (!empty($produit_details['Produit']['dlc_jours'])) {
				$dlc_jours_recette = $produit_details['Produit']['dlc_jours'];
			} else {
				$dlc_jours_recette = null; // Valeur par défaut si DLC non défini
			}
			
			$this->request->data['Production']['recette_dlc_jour'] = $dlc_jours_recette;

			if ($this->Production->saveAssociated($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(['action'=>'view',$this->Production->id]);
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect($this->referer());
			}
		} else if ($this->Production->exists($id)) {
			$options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
			$this->request->data = $this->Production->find('first', $options);
		}

		$settings['Produit.type'] = 1;
		$settings['OR'] = ['Produit.display_on' => $store_type,'display_on' => 3];

		$users = $this->Production->User->findList();
		$produits = $this->Production->Produit->findList($settings);
		$depots = $this->Production->Depot->findList(['Depot.id'=>$depots]);
		$this->set(compact('users','produits','depots'));
		$this->layout = false;
	}

	public function generateLotNumber($lot_counter) {
		// Valider le compteur
		if (!is_numeric($lot_counter) || $lot_counter < 0) {
			throw new InvalidArgumentException('Le compteur de lot doit être un entier positif.');
		}
	
		// Obtenir l'année (2 derniers chiffres) et le quantième
		$year = date('y'); // Année en 2 chiffres (ex. '25' pour 2025)
		$dayOfYear = str_pad(date('z') + 1, 3, '0', STR_PAD_LEFT); // Quantième (z retourne 0-indexé, on ajoute 1)
	
		// Générer le numéro de lot
		$lotNumber = $year . $dayOfYear . str_pad($lot_counter, 3, '0', STR_PAD_LEFT);
	
		return $lotNumber;
	}

	
	public function view($id = null) {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');
		$depots = $this->Session->read('depots');
		$details = [];
		if ($this->Production->exists($id)) {
			$options = array('contain'=>['Produit','User','Depot'],'conditions' => array('Production.' . $this->Production->primaryKey => $id));
			$this->request->data = $this->Production->find('first', $options);
			$details = $this->Production->Productiondetail->find('all',[
				'conditions' => ['Productiondetail.production_id' => $id],
				'contain'=>['Produit' => ['Unite'] ],
			]);
		}
		$this->set(compact('details'));
		$this->getPath($this->idModule);
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->id = $id;
		if (!$this->Production->exists()) throw new NotFoundException(__('Invalide Production'));

		if ($this->Production->flagDelete()) {
			$this->Production->Productiondetail->updateAll(['Productiondetail.deleted'=>1],['Productiondetail.production_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function changestate($production_id = null,$statut = -1) {
		$production = $this->Production->find('first', [ 'conditions' => ['Production.id' => $production_id] ]);
		$depot_id = ( isset($production['Production']['depot_id']) AND !empty($production['Production']['depot_id']) ) ? $production['Production']['depot_id'] : 1 ;
		$details = $this->Production->Productiondetail->find('all',['conditions' => ['Productiondetail.production_id'=>$production_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : aucun détail à produire ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->id = $production_id;
		if ($this->Production->saveField('statut',$statut)) {
			foreach ($details as $production) { $this->entree($production['Productiondetail']['produit_id'],$depot_id,$production['Productiondetail']['quantite_reel']); }
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function entree($produit_id = null,$depot_id = null,$quantite_entree = 0) {
		$this->loadModel('Depotproduit');
		$depot = $this->Depotproduit->find('first',[ 'conditions'=>[ 'depot_id' => $depot_id, 'produit_id' => $produit_id ] ]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);
		
		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) ) ? (int) $depot['Depotproduit']['quantite'] : 0 ;
		$id = ( isset( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		$quantite = $ancienne_quantite + $quantite_entree;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
		];

		if ( $this->Depotproduit->save($data) ) { unset( $data ); return true;
		} else { unset( $data ); return false; }
	}


	public function editdetail($id = null,$production_id = null) {
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Production->Productiondetail->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Production->Productiondetail->exists($id)) {
			$options = array('conditions' => array('Productiondetail.' . $this->Production->Productiondetail->primaryKey => $id));
			$this->request->data = $this->Production->Productiondetail->find('first', $options);
		}

		$produits = $this->Production->Productiondetail->Produit->findList();
		$this->set(compact('produits','role_id'));
		$this->layout = false;
	}

	public function deletedetail($id = null,$production_id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Production->Productiondetail->id = $id;
		if (!$this->Production->Productiondetail->exists()) throw new NotFoundException(__('Invalide produit'));

		if ($this->Production->Productiondetail->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}


	public function calculateDlc($dateProduction, $nombreJours)
	{
		// Vérifier que les paramètres sont valides
		if (empty($dateProduction) || !is_numeric($nombreJours)) {
			return 'Paramètres invalides';
		}

		// Convertir la date de production en objet DateTime
		try {
			$date = new DateTime($dateProduction);
		} catch (Exception $e) {
			return 'Format de date invalide';
		}

		// Ajouter les jours à la date
		$date->modify("+$nombreJours days");

		// Retourner la DLC au format YYYY-MM-DD
		return $date->format('Y-m-d');


		var_dump($date->format('Y-m-d'));

	}



	public function generateProductionPdf($production_id = null)
{
    $user_id = $this->Session->read('Auth.User.id');
    $details = [];

    if ($this->Production->exists($production_id)) {
        // Fetch production data
        $options = [
            'contain' => [],
            'conditions' => ['Production.' . $this->Production->primaryKey => $production_id]
        ];
        $data = $this->Production->find('first', $options);

        // Fetch production details
        $details = $this->Production->Productiondetail->find('all', [
            'conditions' => ['Productiondetail.production_id' => $production_id],
            'contain' => ['Produit'],
        ]);
    }

    if (empty($details)) {
        $this->Session->setFlash('Aucun détail trouvé pour cette production.', 'alert-danger');
        return $this->redirect($this->referer());
    }

    $societe = $this->GetSociete();

    // Helper instance
    App::uses('LettreHelper', 'View/Helper');
    $LettreHelper = new LettreHelper(new View());

    $view = new View($this, false);
    $style = $view->element('style', ['societe' => $societe]);
    $footer = $view->element('footer', ['societe' => $societe]);

	

	App::uses('AppHelper', 'View/Helper');
	$AppHelper = new AppHelper(new View());
	$statut_production =  $data['Production']['statut'];
	$statut_production_output = $AppHelper->getValideEntree($statut_production);

	$recette_dlc_jour = !empty($data['Production']['recette_dlc_jour']) ? $data['Production']['recette_dlc_jour'] : "Non définie";
	$dlc = !empty($data['Production']['dlc']) ? date('d/m/Y', strtotime($data['Production']['dlc'])) : "Non définie";


    // Title
    $title = '
    <div style="text-align:center; margin-top: 5px; margin-bottom: 30px;">
        <h3 style="text-transform: uppercase; font-size: 18px; font-weight: bold; margin: 0;">Ordre de fabrication</h3>
    </div>';

    // Header with production details
    $header = '
    <table width="100%" style="border-collapse: collapse; font-size: 12px; margin-bottom: 20px;">
        <tr>
            <td style="width:20%; text-align:left;"><strong>Référence OF</strong></td>
            <td style="width:30%; text-align:left;">' . $data['Production']['reference'] . '</td>
            <td style="width:20%; text-align:left;"><strong>Date</strong></td>
            <td style="width:30%; text-align:left;">' . $data['Production']['date'] . '</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Objet</strong></td>
            <td style="text-align:left;">' . $data['Production']['libelle'] . '</td>
            <td style="text-align:left;"><strong>Responsable</strong></td>
            <td style="text-align:left;">SADEK HASSAN</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Produit</strong></td>
            <td style="text-align:left;">TEST RECETTE</td>
            <td style="text-align:left;"><strong>Dépôt</strong></td>
            <td style="text-align:left;">COMPTOIR</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Quantité à produire</strong></td>
            <td style="text-align:left;">'.$data['Production']['quantite'].'</td>
            <td style="text-align:left;"><strong>Prix Theo</strong></td>
            <td style="text-align:left;">'.$data['Production']['prix_theo'].'</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Quantité produite</strong></td>
            <td style="text-align:left;">'. $data['Production']['quantite_prod'] .'</td>
            <td style="text-align:left;"><strong>Prix Prod</strong></td>
            <td style="text-align:left;">'.$data['Production']['prix_prod'].'</td>
        </tr>
		<tr>
            <td style="text-align:left;"><strong>Durée de validité (jours)</strong></td>
            <td style="text-align:left;">'.$recette_dlc_jour .'</td>
            <td style="text-align:left;"><strong>DLC de produit	</strong></td>
            <td style="text-align:left;">'.$dlc.'</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Statut</strong></td>
            <td colspan="3" style="text-align:center; background-color:#d1edf5; font-weight:bold;">
			'.$statut_production_output.'
			</td>
        </tr>
    </table>';

    // Build the full HTML
    $html = '
    <html>
        <head>
            <title>Fiche de Production</title>
            ' . $style . '
        </head>
        <body>
            ' . $title . '
            ' . $header . '
            <div>
                <table class="details" width="100%" style="border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="border: 1px solid #ddd; padding: 8px;">Produit</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Quantité Théorique</th>
                            <th style="border: 1px solid #ddd; padding: 8px;">Quantité Réelle</th>
                        </tr>
                    </thead>
                    <tbody>';

    foreach ($details as $detail) {
        $quantite_theo = isset($detail['Productiondetail']['quantite_theo']) ? $detail['Productiondetail']['quantite_theo'] : 0;
        $quantite_reel = !empty($detail['Productiondetail']['quantite_reel']) ? number_format($detail['Productiondetail']['quantite_reel'], 2, ',', ' ') : '...';
        $libelle = isset($detail['Produit']['libelle']) ? $detail['Produit']['libelle'] : 'Inconnu';

        $html .= '<tr>
            <td style="border: 1px solid #ddd; padding: 8px;">' . htmlspecialchars($libelle) . '</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align:right;">' . number_format($quantite_theo, 2, ',', ' ') . '</td>
            <td style="border: 1px solid #ddd; padding: 8px; text-align:center;">' . $quantite_reel . '</td>
        </tr>';
    }

    $html .= '
                    </tbody>
                </table>
            </div>
            ' . $footer . '
        </body>
    </html>';

    // Generate PDF
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();

    // Ensure directory exists
    $destination = WWW_ROOT . 'pdfs' . DS . 'productions';
    if (!file_exists($destination)) {
        mkdir($destination, 0700, true);
    }

    $file_path = $destination . DS . 'Production_' . $data['Production']['reference'] . '.pdf';
    file_put_contents($file_path, $output);

    // Force download of the file
    $this->response->file($file_path, [
        'download' => true,
        'name' => 'Production_' . $data['Production']['reference'] . '.pdf',
    ]);

    // Stay on the same page
    return $this->response;
}



public function etiquettesGood($poids = null) {
    // Vérifier si la requête est AJAX
    if ($this->request->is('ajax')) {
        // Charger escpos-php
        require_once APP . 'Vendor' . DS . 'escpos-php' . DS . 'autoload.php';

        // 🔹 Vérifier si le poids est passé en POST
        if ($this->request->is('post')) {
            if (isset($this->request->data['poids'])) {
                $poids = floatval($this->request->data['poids']); // Convertir en nombre flottant
            }
        }

        // 🔹 Si aucun poids, récupérer depuis la balance
        if ($poids === null) {
            $poidsData = json_decode($this->getPoidsBalance(), true);
            if (!isset($poidsData['poids']) || $poidsData['poids'] <= 0) {
                echo json_encode(["error" => "Impossible de récupérer le poids depuis la balance."]);
                exit;
            }
            $poids = $poidsData['poids'];
			//$poids = number_format($poidsData['poids'], 3, '.', ''); // 🔹 Forcer 3 décimales
        }

        // 🔹 Vérifier le poids reçu
        // file_put_contents(APP . 'tmp/logs/impression.log', "Poids reçu pour impression : " . $poids . " kg\n", FILE_APPEND);
		file_put_contents("C:/laragon/www/jcollab/jcollab_eng/app/tmp/logs/impression.log", "Début impression avec poids : " . $poids . "\n", FILE_APPEND);


        try {
            // 🔹 Ajouter un message de confirmation avant d'imprimer
            echo json_encode(["message" => "Début de l'impression avec poids : " . $poids . " kg"]);
            flush();
            sleep(1);

            // Connexion à l'imprimante réseau
            $connector = new NetworkPrintConnector("192.168.40.40", 9100);
            $printer = new Printer($connector);

            // Ajout du titre en gras et centré
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("IMPRESSION DU POIDS\n");
            $printer->setEmphasis(false);
            $printer->text("----------------------------\n");

            // Alignement à gauche pour le poids
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Poids mesuré : " . number_format($poids, 3, ',', ' ') . " kg\n");
            $printer->text("----------------------------\n");

            // Ajout de la date et heure d'impression
            $date = date("d/m/Y H:i:s");
            $printer->text("Date : " . $date . "\n");

            // Coupure du papier et fermeture de l'imprimante
            $printer->cut();
            $printer->close();

            // 🔹 Ajouter un log pour confirmer l'impression
            file_put_contents(APP . 'tmp/logs/impression.log', "Impression réussie avec poids : " . $poids . " kg\n", FILE_APPEND);

            echo json_encode(["message" => "Impression réussie avec poids : " . $poids . " kg"]);
            exit;
        } catch (Exception $e) {
            file_put_contents(APP . 'tmp/logs/impression.log', "Erreur d'impression : " . $e->getMessage() . "\n", FILE_APPEND);
            echo json_encode(["error" => "Erreur d'impression : " . $e->getMessage()]);
            exit;
        }
    }

    // Chargement de la vue si ce n'est pas une requête AJAX
    $this->set('poids', null);
}

public function etiquettes($production_id = null) {
    $this->loadModel('Balance');
    $this->loadModel('Etiquette');

    if ($this->request->is('ajax')) {
        require_once APP . 'Vendor' . DS . 'escpos-php' . DS . 'autoload.php';

        $poids = null;
        if ($this->request->is('post') && isset($this->request->data['poids'])) {
            $poids = number_format(floatval($this->request->data['poids']), 3, '.', ''); // 🔹 FORCER 3 DÉCIMALES
        }

        if ($poids === null) {
            $poidsData = json_decode($this->getPoidsBalance(), true);
            if (!isset($poidsData['poids']) || $poidsData['poids'] <= 0) {
                echo json_encode(["error" => "Impossible de récupérer le poids depuis la balance."]);
                exit;
            }
            $poids = number_format($poidsData['poids'], 3, '.', ''); // 🔹 FORCER 3 DÉCIMALES
        }

        if (!$production_id) {
            echo json_encode(["error" => "ID de production manquant."]);
            exit;
        }

        // 🔹 Sauvegarde en base de données avec format 3 décimales
        $this->Etiquette->save([
            'Etiquette' => [
                'production_id' => $production_id,
                'poids' => (string)$poids // ✅ SAUVEGARDE COMME STRING POUR NE PAS TRONQUER
            ]
        ]);

        echo json_encode(["message" => "Étiquette enregistrée avec succès.", "poids" => $poids]);
        exit;
    }

    // 🔹 Récupération des balances enregistrées
    $balances = $this->Balance->find('all', [
        'recursive' => -1
    ]);

    if (empty($balances)) {
        $this->Session->setFlash("⚠ Aucune balance trouvée en base de données.", 'default', ['class' => 'alert alert-warning']);
    }

    $this->set(compact('production_id', 'balances'));
}





public function getPoidsBalance() {
    $ip_balance = '192.168.105.61'; // IP de la balance
    $port_balance = 8000; // Port de la balance

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($sock === false) {
        die(json_encode(["error" => "Erreur de création du socket : " . socket_strerror(socket_last_error())]));
    }

    socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 5, "usec" => 0));

    if (!socket_connect($sock, $ip_balance, $port_balance)) {
        die(json_encode(["error" => "Erreur de connexion au socket : " . socket_strerror(socket_last_error())]));
    }

    // 🔹 Envoyer la commande "REQUEST_WEIGHT" à la balance
    $message = "REQUEST_WEIGHT\n";
    socket_send($sock, $message, strlen($message), 0);

    // 🔹 Lire la réponse de la balance
    $data = '';
    $bytes = socket_recv($sock, $data, 1024, MSG_WAITALL);
    socket_close($sock);

    if ($bytes === false) {
        die(json_encode(["error" => "Erreur de réception des données : " . socket_strerror(socket_last_error())]));
    }

    $data = trim($data);

    // 🔍 Enregistrer les données brutes pour analyse
    file_put_contents(APP . 'tmp/logs/balance.log', "Données brutes : " . $data . "\n", FILE_APPEND);

    // 🔹 Extraction et nettoyage des données
    $poids = 0;

    // Utiliser une expression régulière pour extraire uniquement les nombres avec décimales
    if (preg_match('/([\d]+\.[\d]+)/', $data, $matches)) {
        $poids = number_format(floatval($matches[1]), 3, '.', ''); // ✅ FORCER 3 DÉCIMALES
    }

    // 🔍 Ajouter un log du poids détecté
    file_put_contents(APP . 'tmp/logs/balance.log', "Poids détecté : " . $poids . " kg\n", FILE_APPEND);

    // Retourner le poids en JSON
    echo json_encode(["poids" => $poids]);
    exit;
}


public function checkBalanceAvailability($balance_id = null) {
    $this->autoRender = false;
    $this->loadModel('Balance');

    if (!$balance_id) {
        echo json_encode(["error" => "Aucune balance sélectionnée."]);
        exit;
    }

    $balance = $this->Balance->findById($balance_id);
    if (!$balance) {
        echo json_encode(["error" => "Balance introuvable."]);
        exit;
    }

    $adresse_ip = $balance['Balance']['adresse_ip'];
    $port = $balance['Balance']['port'];

    $connection = @fsockopen($adresse_ip, $port, $errno, $errstr, 2);
    if ($connection) {
        fclose($connection);
        $this->Balance->id = $balance_id;
        $this->Balance->saveField('statut', 'disponible');

        echo json_encode(["statut" => "disponible"]);
    } else {
        $this->Balance->id = $balance_id;
        $this->Balance->saveField('statut', 'indisponible');

        echo json_encode(["statut" => "indisponible"]);
    }
    exit;
}






	



}