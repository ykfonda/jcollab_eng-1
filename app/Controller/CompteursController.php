<?php

class CompteursController extends AppController
{
    public $idModule = 134;
    public $uses = ['Store', 'User', 'Compteur'];

    public function index()
    {
        $stores = $this->Compteur->Store->findList();
        $this->set(compact('stores'));
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $conditions = [];
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Compteur.module') {
                    $conditions['Compteur.module LIKE '] = "%$value%";
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');

        $conditions['Compteur.store_id'] = $selected_store;

        $this->Paginator->settings = ['contain' => ['Store'], 'order' => ['Compteur.date_c' => 'DESC'], 'conditions' => $conditions];
        $taches = $this->Paginator->paginate('Compteur');
        $this->set(compact('taches'));

        $this->layout = false;
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($id != null) {
                $options = ['conditions' => ['prefix' => trim($this->request->data['Compteur']['prefix']), 'deleted' => 1, 'active' => 0]];
                $compteur = $this->Compteur->find('first', $options);

                if ($this->Compteur->save($this->request->data)) {
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                }
            } else {
                $options = ['conditions' => ['module' => $this->request->data['Compteur']['module'], 'store_id' => $this->request->data['Compteur']['store_id']]];
                $compteur = $this->Compteur->find('first', $options);
                if (isset($compteur['Compteur']['id'])) {
                    $this->Session->setFlash('Il ne peut y avoir deux compteurs pour le même store', 'alert-danger');

                    return $this->redirect(['action' => 'index']);
                }
                if ($this->Compteur->save($this->request->data)) {
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                } else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Compteur->exists($id)) {
            $options = ['conditions' => ['Compteur.'.$this->Compteur->primaryKey => $id]];
            $this->request->data = $this->Compteur->find('first', $options);
        }
        $modules = [];
        $modules['Facture'] = 'Facture';
        $modules['Devis'] = 'Devis';
        $modules['Bon commande'] = 'Bon commande';
        $modules['Bon livraison'] = 'Bon livraison';
        $modules['Bon retour'] = 'Bon retour';

        $stores = $this->Compteur->Store->findList();
        $this->set(compact('modules', 'stores'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }

        if ($this->Compteur->delete($id)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
