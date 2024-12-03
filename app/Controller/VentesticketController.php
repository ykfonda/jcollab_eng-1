<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class VentesticketController extends AppController {
	public $idModule = 123;
	public $uses = ["Salepoint"];

	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
        $this->loadModel("Store");

        $magasins = $this->Store->find("list");
        
		$this->set(compact('magasins'));
		$this->getPath($this->idModule);
	}

	

	public function indexAjax(){
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$conditions['Salepoint.etat'] = 2;
		$conditions['Salepoint.date >='] = date('Y-m-d', strtotime(date("Y/m/d")));
        $conditions['Salepoint.date <='] = date('Y-m-d H:i:s', strtotime(date("Y/m/d").' 23:59:59'));
        foreach ($this->params['named'] as $param_name => $value) {
           
            if ($param_name == 'Salepoint2.magasin_id') {
               /* $this->loadModel("Store");
               $stores = $this->Store->find("all", ["conditions" => ["societe_id" => $value]]);
               $stores_id = [];
               foreach ($stores as $store) {
                   $stores_id[] = $store["Store"]["id"];
               }
               $conditions['Salepoint.store'] = $stores_id;
*/                 $conditions['Salepoint.store'] = $value;

            } 
            if ($param_name == 'Salepoint2.date1') {
               $arr["date1"] = date('Y-m-d', strtotime($value));
               $conditions['Salepoint.date >='] = date('Y-m-d', strtotime($value));
           } if ($param_name == 'Salepoint2.date2') {
               //$arr["date2"] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
               $conditions['Salepoint.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
               
           }
           else{
                           
               $this->request->data['Filter'][$param_name] = $value;
           }
       
   }



		/* $selected_store  = $this->Session->read('Auth.User.StoreSession.id');
		$this->loadModel("Depot");		
		$conditions['Salepoint.store'] = $selected_store;
		 */
		
		//var_dump($conditions);
		//die();


		$this->Salepoint->recursive = -1;
		$settings = [
			'contain'=>['Store','Caisse','Avance'],
			'order'=>['Salepoint.date'=>'DESC','Salepoint.id'=>'DESC'],
            
            
			'conditions'=>$conditions
		];
		
        $this->Paginator->settings = $settings;
		$taches = $this->Paginator->paginate();
       
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function excel(){
		$role_id = $this->Session->read('Auth.User.role_id');
		$user_id = $this->Session->read('Auth.User.id');
		$admins = $this->Session->read('admins');

		$conditions['Salepoint.etat'] = [2,3];
		if ( in_array($role_id, $admins) ) $conditions['Salepoint.etat'] = [2,3];
		else $conditions['Salepoint.user_c'] = $user_id;

		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Salepoint.reference' ) {
					$conditions['Salepoint.reference LIKE '] = "%$value%";
				}
				else if( $param_name == 'Salepoint.date1' ) {
					$conditions['Salepoint.date >='] = date('Y-m-d',strtotime($value));
				}
					else if( $param_name == 'Salepoint.date2' ) {
					$conditions['Salepoint.date <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				}
					else if( $param_name == 'Salepoint.societe_id' ) {
					$this->loadModel("Store");
					$stores = $this->Store->find("all",["conditions" => ["societe_id" => $value]]);
					$stores_id = [];
					foreach($stores as $store) {
						$stores_id[] = $store["Store"]["id"];
					}
					$conditions['Salepoint.store'] = $stores_id;
				}
					else if( $param_name == 'Salepoint.heure1' ) {
						
						$conditions['HOUR(Salepoint.date_c) >='] = $value;
					}
					else if( $param_name == 'Salepoint.heure2' ) {
						
						$conditions['HOUR(Salepoint.date_c) <'] = $value;
					}
					else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$settings = [
			'contain'=>['Salepointdetail' => ["Produit"],'Creator','Avance','User','Client'=>['Ville']],
			'order'=>['Salepoint.date'=>'DESC','Salepoint.id'=>'DESC'],
			'limit' => 15,
			'conditions'=>$conditions,
			
		];
		$taches = $this->Salepoint->find('all',$settings);
      
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Salepoint->id = $id;
		if (!$this->Salepoint->exists()) {
			throw new NotFoundException(__('Invalide bon de livraison'));
		}

		if ($this->Salepoint->flagDelete()) {
			$this->Salepoint->Salepointdetail->updateAll(['Salepointdetail.deleted'=>1],['Salepointdetail.salepoint_id'=>$id]);
			$this->Salepoint->Avance->updateAll(['Avance.deleted'=>1],['Avance.salepoint_id'=>$id]);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function view($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$depot_id = $this->Session->read('Auth.User.depot_id');

		$details = [];
		$avances = [];
		if ($this->Salepoint->exists($id)) {
			$options = array('contain'=>['Depot','Store','Client','User'],'conditions' => array('Salepoint.' . $this->Salepoint->primaryKey => $id));
			$this->request->data = $this->Salepoint->find('first', $options);

			$details = $this->Salepoint->Salepointdetail->find('all',[
				'conditions' => ['Salepointdetail.salepoint_id'=>$id],
				'contain' => ['Produit'],
			]);

			$avances = $this->Salepoint->Avance->find('all',[
				'conditions' => ['Avance.salepoint_id'=>$id],
				'order' => ['date ASC'],
			]);

		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		$produits = $this->Salepoint->Salepointdetail->Produit->findList();

		$this->set(compact('produits','details','role_id','user_id','avances'));
		$this->getPath($this->idModule);
	}

	public function ticket($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Salepoint->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Salepoint.' . $this->Salepoint->primaryKey => $id));
			$this->request->data = $this->Salepoint->find('first', $options);

			$details = $this->Salepoint->Salepointdetail->find('all',[
				'conditions' => ['Salepointdetail.salepoint_id'=>$id],
				'contain' => ['Produit'],
			]);
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		// if ( empty( $details ) ) {
		// 	$this->Session->setFlash('Aucun produit saisie ! ','alert-danger');
		// 	return $this->redirect( $this->referer() );
		// }

		$societe = $this->GetSociete();
		$this->set(compact('details','role','user_id','societe'));
		$this->layout = false;
	}

	public function pdf($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Salepoint->exists($id)) {
			$options = array('contain'=>['User','Client'=>['Ville']],'conditions' => array('Salepoint.' . $this->Salepoint->primaryKey => $id));
			$this->request->data = $this->Salepoint->find('first', $options);

			$details = $this->Salepoint->Salepointdetail->find('all',[
				'conditions' => ['Salepointdetail.salepoint_id'=>$id],
				'contain' => ['Produit'],
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

	public function editavance($id = null,$salepoint_id = null) {
		$bonlivraison = $this->Salepoint->find('first',['conditions'=>['id'=>$salepoint_id]]);
		$reste_a_payer = ( isset( $bonlivraison['Salepoint']['reste_a_payer'] ) ) ? $bonlivraison['Salepoint']['reste_a_payer'] : 0 ;
		$client_id = ( isset( $bonlivraison['Salepoint']['client_id'] ) ) ? $bonlivraison['Salepoint']['client_id'] : null ;
		$user_id = $this->Session->read('Auth.User.id');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Avance']['user_id'] = $user_id;
			$this->request->data['Avance']['salepoint_id'] = $salepoint_id;
			$this->request->data['Avance']['client_id'] = $client_id;
			if ($this->Salepoint->Avance->save($this->request->data)) {
				$this->calculatrice($salepoint_id);
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Salepoint->Avance->exists($id)) {
			$options = array('conditions' => array('Avance.' . $this->Salepoint->Avance->primaryKey => $id));
			$this->request->data = $this->Salepoint->Avance->find('first', $options);
		}

		$this->set(compact('reste_a_payer'));
		$this->layout = false;
	}

	public function calculatrice($salepoint_id = null) {
		$salepoint = $this->Salepoint->find('first',['conditions'=>['Salepoint.id'=>$salepoint_id]]);
		$remise = ( isset( $salepoint['Salepoint']['remise'] ) AND !empty( $salepoint['Salepoint']['remise'] ) ) ? (float) $salepoint['Salepoint']['remise'] : 0 ;		
		$details = $this->Salepoint->Salepointdetail->find('all',['contain' => ['Produit'] ,'conditions' => [ 'Salepointdetail.salepoint_id' => $salepoint_id ] ]);
		$avances = $this->Salepoint->Avance->find('all',['conditions' => ['salepoint_id' => $salepoint_id]]);

		$total_cmd = 0;
		$total_a_payer_ht = 0;
		$total_a_payer_ttc = 0;
		$remise_articles = 0;
		$montant_remise_articles = 0;
		$nombre_total = count( $details );
		foreach ($details as $k => $v) {
			// TVA
			$tva = ( isset( $v['Produit']['tva_vente'] ) AND !empty( $v['Produit']['tva_vente'] ) ) ? (int) $v['Produit']['tva_vente'] : 20 ;
			$division_tva = (1+$tva/100);
			// Quantité & Prix de vente
			$qte_cmd = $v['Salepointdetail']['qte_cmd'];
			$qte = ( isset( $v['Salepointdetail']['qte'] ) AND $v['Salepointdetail']['qte'] > 0 ) ? $v['Salepointdetail']['qte'] : $qte_cmd;

			$prix_vente_ht = round( $v['Salepointdetail']['prix_vente']/$division_tva,2 );
			$prix_vente_ttc = $v['Salepointdetail']['prix_vente'];
			// Calcule total
			$total_ht = round($prix_vente_ht*$qte,2);
			$total_ttc = round($prix_vente_ttc*$qte,2);

			$total_a_payer_ht = $total_a_payer_ht + $total_ht;
			$total_a_payer_ttc = $total_a_payer_ttc + $total_ttc;
			$total_cmd = $total_cmd + $qte_cmd;
		}

		$montant_remise = ( $total_a_payer_ttc >= 0 ) ? (float) ($total_a_payer_ttc*$remise)/100 : 0 ;

		$montant_tva = $total_a_payer_ttc-$total_a_payer_ht;
		$total_apres_reduction = round( $total_a_payer_ttc - $montant_remise ,2);

		$total_paye = 0;
		foreach ($avances as $k => $v) { $total_paye = $total_paye + $v['Avance']['montant']; }

		$reste_a_payer = $total_apres_reduction - $total_paye ;
		$reste_a_payer = ($reste_a_payer <= 0 ) ? 0 : $reste_a_payer;

		if ( $total_apres_reduction == $total_paye ) $paye = 2;
		else if( $total_paye == 0 ) $paye = -1;
		else $paye = 1;

		$salepointData['Salepoint']['paye'] = $paye;
		$salepointData['Salepoint']['remise'] = $remise;
		$salepointData['Salepoint']['id'] = $salepoint_id;
		$salepointData['Salepoint']['total_cmd'] = $total_cmd;
		$salepointData['Salepoint']['total_paye'] = $total_paye;
		$salepointData['Salepoint']['montant_tva'] = $montant_tva;
		$salepointData['Salepoint']['reste_a_payer'] = $reste_a_payer;
		$salepointData['Salepoint']['montant_remise'] = $montant_remise;
		$salepointData['Salepoint']['total_a_payer_ht'] = $total_a_payer_ht;
		$salepointData['Salepoint']['total_a_payer_ttc'] = $total_a_payer_ttc;
		$salepointData['Salepoint']['total_apres_reduction'] = $total_apres_reduction;
			
		return $this->Salepoint->save($salepointData);
	}

	public function deleteavance($id = null,$salepoint_id = null) {
		$this->Salepoint->Avance->id = $id;
		if (!$this->Salepoint->Avance->exists()) {
			throw new NotFoundException(__('Invalide Avance'));
		}

		if ($this->Salepoint->Avance->flagDelete()) {
			$this->calculatrice($salepoint_id);
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function facture($salepoint_id = null) {
		$depot_id = $this->Session->read('Auth.User.depot_id');
		if ($this->Salepoint->exists($salepoint_id)) {
			$options = array('conditions' => array('Salepoint.id' => $salepoint_id));
			$bonlivraison = $this->Salepoint->find('first', $options);
			$details = $this->Salepoint->Salepointdetail->find('all',['conditions' => ['salepoint_id'=>$salepoint_id]]);
			$avances = $this->Salepoint->Avance->find('all',['conditions' => ['salepoint_id' => $salepoint_id]]);

			$data['Facture'] = [
				'etat' => 2,
				'id' => null,
				'salepoint_id' => $salepoint_id,
				'paye' => $bonlivraison['Salepoint']['paye'],
				'date' => $bonlivraison['Salepoint']['date'],
				'remise' => $bonlivraison['Salepoint']['remise'],
				'user_id' => $bonlivraison['Salepoint']['user_id'],
				'reduction' => $bonlivraison['Salepoint']['reduction'],
				'montant_tva' => $bonlivraison['Salepoint']['montant_tva'],
				'active_remise' => $bonlivraison['Salepoint']['active_remise'],
				'client_id' => $bonlivraison['Salepoint']['client_id'],
				'total_qte' => $bonlivraison['Salepoint']['total_qte'],
				'total_paye' => $bonlivraison['Salepoint']['total_paye'],
				'total_paquet' => $bonlivraison['Salepoint']['total_paquet'],
				'reste_a_payer' => $bonlivraison['Salepoint']['reste_a_payer'],
				'total_a_payer_ht' => $bonlivraison['Salepoint']['total_a_payer_ht'],
				'total_a_payer_ttc' => $bonlivraison['Salepoint']['total_a_payer_ttc'],
				'total_apres_reduction' => $bonlivraison['Salepoint']['total_apres_reduction'],
			];

			$data['Avance'] = [];
			foreach ($avances as $key => $value) {
				$data['Avance'][] = [
					'id' => $value['Avance']['id'],
				];
			}

			$data['Facturedetail'] = [];
			foreach ($details as $key => $value) {
				$data['Facturedetail'][] = [
					'id' => null,
					'depot_id' => $depot_id,
					'ttc' => $value['Salepointdetail']['ttc'],
					'qte' => $value['Salepointdetail']['qte'],
					'total' => $value['Salepointdetail']['total'],
					'paquet' => $value['Salepointdetail']['paquet'],
					'prix_vente' => $value['Salepointdetail']['prix_vente'],
					'produit_id' => $value['Salepointdetail']['produit_id'],
					'total_unitaire' => $value['Salepointdetail']['total_unitaire'],
					'montant_remise' => $value['Salepointdetail']['montant_remise'],
					'remise' => $value['Salepointdetail']['remise'],
				];
			}

			if ($this->Salepoint->Facture->saveAssociated($data)) {
				$facture_id = $this->Salepoint->Facture->id;
				$this->Salepoint->id = $salepoint_id;
				if( $this->Salepoint->saveField('facture_id',$facture_id) );
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}
	}

	public function mail($salepoint_id = null) {
		$bonlivraison = $this->Salepoint->find('first',['contain'=>['Client'],'conditions'=>['Salepoint.id'=>$salepoint_id]]);
		$email = ( isset( $bonlivraison['Client']['email'] ) AND !empty( $bonlivraison['Client']['email'] ) ) ? $bonlivraison['Client']['email'] : '' ;
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Email']['salepoint_id'] = $salepoint_id;
			if ($this->Salepoint->Email->save($this->request->data)) {
				$url = $this->generatepdf($salepoint_id);
				$email_id = $this->Salepoint->Email->id;
				if ( $this->Salepoint->Email->saveField('url',$url) ) {
					$settings = $this->GetParametreSte();
					$to = [ $this->data['Email']['email'] ];
					$objet = ( isset( $this->data['Email']['objet'] ) ) ? $this->data['Email']['objet'] : '' ;
					$content = ( isset( $this->data['Email']['content'] ) ) ? $this->data['Email']['content'] : '' ;
					$attachments = [ 'Salepoint' => ['mimetype' => 'application/pdf','file' => $url ] ];
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

	public function generatepdf($salepoint_id=null){
		$user_id = $this->Session->read('Auth.User.id');
		$role = $this->Session->read('Auth.User.role_id');
		$details = [];
		if ($this->Salepoint->exists($salepoint_id)) {
			$options = array('contain'=>['Client'=>['Ville']],'conditions' => array('Salepoint.' . $this->Salepoint->primaryKey => $salepoint_id));
			$data = $this->Salepoint->find('first', $options);

			$details = $this->Salepoint->Salepointdetail->find('all',[
				'conditions' => ['Salepointdetail.salepoint_id'=>$salepoint_id],
				'contain' => ['Produit'],
			]);
		}
		$societe = $this->GetSociete();

		App::uses('LettreHelper', 'View/Helper');
		$LettreHelper = new LettreHelper(new View());

		$view = new View($this, false);
		$style = $view->element('style',['societe' => $societe]);
		$header = $view->element('header',['societe' => $societe,'title' => 'VENTE']);
		$footer = $view->element('footer',['societe' => $societe]);
		$ville = (isset( $this->data['Client']['Ville']['id'] ) AND !empty( $this->data['Client']['Ville']['id'] )) ? strtoupper($this->data['Client']['Ville']['libelle']).'<br/>' : '' ;
		$ice = (isset( $this->data['Client']['ice'] ) AND !empty( $this->data['Client']['ice'] )) ? 'ICE : '.strtoupper($this->data['Client']['ice']).'<br/>' : '' ;
		
		$html = '
			<html>
			<head>
			    <title>VENTE N° : '.$data['Salepoint']['reference'].'</title>
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
			                        <h4 class="container">VENTE N° : '.$data['Salepoint']['reference'].'</h4>
			                    </td>
			                    <td style="width:50%;text-align:center;">
			                        <h4 class="container">DATE : '.$data['Salepoint']['date'].'</h4>
			                    </td>
			                </tr>';
			                if ( isset( $data['Client']['id'] ) AND !empty( $data['Client']['id'] ) ) {  
			                    $html.='<tr>
			                        <td style="width:50%;text-align:center;"></td>
			                        <td style="width:50%;text-align:left;">
			                            <h4 class="container">
			                                '.strtoupper($data['Client']['designation']).'<br/>
			                                '.strtoupper($data['Client']['adresse']).'<br/>
			                                '.strtoupper($data['Client']['telmobile']).'<br/>
			                                '.$ville.'
			                                '.$ice.'
			                            </h4>
			                        </td>
			                    </tr>';
			                }
			            $html.='</tbody>
			        </table>

				    <table class="details" width="100%">
				        <thead>
				            <tr>
			                    <th nowrap="">Désignation </th>
			                    <th nowrap="">Quantité </th>
			                    <th nowrap="">Prix</th>
			                    <th nowrap="">Remise(%)</th>
			                    <th nowrap="">Montant total</th>
				            </tr>
				        </thead>
			            <tbody>';
			                foreach ($details as $tache){
			                    $html.='<tr>
			                        <td nowrap>'.$tache['Produit']['libelle'].'</td>
			                        <td nowrap style="text-align:right;">'.$tache['Salepointdetail']['qte'].'</td>
			                        <td nowrap style="text-align:right;">'.number_format($tache['Salepointdetail']['prix_vente'], 2, ',', ' ').'</td>
			                        <td nowrap style="text-align:right;">'.(int)$tache['Salepointdetail']['remise'].'%</td>
			                        <td nowrap style="text-align:right;">'.number_format($tache['Salepointdetail']['total'], 2, ',', ' ').'</td>
			                    </tr>';
			                }
			                $html .= '
			                    <tr class="hide_total">
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="hide_total">TOTAL HT</td>
			                        <td class="hide_total">'.number_format($data['Salepoint']['total_a_payer_ht'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">TOTAL TVA ('.$societe['Societe']['tva'].'%)</td>
			                        <td class="total">'.number_format($data['Salepoint']['montant_tva'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">TOTAL TTC</td>
			                        <td class="total">'.number_format($data['Salepoint']['total_a_payer_ttc'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">REMISE('.(int)$data['Salepoint']['remise'].'%)</td>
			                        <td class="total">'.number_format($data['Salepoint']['montant_remise'], 2, ',', ' ').'</td>
			                    </tr>
			                    <tr >
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td style="border:none;"></td>
			                        <td class="total">NET A PAYER</td>
			                        <td class="total">'.number_format($data['Salepoint']['total_apres_reduction'], 2, ',', ' ').'</td>
			                    </tr>
			            </tbody>
				    </table>

				    <table width="100%">
				        <tbody>
				            <tr>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    <u>Arrêtée la présente de la vente à la somme de :</u>
				                </td>
				                <td style="width:50%;text-align:left;font-weight:bold;">
				                    '.strtoupper( $LettreHelper->NumberToLetter( strval($data['Salepoint']['total_apres_reduction']) ) ).' DHS
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
		file_put_contents($destination.DS.'Salepoint.'.$data['Salepoint']['date'].'-'.$data['Salepoint']['id'].'.pdf', $output);
		return $destination.DS.'Salepoint.'.$data['Salepoint']['date'].'-'.$data['Salepoint']['id'].'.pdf';
	}
}