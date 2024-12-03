<?php
class DepencesController extends AppController {
	public $idModule = 109;
	

	public function index() {
		$role_id = $this->Session->read('Auth.User.role_id');
		$boncommandes = $this->Depence->Boncommande->find('list');
		$bonreceptions = $this->Depence->Bonreception->find('list');
		$categoriedepences = $this->Depence->Categoriedepence->find('list');
		$fournisseurs = $this->Depence->Boncommande->Fournisseur->find('list');
		$this->set(compact('boncommandes','fournisseurs','bonreceptions','categoriedepences'));
		$this->getPath($this->idModule);
	}

	public function edit($id = null) {
		$user_id = $this->Session->read('Auth.User.id');
		$role_id = $this->Session->read('Auth.User.role_id');
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Depence->save($this->request->data)) {
				$this->Session->setFlash('L\'enregistrement a été effectué avec succès.','alert-success');
			} else {
				$this->Session->setFlash('Il y a un problème','alert-danger');
				return $this->redirect(array('action' => 'index'));
			}
			return $this->redirect(array('action' => 'index'));
		} else if ($this->Depence->exists($id)) {
			$options = array('conditions' => array('Depence.' . $this->Depence->primaryKey => $id));
			$this->request->data = $this->Depence->find('first', $options);
		}

		$categoriedepences = $this->Depence->Categoriedepence->find('list',['conditions' =>['Categoriedepence.id !='=>1] ]);
		$this->set(compact('categoriedepences','user_id'));
		$this->layout = false;
	}

	public function indexAjax(){
		$conditions = [];
		$dateConditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Depence.reference' )
					$conditions['Depence.reference LIKE '] = "%$value%";
				else if( $param_name == 'Depence.emeteur' )
					$conditions['Depence.emeteur LIKE '] = "%$value%";
				else if( $param_name == 'Depence.etat' ){
					if( $value == 2 ) $conditions['Depence.etat'] = [-1,1];
					else $conditions['Depence.etat'] = $value;
				}else if( $param_name == 'Depence.date1' ){
					$conditions['Depence.date >='] = date('Y-m-d',strtotime($value));
					$dateConditions['Depence.date >='] = date('Y-m-d',strtotime($value));
				}else if( $param_name == 'Depence.date2' ){
					$conditions['Depence.date <='] = date('Y-m-d',strtotime($value));
					$dateConditions['Depence.date <='] = date('Y-m-d',strtotime($value));
				}else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$chiffre_valide = $this->Depence->find('first',[
			'fields' => ['SUM(Depence.montant) as montant'],
			'conditions' => $dateConditions,
		]);

		$chiffre_affaire_valide = (isset( $chiffre_valide[0]['montant'] )) ? $chiffre_valide[0]['montant'] : 0 ;

		$this->Depence->recursive = -1;
		$settings = [
			'contain' => ['Creator','Boncommande','Bonreception','Categoriedepence'],
			'order'=>['Depence.id'=>'DESC'],
			'conditions'=> $conditions,
		];
		$taches = $this->Depence->find('all',$settings);
		$this->set(compact('taches','chiffre_affaire_valide'));
		$this->layout = false;
	}

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Depence->id = $id;
		if (!$this->Depence->exists()) {
			throw new NotFoundException(__('Invalide dépence'));
		}

		if ($this->Depence->flagDelete()) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}