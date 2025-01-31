<?php
class SortieController extends AppController {
	public $idModule = 95;
	
	public $uses = ['Mouvement','Sortiedetail','Bontransfert','Mouvementprincipal'];

	public $components = array('Ftp');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('validersortiecsb','importblcsb');
    }

	public function index() {
		$this->loadModel("Sortiedetail");
		$depots = $this->Session->read('depots');
		$produits = $this->Sortiedetail->Produit->findList();
		$depots = $this->Sortiedetail->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('produits','depots','fournisseurs'));
		$this->getPath($this->idModule);
	}
	public function pdf($id = null,$nom = null,$adresse = null,$ice = null)
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role = $this->Session->read('Auth.User.role_id');
        $details = [];
        if ($this->Mouvementprincipal->exists($id)) {
            $options = array('contain'=>['DepotSource' => ["Societe"],'DepotDestination'=> ["Societe"]],'conditions' => array('Mouvementprincipal.' . $this->Mouvementprincipal->primaryKey => $id));
            $mouvement_p = $this->request->data = $this->Mouvementprincipal->find('first', $options);

            $details = $this->Mouvementprincipal->Sortiedetail->find('all', [
                'conditions' => ['Sortiedetail.id_mouvementprincipal'=>$id],
                'contain' => ['Produit'],
            ]); 						
        } else {
            $this->Session->setFlash("Ce document n'existe pas !", 'alert-danger');
            return $this->redirect(['action' => 'index']);
        }

        if (empty($details)) {
            $this->Session->setFlash('Aucun produit saisie ! ', 'alert-danger');
            return $this->redirect($this->referer());
        }
        
  
        $societe = $this->GetSociete();
        //$this->view = "pdf_test";
        $this->set(compact('details', 'role', 'user_id', 'societe'));
        $this->layout = false;
    }


	public function generercsb($mouvementprincipal_id = null, $depot_destination_id, $depot_source_id) {


		$mouvement = [];
		$details = [];
		$onze = 11;
		// $store_id_usine = 19; // Varible SESSION
		$adr_string = "ADR";
		$item_string = "ITM";
		$prix_valeur = "";

		$this->loadModel("Depot");
		$depotData = $this->Depot->find('first', [
			'conditions' => [
				'id' => $depot_source_id,
				// 'store_id' => $store_id_usine // la condition pour le store_id == toujours USINE 
			],
			'fields' => ['id','store_id']
		]);
		$store_id = $depotData['Depot']['store_id'];
		$depot_id_data = $depotData['Depot']['id'];

		$mouvementprincipal = $this->Mouvementprincipal->find('first', [
			'conditions' => [
				'id' => $mouvementprincipal_id,
				'depot_destination_id' => $depot_destination_id,
			]
		]);

		// debug($mouvementprincipal);

		// Vérification si $mouvementprincipal est vide
		if (empty($mouvementprincipal)) {
			 echo "Nothing to do"; 
		} else {
		
			$this->loadModel('Store');
			$storeData = $this->Store->find('first', [
				'conditions' => ['id' => $store_id],
				'fields' => ['code_csb']
			]);
			$code_csb = $storeData['Store']['code_csb'];
			$mouv_ref = $mouvementprincipal['Mouvementprincipal']['reference'];
			$mouv_date = $mouvementprincipal['Mouvementprincipal']['date'];
			$mouv_date = str_replace('-', '/', $mouv_date); // Remplacer les tirets par des slashes

			// Vérifier si $mouv_ref contient un tiret "-"
			if (strpos($mouv_ref, '-') !== false) {
				// Reformater la valeur REF 
				$reference_split = explode('-', $mouv_ref);
				$mouv_ref = $reference_split[1]; // La deuxième partie après le tiret
			}

			$sortieDetails = $this->Sortiedetail->find('all', [
				'conditions' => [
					'Sortiedetail.id_mouvementprincipal' => $mouvementprincipal['Mouvementprincipal']['id']
				],
				'contain' => [
					'Produit' => [
						'fields' => ['code_barre']
					]
				],
				'order' => ['Sortiedetail.id' => 'DESC'],
			]);
		
			$csvData = [
				[$adr_string, $code_csb, $mouv_date, $mouv_ref], // Première ligne
			];
		
			foreach ($sortieDetails as $detail) {
				$csvData[] = [$item_string, $detail['Produit']['code_barre'], $detail['Sortiedetail']['stock_source'],$prix_valeur, $onze];
			}
		
			$mouv_date_sans_separateur = str_replace('/', '', $mouv_date);
			
			$filename = 'RT_' . $mouv_ref . '_' . $mouv_date_sans_separateur . '_' . $code_csb. '.csv';
			$filepath = WWW_ROOT . 'uploads\bon_retour' . DS . $filename;
		
			$csv = chr(239) . chr(187) . chr(191); // BOM for UTF-8
			foreach ($csvData as $line) {
				$csv .= implode(';', $line) . "\n";
			}
		
			file_put_contents($filepath, $csv);

			// Send it to the server (FTP)

				// Informations de connexion FTP
				//$ftp_server = '102.53.11.94';
				$ftp_server = '192.168.20.60';
				$ftp_user = 'lafondasapino\userftp';
				$ftp_pass = 'C-s//B*%2o14';

				// $ftp_server = 'ftp.iafsys.app';
				// $ftp_user = 'csbuser@iafsys.app';
				// $ftp_pass = 't+1.%ga7?ML?';

				$conn_id = ftp_connect($ftp_server);
				$login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

				// Vérification de la connexion
				if ($conn_id && $login_result) {
					// Transfert du fichier
					if (ftp_put($conn_id, '/RETOUR/' . $filename, $filepath, FTP_BINARY)) {
						echo "Fichier $filename transféré avec succès\n";
					} else {
						echo "Problème lors du transfert du fichier\n";
					}

					// Fermeture de la connexion FTP
					ftp_close($conn_id);
				} else {
					echo "Connexion FTP échouée\n";
				}

		} // end IF | Vérification si $mouvementprincipal est vide
	
		$this->layout = false;
	}

	
	public function validersortiecsb($mouvementprincipal_id  = null) {

		$this->loadModel("Depot");

		// Affectation des varibles (STATIC)
		$depot_source_id_ini = 10;
		$depot_source_societe_id = 1;
		$societe_source_client_id = 84;
		$societe_source_fournisseur_id = 4;

		$mouvement = []; $details = [];

		$mouvementprincipal = $this->Mouvementprincipal->find('first', 
			[ 'conditions' => 
			[
				'id' => $mouvementprincipal_id,
				'depot_source_id' => $depot_source_id_ini,
				'type' => "Expedition",
			] 
		]);

		// $details = $this->Mouvementprincipal->Sortiedetail->find('all',[
		$details = $this->Sortiedetail->find('all',[
			'conditions' => ['Sortiedetail.id_mouvementprincipal' => $mouvementprincipal_id ], 
			'contain' => ['Produit'],'order'=>['Sortiedetail.id'=>'DESC'],
		]);

		if (empty($details)) {
			$this->Session->setFlash('Opération impossible : Aucun produit saisie MSG 001','alert-danger');
			// return $this->redirect( $this->referer() );
		}

        // Recuprer les informations de la société
		$depot_source_id = $mouvementprincipal["Mouvementprincipal"]["depot_source_id"];
		$depot_destination_id = $mouvementprincipal["Mouvementprincipal"]["depot_destination_id"];
		$societe_source = $this->Depot->find('first', [ 'conditions' => ['Depot.id' => $depot_source_id]]);
		$societe_dest = $this->Depot->find('first', ["contain" => ["Societe"], 'conditions' => ['Depot.id' => $depot_destination_id]]);

		// l'entête de Bontransfert
		if($societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"] )
		{
			$data_transfert['Bontransfert']['id'] = null;
			$data_transfert['Bontransfertdetail'] = [];
			$data_transfert['Bontransfert']['date'] = $mouvementprincipal["Mouvementprincipal"]['date'];
			
			$data_transfert['Bontransfert']['depot_source_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			$data_transfert['Bontransfert']['depot_destination_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'];
			$data_transfert['Bontransfert']['type'] = "Expedition";		
			
		}

		// l'entête de Bonlivraison
		if($societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"]) {
			$data_expedition['Bonlivraison']['id'] = null;
			$data_expedition['Bonlivraisondetail'] = [];
			$data_expedition['Bonlivraison']['date'] = $mouvementprincipal["Mouvementprincipal"]['date'];
			
			$data_expedition['Bonlivraison']['depot_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			//$data_expedition['Bonlivraison']['depot_source_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			
			$data_expedition['Bonlivraison']['etat'] = -1;
			$data_expedition['Bonlivraison']['paye'] = -1;
			$data_expedition['Bonlivraison']['client_id'] = $societe_dest["Societe"]["client_id"];

			$data_expedition['Bonlivraison']['type'] = "Expedition";
			$data_expedition['Bonlivraison']['etat'] = 2;
			$data_expedition['Bonlivraison']['fournisseur_id'] =$societe_source_fournisseur_id;			
			// echo "GO";
		}


		if (!empty( $mouvementprincipal['Mouvementprincipal']['id'] ) AND $mouvementprincipal['Mouvementprincipal']['valide'] == -1 ) {

			foreach ($details as $sortiedetail) {
				$mouvement[] = [
					'id' => null,
					'operation' => 1,
					'num_lot' => $sortiedetail['Sortiedetail']['num_lot'],
					'prix_achat' => $sortiedetail['Sortiedetail']['prix_achat'],
					'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
					'stock_source' => $sortiedetail['Sortiedetail']['stock_source'],
					'depot_source_id' => $depot_source_id_ini,
					'depot_destination_id' => ( isset( $sortiedetail['Sortiedetail']['depot_destination_id'] ) ) ? $sortiedetail['Sortiedetail']['depot_destination_id'] : 0,
					'date' => ( isset( $sortiedetail['Sortiedetail']['date'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date'] ) ) : date('Y-m-d') ,
					'date_sortie' => ( isset( $sortiedetail['Sortiedetail']['date_sortie'] ) AND !empty( $sortiedetail['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date_sortie'] ) ) : null ,
					'description' => "Fichier CSB | Sortie N : ".$sortiedetail['Sortiedetail']['reference'],
				];

				$total_transfert = 0;

				// MEME BOITE
                if ($societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"]) {
                    $data_transfert['Bontransfertdetail'][] = [
                    'operation' => -1,
                    'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
                    'stock_source' => $sortiedetail['Sortiedetail']['stock_source'],
                    'stock_destination' => $sortiedetail['Sortiedetail']['stock_source'],
					'depot_source_id' => (isset($sortiedetail['Sortiedetail']['depot_source_id'])) ? $sortiedetail['Sortiedetail']['depot_source_id']: 0,
                    'depot_destination_id' => $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'],
                    'date' => (isset($sortiedetail['Sortiedetail']['date'])) ? date('Y-m-d', strtotime($sortiedetail['Sortiedetail']['date'])) : date('Y-m-d') ,
                ];
				$total_transfert += ($sortiedetail['Sortiedetail']['stock_source'] * $sortiedetail['Produit']['prixachat']);
                }

				// HORS BOITE => data de bon livraison
				if($societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"]) {
					$data_expedition['Bonlivraisondetail'][] = [		
						'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
						'depot_id' => $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'],
						'ttc' => $sortiedetail['Produit']['prix_vente'] * $sortiedetail['Sortiedetail']['stock_source'],
						'qte' => $sortiedetail['Sortiedetail']['stock_source'],
						'prix_vente' => $sortiedetail['Produit']['prix_vente'],
					];
				}
			}

			//// enregistrement des mouvements
			$this->loadModel('Mouvement');
			$this->loadModel('Entree');

			if ($this->Mouvement->saveMany($mouvement)) {
				foreach ($details as $sortiedetail) { 
						
					$this->sortie( $sortiedetail['Sortiedetail']['produit_id'] , $sortiedetail['Sortiedetail']['depot_source_id'], $sortiedetail['Sortiedetail']['stock_source']); 
					
					$produit_id_tosave 			= $sortiedetail['Sortiedetail']['produit_id'];
					$depot_id_tosave			= $sortiedetail['Sortiedetail']['depot_source_id'];
					$quantite_entree_tosave 	= $sortiedetail['Sortiedetail']['stock_source'];

					$depot = $this->Mouvement->Produit->Depotproduit->find('first',[
						'conditions'=>[ 
							'depot_id' => $depot_id_tosave, 
							'produit_id' => $produit_id_tosave,
						] 
					]);
					if ($depot_id_tosave != null) {
						$donnees['Entree'] = [
						'quantite' => $quantite_entree_tosave,
						'depot_id' => $depot_id_tosave,
						'produit_id' => $produit_id_tosave,
						'user_c' => 1,
						"type" => "Sortie"
					];
						$this->Entree->saveMany($donnees);
					}

				}

				$this->Mouvementprincipal->id = $mouvementprincipal_id;
				$this->Mouvementprincipal->saveField('valide',1); // à retablir
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}

			// Save DATA => Bontransfert
			if($societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"] ) {
                $this->loadModel('Bontransfert');
				$data_transfert['Bontransfert']['total'] = $total_transfert;
                if ($this->Bontransfert->saveAssociated($data_transfert)) {
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès. 01', 'alert-success');
					// return $this->redirect(array('action' => 'index'));
				} else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }
            }

			// Save DATA => Bonlivraison
			if($societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"] ){
				
				$this->loadModel('Bonlivraison');

				//  $depot_src = $this->Bonlivraison->Depot->find('first', ["contain" => ["Societe"],"conditions" => ["Depot.id" => $data_expedition['Bonlivraison']['depot_id'], "Depot.deleted" => 0]]);
            
				//$data_expedition['Bonlivraison']['client_id'] = $depot_src["Societe"]["client_id"];
				// $data_expedition['Bonlivraison']['fournisseur_id'] = $depot_src["Societe"]["fournisseur_id"]; 
				
				
				if ($this->Bonlivraison->saveAssociated($data_expedition)) {

					$bonlivraison_id = $this->Bonlivraison->id; 
					$bonlivraison = $this->Bonlivraison->find('first', ['contain'=>['User'],'conditions' => ['Bonlivraison.id' => $bonlivraison_id]]);
					$data_expedition['Bonreception']['id'] = null;
                    $data_expedition['Bonreceptiondetail'] = [];
                    $data_expedition['Bonreception']['date'] = $bonlivraison['Bonlivraison']['date'];
                
                    $data_expedition['Bonreception']['depot_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'];
                    $data_expedition['Bonreception']['depot_source_id'] = $bonlivraison['Bonlivraison']['depot_source_id'];
                
					$this->loadModel("Depot");
					// $societe_source = $this->Depot->find('first', [ "contain" => ["Societe"],'conditions' => ['Depot.id' => $bonlivraison['Bonlivraison']['depot_id']]]);

                    $data_expedition['Bonreception']['etat'] = -1;
                    $data_expedition['Bonreception']['type'] = "Expedition";
                    $data_expedition['Bonreception']['paye'] = -1;
					// $data_expedition['Bonreception']['fournisseur_id'] = $societe_source["Societe"]["fournisseur_id"];
					$data_expedition['Bonreception']['fournisseur_id'] = $societe_source_fournisseur_id;

					$data_expedition['Bonreception']['mouvementprincipal_id'] = $mouvementprincipal_id;

                    $bonlivraisondet = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                    'conditions' => ['Bonlivraisondetail.bonlivraison_id'=>$bonlivraison_id],
                    'fields' => ['Produit.*','Bonlivraisondetail.*'],
                    'contain' => ['Produit'],
                ]);



                    foreach ($bonlivraisondet as $key => $value) {
                        $data_expedition['Bonreceptiondetail'][] = [
                        'id' => null,
                        'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                        'qte_cmd' => $value['Bonlivraisondetail']['qte'],
                        'qte' => $value['Bonlivraisondetail']['qte'],
                        'prix_vente' => $value['Produit']['prix_vente'],
                        "num_lot" => "",
						"ttc" =>  $value['Bonlivraisondetail']['qte'] * $value['Produit']['prix_vente'],
                    ];
                        
                    }
                    $this->loadModel('Bonreception');

                    if ($this->Bonreception->saveAssociated($data_expedition)) {
                        $total = 0;
                        $id = $this->Bonreception->getLastInsertId();
                        $options = array('contain'=>['Fournisseur','Depot'],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
                        $this->request->data = $this->Bonreception->find('first', $options);
                    
                        $details_r = $this->Bonreception->Bonreceptiondetail->find('all', [
                        'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
                        'fields' => ['Produit.*','Bonreceptiondetail.*'],
                        'contain' => ['Produit'],
                    ]);
                        for ($i = 0; $i < count($details); $i++) {
                            $details_r[$i]["Bonreceptiondetail"]["total"] = $details_r[$i]["Bonreceptiondetail"]["prix_vente"] * $details_r[$i]["Bonreceptiondetail"]["qte"];
                    
                            $this->Bonreception->Bonreceptiondetail->id = $details_r[$i]["Bonreceptiondetail"]["id"];
                            $this->Bonreception->Bonreceptiondetail->savefield("total", $details_r[$i]["Bonreceptiondetail"]["total"]);
                        }
                        App::import('Controller', 'Bonreceptions');
                        $Bonreceptions = new BonreceptionsController;
						
                        $Bonreceptions->calculatrice($id);
                    
                
                    }

		
					$id = $this->Bonlivraison->getLastInsertId();

				App::import('Controller', 'Bonlivraisons');
				$Bonreceptions = new BonlivraisonsController;
				$Bonreceptions->calculatrice($id);
				
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
					// return $this->redirect(array('controller' =>'Bonlivraisons','action' => 'view',$id));
				} else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                } 
			}
			
			// return $this->redirect( $this->referer() );

		} else {
			$this->Session->setFlash('Opération impossible : bon déja validé','alert-danger');
		}
			// return $this->redirect( $this->referer() );


		$this->layout = false;
	}
	

	public function valider($mouvementprincipal_id  = null) {
		
		if ( isset( $this->globalPermission['Permission']['v'] ) AND $this->globalPermission['Permission']['v'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de valider !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$mouvement = []; $details = [];

		$mouvementprincipal = $this->Mouvementprincipal->find('first', [ 'conditions' => ['id' => $mouvementprincipal_id] ]);
		
		// $details = $this->Mouvementprincipal->Sortiedetail->find('all',[
		$details = $this->Sortiedetail->find('all',[
			'conditions' => ['Sortiedetail.id_mouvementprincipal' => $mouvementprincipal_id ], 
			'contain' => ['Produit'],'order'=>['Sortiedetail.id'=>'DESC'],
		]);

		if ( empty( $details ) ) {
			$this->Session->setFlash('Opération impossible : Aucun produit saisie MSG 002','alert-danger');
			return $this->redirect( $this->referer() );
		}
        if ($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition") {
            $depot_source_id = $mouvementprincipal["Mouvementprincipal"]["depot_source_id"];
            $depot_destination_id = $mouvementprincipal["Mouvementprincipal"]["depot_destination_id"];
        
            $this->loadModel("Depot");
            $societe_source = $this->Depot->find('first', [ 'conditions' => ['Depot.id' => $depot_source_id],
        ]);
            $societe_dest = $this->Depot->find('first', ["contain" => ["Societe"], 'conditions' => ['Depot.id' => $depot_destination_id],
         ]);
        }
		if($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"] )
		{
			$data_transfert['Bontransfert']['id'] = null;
			$data_transfert['Bontransfertdetail'] = [];
			$data_transfert['Bontransfert']['date'] = $mouvementprincipal["Mouvementprincipal"]['date'];
			
			$data_transfert['Bontransfert']['depot_source_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			$data_transfert['Bontransfert']['depot_destination_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'];
			$data_transfert['Bontransfert']['type'] = "Expedition";		
			
		}
		elseif($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"]) {
			
			
		
			$data_expedition['Bonlivraison']['id'] = null;
			$data_expedition['Bonlivraisondetail'] = [];
			$data_expedition['Bonlivraison']['date'] = $mouvementprincipal["Mouvementprincipal"]['date'];
			
			$data_expedition['Bonlivraison']['depot_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			//$data_expedition['Bonlivraison']['depot_source_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_source_id'];
			
			$data_expedition['Bonlivraison']['etat'] = -1;
			$data_expedition['Bonlivraison']['paye'] = -1;
			$data_expedition['Bonlivraison']['client_id'] = $societe_dest["Societe"]["client_id"];

			$data_expedition['Bonlivraison']['type'] = "Expedition";
			$data_expedition['Bonlivraison']['etat'] = 2;
			

		}
		if ( isset( $mouvementprincipal['Mouvementprincipal']['id'] ) AND !empty( $mouvementprincipal['Mouvementprincipal']['id'] ) AND $mouvementprincipal['Mouvementprincipal']['valide'] == -1 ) {
			foreach ($details as $sortiedetail) {
				$mouvement[] = [
					'id' => null,
					'operation' => 1,
					'num_lot' => $sortiedetail['Sortiedetail']['num_lot'],
					'prix_achat' => $sortiedetail['Sortiedetail']['prix_achat'],
					'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
					'stock_source' => $sortiedetail['Sortiedetail']['stock_source'],
					'depot_source_id' => ( isset( $sortiedetail['Sortiedetail']['depot_source_id'] ) ) ? $sortiedetail['Sortiedetail']['depot_source_id'] : 0,
					'depot_destination_id' => ( isset( $sortiedetail['Sortiedetail']['depot_destination_id'] ) ) ? $sortiedetail['Sortiedetail']['depot_destination_id'] : 0,
					'date' => ( isset( $sortiedetail['Sortiedetail']['date'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date'] ) ) : date('Y-m-d') ,
					'date_sortie' => ( isset( $sortiedetail['Sortiedetail']['date_sortie'] ) AND !empty( $sortiedetail['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date_sortie'] ) ) : null ,
					'description' => "Numéro du bon de sortie : ".$sortiedetail['Sortiedetail']['reference'],
				];

				$total_transfert = 0;
                if ($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"]) {
                    $data_transfert['Bontransfertdetail'][] = [
                 
                    'operation' => -1,
                    'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
                    'stock_source' => $sortiedetail['Sortiedetail']['stock_source'],
                    'stock_destination' => $sortiedetail['Sortiedetail']['stock_source'],
					'depot_source_id' => (isset($sortiedetail['Sortiedetail']['depot_source_id'])) ? $sortiedetail['Sortiedetail']['depot_source_id']: 0,
                    'depot_destination_id' => $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'],
                    'date' => (isset($sortiedetail['Sortiedetail']['date'])) ? date('Y-m-d', strtotime($sortiedetail['Sortiedetail']['date'])) : date('Y-m-d') ,
                ];
				$total_transfert += ($sortiedetail['Sortiedetail']['stock_source'] * $sortiedetail['Produit']['prixachat']);
                }
				elseif($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"]) {
					
					
					$data_expedition['Bonlivraisondetail'][] = [
						
						'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
						'depot_id' => $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'],
						'ttc' => $sortiedetail['Produit']['prix_vente'] * $sortiedetail['Sortiedetail']['stock_source'],
						'qte' => $sortiedetail['Sortiedetail']['stock_source'],
						'prix_vente' => $sortiedetail['Produit']['prix_vente']
					];
				
				
				}
			}



			//// enregistrement des mouvements
			$this->loadModel('Mouvement');
			$this->loadModel('Entree');

			if ($this->Mouvement->saveMany($mouvement)) {
				foreach ($details as $sortiedetail) { 
						
					$this->sortie( $sortiedetail['Sortiedetail']['produit_id'] , $sortiedetail['Sortiedetail']['depot_source_id'], $sortiedetail['Sortiedetail']['stock_source']); 
					
					$produit_id_tosave 			= $sortiedetail['Sortiedetail']['produit_id'];
					$depot_id_tosave			= $sortiedetail['Sortiedetail']['depot_source_id'];
					$quantite_entree_tosave 	= $sortiedetail['Sortiedetail']['stock_source'];

					$depot = $this->Mouvement->Produit->Depotproduit->find('first',[
						'conditions'=>[ 
							'depot_id' => $depot_id_tosave, 
							'produit_id' => $produit_id_tosave,
						] 
					]);
					if ($depot_id_tosave != null) {
						$donnees['Entree'] = [
						'quantite' => $quantite_entree_tosave,
						'depot_id' => $depot_id_tosave,
						'produit_id' => $produit_id_tosave,
						"type" => "Sortie"
					];
						$this->Entree->saveMany($donnees);
					}

				}



				$this->Mouvementprincipal->id = $mouvementprincipal_id;
				$this->Mouvementprincipal->saveField('valide',1);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');

				if (!isset($check_valider_sans_creer_RT)) {
					$this->generercsb($mouvementprincipal_id, $depot_destination_id, $depot_source_id);
				}

			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			
			
			if($mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] == $societe_dest["Depot"]["societe_id"] ) {
                $this->loadModel('Bontransfert');
				$data_transfert['Bontransfert']['total'] = $total_transfert;
                if ($this->Bontransfert->saveAssociated($data_transfert)) {
					

					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
					return $this->redirect(array('action' => 'index'));
				} else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }
            }
			elseif(	$mouvementprincipal["Mouvementprincipal"]["type"] == "Expedition" and $societe_source["Depot"]["societe_id"] != $societe_dest["Depot"]["societe_id"] ){
				
				$this->loadModel('Bonlivraison');
				 $depot_src = $this->Bonlivraison->Depot->find('first', ["contain" => ["Societe"],"conditions" => ["Depot.id" => $data_expedition['Bonlivraison']['depot_id'], "Depot.deleted" => 0]]);
            
				//$data_expedition['Bonlivraison']['client_id'] = $depot_src["Societe"]["client_id"];
				$data_expedition['Bonlivraison']['fournisseur_id'] = $depot_src["Societe"]["fournisseur_id"]; 
				
				if ($this->Bonlivraison->saveAssociated($data_expedition)) {

					////////add
					$bonlivraison_id = $this->Bonlivraison->id; 
					$bonlivraison = $this->Bonlivraison->find('first', ['contain'=>['User'],'conditions' => ['Bonlivraison.id' => $bonlivraison_id]]);
					$data_expedition['Bonreception']['id'] = null;
                    $data_expedition['Bonreceptiondetail'] = [];
                    $data_expedition['Bonreception']['date'] = $bonlivraison['Bonlivraison']['date'];
                
                    $data_expedition['Bonreception']['depot_id'] = $mouvementprincipal["Mouvementprincipal"]['depot_destination_id'];
                    $data_expedition['Bonreception']['depot_source_id'] = $bonlivraison['Bonlivraison']['depot_source_id'];
                
					$this->loadModel("Depot");
					$societe_source = $this->Depot->find('first', [ "contain" => ["Societe"],'conditions' => ['Depot.id' => $bonlivraison['Bonlivraison']['depot_id']]]);

                    $data_expedition['Bonreception']['etat'] = -1;
                    $data_expedition['Bonreception']['type'] = "Expedition";
                    $data_expedition['Bonreception']['paye'] = -1;
					$data_expedition['Bonreception']['fournisseur_id'] = $societe_source["Societe"]["fournisseur_id"];

					$data_expedition['Bonreception']['mouvementprincipal_id'] = $mouvementprincipal_id;

                    $bonlivraisondet = $this->Bonlivraison->Bonlivraisondetail->find('all', [
                    'conditions' => ['Bonlivraisondetail.bonlivraison_id'=>$bonlivraison_id],
                    'fields' => ['Produit.*','Bonlivraisondetail.*'],
                    'contain' => ['Produit'],
                ]);
                    foreach ($bonlivraisondet as $key => $value) {
                        $data_expedition['Bonreceptiondetail'][] = [
                        'id' => null,
                        'produit_id' => $value['Bonlivraisondetail']['produit_id'],
                        'qte_cmd' => $value['Bonlivraisondetail']['qte'],
                        'qte' => $value['Bonlivraisondetail']['qte'],
                        'prix_vente' => $value['Produit']['prix_vente'],
                        "num_lot" => "",
						"ttc" =>  $value['Bonlivraisondetail']['qte'] * $value['Produit']['prix_vente'],
                    ];
                        
                    }
                    $this->loadModel('Bonreception');

					
                    if ($this->Bonreception->saveAssociated($data_expedition)) {
                        $total = 0;
                        $id = $this->Bonreception->getLastInsertId();
                        $options = array('contain'=>['Fournisseur','Depot'],'conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
                        $this->request->data = $this->Bonreception->find('first', $options);
                    
                        $details_r = $this->Bonreception->Bonreceptiondetail->find('all', [
                        'conditions' => ['Bonreceptiondetail.bonreception_id'=>$id],
                        'fields' => ['Produit.*','Bonreceptiondetail.*'],
                        'contain' => ['Produit'],
                    ]);
                        for ($i = 0; $i < count($details); $i++) {
                            $details_r[$i]["Bonreceptiondetail"]["total"] = $details_r[$i]["Bonreceptiondetail"]["prix_vente"] * $details_r[$i]["Bonreceptiondetail"]["qte"];
                    
                            $this->Bonreception->Bonreceptiondetail->id = $details_r[$i]["Bonreceptiondetail"]["id"];
                            $this->Bonreception->Bonreceptiondetail->savefield("total", $details_r[$i]["Bonreceptiondetail"]["total"]);
                        }
                        App::import('Controller', 'Bonreceptions');
                        $Bonreceptions = new BonreceptionsController;
						
                        $Bonreceptions->calculatrice($id);
                    
                
                    }

		
					$id = $this->Bonlivraison->getLastInsertId();

				App::import('Controller', 'Bonlivraisons');
				$Bonreceptions = new BonlivraisonsController;
				$Bonreceptions->calculatrice($id);
				
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
					return $this->redirect(array('controller' =>'Bonlivraisons','action' => 'view',$id));
				} else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                } 
			}
			
			return $this->redirect( $this->referer() );

		} else {
			$this->Session->setFlash('Opération impossible : bon déja validé','alert-danger');
		}
			return $this->redirect( $this->referer() );
	}




	
	public function indexAjax(){
		$depots = $this->Session->read('depots');
		$conditions['DepotSource.id' ] = $depots;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Produit.libelle' )
					$conditions['Produit.libelle LIKE'] = "%$value%";
				else if( $param_name == 'Sortiedetail.num_lot' )
					$conditions['Sortiedetail.num_lot LIKE'] = "%$value%";
				else if( $param_name == 'Sortiedetail.reference' )
					$conditions['Sortiedetail.reference LIKE'] = "%$value%";
				else if( $param_name == 'Sortiedetail.date1' )
					$conditions['Sortiedetail.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Sortiedetail.date2' )
					$conditions['Sortiedetail.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");
		$depots = $this->Depot->find("list", ["conditions" => ["store_id" => $selected_store],
		'fields' => ['id']]);
		if(count($depots) == 1)
		$conditions['DepotSource.id'] = $depots;
		else
		$conditions['DepotSource.id IN'] = $depots;

		$this->loadModel('Mouvementprincipal');
		$this->Mouvementprincipal->recursive = -1;
		/* $this->Paginator->settings = [
			'contain'=>['DepotSource','DepotDestination','Creator'],
			'order'=>['Mouvementprincipal.id'=>'DESC'],
			'conditions'=>$conditions
		]; */
	
	
		$this->loadModel('Motifsretour');
$this->Paginator->settings = [
    'order' => ['Mouvementprincipal.id' => 'DESC'],
    'contain' => ['DepotSource', 'DepotDestination', 'Motifsretour'], // Ajout de la relation
    'conditions' => $conditions
];

		$mouvementprincipals = $this->Paginator->paginate('Mouvementprincipal');
		
		$this->set(compact('taches','mouvementprincipals'));
		$this->layout = false;
	}

	public function delete_principal($mouvementprincipal_id) {
		$this->loadModel("Sortiedetail");
		$sortiedetails = $this->Sortiedetail->find('all',[
			'conditions' => ['Sortiedetail.id_mouvementprincipal' => $mouvementprincipal_id ] 
		]);
		
		foreach ($sortiedetails as $sortiedetail) {
			$this->entree($sortiedetail['Sortiedetail']['produit_id'],$sortiedetail['Sortiedetail']['depot_source_id'],$sortiedetail['Sortiedetail']['stock_source']);
			
			$mouvement_save[] = [
				'id' => null,
				'operation' => 1,
				'num_lot' => $sortiedetail['Sortiedetail']['num_lot'],
				'prix_achat' => $sortiedetail['Sortiedetail']['prix_achat'],
				'produit_id' => $sortiedetail['Sortiedetail']['produit_id'],
				'stock_source' => $sortiedetail['Sortiedetail']['stock_source'],
				'depot_source_id' => ( isset( $sortiedetail['Sortiedetail']['depot_source_id'] ) ) ? $sortiedetail['Sortiedetail']['depot_source_id'] : 0,
				'depot_destination_id' => ( isset( $sortiedetail['Sortiedetail']['depot_destination_id'] ) ) ? $sortiedetail['Sortiedetail']['depot_destination_id'] : 0,
				'date' => ( isset( $sortiedetail['Sortiedetail']['date'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date'] ) ) : date('Y-m-d') ,
				'date_sortie' => ( isset( $sortiedetail['Sortiedetail']['date_sortie'] ) AND !empty( $sortiedetail['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $sortiedetail['Sortiedetail']['date_sortie'] ) ) : null ,
				'description' => "Numéro du bon de sortie : ".$sortiedetail['Sortiedetail']['reference'],
			];
			
			$this->loadModel('Mouvement');
			
			
			$this->Sortiedetail->id = $sortiedetail["Sortiedetail"]["id"];
			if(!$this->Sortiedetail->delete()) {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
		}
		$this->Mouvement->saveMany($mouvement_save);

		$this->loadModel("Mouvementprincipal");
		$mouvementprincipal = $this->Mouvementprincipal->find('first',[
			'conditions' => ['Mouvementprincipal.id' => $mouvementprincipal_id ] 
		]);
		$this->Mouvementprincipal->id = $mouvementprincipal["Mouvementprincipal"]["id"];
		if(!$this->Mouvementprincipal->delete()) {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		else {
			$this->Session->setFlash('La suprrésion a été effectué avec succès.','alert-success');
		}
		return $this->redirect(array('action' => 'index'));			
	}

	
	public function edit($id = null, $mouvementprincipal_id = null) {
		$depots = $this->Session->read('depots');
		$this->loadModel("Sortiedetail");
		if ($this->request->is(array('post', 'put'))) {
			$this->loadModel("Depot");
				$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
				$depot_dest = $this->Depot->find('first',[
					'conditions' => ['store_id' => $selected_store,
					"principal" => 1 ] 
				]);
			 if($id == 0 and $mouvementprincipal_id != null) {
				$this->request->data['Sortiedetail']['id_mouvementprincipal'] = $mouvementprincipal_id;	
				$this->loadModel("Mouvementprincipal");
				$mouvementprincipal = $this->Mouvementprincipal->find('first',[
					'conditions' => ['Mouvementprincipal.id' => $mouvementprincipal_id ] 
				]);
				$this->Mouvementprincipal->id = $mouvementprincipal["Mouvementprincipal"]["id"];
				$this->Mouvementprincipal->saveField('nb_produits',$mouvementprincipal["Mouvementprincipal"]["nb_produits"] + 1 );
				$this->request->data['Sortiedetail']['depot_source_id'] = $mouvementprincipal["Mouvementprincipal"]["depot_source_id"];
				$this->request->data['Sortiedetail']['depot_destination_id'] = $mouvementprincipal["Mouvementprincipal"]["depot_destination_id"];
			}
			/* else {
				$this->loadModel("Depot");
				$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
				$depot_dest = $this->Depot->find('first',[
					'conditions' => ['store_id' => $selected_store,
					"principal" => 1 ] 
				]);
				$data = [
					"date_sortie" => ( isset( $this->data['Sortiedetail']['date_sortie'] ) AND !empty( $this->data['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Sortiedetail']['date_sortie'] ) ) : date('Y-m-d'),
					"description" => ( isset( $this->data['Sortiedetail']['description'] ) AND !empty( $this->data['Sortiedetail']['description'] ) ) ? $this->data['Sortiedetail']['description'] : "",
					"type" => "Sortie",
					"depot_destination_id" => $depot_dest["Depot"]["id"],
					"depot_source_id" => $depot_dest["Depot"]["id"],
					"nb_produits" => 1,
					'valide' => -1
				];
				$this->Mouvementprincipal->save($data);
				$this->request->data['Sortiedetail']['id_mouvementprincipal'] = $this->Mouvementprincipal->getLastInsertId();
			}
 */			
			$this->request->data['Sortiedetail']['operation'] = 1;
			$this->request->data['Sortiedetail']['depot_source_id'] = $depot_dest["Depot"]["id"];
		
			$this->request->data['Sortiedetail']['date_sortie'] = ( isset( $this->data['Sortiedetail']['date_sortie'] ) AND !empty( $this->data['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Sortiedetail']['date_sortie'] ) ) : date('Y-m-d');
			$this->request->data['Sortiedetail']['date'] = ( isset( $this->data['Sortiedetail']['date_sortie'] ) AND !empty( $this->data['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Sortiedetail']['date_sortie'] ) ) : null; 
			$this->loadModel("Sortiedetail");
			$this->Sortiedetail->id = $this->request->data['Sortiedetail']['id'];
			if ($this->Sortiedetail->save($this->request->data)) {

				/* if ( isset( $this->data['Sortiedetail']['produit_id'] ) AND isset( $this->data['Sortiedetail']['depot_source_id'] ) ) {
					$this->sortie($this->data['Sortiedetail']['produit_id'],$this->data['Sortiedetail']['depot_source_id'],$this->data['Sortiedetail']['stock_source']);
				}  */

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect($this->referer());
		} else if ($this->Sortiedetail->exists($id)) {
			$options = array('conditions' => array('Sortiedetail.' . $this->Sortiedetail->primaryKey => $id));
			$this->request->data = $this->Sortiedetail->find('first', $options);
			$this->loadModel("Produit");
			$produit = $this->Produit->find('first', ['conditions' => ['Produit.id' => $this->request->data["Sortiedetail"]["produit_id"]]  ]);
		}
		
		$produits = $this->Sortiedetail->Produit->findList();
		$depots = $this->Sortiedetail->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('produit','produits','depots','fournisseurs'));
		$this->layout = false;
	}
	
	public function sortie($produit_id = null,$depot_id,$quantite_sortie = 0) {
		$depot = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[ 
				'depot_id' => $depot_id, 
				'produit_id' => $produit_id,
			] 
		]);

		/*
        if ($depot_id != null) {
            $this->loadModel('Entree');
            $donnees['Entree'] = [
            'quantite' => $quantite_sortie,
            'depot_id' => $depot_id,
            'produit_id' => $produit_id,
            "type" => "Sortie"
        ]; 
            $this->Entree->save($donnees);
        } */
		$ancienne_quantite = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['quantite'] ) ) ?  $depot['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite - $quantite_sortie;
		/* if( $quantite <= 0 ) $quantite = 0; */

		$id = ( isset( $depot['Depotproduit']['id'] ) AND !empty( $depot['Depotproduit']['id'] ) ) ? $depot['Depotproduit']['id'] : null ;
		
		$data = [
			'id' => $id,
			'date' => date('Y-m-d'),
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			'quantite' => $quantite,
		];
		/* var_dump($quantite);die(); */
		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}

	public function entree($produit_id = null,$depot_id = 1,$quantite_entree = 0) {
		$source = $this->Mouvement->Produit->Depotproduit->find('first',[
			'conditions'=>[
				'depot_id' => $depot_id,
				'produit_id' => $produit_id,
			] 
		]);

		$this->loadModel('Entree');
		$donnees['Entree'] = [
			'quantite' => $quantite_entree,
			'depot_id' => $depot_id,
			'produit_id' => $produit_id,
			"type" => "Entree"
		];
		$this->Entree->save($donnees);

		$ancienne_quantite = ( isset( $source['Depotproduit']['id'] ) AND !empty( $source['Depotproduit']['quantite'] ) ) ?  $source['Depotproduit']['quantite'] : 0 ;
		$quantite = $ancienne_quantite + $quantite_entree;
		if( $quantite <= 0 ) $quantite = 0;

		$id = ( isset( $source['Depotproduit']['id'] ) ) ? $source['Depotproduit']['id'] : null ;
		
		$data['Depotproduit'] = [
			'id' => $id,
			'depot_id' => $depot_id,
			'date' => date('Y-m-d'),
			'quantite' => $quantite,
			'produit_id' => $produit_id,
		];

		if ( $this->Mouvement->Produit->Depotproduit->save($data) ) return true;
		else return false;
	}
	public function loadquantite($produit_id = null){
		$produit = $this->Mouvement->Produit->find('first',[
			'conditions'=>['Produit.id'=>$produit_id]]);
		die( json_encode( $produit["Produit"]["stockactuel"] ) );	
	}
		
	public function loadproduit($produit_id = null,$depot_id = null){
		App::uses('HtmlHelper', 'View/Helper');
		$HtmlHelper = new HtmlHelper(new View());
		$produit = [];
		if ( !empty( $produit_id ) AND !empty( $depot_id ) ) {
			$produit = $this->Mouvement->Produit->find('first',[
				'fields' => ['Depotproduit.*', 'Produit.*'/* ,'Unite.*' */],
				'conditions'=>['Produit.id'=>$produit_id],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
					/* ['table' => 'unites', 'alias' => 'Unite', 'type' => 'LEFT', 'conditions' => ['Unite.id = Produit.unite_id','Unite.deleted = 0']], */
				], 
			]);

			$produit['Produit']['unite'] = ( isset( $produit['Unite']['id'] ) AND !empty( $produit['Unite']['id'] ) ) ? strtolower( $produit['Unite']['libelle'] ) : '' ;
			$produit['Produit']['stock'] = ( isset( $produit['Depotproduit']['quantite'] ) AND !empty( $produit['Depotproduit']['quantite'] ) ) ? $produit['Depotproduit']['quantite'] : 0 ;
			/* $produit['Produit']['stock'] = ( isset( $produit['Produit']['stockactuel'] ) AND !empty( $produit['Produit']['stockactuel'] ) ) ? $produit['Produit']['stockactuel'] : 0 ; */
			
			if (isset($produit['Produit']['image']) AND file_exists( WWW_ROOT.'uploads'.DS.'articles_images'.DS.$produit['Produit']['image']))
				$produit['Produit']['image'] = $HtmlHelper->url('/uploads/articles_images/'.$produit['Produit']['image']);
			else	
				$produit['Produit']['image'] = $HtmlHelper->url('/img/no-image.png');
		}
		//$data = ["stock" => $produit['Depotproduit']['quantite']];
		$data = ["stock" => $produit['Produit']['stock']];
		die( json_encode( $data ) );
	}

	public function loaddepots($produit_id = null) {
		$depots = $this->Session->read('depots');
		$depots = $this->Mouvement->DepotSource->find('list',[
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.depot_id = DepotSource.id','Depotproduit.deleted = 0']],
				['table' => 'produits', 'alias' => 'Produit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id','Produit.deleted = 0']],
			],
			'conditions' => [
				'Depotproduit.quantite >='=>0,
				'Produit.id' => $produit_id,
				'DepotSource.id'=>$depots,
			],
		]);

		die( json_encode( $depots ) );
	}
	public function view($sortie_id = null) {
		$details = [];

		$this->loadModel('Mouvementprincipal');
		$this->loadModel('Sortiedetail');
		$this->loadModel('Bonreception');
	
		if ($this->Mouvementprincipal->exists($sortie_id)) {
			$options = array('contain' => "DepotSource",'conditions' => array('Mouvementprincipal.' . $this->Mouvementprincipal->primaryKey => $sortie_id));
			$this->request->data = $this->Mouvementprincipal->find('first', $options);
			
			$details = $this->Sortiedetail->find('all', array(
				'conditions' => array('Sortiedetail.id_mouvementprincipal' => $sortie_id),
				'order' => array('Sortiedetail.id' => 'DESC'),
				'contain' => array(
					'Mouvementprincipal' => array(
						'Bonreception' => array(
							'conditions' => array('Bonreception.mouvementprincipal_id' => $sortie_id),
							'Bonreceptiondetail' 
						)
					),
					'Produit',
					'DepotSource',
					'DepotDestination'
				)
			));
						
		}

		$depots = $this->Mouvementprincipal->DepotSource->findList();
		$produits = $this->Mouvementprincipal->Produit->findList();
		$this->set(compact('produits','depots','details'));
		$this->getPath($this->idModule);
	}


	public function editall() {
		$depots = $this->Session->read('depots');
		if ($this->request->is(array('post', 'put'))) {
			$depot_id = ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0 ;
			$insert = [
				'id' => null,
				'description' => ( isset( $this->data['Mouvement']['description'] ) ) ? $this->data['Mouvement']['description'] : 'Sortie en masse ' ,
				'motifsretour_id' => ( isset( $this->data['Mouvement']['motifsretour_id'] ) ) ? $this->data['Mouvement']['motifsretour_id'] : null,
				'date' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : date('Y-m-d') ,
				'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : date('Y-m-d') ,
				'depot_source_id' => ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0,
				'nb_produits' => ( isset( $this->data['MouvementDetail'] ) ) ? sizeof($this->data['MouvementDetail']) : 0,
				'type' => "Sortie en masse",
				'valide' => -1,
				'user_c' => null,
				'date_c' => 1,			
			];
			
			if ( !$this->Mouvementprincipal->save($insert) ) {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect( $this->referer() );
			} 
			if ( isset( $this->data['MouvementDetail'] ) AND !empty( $this->data['MouvementDetail'] ) ) {
				$data = [];
				foreach ($this->data['MouvementDetail'] as $key => $value) {
					$data[] = [
						'id' => null,
						'operation' => 1,
						'depot_source_id' => $depot_id,
						'produit_id' => $value['produit_id'],
						'num_lot' =>  ( isset( $value['num_lot'] ) AND !empty( $value['num_lot'] ) ) ? $value['num_lot'] : null ,
						'stock_source' =>  ( isset( $value['stock_source'] ) AND !empty( $value['stock_source'] ) ) ? $value['stock_source'] : 0 ,
						'fournisseur_id' => ( isset( $this->data['Mouvement']['fournisseur_id'] ) ) ? $this->data['Mouvement']['fournisseur_id'] : null ,
						'description' => ( isset( $this->data['Mouvement']['description'] ) ) ? $this->data['Mouvement']['description'] : 'Sortie en masse ' ,
						'date' => ( isset( $this->data['Mouvement']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : date('Y-m-d') ,
						'id_mouvementprincipal' => $this->Mouvementprincipal->getLastInsertId()
					];
				}

				if ( $this->Sortiedetail->saveMany($data) ) {
					/* foreach ($data as $key => $value) { 
						$this->sortie( $value['produit_id'] , $value['depot_source_id'], $value['stock_source']); 
					} */
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
				return $this->redirect( array('action' => 'index') );
			} else {
				$this->Session->setFlash('Aucune ligne a saisie','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}

		$this->loadModel('Motifsretour');
		$motifs = $this->Mouvement->Motifsretour->find('list', [
			'fields' => ['Motifsretour.id', 'Motifsretour.libelle']
		]);
		$this->set(compact('motifs'));

		
		$fournisseurs = $this->Mouvement->Fournisseur->find('list');
		$depots = $this->Mouvement->DepotSource->findList(['DepotSource.id'=>$depots]);
		$this->set(compact('depots','fournisseurs','motifs'));
		$this->getPath($this->idModule);
	}

	// importer les données BL depuis fichier CSB
	public function importblcsbOLDGOLD() {
		/**** Bon Livraison : BL_000043_28122023_1029111.csv
			ADR;1029111;30/12/2023;37;0,00;0,00;
			ITM;607;3,00
			ITM;260;4,50
		***/
		$this->loadModel("Produit");
		$this->loadModel('Mouvementprincipal');
		$this->loadModel('Mouvement');
		$this->loadModel("Depot");
		$this->loadModel("Store");
		

		// Affectation des varibles (STATIC)
		$depot_source_id = 10;
		$depot_source_societe_id = 1;
		$societe_dest_client_id = 84;

		$directory = APP . 'webroot' . DS . 'uploads' . DS . 'bon_livraison';
		// Modèle de titre recherché
		$pattern = 'BL_*_*_*.csv';
		$matchingFiles = glob($directory . DS . $pattern);
		foreach ($matchingFiles as $file) {
			$fileTitle = pathinfo($file, PATHINFO_FILENAME);
			// Vérifier si le titre correspond au modèle
			if (preg_match('/^BL_\d{6}_\d{8}_\d{7}$/', $fileTitle)) {
				// echo "Fichier correspondant trouvé : $fileTitle\n";
				// Faire ce que tu veux avec le fichier correspondant ici
			}
		}
		


		// $filename = 'uploads/bon_livraison/BL_000043_28122023_1029111.csv';

		$handle = fopen($filename, 'r');
		$headerProcessed = false;
		$headerData = [];
		$detailsData = [];
		
		while (($row = fgetcsv($handle, 0, ';')) !== false) {
			if ($row[0] = 'ADR' && !$headerProcessed) {
				$headerData = [
					'code_csb' => $row[1],
					'date' => $row[2],
					'reference' => $row[3],
				];
				$headerProcessed = true;
			} elseif ($row[0] = 'ITM') {
				$detailsData[] = [
					'code_barre' => $row[1],
					'quantite' => $row[2],
					'prix' => isset($row[3]) ? $row[3] : '',
				];
			}
		}
		
		fclose($handle);
		
		// Afficher les données d'en-tête et les données de détails
		// debug($headerData);
		// debug($detailsData);
		

	// 1 - Données store / depot 

	$code_csb_value = isset($headerData['code_csb']) ? $headerData['code_csb'] : null;
	$store_dest = $this->Depot->Store->find("first", ["conditions" => ["Store.code_csb" => $code_csb_value]]);

	// Recherche du dépôt en fonction du code CSB
	$depot = $this->Depot->find('first', [
		'fields' => ['Depot.id','Depot.societe_id'],
		'conditions' => [
			'Store.code_csb' => $code_csb_value,
			'Store.id = Depot.store_id'
		],
		'joins' => [
			[
				'table' => 'stores',
				'alias' => 'Store',
				'type' => 'INNER',
				'conditions' => [
					'Store.id = Depot.store_id'
				]
			]
		]
	]);

	if ($depot) {
		$depot_destination_id = $depot['Depot']['id'];
		$depot_destination_societe_id = $depot['Depot']['societe_id'];
	} else {
		$depot_destination_id = NULL;
	}

	// 2 - Création d'une nouvelle instance du modèle Mouvementprincipal
	$mouvement = $this->Mouvementprincipal->create();

		//Traitement de la date BL
		$date_operation = $headerData['date'];
		$date_operation = DateTime::createFromFormat('d/m/Y', $date_operation);
		$date_operation = $date_operation->format('Y-m-d');

	// Préparation des données à insérer
	$data = [
		'reference' => $headerData['reference'],
		'description' => 'Fichier CSB',
		'date' => $date_operation,
		'date_sortie' => $date_operation,
		'depot_source_id' => $depot_source_id,
		'depot_destination_id' => $depot_destination_id,
		'nb_produits' => count($detailsData), // Nombre de produits
		'type' => 'Expedition',
		'valide' => -1,
		'user_c' => 1,
		'deleted' => 0
	];

	// Assignation des données au modèle
	$this->Mouvementprincipal->set($data);

	// Vérification et sauvegarde des données
	if ($this->Mouvementprincipal->validates() && $this->Mouvementprincipal->save($data)) {
		$id_mouvementprincipal = $this->Mouvementprincipal->getLastInsertID();

		// Succès de l'insertion
		echo 'Données insérées avec succès.';
	} else {
		// Erreur lors de l'insertion
		echo 'Erreur lors de l\'insertion des données.';
	}



		// 3- Création d'une nouvelle instance du modèle sortiedetails
		// Boucle pour chaque élément de détail
		$sortiedetailsData = [];
		$mouvementData = [];
		foreach ($detailsData as $detail) {

		// check the produit
		$produit = $this->Produit->find('first', [
			'fields' => ['Produit.id','Produit.prixachat'],
			'conditions' => ['Produit.code_barre' => $detail['code_barre']]
		]);

		if ($produit) {
			// Si le produit correspondant est trouvé, récupérez l'ID du produit et les autres données
			$produit_id 		= $produit['Produit']['id'];
			if (empty($detail['prix']) OR $detail['prix']= "0,00") {
				$produit_prixachat 	= $produit['Produit']['prixachat'];
			}else {
				$produit_prixachat 	= $detail['prix'];
			}
		}else{
			$produit_id = "";
		}

		$sortiedetailsData = [
			'reference' => $headerData['reference'],
			'description' => 'Fichier CSB',
			'prix_achat' => $produit_prixachat,
			'date' => $date_operation,
			'date_sortie' => $date_operation,
			'stock_source' => $detail['quantite'],
			'paquet_source' => null,
			'total_general' => null,
			'stock_destination' => $depot_destination_id,
			'produit_id' => $produit_id,
			'client_id' => null,
			'depot_source_id' => $depot_source_id,
			'depot_destination_id' => $depot_destination_id,
			'vente_id' => null,
			'facture_id' => null,
			'retour_id' => null,
			'fournisseur_id' => null,
			'operation' => 1,
			'returned' => -1,
			'id_mouvementprincipal' => $id_mouvementprincipal // Utilisez l'ID précédemment enregistré
		];

			// 4 Enregistrement des données dans la table sortiedetails
			if ($this->Sortiedetail->saveAll($sortiedetailsData)) {
				// Succès de l'insertion
				echo 'Données insérées avec succès.';
			} else {
				// Erreur lors de l'insertion
				echo 'Erreur lors de l\'insertion des données.';
			}
		
		
			// 4- Création d'une nouvelle instance du modèle Mouvements

			// Calcul du total général en bouclant à travers les détails
			// $total_general = 0;
			// foreach ($detailsData as $detail) {
				// Calcul du total pour chaque produit
				// $total_general += $detail['quantite'] * $produit_prixachat;
			// }

			// 5 Création des données pour l'insertion mouvement
			$mouvementData = [
				'reference' => $headerData['reference'],
				'num_lot' => null,
				'description' => 'Numéro du bon de sortie / Fichier CSB : ' . $headerData['reference'],
				'prix_achat' => $produit_prixachat,
				'date' => $date_operation,
				'date_sortie' => $date_operation,
				'stock_source' => $detail['quantite'], 
				'paquet_source' => null,
				'total_general' => NULL,
				'stock_destination' => $depot_destination_id,
				'produit_id' => $produit_id,
				'client_id' => null,
				'depot_source_id' => $depot_source_id,
				'depot_destination_id' => $depot_destination_id,
				'vente_id' => null,
				'facture_id' => null,
				'retour_id' => null,
				'fournisseur_id' => null,
				'operation' => 1,
				'returned' => -1,
				'deleted' => 0
			];

			// Enregistrement des données dans la table mouvements
			$this->Mouvement->create();
			if ($this->Mouvement->saveAll($mouvementData)) {
				// Succès de l'insertion
				echo 'Données insérées avec succès dans la table mouvements.';
			} else {
				// Erreur lors de l'insertion
				echo 'Erreur lors de l\'insertion des données dans la table mouvements.';
			}

		
		} // Fin de boucle détail document

		

		
		
		
		// 6- Création d'une nouvelle instance du modèle Bontransfert ou Bonlivraison
		if($depot_source_societe_id == $depot_destination_societe_id )
		{
			$data_transfert['Bontransfert']['id'] = null;
			$data_transfert['Bontransfertdetail'] = [];
			$data_transfert['Bontransfert']['date'] = $date_operation;
			$data_transfert['Bontransfert']['depot_source_id'] = $depot_source_id;
			$data_transfert['Bontransfert']['depot_destination_id'] = $depot_destination_id;
			$data_transfert['Bontransfert']['type'] = "Expedition";		
		}else{
			$data_expedition['Bonlivraison']['id'] = null;
			$data_expedition['Bonlivraisondetail'] = [];
			$data_expedition['Bonlivraison']['date'] = $date_operation;
			
			$data_expedition['Bonlivraison']['depot_id'] = $depot_source_id;
			
			$data_expedition['Bonlivraison']['etat'] = -1;
			$data_expedition['Bonlivraison']['paye'] = -1;
			$data_expedition['Bonlivraison']['client_id'] = $societe_dest_client_id;

			$data_expedition['Bonlivraison']['type'] = "Expedition";
			$data_expedition['Bonlivraison']['etat'] = 2;
		}



	$this->layout = false;
	}

	
	// importer les données BL depuis fichier CSB
	public function importblcsb() {
		/**** Bon Livraison : BL_000043_28122023_1029111.csv
			ADR;1029111;30/12/2023;37;0,00;0,00;
			ITM;607;3,00
			ITM;260;4,50
		***/
		$this->loadModel("Produit");
		$this->loadModel('Mouvementprincipal');
		$this->loadModel('Mouvement');
		$this->loadModel("Depot");
		$this->loadModel("Store");
		$this->loadModel('Sortiedetail');
		
		$ftp = $this->Ftp->getFtpConnection();
        $fileList = ftp_nlist($ftp, '/BL');

		// Initialisez un tableau pour stocker les fichiers .csv
		$csvFiles = [];

		// Parcourez la liste des fichiers pour ne sélectionner que les fichiers avec l'extension .csv
		foreach ($fileList as $file) {
			// Vérifiez si le fichier a l'extension .csv
			if (preg_match('/\.csv$/', $file)) {
				// Ajoutez le fichier au tableau des fichiers .csv
				$csvFiles[] = $file;
			}
		}

		$fileList = $csvFiles;
		
		// Définissez un répertoire local temporaire pour stocker les fichiers téléchargés
		$directory = APP . 'webroot' . DS . 'uploads' . DS . 'bon_livraison';

		// Assurez-vous que le répertoire local existe sinon créez-le
		if (!file_exists($directory)) {
			mkdir($directory, 0777, true);
		}

		// Téléchargez les fichiers du répertoire distant vers le répertoire local temporaire
			foreach ($fileList as $file) {
				$localFile = $directory . DS . basename($file);
				if (ftp_get($ftp, $localFile, $file, FTP_BINARY)) {
					echo "Le fichier a été téléchargé avec succès";
						
					$ftpArchiveDirectory = '/BL/archives';
					// Déplacez (coper) le fichier vers le répertoire d'archives sur le serveur FTP
					if (ftp_rename($ftp, $file, $ftpArchiveDirectory . '/' . basename($file))) {
						// Le fichier a été déplacé avec succès vers le répertoire d'archives sur le serveur FTP
					} else {
						echo "Erreur lors du déplacement du fichier vers le répertoire d'archives sur le serveur FTP";
					}



				} else {
					echo "Erreur lors du téléchargement du fichier";
				}
			}

		// Modèle de titre recherché
		$pattern = 'BL_*_*_*.csv';
		$matchingFiles = glob($directory . DS . $pattern);

		foreach ($matchingFiles as $filename) {
			$handle = fopen($filename, 'r');
			$headerProcessed = false;
			$headerData = [];
			$detailsData = [];

			while (($row = fgetcsv($handle, 0, ';')) !== false) {
				if ($row[0] = 'ADR' && !$headerProcessed) {
					$headerData = [
						'code_csb' => $row[1],
						'date' => $row[2],
						'reference' => $row[3],
					];
					$headerProcessed = true;
				} elseif ($row[0] = 'ITM') {
					$detailsData[] = [
						'code_barre' => !empty($row[1]) ? $row[1] : $row[4], // Utilisation de $row[4] si $row[1] est vide
						'quantite' => $row[2],
						'prix' => isset($row[3]) ? $row[3] : '',
					];
				}
			}
			

			fclose($handle);

			// Traitement des données du fichier actuel ici
			// Vous pouvez utiliser $headerData et $detailsData pour chaque fichier
			// Par exemple, pour afficher les données :
			// echo "Header: " . print_r($headerData, true) . "\n";
			// echo "Details: " . print_r($detailsData, true) . "\n";

			// debug($headerData);
			// debug($detailsData);


			// 1 - Données store / depot 
			$code_csb_value = isset($headerData['code_csb']) ? $headerData['code_csb'] : null;
			$this->traitementimportblcsb($code_csb_value, $headerData, $detailsData);

			// Archiver les .csv locaux
			$localArchiveDirectory = APP . 'webroot' . DS . 'uploads' . DS . 'bon_livraison' . DS . 'archives';
			if (!file_exists($localArchiveDirectory)) {
				mkdir($localArchiveDirectory, 0777, true);
			}
			$localArchiveFile = $localArchiveDirectory . DS . basename($filename);
			if (rename($filename, $localArchiveFile)) {
				echo "Le fichier a été déplacé avec succès vers le répertoire d'archives local <br />";
			} else {
				echo "Erreur lors du déplacement du fichier vers le répertoire d'archives local  <br />";
			}


		}

		$this->layout = false;
	}



	public function traitementimportblcsb($code_csb_value, $headerData, $detailsData) {

		$this->loadModel("Produit");
		$this->loadModel('Mouvementprincipal');
		$this->loadModel('Mouvement');
		$this->loadModel("Depot");
		$this->loadModel("Store");
		$this->loadModel('Sortiedetail');

		// Affectation des varibles (STATIC)
		$depot_source_id = 10;
		$depot_source_societe_id = 1;
		$societe_dest_client_id = 84;

		$store_dest = $this->Depot->Store->find("first", ["conditions" => ["Store.code_csb" => $code_csb_value]]);

		// Recherche du dépôt en fonction du code CSB
		$depot = $this->Depot->find('first', [
			'fields' => ['Depot.id','Depot.societe_id'],
			'conditions' => [
				'Store.code_csb' => $code_csb_value,
				'Store.id = Depot.store_id'
			],
			'joins' => [
				[
					'table' => 'stores',
					'alias' => 'Store',
					'type' => 'INNER',
					'conditions' => [
						'Store.id = Depot.store_id'
					]
				]
			]
		]);

		if ($depot) {
			$depot_destination_id = $depot['Depot']['id'];
			$depot_destination_societe_id = $depot['Depot']['societe_id'];
		} else {
			$depot_destination_id = NULL;
		}


		// 2 - Création d'une nouvelle instance du modèle Mouvementprincipal
		$mouvement = $this->Mouvementprincipal->create();

			//Traitement de la date BL
			$date_operation = $headerData['date'];
			$date_operation = DateTime::createFromFormat('d/m/Y', $date_operation);
			$date_operation = $date_operation->format('Y-m-d');

		// Préparation des données à insérer
		$data = [
			'reference' => $headerData['reference'],
			'description' => 'Fichier CSB',
			'date' => $date_operation,
			'date_sortie' => $date_operation,
			'depot_source_id' => $depot_source_id,
			'depot_destination_id' => $depot_destination_id,
			'nb_produits' => count($detailsData), // Nombre de produits
			'type' => 'Expedition',
			'valide' => -1,
			'user_c' => 1,
			'deleted' => 0
		];

		// Assignation des données au modèle
		$this->Mouvementprincipal->set($data);

		// Vérification et sauvegarde des données
		if ($this->Mouvementprincipal->validates() && $this->Mouvementprincipal->save($data)) {
			
			$id_mouvementprincipal = $this->Mouvementprincipal->getLastInsertID();

			// Succès de l'insertion
			// echo 'Données insérées avec succès. Mouvementprincipal <br />';
		} else {
			// Erreur lors de l'insertion
			echo 'Erreur lors de l\'insertion des données.';
		}

		// 3- Création d'une nouvelle instance du modèle sortiedetails
		// Boucle pour chaque élément de détail
		$sortiedetailsData = [];
		$mouvementData = [];
		foreach ($detailsData as $detail) {

			// check the produit
			$produit = $this->Produit->find('first', [
				'fields' => ['Produit.id','Produit.prixachat'],
				'conditions' => ['Produit.code_barre' => $detail['code_barre']]
			]);

			if ($produit) {
				// Si le produit correspondant est trouvé, récupérez l'ID du produit et les autres données
				$produit_id 		= $produit['Produit']['id'];
				if (empty($detail['prix']) OR $detail['prix']= "0,00") {
					$produit_prixachat 	= $produit['Produit']['prixachat'];
				}else {
					$produit_prixachat 	= $detail['prix'];
				}
			}else{
				$produit_id = "";
				$produit_prixachat = "0.000";
			}

			// 4 Enregistrement des données dans la table sortiedetails
			
			$quantite_to_save =  $detail['quantite'];
			$quantite_to_save = str_replace(',', '.', $quantite_to_save); // Remplacer la virgule par le point


		// Si le code barre =vide ou bien =000
		if (!empty($produit_id) OR $produit_id = "") {
			$sortiedetailsData = [
				'reference' => $headerData['reference'],
				'description' => 'Fichier CSB',
				'prix_achat' => $produit_prixachat,
				'date' => $date_operation,
				'date_sortie' => $date_operation,
				'stock_source' => $quantite_to_save,
				'paquet_source' => null,
				'total_general' => null,
				'stock_destination' => $depot_destination_id,
				'produit_id' => $produit_id,
				'client_id' => null,
				'depot_source_id' => $depot_source_id,
				'depot_destination_id' => $depot_destination_id,
				'vente_id' => null,
				'facture_id' => null,
				'retour_id' => null,
				'fournisseur_id' => null,
				'operation' => 1,
				'returned' => -1,
				'id_mouvementprincipal' => $id_mouvementprincipal // Utilisez l'ID précédemment enregistré
			];
		}


			if ($this->Sortiedetail->saveAll($sortiedetailsData)) {
				// Succès de l'insertion
				// echo 'Données insérées avec succès. sortiedetailsData <br />';
			} else {
				// Erreur lors de l'insertion
				echo 'Erreur lors de l\'insertion des données. sortiedetailsData <br />';
			}
	
		} // Fin de boucle détail document

	// => OLD CODE
	// Faire appel à la fonction valider pour valider les données de sortie automatiqument
	// $check_valider_sans_creer_RT = true;	
	// $this->valider($id_mouvementprincipal);

	$this->layout = false;
	}

	// Valider les BL sortie depuis l'use 
	// http://localhost/JCOLLAB/JCOLLAB4X_server/sortie/validerimportblcsb

	public function validerimportblcsb() {

		// Affectation des varibles (STATIC)
		$depot_source_id = 10;
		$depot_source_societe_id = 1;

		$mouvementprincipal = $this->Mouvementprincipal->find('all', [
			'conditions' => [
				'valide' => -1,
				'depot_source_id' => $depot_source_id,
			],
			'fields' => ['id']
		]);

		
		if (count($mouvementprincipal) > 0) {
			// Au moins un résultat a été trouvé
			foreach ($mouvementprincipal as $mouvement) {
				$id_mouvementprincipal =  $mouvement['Mouvementprincipal']['id'];
				$check_valider_sans_creer_RT = true;	
				$this->validersortiecsb($id_mouvementprincipal);
			}
		} else {
			// Aucun résultat trouvé
			echo "Aucun résultat trouvé.";
		}

	$this->layout = false;
	}



	public function editexp() {
		// $depots = $this->Session->read('depots');
		if ($this->request->is(array('post', 'put'))) {
			// $depot_id = ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0 ;
			
			$data['Sortiedetail']['depot_source_id'] = ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0;
			$data['Sortiedetail']['depot_destination_id'] = ( isset( $this->data['Mouvement']['depot_destination_id'] ) ) ? $this->data['Mouvement']['depot_destination_id']: 0;
			$this->loadModel("Depot");
			$depotdestprincipal = $this->Depot->find("all",["conditions" => ["store_id" => $data['Sortiedetail']['depot_destination_id']]]); 
			
			/* if(!isset($depotdestprincipal[0]["Depot"]["id"])) {
				$this->Session->setFlash('le Site de destination n\'a pas de dépôt principal ','alert-danger');
				return $this->redirect( $this->referer() );
			} */
			$insert = [
				'id' => null,
				'description' => ( isset( $this->data['Mouvement']['description'] ) ) ? $this->data['Mouvement']['description'] : 'Sortie en masse ' ,
				'date' => ( isset( $this->data['Mouvement']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date'] ) ) : date('Y-m-d') ,
				'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : date('Y-m-d') ,
				'depot_source_id' => ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0,
				'depot_destination_id' => (isset($depotdestprincipal[0]["Depot"]["id"])) ? $depotdestprincipal[0]["Depot"]["id"] : 0,
				'nb_produits' => ( isset( $this->data['MouvementDetail'] ) ) ? sizeof($this->data['MouvementDetail']) : 0,
				'type' => "Expedition",
				'valide' => -1,
				'user_c' => null,
				'date_c' => 1,			
			];
			$this->loadModel('Mouvementprincipal');
			if ( !$this->Mouvementprincipal->save($insert) ) {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect( $this->referer() );
			} 
			
			if ( isset( $this->data['MouvementDetail'] ) AND !empty( $this->data['MouvementDetail'] ) ) {
				$data = [];
				foreach ($this->data['MouvementDetail'] as $key => $value) {
					$data[] = [
						'id' => null,
						'operation' => 1,
						'depot_source_id' => ( isset( $this->data['Mouvement']['depot_id'] ) ) ? $this->data['Mouvement']['depot_id']: 0,
						'depot_destination_id' => (isset($depotdestprincipal[0]["Depot"]["id"])) ? $depotdestprincipal[0]["Depot"]["id"] : 0,
						'produit_id' => $value['produit_id'],
						'num_lot' =>  ( isset( $value['num_lot'] ) AND !empty( $value['num_lot'] ) ) ? $value['num_lot'] : null ,
						'stock_source' =>  ( isset( $value['stock_source'] ) AND !empty( $value['stock_source'] ) ) ? $value['stock_source'] : 0 ,
						'fournisseur_id' => ( isset( $this->data['Mouvement']['fournisseur_id'] ) ) ? $this->data['Mouvement']['fournisseur_id'] : null ,
						'description' => ( isset( $this->data['Mouvement']['description'] ) ) ? $this->data['Mouvement']['description'] : 'Sortie en masse ' ,
						'date' => ( isset( $this->data['Mouvement']['date'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date'] ) ) : date('Y-m-d') ,
						'date_sortie' => ( isset( $this->data['Mouvement']['date_sortie'] ) AND !empty( $this->data['Mouvement']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $this->data['Mouvement']['date_sortie'] ) ) : date('Y-m-d') ,
						'id_mouvementprincipal' => $this->Mouvementprincipal->getLastInsertId()
					];
				}

				
				$this->loadModel('Sortiedetail');
				if ( $this->Sortiedetail->saveMany($data) ) {
					/* foreach ($data as $key => $value) { 
						$this->sortie( $value['produit_id'] , $value['depot_source_id'], $value['stock_source']); 
					} */
					$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');

					/* App::import('Controller', 'Bonentrees');
					$Bonentrees = new BonentreesController;
					$Bonentrees->entree($produit_id = $value['produit_id'],$depot_id = $this->data['Mouvement']['depot_destination_id'],$quantite_entree = 0); */
				} else {
					$this->Session->setFlash('Il y a un problème','alert-danger');
				}
				return $this->redirect( array('action' => 'index') );
			} else {
				$this->Session->setFlash('Aucune ligne a saisie','alert-danger');
				return $this->redirect( $this->referer() );
			}
		}
		$fournisseurs = $this->Mouvement->Fournisseur->find('list');
		$selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");
		$depots_dest = $this->Depot->Store->find("list", ["conditions" => ["not" => ["Store.id" => $selected_store]]]);
		$depots_source = $this->Depot->find("list",["conditions" =>  ["Depot.store_id" => $selected_store]]);
		$this->set(compact('depots_dest','depots_source','fournisseurs'));
		$this->getPath($this->idModule);
	}

	public function newrow($count = 0,$produit_id = null,$depot_id = null,$stock = null, $quantite_sortie = null) {

		$quantite_sortie = ( !isset($quantite_sortie) ) ? 0 : $quantite_sortie ;
		$stock = ( !isset($stock) ) ? 0 : $stock ;
		$conditions['Produit.active'] = 1;
		if( $depot_id != null ) {
			$conditions['Depotproduit.depot_id'] = $depot_id;
			/* $conditions['Depotproduit.quantite >='] = 0; */
		}
		$produits = $this->Bontransfert->Produit->findList();//'list',[
			/* 'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Produit.id = Depotproduit.produit_id','Depotproduit.deleted = 0']],
			], */
			/* 'conditions' => $conditions, */
		//]);
		
		//$produits[$produit_id]["Produit"]["quantite"]
	

		$this->set(compact('produits','produit_id','count','stock','quantite_sortie'));
		$this->layout = false;
	}

	public function scan($code_barre = null, $depot_id = null) {
		$response['error'] = true;
		$response['message'] = "";
		$response['data']['prix_achat'] = 0;
		$response['data']['stock_source'] = 0;
		$response['data']['produit_id'] = null;
		$response['data']['produit_id'] = null;
		$longeur = strlen($code_barre);
		if ( $longeur != 13 ) $response['message'] = "Code a barre est incorrect , produit introuvable !";
		else {
			$this->loadModel('Parametreste');
			$params = $this->Parametreste->findList();
			$cb_identifiant = ( isset($params['cb_identifiant']) AND !empty($params['cb_identifiant']) ) ? $params['cb_identifiant'] : '2900' ;
			$cb_produit_depart = ( isset($params['cb_produit_depart']) AND !empty($params['cb_produit_depart']) ) ? $params['cb_produit_depart'] : 4 ;
			$cb_produit_longeur = ( isset($params['cb_produit_longeur']) AND !empty($params['cb_produit_longeur']) ) ? $params['cb_produit_longeur'] : 3 ;
			$cb_quantite_depart = ( isset($params['cb_quantite_depart']) AND !empty($params['cb_quantite_depart']) ) ? $params['cb_quantite_depart'] : 7 ;
			$cb_quantite_longeur = ( isset($params['cb_quantite_longeur']) AND !empty($params['cb_quantite_longeur']) ) ? $params['cb_quantite_longeur'] : 5 ;
			$cb_div_kg = ( isset($params['cb_div_kg']) AND !empty($params['cb_div_kg']) AND $params['cb_div_kg'] > 0 ) ? (int) $params['cb_div_kg']: 0000 ;
			$identifiant = substr(trim( $code_barre ),0,4);
			if ( $cb_identifiant != $identifiant ) $response['message'] = "Identifiant du code à barre est incorrect , veuillez vérifier votre paramétrage d'application !";
			else{
				$code_article = substr(trim( $code_barre ),$cb_produit_depart,$cb_produit_longeur);
				$quantite = substr(trim( $code_barre ),$cb_quantite_depart,$cb_quantite_longeur);

				$produit = $this->Mouvement->Produit->find('first',['fields'=>['id','prix_vente','stockactuel','unite_id','prixachat'],'conditions' => [ 'Produit.type' => 2,'Produit.code_barre' => $code_article ]]);
				if( !isset($produit['Produit']['id']) ) {
					$response['message'] = "Code a barre incorrect produit introuvable !";
				}
				
				$produit = $this->Mouvement->Produit->find('first',[
					'fields' => [ 'Depotproduit.*', 'Produit.*'],
					'conditions'=>['Produit.code_barre' => $code_article],
					 'joins' => [
						['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'LEFT', 'conditions' => ['Depotproduit.produit_id = Produit.id','Depotproduit.deleted = 0','Depotproduit.depot_id = '.$depot_id]],
					], 
				]);
				/* if(!isset($produit['Depotproduit']['id'])) {
					$response['message'] = "Le produit n'existe pas dans ce dépôt !";
				} */
				$quantite =  (float) $quantite;
				/* else */ if ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['id'] ) ) {
					if ( isset( $produit['Produit']['pese'] ) AND $produit['Produit']['pese'] == "1" ) $qte = round($quantite/$cb_div_kg,3); // autre  
					else $qte =  $quantite; // piéce

					if ( $qte < 0 ) $response['message'] = "Opération impossible la quantité doit étre supérieur a zéro !";
					else {
						$response['error'] = false;
						$response['data']['quantite_sortie'] = $qte;
						$response['data']['produit_id'] = $produit['Produit']['id'];
						$response['data']['stock'] =  $produit['Depotproduit']['quantite'];
						/* $response['data']['stock'] =  $produit['Produit']['stockactuel']; */
					}
				}  
			}
		}

		header('Content-Type: application/json; charset=UTF-8');
		die( json_encode( $response ) );
	}
	
	public function delete($id = null,$id_mouvementprincipal = null) {
		$this->Sortiedetail->id = $id;
		if (!$this->Sortiedetail->exists()) throw new NotFoundException(__('Invalide Sortie detail'));

		$mouvement = $this->Sortiedetail->find('first', ['conditions' => ['Sortiedetail.id' => $id]]);
		$mouvement_save = [
			'id' => null,
			'operation' => 2,
			'num_lot' => $mouvement['Sortiedetail']['num_lot'],
			'prix_achat' => $mouvement['Sortiedetail']['prix_achat'],
			'produit_id' => $mouvement['Sortiedetail']['produit_id'],
			'stock_source' => $mouvement['Sortiedetail']['stock_source'],
			'depot_source_id' => ( isset( $mouvement['Sortiedetail']['depot_source_id'] ) ) ? $mouvement['Sortiedetail']['depot_source_id'] : 0,
			'depot_destination_id' => ( isset( $mouvement['Sortiedetail']['depot_destination_id'] ) ) ? $mouvement['Sortiedetail']['depot_destination_id'] : 0,
			'date' => ( isset( $mouvement['Sortiedetail']['date'] ) ) ? date('Y-m-d', strtotime( $mouvement['Sortiedetail']['date'] ) ) : date('Y-m-d') ,
			'date_sortie' => ( isset( $mouvement['Sortiedetail']['date_sortie'] ) AND !empty( $mouvement['Sortiedetail']['date_sortie'] ) ) ? date('Y-m-d', strtotime( $mouvement['Sortiedetail']['date_sortie'] ) ) : null ,
			'description' => "Numéro du bon de sortie : ".$mouvement['Sortiedetail']['reference'],
		];
		
		$this->loadModel('Mouvement');

		$this->Mouvement->save($mouvement_save);
		if ($this->Sortiedetail->delete()) {
			
			$this->loadModel("Mouvementprincipal");
			$mouvementprincipal = $this->Mouvementprincipal->find('first',[
				'conditions' => ['Mouvementprincipal.id' => $id_mouvementprincipal ] 
			]);
			$this->Mouvementprincipal->id = $mouvementprincipal["Mouvementprincipal"]["id"];
			$this->Mouvementprincipal->saveField('nb_produits',$mouvementprincipal["Mouvementprincipal"]["nb_produits"] - 1 );
	
			if ( isset( $mouvement['Sortiedetail']['produit_id'] ) AND isset( $mouvement['Sortiedetail']['depot_source_id'] ) ) {
				$this->entree($mouvement['Sortiedetail']['produit_id'],$mouvement['Sortiedetail']['depot_source_id'],$mouvement['Sortiedetail']['stock_source']);
					
			}

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}


	// Générateur de états RT T09 pour CSB
	public function rtcsbt09() {
		$this->loadModel("Salepoint");
		$nine = 9;
		$zero = 0;
		$thirteen = 13;
		$itm = "ITM";
	


		if ($this->request->is('post')) {
			$formData = $this->request->data;

			$date_form = $formData['Filter']['Mouvement']['date2'];
			$dateYMD = date('Y-m-d', strtotime($date_form));

			$date_form = str_replace('-', '', $date_form);
			$dateYMD = str_replace('-', '', $dateYMD);

			$conditions = array(
				'Salepoint.reference LIKE' => '%T09%',
				"DATE(Salepoint.date) BETWEEN ? AND ?" => array(
					date('Y-m-d', strtotime($formData['Filter']['Mouvement']['date1'])),
					date('Y-m-d', strtotime($formData['Filter']['Mouvement']['date2']))
				),
				// 'Salepoint.store' => $formData['Filter']['Salepoint']['store']
			);
			
			$salepointsData = $this->Salepoint->find('all', array(
				'conditions' => $conditions,
				'joins' => array(
					array(
						'table' => 'stores',
						'alias' => 'Store',
						'type' => 'INNER',
						'conditions' => array(
							'Salepoint.store = Store.id'
						)
					),
					array(
						'table' => 'salepointdetails',
						'alias' => 'SalepointDetail',
						'type' => 'INNER',
						'conditions' => array(
							'Salepoint.id = SalepointDetail.salepoint_id'
						)
					),
					array(
						'table' => 'produits',
						'alias' => 'Produit',
						'type' => 'INNER',
						'conditions' => array(
							'SalepointDetail.produit_id = Produit.id'
						)
					)
				),
				'fields' => array(
					'Salepoint.id',
					'Salepoint.reference',
					'Salepoint.store',
					'Salepoint.date',
					// Ajoutez d'autres champs de la table Salepoint que vous souhaitez récupérer
					'Store.code_csb',
					// Ajoutez les champs de la table SalepointDetails que vous souhaitez récupérer
					'SalepointDetail.qte',
					'SalepointDetail.produit_id',
					// Ajoutez les champs de la table Produit que vous souhaitez récupérer
					'Produit.code_barre',
					'Produit.pese'
				)
			));
			
			// Regrouper les données par store
			$groupedData = [];

			foreach ($salepointsData as $salepoint) {
				$storeId = $salepoint['Salepoint']['store'];
				$groupedData[$storeId][] = $salepoint;
			}
			
			// Générer un fichier CSV pour chaque store
			foreach ($groupedData as $storeId => $storeData) {
				$filename = 'RT_' . $storeData[0]['Store']['code_csb'] . '_'. $date_form . '.csv';
				$filepath = WWW_ROOT . 'uploads' . DS . 'bon_retour' . DS . $filename;
			
				$csvData = []; // Réinitialiser $csvData pour chaque store
			
				// Entête pour ADR
				$dateSansHeure = date('d-m-Y', strtotime($storeData[0]['Salepoint']['date']));
				$dateSansHeureSansTirets = str_replace('-', '', $dateSansHeure);
			
				$adr_string = 'ADR;'. $storeData[0]['Store']['code_csb'] . ';' . $dateYMD . ';' . $storeData[0]['Salepoint']['store'] . '9' . $date_form . '';
				$csvData[] = [$adr_string];
			
				// Regrouper les quantités par code-barres de produit et cumuler les quantités
				$groupedQuantities = [];
				foreach ($storeData as $salepoint) {
					$codeBarre = $salepoint['Produit']['code_barre'];
					$qte = $salepoint['SalepointDetail']['qte'];
					if (!isset($groupedQuantities[$codeBarre])) {
						$groupedQuantities[$codeBarre] = 0;
					}
					$groupedQuantities[$codeBarre] += $qte;
				}

				// Ajouter les données regroupées et cumulées à $csvData
				foreach ($groupedQuantities as $codeBarre => $cumulatedQte) {
					$itm_qnt = $cumulatedQte;
					$pese_produit = $storeData[0]['Produit']['pese']; // Utilisez la première occurrence pour récupérer la valeur de "pese" (peut-être peut être différente pour chaque produit)

					if ($pese_produit == 0) {
						$itm_qnt = ceil($itm_qnt);
					}

					$csvData[] = [
						//$storeData[0]['Salepoint']['store'], // Vous pouvez récupérer le store ici si nécessaire
						$itm,
						$codeBarre,
						$itm_qnt,
						$zero,
						$thirteen,
					];
				}

			
				// Générer le fichier CSV pour le store actuel
				$csv = chr(239) . chr(187) . chr(191); // BOM for UTF-8
				foreach ($csvData as $line) {
					$csv .= implode(';', $line) . "\n";
				}
			
				file_put_contents($filepath, $csv);
			}
			
		} // END






	
		$this->layout = false;
	}

	
	
	

	


}