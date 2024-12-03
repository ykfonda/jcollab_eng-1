<?php
App::uses('AppController', 'Controller');

class NotificationsController extends AppController {
	public $idModule = 0;
	

	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Notification.message' )
					$conditions['Notification.message LIKE '] = "%$value%";
				else if( $param_name == 'Notification.date1' )
					$conditions['Notification.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Notification.date2' )
					$conditions['Notification.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Notification->recursive = -1;
		$this->Paginator->settings = [
			'contain' => ['NotificationsVue' => ['conditions' => ['NotificationsVue.user_id' => $user_id] ]],
			'joins'=>[
				['table' => 'notifications_users','alias' => 'NotificationUser', 'type' => 'INNER','conditions' => ['NotificationUser.notification_id = Notification.id']] ,
			],
			'conditions'=> [ 'NotificationUser.user_id'=>$user_id , 'Notification.read'=>[1,-1] ] + $conditions,
			'order'=>['Notification.date_c'=>'DESC']
		];
		$user_notifications = $this->Paginator->paginate();
		$this->set(compact('user_notifications'));
		$this->layout = false;
	}

	public function readall(){
		$user_id = $this->Session->read('Auth.User.id');
		$options = [
			'fields' => ['Notification.id','Notification.id'],
			'joins'=>[
				['table' => 'notifications_users','alias' => 'NotificationUser', 'type' => 'INNER','conditions' => ['NotificationUser.notification_id = Notification.id']] ,
			],
			'conditions'=> [ 'NotificationUser.user_id'=>$user_id , 'Notification.read'=>-1 ],
		];
		$notifications = $this->Notification->find('list',$options);

		if( !empty( $notifications ) AND $this->Notification->UpdateAll( ['Notification.read' => 1] , ['Notification.id' => $notifications] ) ){
			$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
		}else{
			$this->Session->setFlash('Aucune notification à marquer','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function link($notifID = null){
		$userID = $this->Session->read('Auth.User.id');
		$notif = $this->Notification->find('first',['conditions' => ['Notification.id' => $notifID]]);

		if(!empty($notif)){
			$this->Notification->NotificationsVue->save(['notification_id' => $notifID, 'user_id' => $userID]);
			$this->Notification->id = $notifID;
			$this->Notification->saveField('read',1);
			if ( !empty( $notif['Notification']['link'] ) ) {
				return $this->redirect($notif['Notification']['link']);
			}else{
				return $this->redirect(['controller'=>'pages','action'=>'index']);
			}
		}else{
			$this->Session->setFlash('Il y a un problème','alert-danger');
			return $this->redirect( $this->referer() );
		}
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Notification->id = $id;
		if (!$this->Notification->exists()) {
			throw new NotFoundException(__('Invalide statut'));
		}

		if ($this->Notification->flagDelete()) {
			$this->saveLogs('Notification');
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function index(){

	}

}