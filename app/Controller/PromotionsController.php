<?php

class PromotionsController extends AppController
{
    public $idModule = 351;
    public $uses = ['Promotion', 'Client', 'Produit', 'Categorieproduit'];

    public function index()
    {
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $conditions = [];
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Promotion.reference') {
                    $conditions['Promotion.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Promotion.date_debut') {
                    $conditions['Promotion.date_debut >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Promotion.date_fin') {
                    $conditions['Promotion.date_fin <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Paginator->settings = ['contain' => ['Creator', 'Client', 'Produit', 'Categorieproduit'], 'conditions' => $conditions];
        $taches = $this->Paginator->paginate('Promotion');
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function view($id = null)
    {
        $details = [];

        if ($this->Promotion->exists($id)) {
            $options = ['contain' => ['Client'], 'conditions' => ['Promotion.'.$this->Promotion->primaryKey => $id]];
            $this->request->data = $this->Promotion->find('first', $options);

            $details = $this->Promotion->Promotiondetail->find('all', [
                'conditions' => ['Promotiondetail.Promotion_id' => $id],
                'order' => ['Promotiondetail.date_c' => 'DESC'],
            ]);
        }
        $this->set(compact('details'));
        $this->getPath($this->idModule);
    }

    public function editClient($id = null)
    {
        $this->layout = false;
    }

    public function editClientProduit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Promotion->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Promotion->exists($id)) {
            $options = ['conditions' => ['Promotion.'.$this->Promotion->primaryKey => $id]];
            $this->request->data = $this->Promotion->find('first', $options);
        }
        $clients = $this->Client->findList();
        $produits = $this->Produit->findList();

        $this->set(compact('clients', 'produits'));
        $this->layout = false;
    }

    public function editClientCategorie($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Promotion->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Promotion->exists($id)) {
            $options = ['conditions' => ['Promotion.'.$this->Promotion->primaryKey => $id]];
            $this->request->data = $this->Promotion->find('first', $options);
        }
        $clients = $this->Client->findList();
        $categories = $this->Categorieproduit->find('list');
        $this->set(compact('clients', 'categories'));
        $this->layout = false;
    }

    public function editGenerale($id = null)
    {
        $this->layout = false;
    }

    public function editGeneraleProduit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Promotion->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Promotion->exists($id)) {
            $options = ['conditions' => ['Promotion.'.$this->Promotion->primaryKey => $id]];
            $this->request->data = $this->Promotion->find('first', $options);
        }
        $produits = $this->Produit->findList();
        $this->set(compact('produits'));
        $this->layout = false;
    }

    public function editGeneraleCategorie($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($this->Promotion->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Promotion->exists($id)) {
            $options = ['conditions' => ['Promotion.'.$this->Promotion->primaryKey => $id]];
            $this->request->data = $this->Promotion->find('first', $options);
        }
        $categories = $this->Categorieproduit->find('list');
        $this->set(compact('categories'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        if ($this->Promotion->delete($id)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
