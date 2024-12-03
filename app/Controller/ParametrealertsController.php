<?php
class ParametrealertsController extends AppController {
	public $idModule = 55;
	
	public $uses = ['Parametrealert','Groupe','Financetudiant','Alert'];

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(['generate']);
	}

	public function index() {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Parametrealert->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
			}
			return $this->redirect( $this->referer() );
		}else{
			$this->request->data = $this->Parametrealert->find('first');
		}

		$groupes = $this->Groupe->find('list',['order'=>'libelle asc']);
		$this->set(compact('groupes'));
		$this->getPath($this->idModule);
	}
	
	public function generate() {
		$year_id = $this->Auth->Session->read('Auth.Year.id');
		$params = $this->Parametrealert->find('first')['Parametrealert'];
		$groupe = $this->Groupe->find('first',[
			'conditions'=>['id'=>$params['groupe_id']],
			'contain' => ['User'],
		]);

		$date_declenchement = date('Y-m-d', strtotime($params['date_declenchement']));

		$users = [];
		if ( isset( $groupe['User'] ) AND !empty( $groupe['User'] ) ) {
			foreach ($groupe['User'] as $key => $value) {
				$users[ $value['id'] ] = $value['id'];
			}
		}
		if ( !empty( $users ) ) {
			$financetudiants = $this->Financetudiant->find('all',[
				'fields' => ['User.nom','User.prenom','User.id','Financetudiant.*'],
				'conditions' => [
					'Financetudiant.statut'=>[-1,2],
					'Financetudiant.year_id'=>$year_id,
					'Financetudiant.reste_a_payer !='=>0,
				],
				'joins' => [
					['table' => 'users', 'alias' => 'User', 'type' => 'INNER', 'conditions' => ['User.id = Financetudiant.user_id']],
				],
			]);
			$alerts = [];
			$statuts = array(-1 => 'En attente',1 => 'Payée',2 => 'Non-payée');
			foreach ($financetudiants as $k => $v) {
				
				$statut = (isset( $statuts[ $v['Financetudiant']['statut'] ] ) AND !empty( $statuts[ $v['Financetudiant']['statut'] ] ) ) ? $statuts[ $v['Financetudiant']['statut'] ] : 'Non-payée' ;
				$message = $v['User']['nom'].' '.$v['User']['prenom'].' le reste à payer est : '.$v['Financetudiant']['reste_a_payer'].'Dhs';
				$content = "La fiche financière de ".$v['User']['nom']." ".$v['User']['prenom']." est ".$statut." et le montant qu'il reste à payer est : ".$v['Financetudiant']['reste_a_payer']."Dhs";
				
				$alerts[ $v['Financetudiant']['id'] ]['Alert'] = [
					'libelle' => $message,
					'content' => $content,
					'link' => '/financetudiants/view/'.$v['Financetudiant']['id'].'/'.$v['User']['id'],
				];

				$alerts[ $v['Financetudiant']['id'] ]['User']['User'] = $users;
			}
			
			if( $this->Alert->query('TRUNCATE TABLE alerts;') AND $this->Alert->AlertUser->query('TRUNCATE TABLE alerts_users;') );
			if ( !empty( $alerts ) AND $this->Alert->saveMany($alerts , ['deep' => true] ) ) {
				$this->Session->setFlash('Génération des alertes effectué avec succès.','alert-success');
			}else{
				$this->Session->setFlash('Aucune alertes généré !','alert-danger');
			}
		}
		
		return $this->redirect( ['action'=>'index' ] );
	}
}