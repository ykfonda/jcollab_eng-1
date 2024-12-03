<?php

class MonstockController extends AppController
{
    public $idModule = 93;

    public $uses = ['Produit', 'User'];

    public function index()
    {
        $user_id = $this->Session->read('Auth.User.id');
        $role_id = $this->Session->read('Auth.User.role_id');
        $admins = $this->Session->read('admins');
        $depots = $this->Session->read('depots');

        $produits = $this->Produit->findList();
        $depots = $this->Produit->Depotproduit->Depot->findList(['Depot.id' => $depots]);
        $this->set(compact('produits', 'user_id', 'admins', 'role_id', 'depots'));
        $this->getPath($this->idModule);
    }

    public function transaction($produit_id = null, $depot_source_id = null)
    {
        $entree = $this->Produit->Mouvement->find('first', [
            'fields' => ['SUM(Mouvement.paquet_source) as paquet', 'SUM(Mouvement.stock_source) as quantite', 'SUM(Mouvement.total_general) as total'],
            'conditions' => [
                'depot_source_id' => $depot_source_id,
                'produit_id' => $produit_id,
                'operation' => -1,
            ],
        ]);

        $quantite_entree = (isset($entree[0]['quantite']) and !empty($entree[0]['quantite'])) ? (int) $entree[0]['quantite'] : 0;
        $paquet_entree = (isset($entree[0]['paquet']) and !empty($entree[0]['paquet'])) ? (int) $entree[0]['paquet'] : 0;
        $total_entree = (isset($entree[0]['total']) and !empty($entree[0]['total'])) ? (int) $entree[0]['total'] : 0;

        $sortie = $this->Produit->Mouvement->find('first', [
            'fields' => ['SUM(Mouvement.paquet_source) as paquet', 'SUM(Mouvement.stock_source) as quantite', 'SUM(Mouvement.total_general) as total'],
            'conditions' => [
                'depot_source_id' => $depot_source_id,
                'produit_id' => $produit_id,
                'operation' => 1,
            ],
        ]);

        $quantite_sortie = (isset($sortie[0]['quantite']) and !empty($sortie[0]['quantite'])) ? (int) $sortie[0]['quantite'] : 0;
        $paquet_sortie = (isset($sortie[0]['paquet']) and !empty($sortie[0]['paquet'])) ? (int) $sortie[0]['paquet'] : 0;
        $total_sortie = (isset($sortie[0]['total']) and !empty($sortie[0]['total'])) ? (int) $sortie[0]['total'] : 0;

        $quantite = $quantite_entree - $quantite_sortie;
        $paquet = $paquet_entree - $paquet_sortie;
        $total = $total_entree - $total_sortie;

        $quantite = ($quantite <= 0) ? 0 : $quantite;
        $paquet = ($paquet <= 0) ? 0 : $paquet;
        $total = ($total <= 0) ? 0 : $total;

        $this->loadModel('Depotproduit');
        $req = $this->Depotproduit->find('first', [
            'conditions' => [
                'depot_id' => $depot_source_id,
                'produit_id' => $produit_id,
            ],
        ]);

        $id = (isset($req['Depotproduit']['id']) and !empty($req['Depotproduit']['id'])) ? $req['Depotproduit']['id'] : null;

        $data['Depotproduit'] = [
            'id' => $id,
            'date' => date('Y-m-d'),
            'depot_id' => $depot_source_id,
            'produit_id' => $produit_id,
            'quantite' => $quantite,
            'paquet' => $paquet,
            'total' => $total,
        ];

        if ($this->Produit->Depotproduit->save($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function correction()
    {
        $mouvements = $this->Produit->Mouvement->find('all', [
            'conditions' => ['Mouvement.operation' => -1],
        ]);

        //$this->Produit->query('TRUNCATE TABLE depotproduits;');
        foreach ($mouvements as $k => $v) {
            $this->transaction($v['Mouvement']['produit_id'], $v['Mouvement']['depot_source_id']);
        }

        if (true) {
            $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
        } else {
            $this->Session->setFlash('Il y a un problème', 'alert-danger');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function edit($id = null)
    {
        $this->loadModel('Depotproduit');
        if ($this->request->is(['post', 'put'])) {
            if ($this->Depotproduit->save($this->request->data)) {
                $this->Session->setFlash('L\'enregistrement a été effectué avec succès.', 'alert-success');
            } else {
                $this->Session->setFlash('Il y a un problème', 'alert-danger');
            }

            return $this->redirect(['action' => 'index']);
        } elseif ($this->Depotproduit->exists($id)) {
            $options = ['conditions' => ['Depotproduit.'.$this->Depotproduit->primaryKey => $id]];
            $this->request->data = $this->Depotproduit->find('first', $options);
        }
        $produits = $this->Produit->findList();
        $depots = $this->Depotproduit->Depot->find('list');
        $this->set(compact('depots', 'produits'));
        $this->layout = false;
    }

    public function excel()
    {
        $depots = $this->Session->read('depots');
        $conditions['Depot.id'] = $depots;
        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Produit.libelle') {
                    $conditions['Produit.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.reference') {
                    $conditions['Produit.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.code_barre') {
                    $conditions['Produit.code_barre LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.date1') {
                    $conditions['Produit.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Produit.date2') {
                    $conditions['Produit.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Produit->recursive = -1;
        $settings = [
            'fields' => [
                'Produit.id',
                'Produit.libelle',
                'Produit.image',
                'Produit.reference',
                'Produit.code_barre',
                'Produit.type',
                'Depotproduit.id',
                'Depotproduit.quantite',
                'Depotproduit.depot_id',
                'Depot.libelle',
            ],
            'conditions' => $conditions,
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id', 'Depotproduit.deleted = 0']],
                ['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depot.id = Depotproduit.depot_id', 'Depot.deleted = 0']],
            ],
            'order' => ['Depotproduit.quantite' => 'DESC'],
        ];
        $taches = $this->Produit->find('all', $settings);
        $this->set(compact('taches', 'role_id', 'user_id'));
        $this->layout = false;
    }

    public function indexAjax()
    {
        /* $depots = $this->Session->read('depots');
        $conditions['Depot.id'] = $depots; */
        $conditions = [];
        $selected_store = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list', ['conditions' => ['store_id' => $selected_store],
        'fields' => ['id'], ]);
        $conditions['Depotproduit.depot_id'] = $depots;

        foreach ($this->params['named'] as $param_name => $value) {
            if (!in_array($param_name, ['page', 'sort', 'direction', 'limit'])) {
                if ($param_name == 'Produit.libelle') {
                    $conditions['Produit.libelle LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.reference') {
                    $conditions['Produit.reference LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.code_barre') {
                    $conditions['Produit.code_barre LIKE '] = "%$value%";
                } elseif ($param_name == 'Produit.date1') {
                    $conditions['Produit.date >='] = date('Y-m-d', strtotime($value));
                } elseif ($param_name == 'Produit.date2') {
                    $conditions['Produit.date <='] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                } else {
                    $conditions[$param_name] = $value;
                    $this->request->data['Filter'][$param_name] = $value;
                }
            }
        }

        $this->Produit->recursive = -1;
        $this->Paginator->settings = [
            'fields' => [
                'Produit.id',
                'Produit.libelle',
                'Produit.image',
                'Produit.reference',
                'Produit.code_barre',
                'Produit.type',
                'Depotproduit.id',
                'Depotproduit.quantite',
                'Depotproduit.depot_id',
                'Depot.libelle',
            ],
            'conditions' => $conditions,
            'joins' => [
                ['table' => 'depotproduits', 'alias' => 'Depotproduit', 'type' => 'INNER', 'conditions' => ['Depotproduit.produit_id = Produit.id', 'Depotproduit.deleted = 0']],
                ['table' => 'depots', 'alias' => 'Depot', 'type' => 'INNER', 'conditions' => ['Depot.id = Depotproduit.depot_id', 'Depot.deleted = 0']],
            ],
            'order' => ['Depotproduit.quantite' => 'DESC'],
        ];

        $taches = $this->Paginator->paginate('Produit');
        $this->set(compact('taches', 'role_id', 'user_id'));
        $this->layout = false;
    }
}
