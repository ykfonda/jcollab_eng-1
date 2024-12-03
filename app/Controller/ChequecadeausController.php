<?php

class ChequecadeausController extends AppController
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
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Chequecadeau.reference') {
                    $conditions['Chequecadeau.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Chequecadeau.date_debut') {
                    $conditions['Chequecadeau.date_debut >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Chequecadeau.date_fin') {
                    $conditions['Chequecadeau.date_fin <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Paginator->settings = ['contain' => ['Client'], 'order' => ['Chequecadeau.id' => 'DESC'], 'conditions' => $conditions];
        $taches = $this->Paginator->paginate('Chequecadeau');
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            //$options = array('conditions' => array('Caisse.' . $this->Caisse->primaryKey => $id));
            //$caisse_exist = $this->Caisse->find('first', $options);
            $validite = $this->request->data['Chequecadeau']['validite'];
            if ($this->request->data['Chequecadeau']['active'] == '1') {
                $this->request->data['Chequecadeau']['date_debut'] = date('Y-m-d H:i:s');
                $days = '+'.$validite.' day';
                $this->request->data['Chequecadeau']['date_fin'] = date('Y-m-d H:i:s', strtotime($days, strtotime($this->request->data['Chequecadeau']['date_debut'])));
                /*
                $date_fin->modify($days);
                $this->request->data["Chequecadeau"]["date_fin"] = $date_fin; */
            }
            /*else {
                $options = array('conditions' => array("prefix" => trim($this->request->data["Caisse"]["prefix"]),"deleted" => 0,"compteur_actif" => [0,1]));
                $caisse = $this->Caisse->find('first', $options);
                if($caisse) {
                    $this->Session->setFlash('Il y a deux caisses avec le même compteur','alert-danger');
                    return $this->redirect(array('action' => 'index'));
                }
                $options = array('conditions' => array("prefix" => trim($this->request->data["Caisse"]["prefix"]),"deleted" => 1,"compteur_actif" => 0));
                $caisse = $this->Caisse->find('first', $options);
                if($caisse) {
                    $this->Session->setFlash('Il y a deux caisses avec le même compteur','alert-danger');
                    return $this->redirect(array('action' => 'index'));
                }
            }
            */
            if ($this->Chequecadeau->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Chequecadeau->exists($id)) {
            $options = ['conditions' => ['Chequecadeau.'.$this->Chequecadeau->primaryKey => $id]];
            $this->request->data = $this->Chequecadeau->find('first', $options);
        }

        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        if ($this->Chequecadeau->delete($id)) {
            $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
