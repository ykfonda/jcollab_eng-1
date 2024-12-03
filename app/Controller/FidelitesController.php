<?php

class FidelitesController extends AppController
{
    public $idModule = 351;
    //	public $uses = ['Caisse'];

    public function index()
    {
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $conditions = [];

        $this->Paginator->settings = ['conditions' => $conditions];
        $taches = $this->Paginator->paginate('Fidelite');
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Fidelite->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Fidelite->exists($id)) {
            $options = ['conditions' => ['Fidelite.'.$this->Fidelite->primaryKey => $id]];
            $this->request->data = $this->Fidelite->find('first', $options);
        }

        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        if ($this->Fidelite->delete($id)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
