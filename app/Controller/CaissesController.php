<?php

class CaissesController extends AppController
{
    public $idModule = 130;
    public $uses = ['Caisse'];

    public function index()
    {
        $stores = $this->Caisse->Store->findList();
        $societes = $this->Caisse->Societe->findList();
        $this->set(compact('stores', 'societes'));
        $this->getPath($this->idModule);
    }

    public function pos($caisse_id)
    {
        $this->Session->write('caisse_id', $caisse_id);
        $this->redirect(['controller' => 'Pos', 'action' => 'index', null]);
    }

    public function societe($store_id = null)
    {
        $store = $this->Caisse->Store->find('first', ['conditions' => ['Store.id' => $store_id]]);
        $societe_id = (isset($store['Store']['societe_id']) and !empty($store['Store']['societe_id'])) ? $store['Store']['societe_id'] : '';
        die(json_encode(['societe_id' => $societe_id]));
    }

    public function indexAjax()
    {
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');

        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Caisse.reference') {
                    $conditions['Caisse.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Caisse.libelle') {
                    $conditions['Caisse.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Caisse.date1') {
                    $conditions['Caisse.date_c >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Caisse.date2') {
                    $conditions['Caisse.date_c <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');

        $conditions['Caisse.store_id'] = $selected_store;
        $this->Paginator->settings = ['contain' => ['Store', 'Societe'], 'order' => ['Caisse.libelle' => 'ASC'], 'conditions' => $conditions];
        $taches = $this->Paginator->paginate('Caisse');
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function checkIp($adresse_ip)
    {
        /* $localIP = getHostByName(getHostName());
        $response = [];
        $response["error"] = true;
        if($localIP == $adresse_ip) {
            $response["error"] = false;
        } */
        $response = [];
        $response['error'] = false;
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($id != null) {
                $options = ['conditions' => ['Caisse.'.$this->Caisse->primaryKey => $id]];
                $caisse_exist = $this->Caisse->find('first', $options);
            } else {
                $options = ['conditions' => ['prefix' => trim($this->request->data['Caisse']['prefix']), 'deleted' => 0, 'compteur_actif' => [0, 1]]];
                $caisse = $this->Caisse->find('first', $options);
                if ($caisse) {
                    $this->Session->setFlash('Il y a deux caisses avec le même compteur', 'alert-danger');

                    return $this->redirect(['action' => 'index']);
                }
                $options = ['conditions' => ['prefix' => trim($this->request->data['Caisse']['prefix']), 'deleted' => 1, 'compteur_actif' => 0]];
                $caisse = $this->Caisse->find('first', $options);
                if ($caisse) {
                    $this->Session->setFlash('Il y a deux caisses avec le même compteur', 'alert-danger');

                    return $this->redirect(['action' => 'index']);
                }
            }
            if ($this->Caisse->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Caisse->exists($id)) {
            $options = ['conditions' => ['Caisse.'.$this->Caisse->primaryKey => $id]];
            $this->request->data = $this->Caisse->find('first', $options);
        }
        $stores = $this->Caisse->Store->findList();
        $societes = $this->Caisse->Societe->findList();
        $this->set(compact('stores', 'societes'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        $this->Caisse->id = $id;
        if (!$this->Caisse->exists()) {
            throw new NotFoundException(__('Invalide Caisse'));
        }
        if ($this->Caisse->flagDelete()) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
