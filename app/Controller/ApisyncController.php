<?php
class ApisyncController extends AppController {

        public $idModule = 130;
        public $uses = ['Produit', 'Role', 'Commandeglovo', 'Remiseclient', 'User', 'Salepoint', 'Sessionuser', 'Caisse', 'Attente', 'Commande', 'Parametreste', 'Ecommerce', 'Optionproduit', 'Typeconditionnementtproduit', 'Store'];
        public $notice = 0;
        public $created_at;
    
        public function beforeFilter()
        {
            parent::beforeFilter();
            //$this->Auth->allow();
        }



	public function apiGetSalesToSync($store_id = null, $caisse_id = null, $salepoint_id = null)
	{
		$store_id = $this->Session->read('Auth.User.StoreSession.id');
        $caisse_id = $this->Session->read('caisse_id');

		// Définir le type de réponse
		$this->response->type('json');
        
        $store_id = (int) $this->Session->read('Auth.User.StoreSession.id');
        $caisse_id = (int) $this->Session->read('caisse_id');

        // Récupérer les données de la table "Salepoint"
        $salepoints = $this->Salepoint->find('all',[
            'conditions' => [
                'Salepoint.sync' => 0, // 0 = les elements non sync
                'Salepoint.store' => $store_id,
                'Salepoint.caisse_id' => $caisse_id,
                'Salepoint.deleted' => 0,
            ]
        ]);


		// Afficher les données en format JSON
		echo json_encode($salepoints);
        
		// Arrêter le rendu de la vue
		return $this->response;
	}


}