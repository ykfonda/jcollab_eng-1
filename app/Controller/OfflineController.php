<?php
class OfflineController extends AppController {
	public $idModule = 137;
	

	public function index() {
		
		//$offlines = $this->Offline->find('list');
		
		$taches = $this->Paginator->paginate('Offline');
		$this->set(compact('taches'));
	
		$this->getPath($this->idModule);
	}

/* 	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Objectif.abr' )
					$conditions['Objectif.abr LIKE '] = "%$value%";
				else if( $param_name == 'Objectif.libelle' )
					$conditions['Objectif.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Objectif.date1' )
					$conditions['Objectif.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Objectif.date2' )
					$conditions['Objectif.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Objectif->recursive = -1;
		$this->Paginator->settings = ['contain'=>['User'],'order'=>['Objectif.libelle'=>'ASC'],'conditions'=>$conditions];
		$taches = $this->Paginator->paginate();
		$this->set(compact('taches'));
		$this->layout = false;
	}
 */
	
}