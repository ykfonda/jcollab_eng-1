<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));

class RegistrepassationController extends AppController {
    public $idModule = 361; // ID du module pour gérer les permissions ou chemin
    public $uses = ['Registrepassation', 'User', 'Depot']; // Modèles utilisés (sans Produit)

    /**
     * Méthode index : affiche la liste des enregistrements
     */
    public function index() {
        // Lecture des informations utilisateur depuis la session
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $depots = $this->Session->read('depots'); // Dépôts disponibles pour cet utilisateur

        // Récupération des listes associées
        $users = $this->User->find('list'); // Liste des utilisateurs
        $depotsList = $this->Depot->find('list', ['conditions' => ['Depot.id' => $depots]]); // Dépôts autorisés

        // Récupération des enregistrements de Registrepassation
        $registrepassations = $this->Registrepassation->find('all', [
            'conditions' => ['Registrepassation.deleted' => 0], // Filtrer les non supprimés
            'order' => ['Registrepassation.date' => 'DESC'] // Trier par date décroissante
        ]);

        // Transmission des données à la vue
        $this->set(compact('users', 'depotsList', 'registrepassations'));

        // Gestion du chemin de navigation (si nécessaire)
        $this->getPath($this->idModule);
    }

    /**
     * Méthode view : afficher un enregistrement spécifique
     *
     * @param int $id ID de l'enregistrement à afficher
     */
    public function view($id = null) {
        if (!$this->Registrepassation->exists($id)) {
            throw new NotFoundException(__('Enregistrement introuvable.'));
        }

        // Récupération des détails de l'enregistrement
        $registrepassation = $this->Registrepassation->findById($id);
        $this->set('registrepassation', $registrepassation);
    }

    /**
     * Méthode delete : supprimer un enregistrement
     *
     * @param int $id ID de l'enregistrement à supprimer
     */
    public function delete($id = null) {
        $this->Registrepassation->id = $id;

        if (!$this->Registrepassation->exists()) {
            throw new NotFoundException(__('Enregistrement introuvable.'));
        }

        $this->request->allowMethod('post', 'delete'); // Autoriser uniquement POST ou DELETE

        if ($this->Registrepassation->saveField('deleted', 1)) {
            $this->Flash->success(__('L’enregistrement a été supprimé.'));
        } else {
            $this->Flash->error(__('Impossible de supprimer l’enregistrement.'));
        }

        return $this->redirect(['action' => 'index']);
    }



	  /**
     * Ajouter un nouvel enregistrement
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Registrepassation->create(); // Préparer un nouvel enregistrement

            // Si l'enregistrement est sauvegardé avec succès
            if ($this->Registrepassation->save($this->request->data)) {
                $this->Flash->success(__('Le registre a été ajouté avec succès.'));
                return $this->redirect(['action' => 'index']); // Rediriger vers l'index
            }

            // Message d'erreur si la sauvegarde échoue
            $this->Flash->error(__('Impossible d’ajouter le registre. Veuillez réessayer.'));
        }

        // Préparer les données pour les listes déroulantes
        $users = $this->User->find('list'); // Liste des utilisateurs
        $depots = $this->Depot->find('list'); // Liste des dépôts

        // Envoi des données à la vue
        $this->set(compact('users', 'depots'));
    }


	
}
