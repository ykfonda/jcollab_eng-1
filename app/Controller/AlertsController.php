<?php
App::uses('AppController', 'Controller');
class AlertsController extends AppController {
	public $idModule = 0;
	

	public function index() {
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$conditions['AlertUser.user_id'] = $user_id;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Alert.libelle' )
					$conditions['Alert.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Alert.date1' )
					$conditions['Alert.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Alert.date2' )
					$conditions['Alert.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Alert->recursive = -1;
		$this->Paginator->settings = [
			'joins'=>[
				['table' => 'alerts_users','alias' => 'AlertUser', 'type' => 'INNER','conditions' => ['AlertUser.alert_id = Alert.id']] ,
			],
			'conditions'=> $conditions,
			'order'=>['Alert.date_c'=>'DESC']
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function link($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$alert = $this->Alert->find('first',['conditions' => ['Alert.id' => $id]]);
		if(!empty($alert)){
			$alert_user = $this->Alert->AlertUser->find('first',[
				'conditions' => ['alert_id' => $id, 'user_id' => $user_id],
			]);
			if ( !empty( $alert_user['AlertUser']['id'] ) ) {
				$this->Alert->AlertUser->id = $alert_user['AlertUser']['id'];
				$this->Alert->AlertUser->saveField('read' , 1);
			}
			if ( !empty( $alert['Alert']['link'] ) ) {
				return $this->redirect($alert['Alert']['link']);
			}else{
				return $this->redirect(['controller'=>'pages','action'=>'index']);
			}
		}else{
			$this->Session->setFlash('Il y a un problème','alert-danger');
			return $this->redirect( $this->referer() );
		}
	}

	public function generatealerts() {
		$this->loadModel('Parametreste');
		$params = $this->Parametreste->findList();

		$conditions = [];
		if ( isset( $params['Alert_groupe'] ) AND !empty( $params['Alert_groupe'] ) ) $conditions['Groupe.id'] = $params['Alert_groupe'];
		$this->loadModel('Groupe');
		$groupe = $this->Groupe->find('first',[ 'conditions'=>$conditions,'contain' => ['User'] ]);

		$users = [];
		if ( isset( $groupe['User'] ) AND !empty( $groupe['User'] ) ) {
			foreach ($groupe['User'] as $key => $value) $users[ $value['id'] ] = $value['id'];
		}

		$today = date('Y-m-d');
		$duree = ( isset( $params['Alert_duree'] ) ) ? $params['Alert_duree'] : 2 ;
		$today_plus = date('Y-m-d', strtotime(date('Y-m-d'). ' + '.$duree.' days'));

		if ( !empty( $users ) ) {
			$alerts = [];

			$this->loadModel('Avance');
			$payments = $this->Avance->find('all',[
				'conditions' => [
					'Avance.etat' => -1,
					'Avance.date_echeance >=' => $today,
					'Avance.date_echeance <=' => $today_plus
				],
			]);

			$payment_alerts = [];
			foreach ($payments as $k => $v) {
				$reference = ( isset( $v['Avance']['id'] ) AND !empty( $v['Avance']['id'] ) ) ? $v['Avance']['reference'] : '' ;
				$message = "Alerte paiement d'échéance : ".$reference;
				$content = "Vous avez un paiement d'échéance ".$reference." dans la date suivante : ".$v['Avance']['date_echeance'];
				$payment_alerts[ $v['Avance']['id'] ]['Alert'] = [
					'libelle' => $message,
					'content' => $content,
					'icon' => "fa fa-dollar",
					'link' => '/calendriers',
				];

				$payment_alerts[ $v['Avance']['id'] ]['User']['User'] = $users;
			}

			$alerts = array_merge(
				array_values($payment_alerts)
			);

			if( $this->Alert->query('TRUNCATE TABLE alerts;') AND $this->Alert->AlertUser->query('TRUNCATE TABLE alerts_users;') );
			if ( !empty( $alerts ) AND $this->Alert->saveMany($alerts , ['deep' => true] ) ) {
				$this->Session->setFlash('Les alertes a été généré avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Aucune alerte à généré !','alert-danger');
			}
		} else {
			$this->Session->setFlash('Aucun groupe alerte définie !','alert-danger');
		}
		
		return $this->redirect( $this->referer() );
	}
}