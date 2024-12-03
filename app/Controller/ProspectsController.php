<?php
class ProspectsController extends AppController {
	public $idModule = 78;
	
	public $uses = ['Client'];

	public function index() {
		$users_db = $this->Client->User->find('all');
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$categorieclients = $this->Client->Categorieclient->find('list',['order'=>'libelle asc']);
		$clienttypes = $this->Client->Clienttype->find('list',['order'=>'libelle asc']);
		$villes = $this->Client->Ville->find('list',['order'=>'libelle asc']);
		$this->set(compact('users','categorieclients','villes','clienttypes'));
		$this->getPath($this->idModule);
	}
	
	public function indexAjax(){
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$conditions['Client.type'] = -1;
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Client.designation' )
					$conditions['Client.designation LIKE '] = "%$value%";
				else if( $param_name == 'Client.reference' )
					$conditions['Client.reference LIKE '] = "%$value%";
				else if( $param_name == 'Client.date1' )
					$conditions['Client.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Client.date2' )
					$conditions['Client.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Client->recursive = -1;
		$this->Paginator->settings = [
			'contain'=>['User','Categorieclient','Ville','Clienttype'],
			'order'=>['Client.date_c'=>'DESC'],
			'conditions'=>$conditions
		];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}

	public function view($id = null,$annee = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		$annee = ( $annee == null ) ? date('Y') : $annee ;
		$objectifs = [];
		$ca_ventes = 0.00;
		$ca_avoirs = 0.00;
		$ca_total = 0.00;
		$taux = 0.00;
		if ($this->Client->exists($id)) {
			$options = array('contain'=>['User','Categorieclient','Clienttype'],'conditions' => array('Client.' . $this->Client->primaryKey => $id));
			$this->request->data = $this->Client->find('first', $options);
			$objectifs = $this->Client->Objectifclient->find('all',[
				'conditions' => ['Objectifclient.client_id'=>$id],
				'order' => 'Objectifclient.annee DESC'
			]);

			$req1 = $this->Client->Vente->find('first',[
				'fields' => ['SUM(total_paye) as total_paye'],
				'conditions' => ['client_id'=>$id,'etat'=>2,'YEAR(date)' => $annee],
			]);
			$ca_ventes = ( isset( $req1[0]['total_paye'] ) AND !empty( $req1[0]['total_paye'] ) ) ? (float) $req1[0]['total_paye'] : 0.00;

			$req2 = $this->Client->Avoir->find('first',[
				'fields' => ['SUM(total_paye) as total_paye'],
				'conditions' => ['client_id'=>$id,'YEAR(date)' => $annee]
			]);
			$ca_avoirs = ( isset( $req2[0]['total_paye'] ) AND !empty( $req2[0]['total_paye'] ) ) ? (float) $req2[0]['total_paye'] : 0.00;

			$ca_total = $ca_ventes - $ca_avoirs;

			$current_obj = $this->Client->Objectifclient->find('first',[
				'conditions' => ['client_id'=>$id,'annee'=>$annee],
				'order' => 'id DESC'
			]);

			$obj_fixe = ( isset( $current_obj['Objectifclient']['id'] ) ANd !empty( $current_obj['Objectifclient']['objectif'] ) ) ? (float) $current_obj['Objectifclient']['objectif'] : 0.00 ;
			$taux = ( $obj_fixe > 0 ) ? (float) round(($ca_ventes / $obj_fixe)*100 , 2) : 0.00 ;
		}

		$this->set(compact('user_id','role_id','ca_ventes','ca_avoirs','ca_total','objectifs','annee','taux'));
		$this->getPath($this->idModule);
	}

	public function changelocation($id = null,$latitude = null,$longitude = null) {
		$data['Client']['id'] = $id;
		$data['Client']['latitude'] = $latitude;
		$data['Client']['longitude'] = $longitude;
		if ($this->Client->save($data)) {
			$this->Session->setFlash('La mise à jour a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Client']['type'] = -1;
			if ($this->Client->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Client->exists($id)) {
			$options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
			$this->request->data = $this->Client->find('first', $options);
		}

		$users_db = $this->Client->User->find('all');
		$users = [];
		foreach ($users_db as $key => $value) {
			$users[ $value['User']['id'] ] = $value['User']['nom'].' '.$value['User']['prenom'];
		}
		$categorieclients = $this->Client->Categorieclient->find('list');
		$villes = $this->Client->Ville->find('list',['order'=>'libelle asc']);
		$clienttypes = $this->Client->Clienttype->find('list',['order'=>'libelle asc']);
		$this->set(compact('users','categorieclients','user_id','role_id','villes','clienttypes'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalide client'));
		}

		if ($this->Client->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function editobjectif($id = null,$client_id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Objectifclient']['client_id'] = $client_id;
			if ($this->Client->Objectifclient->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		} else if ($this->Client->Objectifclient->exists($id)) {
			$options = array('conditions' => array('Objectifclient.' . $this->Client->Objectifclient->primaryKey => $id));
			$this->request->data = $this->Client->Objectifclient->find('first', $options);
		}

		$this->set(compact('years'));
		$this->layout = false;
	}

	public function deleteobjectif($id = null) {
		$this->Client->Objectifclient->id = $id;
		if (!$this->Client->Objectifclient->exists()) {
			throw new NotFoundException(__('Invalide Objectif client'));
		}

		if ($this->Client->Objectifclient->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect( $this->referer() );
	}
}