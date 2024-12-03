<?php
class PermissionPosController  extends AppController
{
	public $uses = ['Role','Permissionpos'];
    public function index() {
	
		
		$this->getPath($this->idModule);
	}

	public function view($role) {
		if ($this->request->is(array('post', 'put'))) {	
		//var_dump($this->data/* ['Produit']['code_barre'] */); die();
		$role_id = 0;
		$permissionData  = [];
		$permission1 = 0;
		$i = 0;
			foreach($this->data["Permissionpos"] as $key => $value) {
				
				if($key == "role") {
					$role_id = $value;
					continue;
				}
				if($value == "0") {
					$permission1 = 0;
                    $permissionData[] = [
					
                    'nom' => $key,
                    'permission' => 0,
                    'role_id' => $role_id,
                    
                ];
                }
				else {
					$permission1 = 1;
					$permissionData[] = [
						
						'nom' => $key,
						'permission' => 1,
						'role_id' => $role_id,
						
					];
				}
				$permission = $this->Permissionpos->find("first",["conditions" => ["nom" => $key,
				"role_id" => $role_id]]);
                if (isset($permission["Permissionpos"]["id"]) and !empty($permission["Permissionpos"]["id"])) {
					$this->Permissionpos->create();
					$this->Permissionpos->updateAll(
                        ['Permissionpos.permission'=> $permission1],
                        ['Permissionpos.nom'=> $key,
                'Permissionpos.role_id'=> $role_id]
                    );
                }
				else {
					$this->Permissionpos->create();
                    $this->Permissionpos->save($permissionData[$i]);
                }
			$i++;
			}
		
			
						$this->Session->setFlash('L\'action a été effectué avec succès.','alert-success');
		
		return $this->redirect( ['action' => 'index'] );
        }
		$permissions = $this->Permissionpos->find("all",["conditions" => ["role_id" => $role]]);
		$perm = [];
		$perm["Remise"] = false;
		$perm["Remise ticket"] = false;
		$perm["Offert"] = false;
		$perm["Annuler ticket"] = false;
		$perm["Cloture caisse"] = false;
		$perm["Activation cheque cadeau"] = false;
		$perm["Activation bon d'achat"] = false;
		$perm["Activation carte client"] = false;
		$perm["Correction mode paiement"] = false;
		$perm["Retour produit"] = false;
		$perm["Reimpression facture ou ticket"] = false;
		foreach($permissions as $permission) {
			$perm[$permission["Permissionpos"]["nom"]] = ($permission["Permissionpos"]["permission"] == 1) ? true : false;
		}
			$this->set(compact('role','perm'));
	}

	public function indexAjax(){
		$user_id = $this->Auth->Session->read('Auth.User.id');
		$conditions['Role.id !='] = 1;
		if ( $user_id == 1 ) $conditions= [];
		foreach($this->params['named'] as $param_name => $value){
			if(!in_array($param_name, array('page','sort','direction','limit'))){

				if( $param_name == 'Role.libelle' )
					$conditions['Role.libelle LIKE'] = '%'.$value.'%';
				else if( $param_name == 'Role.date1' )
					$conditions['Role.created >='] = date('Y-m-d',strtotime($value));
				else if( $param_name == 'Role.date2' )
					$conditions['Role.created <='] = date('Y-m-d',strtotime($value));
				else{
					$conditions[$param_name] = $value;					
					$this->request->data['Filter'][$param_name] = $value;
				}
			}
		}
		
		$this->Role->recursive = -1;
		$this->Paginator->settings = array(
			'limit' => 15,
			'conditions' => $conditions,
			'order' => 'Role.id ASC',
		);
		$roles = $this->Paginator->paginate();

		$this->set(compact('roles'));
		$this->layout = false;
	}
    
   
}