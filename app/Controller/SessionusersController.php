<?php
class SessionusersController extends AppController {

	public $idModule = 135;
	public $uses = ['Salepoint','Sessionuser'];
	public function index() {
		$this->getPath($this->idModule);
	}

	public function indexAjax(){
		$conditions = [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){
				/* if( $param_name == 'Motifsabandon.libelle' )
					$conditions['Motifsabandon.libelle LIKE '] = "%$value%";
				else if( $param_name == 'Motifsabandon.date1' )
					$conditions['Motifsabandon.date_c >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Motifsabandon.date2' )
					$conditions['Motifsabandon.date_c <='] = date('Y-m-d H:i:s',strtotime($value.' 23:59:59'));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				} */
			}
		}

        $conditions["Sessionuser.date_fin !="] = null;
		$this->Sessionuser->recursive = -1;
		$this->Paginator->settings = [
            /* 'joins'=>[
				['table' => 'salepoints','alias' => 'Salepoint', 'type' => 'INNER','conditions' => ['Salepoint.date_c BETWEEN  Sessionuser.date_debut AND Sessionuser.date_fin','Salepoint.etat = 2','Salepoint.deleted = 0']] ,
			], */
            'contain'=>['User','Site','Caisse'],
            'order'=> ['Sessionuser.id'=>'DESC'], 'conditions'=>$conditions];
		$taches = $this->Paginator->paginate("Sessionuser");
        $chiffre_affaires = [];
        foreach($taches as $tache) {
            $this->loadModel("Salepoint");
            $salepoint = $this->Salepoint->query("Select SUM(total_paye+fee) AS chiffre_affaire from salepoints where salepoints.date_u >= '{$tache['Sessionuser']['date_debut']}' AND salepoints.date_u <= '{$tache['Sessionuser']['date_fin']}' and salepoints.user_id = {$tache['Sessionuser']['user_id']} and salepoints.caisse_id = {$tache['Sessionuser']['caisse_id']} and salepoints.etat = 2");
            array_push($chiffre_affaires,$salepoint[0][0]["chiffre_affaire"]);
        }
        $this->set(compact('taches','chiffre_affaires'));
		$this->layout = false;
	}
	public function view($id = null) {
		
		if ($this->Sessionuser->exists($id)) {
			$options = array('contain'=>['User','Site','Caisse'],'conditions' => array('Sessionuser.' . $this->Sessionuser->primaryKey => $id));
			$sessionuser = $this->Sessionuser->find('first', $options);

			$salepoint = $this->Salepoint->query("Select SUM(total_paye+fee) AS chiffre_affaire from salepoints where salepoints.date_u >= '{$sessionuser['Sessionuser']['date_debut']}' AND salepoints.date_u <= '{$sessionuser['Sessionuser']['date_fin']}' and salepoints.user_id = {$sessionuser['Sessionuser']['user_id']} and salepoints.caisse_id = {$sessionuser['Sessionuser']['caisse_id']} and salepoints.etat = 2");	
			$chiffre_affaire = $salepoint[0][0]["chiffre_affaire"];

			$salepoints = $this->Salepoint->find("all",["conditions" =>
			["Salepoint.date_u >= '{$sessionuser['Sessionuser']['date_debut']}' AND Salepoint.date_u <= '{$sessionuser['Sessionuser']['date_fin']}' and Salepoint.user_id = {$sessionuser['Sessionuser']['user_id']}  and Salepoint.caisse_id = {$sessionuser['Sessionuser']['caisse_id']} and Salepoint.etat = 2"],
		    'order' => ['Salepoint.payment_method']]);

			$payment_methods = [];
			foreach($salepoints as $salepoint) {
				$salepoint["Salepoint"]["payment_method"] = (strpos($salepoint["Salepoint"]["payment_method"],"cod") !== false) ? str_replace("cod","especes",$salepoint["Salepoint"]["payment_method"]) : $salepoint["Salepoint"]["payment_method"];  
				$payment_methods[][$salepoint["Salepoint"]["payment_method"]] = $salepoint["Salepoint"]["total_paye"] + $salepoint["Salepoint"]["fee"]; 
			}
			
		} else {
			$this->Session->setFlash("Ce document n'existe pas !",'alert-danger');
			return $this->redirect( ['action' => 'index'] );
		}

		

		$this->set(compact('sessionuser','chiffre_affaire','payment_methods','salepoints'));
		
	}
	

	public function delete($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) {
			$this->Session->setFlash('Vous n\'avez pas la permission de supprimer !','alert-danger');
			return $this->redirect( $this->referer() );
		}
		$this->Sessionuser->id = $id;
		if (!$this->Sessionuser->exists()) {
			throw new NotFoundException(__('Invalide catégorie client'));
		}

		if ($this->Sessionuser->deleteAll(["Sessionuser.id" => $id],false)) {
			$this->Session->setFlash('La suppression a été effectué avec succès.','alert-success');
		} else {
			$this->Session->setFlash('Il y a un problème','alert-danger');
		}
		return $this->redirect(array('action' => 'index'));
	}
}
