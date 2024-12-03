<?php

class WalletsController extends AppController
{
    public $idModule = 351;
    public $uses = ['Wallet', 'Walletdetail', 'Client', 'PaiementWallet'];

    public function index()
    {
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $conditions = [];
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Wallet.reference') {
                    $conditions['Wallet.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Wallet.date_debut') {
                    $conditions['Wallet.date_debut >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Wallet.date_fin') {
                    $conditions['Wallet.date_fin <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Paginator->settings = ['contain' => ['Creator', 'Client'], 'conditions' => $conditions];
        $taches = $this->Paginator->paginate('Wallet');
        $this->set(compact('taches'));
        $this->layout = false;
    }

    public function view($id = null)
    {
        $details = [];

        if ($this->Wallet->exists($id)) {
            $options = ['contain' => ['Client'], 'conditions' => ['Wallet.'.$this->Wallet->primaryKey => $id]];
            $this->request->data = $this->Wallet->find('first', $options);

            $details = $this->Wallet->Walletdetail->find('all', [
                'conditions' => ['Walletdetail.wallet_id' => $id],
                'order' => ['Walletdetail.date_c' => 'DESC'],
            ]);

            $details_paiement = $this->Wallet->PaiementWallet->find('all', [
                'conditions' => ['PaiementWallet.wallet_id' => $id],
                'order' => ['PaiementWallet.id' => 'DESC'],
            ]);
        }
        $this->set(compact('details', 'details_paiement'));
        $this->getPath($this->idModule);
    }

    public function rechargerwallet($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $data['PaiementWallet'] = $this->request->data['Wallet'];
            $data['PaiementWallet']['wallet_id'] = $id;
            unset($data['PaiementWallet']['client_id']);
            if ($this->PaiementWallet->save($data['PaiementWallet'])) {
                $options = ['contain' => ['Client'], 'conditions' => ['Wallet.'.$this->Wallet->primaryKey => $id]];
                $wallet = $this->Wallet->find('first', $options);
                $montant = $wallet['Wallet']['montant'] + $data['PaiementWallet']['montant'];
                $this->Wallet->id = $id;
                $this->Wallet->saveField('montant', $montant);
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect($this->referer());
        } elseif ($this->Wallet->exists($id)) {
            $options = ['contain' => ['Client'], 'conditions' => ['Wallet.'.$this->Wallet->primaryKey => $id]];
            $wallet = $this->Wallet->find('first', $options);
        }
        $this->request->data['Wallet']['client'] = $wallet['Client']['designation'];
        $this->layout = false;
    }

    public function edit($id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            if ($id == null) {
                $client_id = $this->request->data['Wallet']['client_id'];
                $options = ['conditions' => ['Wallet.client_id' => $client_id]];
                $wallet_exist = $this->Wallet->find('first', $options);
                if (!isset($wallet_exist['Wallet']['id'])) {
                    if ($this->Wallet->save($this->request->data)) {
                        $data['PaiementWallet'] = $this->request->data['Wallet'];
                        $data['PaiementWallet']['wallet_id'] = $this->Wallet->id;
                        unset($data['PaiementWallet']['client_id']);
                        if ($this->PaiementWallet->save($data['PaiementWallet'])) {
                            $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                        }
                    } else {
                        $this->Session->setFlash('Il y a un problème', 'alert-danger');
                    }
                } else {
                    $this->Session->setFlash('la Wallet existe deja pour ce client', 'alert-danger');
                }
            } else {
                if ($this->Wallet->save($this->request->data)) {
                    $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
                } else {
                    $this->Session->setFlash('Il y a un problème', 'alert-danger');
                }
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Wallet->exists($id)) {
            $options = ['conditions' => ['Wallet.'.$this->Wallet->primaryKey => $id]];
            $this->request->data = $this->Wallet->find('first', $options);
        }
        $clients = $this->Client->findList();
        $this->set(compact('clients'));
        $this->layout = false;
    }

    public function delete($id = null)
    {
        if (isset($this->globalPermission['Permission']['s']) and $this->globalPermission['Permission']['s'] == 0) {
            $this->Session->setFlash('Vous n\'avez pas la permission de supprimer !', 'alert-danger');

            return $this->redirect($this->referer());
        }
        if ($this->Wallet->delete($id)) {
            if ($this->Walletdetail->deleteAll(['wallet_id' => $id], false)) {
                $this->Session->setFlash('La suppression a été effectué avec succès.', 'alert-success');
            }
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }
}
