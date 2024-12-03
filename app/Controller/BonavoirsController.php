<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class BonavoirsController extends AppController {
	public $idModule = 82;
	

	public function index() {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$clients = $this->Bonavoir->Client->find('list');
		$users = $this->Bonavoir->User->findList(['role_id'=>3]);
		$this->set(compact('users','clients','user_id','role_id'));
		$this->getPath($this->idModule);
	}

	public function loadquatite($depot_id = null,$produit_id = null) {
		$req = $this->Bonavoir->Bonavoirdetail->Produit->Depotproduit->find('first',['conditions' => ['depot_id'=>$depot_id,'produit_id'=>$produit_id]]);
		$quantite = ( isset( $req['Depotproduit']['id'] ) AND !empty( $req['Depotproduit']['quantite'] ) ) ? (float) $req['Depotproduit']['quantite'] : 0 ;
		die( json_encode( $quantite ) );
	}

	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');
		/*if ( in_array($role_id, $admins) ) $conditions = [];
		else $conditions['Bonavoir.user_c'] = $user_id;*/
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Bonavoir.reference' )
					$conditions['Bonavoir.reference LIKE '] = "%$value%";
				else if( $param_name == 'Bonavoir.date1' )
					$conditions['Bonavoir.date >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Bonavoir.date2' )
					$conditions['Bonavoir.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Bonavoir->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['Creator','User','Client'=>['Ville','Categorieclient']],
			'order'=>['Bonavoir.date'=>'DESC','Bonavoir.id'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$ventes = $this->Bonavoir->find('all',['contain'=>['User','Client'],'conditions'=>$conditions]);
		$this->set(compact('taches','ventes','user_id'));
		$this->layout = false;
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bonavoir->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
				return $this->redirect(array('action' => 'view',$this->Bonavoir->id));
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
		} else if ($this->Bonavoir->exists($id)) {
			$options = array('conditions' => array('Bonavoir.' . $this->Bonavoir->primaryKey => $id));
			$this->request->data = $this->Bonavoir->find('first', $options);
		}

		$clients = $this->Bonavoir->Client->find('list');
		$users = $this->Bonavoir->User->findList(['role_id'=>3]);
		$this->set(compact('users','clients','user_id','role_id'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonavoir->id = $id;
		if (!$this->Bonavoir->exists()) {
			throw new NotFoundException(__('Invalide vente'));
		}

		if ($this->Bonavoir->flagDelete()) {
			$this->Bonavoir->Bonavoirdetail->updateAll(['Bonavoirdetail.deleted'=>1],['Bonavoirdetail.bonavoir_id'=>$id]);
			//$this->Bonavoir->Avance->updateAll(['Avance.deleted'=>1],['Avance.bonavoir_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function deletedetail($id = null,$bonavoir_id = null) {
		$this->Bonavoir->Bonavoirdetail->id = $id;
		if (!$this->Bonavoir->Bonavoirdetail->exists()) {
			throw new NotFoundException(__('Invalide article'));
		}

		if ($this->Bonavoir->Bonavoirdetail->flagDelete()) {
			$details = $this->Bonavoir->Bonavoirdetail->find('all',['conditions' => ['bonavoir_id' => $bonavoir_id]]);

			$total_qte = 0;
			$total_paquet = 0;
			$total_a_payer_ht = 0;
			$total_a_payer_ttc = 0;
			foreach ($details as $key => $value) {
				$total_qte = $total_qte + $value['Bonavoirdetail']['qte'];
				$total_paquet = $total_paquet + $value['Bonavoirdetail']['paquet'];
				$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonavoirdetail']['ttc'];
				$total_a_payer_ht = $total_a_payer_ht + $value['Bonavoirdetail']['total'];
			}

			$data['Bonavoir'] = [
				'id' => $bonavoir_id,
				'total_qte' => $total_qte,
				'total_paquet' => $total_paquet,
				'total_a_payer_ht' => $total_a_payer_ht,
				'total_a_payer_ttc' => $total_a_payer_ttc,
				'total_apres_reduction' => $total_a_payer_ht,
			];

			$this->Bonavoir->save($data);

			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function view($id = null,$flag = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');

		$details = [];
		if ($this->Bonavoir->exists($id)) {
			$options = array('contain'=>['Client'],'conditions' => array('Bonavoir.' . $this->Bonavoir->primaryKey => $id));
			$this->request->data = $this->Bonavoir->find('first', $options);

			$details = $this->Bonavoir->Bonavoirdetail->find('all',[
				'conditions' => ['Bonavoirdetail.bonavoir_id'=>$id],
				'contain' => ['Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$this->set(compact('details','role_id','user_id','flag'));
		$this->getPath($this->idModule);
	}

	public function getProduitByDepot($bonavoir_id = null,$depot_id = null,$categorieproduit_id = null) {
		$produits_exists = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
			'fields' => ['Produit.id','Produit.id'],
			'joins' => [
				['table' => 'bonavoirdetails', 'alias' => 'Bonavoirdetail', 'type' => 'INNER', 'conditions' => ['Bonavoirdetail.produit_id = Produit.id'] ],
			],
			'conditions' => [
				'Bonavoirdetail.deleted'=>0,
				'Bonavoirdetail.depot_id'=>$depot_id,
				'Bonavoirdetail.bonavoir_id'=>$bonavoir_id,
			]
		]);

		$produits = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
			'conditions'=>[
				'Produit.categorieproduit_id'=>$categorieproduit_id,
				//'Produit.id !='=>$produits_exists,
				'Depotproduit.depot_id'=>$depot_id,
				'Depotproduit.quantite >='=>0,
				'Produit.active'=>1,
			],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
			],
			'order' => ['libelle' => 'ASC']
		]);

		die( json_encode( $produits ) );
	}

	public function getProduit($produit_id = null,$depot_id = null) {
		$article = $this->Bonavoir->Bonavoirdetail->Produit->find('first',[
			'fields' => ['Produit.*','Depotproduit.*'],
			'joins' => [
				['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
			],
			'conditions'=>['Produit.id'=>$produit_id,'Depotproduit.depot_id'=>$depot_id],
		]);

		die( json_encode( $article ) );
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonavoir->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Bonavoir.' . $this->Bonavoir->primaryKey => $id));
			$this->request->data = $this->Bonavoir->find('first', $options);

			$details = $this->Bonavoir->Bonavoirdetail->find('all',[
				'conditions' => ['Bonavoirdetail.bonavoir_id'=>$id],
				'contain' => ['Depot','Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('details','role','user_id','societe'));
		$this->layout = false;
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonavoir->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Bonavoir.' . $this->Bonavoir->primaryKey => $id));
			$this->request->data = $this->Bonavoir->find('first', $options);

			$details = $this->Bonavoir->Bonavoirdetail->find('all',[
				'conditions' => ['Bonavoirdetail.bonavoir_id'=>$id],
				'contain' => ['Depot','Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		
		$societe = $this->GetSociete();
		$this->set(compact('details','role','user_id','societe'));
		$this->layout = false;
	}

	public function editdetail($id = null,$bonavoir_id = null) {
		$commande = $this->Bonavoir->find('first', ['contain'=>['User'],'conditions' => ['Bonavoir.id' => $bonavoir_id]]);
		$role_id = $this->Session->read('Auth.User.role_id');
		$admins = $this->Session->read('admins');
		$depot_id = 1 ;

		if ( !in_array($role_id, $admins) ) {
			$produits_exists = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'bonavoirdetails', 'alias' => 'Bonavoirdetail', 'type' => 'INNER', 'conditions' => ['Bonavoirdetail.produit_id = Produit.id'] ],
				],
				'conditions' => [
					'Bonavoirdetail.deleted'=>0,
					'Bonavoirdetail.bonavoir_id'=>$bonavoir_id
				]
			]);

			$produits = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
				'conditions'=>[
					'Produit.active'=>1,
					'Produit.id !='=>$produits_exists,
					'Depotproduit.depot_id'=>$depot_id
				],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
				],
				'order' => ['libelle' => 'ASC']
			]);
			
		}else{
			$produits_exists = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
				'fields' => ['Produit.id','Produit.id'],
				'joins' => [
					['table' => 'bonavoirdetails', 'alias' => 'Bonavoirdetail', 'type' => 'INNER', 'conditions' => ['Bonavoirdetail.produit_id = Produit.id'] ],
				],
				'conditions' => [
					'Bonavoirdetail.deleted'=>0,
					'Bonavoirdetail.bonavoir_id'=>$bonavoir_id
				]
			]);

			$produits = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
				'conditions'=>[
					'Produit.active'=>1,
					'Produit.id !='=>$produits_exists
				],
				'joins' => [
					['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
				],
				'order' => ['libelle' => 'ASC']
			]);
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Bonavoirdetail']['bonavoir_id'] = $bonavoir_id;
			if ($this->Bonavoir->Bonavoirdetail->save($this->request->data)) {
				$details = $this->Bonavoir->Bonavoirdetail->find('all',['conditions' => ['bonavoir_id' => $bonavoir_id]]);
				$total_qte = 0;
				$total_paquet = 0;
				$total_a_payer_ht = 0;
				$total_a_payer_ttc = 0;
				foreach ($details as $key => $value) {
					$total_qte = $total_qte + $value['Bonavoirdetail']['qte'];
					$total_paquet = $total_paquet + $value['Bonavoirdetail']['paquet'];
					$total_a_payer_ttc = $total_a_payer_ttc + $value['Bonavoirdetail']['ttc'];
					$total_a_payer_ht = $total_a_payer_ht + $value['Bonavoirdetail']['total'];
				}

				$data['Bonavoir'] = [
					'id' => $bonavoir_id,
					'total_qte' => $total_qte,
					'total_paquet' => $total_paquet,
					'total_a_payer_ht' => $total_a_payer_ht,
					'total_a_payer_ttc' => $total_a_payer_ttc,
					'total_apres_reduction' => $total_a_payer_ht,
				];

				$this->Bonavoir->save($data);

				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Bonavoir->Bonavoirdetail->exists($id)) {
			$options = array('conditions' => array('Bonavoirdetail.' . $this->Bonavoir->Bonavoirdetail->primaryKey => $id));
			$this->request->data = $this->Bonavoir->Bonavoirdetail->find('first', $options);
			if ( !in_array($role_id, $admins) ) {
				$produits = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
					'conditions'=>[
						'Produit.active'=>1,
						'Produit.id !='=>$produits_exists,
						'Depotproduit.depot_id'=>$depot_id
					],
					'joins' => [
						['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id'] ],
					],
					'order' => ['libelle' => 'ASC']
				]);
			}else{
				$produits = $this->Bonavoir->Bonavoirdetail->Produit->find('list',[
					'order' => ['Produit.libelle' => 'ASC'],
					'conditions'=>['Produit.active'=>1],
				]);
			}
		}

		$depots = $this->Bonavoir->Bonavoirdetail->Depot->find('list');
		$categorieproduits = $this->Bonavoir->Bonavoirdetail->Produit->Categorieproduit->find('list');
		$this->set(compact('produits','role_id','depot_id','depots','categorieproduits'));
		$this->layout = false;
	}

	public function changestate($bonavoir_id = null,$etat = -1) {
		$details = $this->Bonavoir->Bonavoirdetail->find('all',['conditions' => ['Bonavoirdetail.bonavoir_id'=>$bonavoir_id] ]);
		if ( empty( $details ) ) {
			$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Bonavoir->id = $bonavoir_id;
		if ($this->Bonavoir->saveField('etat',$etat)) {
			$this->Session->setFlash("L'enregistrement a été effectué avec succès.",'alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function mail($bonavoir_id = null) {
		$bonavoir = $this->Bonavoir->find('first',['contain'=>['Client'],'conditions'=>['Bonavoir.id'=>$bonavoir_id]]);
		$email = ( isset( $bonavoir['Client']['email'] ) AND !empty( $bonavoir['Client']['email'] ) ) ? $bonavoir['Client']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['bonavoir_id'] = $bonavoir_id;
			if ($this->Bonavoir->Email->save($this->request->data)) {
				$url = $this->generatepdf($bonavoir_id);
				$email_id = $this->Bonavoir->Email->id;
				if ( $this->Bonavoir->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Bonavoir' => ['mimetype' => 'application/pdf','file' => $url ] ];
					if ( $this->sendEmail($settings,$objet, $content, $to , $attachments) ) {
						$this->Session->setFlash('Votre email a été anvoyer avec succès.','alert-success');
					}else{
						$this->Session->setFlash("Problème d'envoi de mail",'alert-danger');
					}
				}
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}

		$this->set(compact('email'));
		$this->layout = false;
	}

	public function generatepdf($bonavoir_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Bonavoir->exists($bonavoir_id)) {
			$options = array('contain'=>['Client'=>['Ville']],'conditions' => array('Bonavoir.' . $this->Bonavoir->primaryKey => $bonavoir_id));
			$data = $this->Bonavoir->find('first', $options);

			$details = $this->Bonavoir->Bonavoirdetail->find('all',[
				'conditions' => ['Bonavoirdetail.bonavoir_id'=>$bonavoir_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'AVOIR']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $data['Client']['Ville']['libelle'] )) ? $data['Client']['Ville']['libelle'] : '' ;
		
		$html = '
		<html>
			<head>
				<title>Avoir</title>
			    '.$style.'
			</head>
			<body>

			    '.$header.'

			    '.$footer.'

			    <div>

				    <table class="info" width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">AVOIR N° : '.$data['Bonavoir']['reference'].'</h4>
				                </td>
				                <td style="width:50%;text-align:center;">
				                    <h4 class="container">DATE : '.$data['Bonavoir']['date'].'</h4>
				                </td>
				            </tr>
				            <tr>
				                <td style="width:70%;text-align:center;"></td>
				                <td style="width:30%;text-align:left;">
				                    <h4 class="container">
					                    '.strtoupper($data['Client']['designation']).'<br/>
					                    '.strtoupper($data['Client']['adresse']).'<br/>
					                    '.$ville.'<br/>
					                    ICE : '.strtoupper($data['Client']['ice']).'
				                    </h4>
				                </td>
				            </tr>
				        </tbody>
				    </table>

				    <table class="details" width="100%">
				        <thead>
				            <tr>
				                <th>Désignation </th>
				                <th>Quantité </th>
				                <th>Prix TTC</th>
				                <th>Montant total TTC</th>
				            </tr>
				        </thead>
				        <tbody>';
				            foreach ($details as $tache){
				                $html.='<tr>
				                    <td nowrap>'.$tache['Produit']['libelle'].'</td>
				                    <td nowrap style="text-align:right;">'.$tache['Bonavoirdetail']['qte'].'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonavoirdetail']['prix_vente'], 2, ',', ' ').'</td>
				                    <td nowrap style="text-align:right;">'.number_format($tache['Bonavoirdetail']['total'], 2, ',', ' ').'</td>
				                </tr>';
				            }
				            $html .= '
				                <tr class="hide_total">
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="hide_total">TOTAL HT</td>
				                    <td class="hide_total">'.number_format($data['Bonavoir']['total_a_payer_ht'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
				                    <td class="total">'.number_format($data['Bonavoir']['montant_tva'], 2, ',', ' ').'</td>
				                </tr>
				                <tr >
				                    <td style="border:none;"></td>
				                    <td style="border:none;"></td>
				                    <td class="total">NET A PAYER</td>
				                    <td class="total">'.number_format($data['Bonavoir']['total_a_payer_ttc'], 2, ',', ' ').'</td>
				                </tr>
				        </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente d\'avoir à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper( $LettreHelper->NumberToLetter( strval( $data['Bonavoir']['total_a_payer_ttc'] ) ) ).' DHS
				                </td>
				            </tr>
				        </tbody>
				    </table>

			    </div>

			    '.$footer.'

			</body>
		</html>';

		//echo $html;die;
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->render();
		$canvas = $dompdf->get_canvas(); 
		$font = Font_Metrics::get_font("helvetica", "bold"); 
		$canvas->page_text(512, 820, "Page : {PAGE_NUM}/{PAGE_COUNT}",$font, 8, array(0,0,0)); 
			
		$output = $dompdf->output();
		$destination = WWW_ROOT.'pdfs';
		if (!file_exists( $destination )) mkdir($destination,true, 0700);
		file_put_contents($destination.DS.'Bonavoir.'.$data['Bonavoir']['date'].'-'.$data['Bonavoir']['id'].'.pdf', $output);
		return $destination.DS.'Bonavoir.'.$data['Bonavoir']['date'].'-'.$data['Bonavoir']['id'].'.pdf';
	}
}