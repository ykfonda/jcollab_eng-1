<?php

class DiversController extends AppController{

	public $idModule = 26;
	
	public $helpers = ['Divers'];

	public function index(){
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				if( $param_name == 'Diver.libelle' ){
					$conditions['OR'] = [ 
						'Diver.libelle LIKE' => "%$value%" , 
						'Diver.description LIKE ' => "%$value%" , 
					];
				}else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}

		$this->Diver->recursive = -1;
		$this->Paginator->settings = array(
			'limit' => 15,
			'conditions' => $conditions,
			'order' => 'Diver.libelle',
		);
		$divers = $this->Paginator->paginate();

		$this->set(compact('divers'));
		$this->layout = false;
	}

}