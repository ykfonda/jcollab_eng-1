<?php

App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));

class ProductionsController extends AppController {
	public $idModule = 131;
	
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
		// Récupérer la quantité produite
		$quantite_prod = $this->request->data['Production']['quantite_prod'];
	
		// Vérifier que la quantité produite est valide
		if (empty($quantite_prod) || !is_numeric($quantite_prod) || $quantite_prod <= 0) {
			$this->Session->setFlash('Quantité produite invalide.', 'alert-danger');
			return $this->redirect(['action' => 'view', $this->request->data['Production']['id']]);
		}
	
		// Mettre à jour la quantité produite
		$this->Production->id = $this->request->data['Production']['id'];
		$this->Production->saveField("quantite_prod", $quantite_prod);
	
		// Mettre à jour la date actuelle
		$currentDate = date('Y-m-d H:i:s'); // Format MySQL datetime
		$this->Production->saveField("date", $currentDate);
	
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

    // Title
    $title = '
    <div style="text-align:center; margin-top: 50px; margin-bottom: 30px;">
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
            <td style="text-align:left;">OF CLIENT</td>
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
            <td style="text-align:left;">123.000</td>
            <td style="text-align:left;"><strong>Prix Theo</strong></td>
            <td style="text-align:left;">41.1882</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Quantité produite</strong></td>
            <td style="text-align:left;">120.000</td>
            <td style="text-align:left;"><strong>Prix Prod</strong></td>
            <td style="text-align:left;">36.1883</td>
        </tr>
        <tr>
            <td style="text-align:left;"><strong>Statut</strong></td>
            <td colspan="3" style="text-align:center; background-color:#d1edf5; font-weight:bold;">En attente</td>
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

	
	



}