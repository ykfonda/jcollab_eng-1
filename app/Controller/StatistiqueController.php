<?php
class StatistiqueController extends AppController {
	public $idModule = 126;

    public function index() {

		
		$this->loadModel('Salepoint');
		$this->loadModel('Avance');
		$this->loadModel('StatStore');


        if ($this->request->is('post') && !empty($this->request->data)) {



            $data = $this->request->data;

            // Valider les dates
            $startDate = isset($data['Event']['start_date']) ? $data['Event']['start_date'] : null;
            $endDate = isset($data['Event']['end_date']) ? $data['Event']['end_date'] : null;





            if (!$this->validateDates($startDate, $endDate)) {
                $this->Flash->error(__('Invalid date range. Please correct and try again.'));
                return $this->redirect(array('action' => 'index'));
            }



            // Convertir les dates au format adapté pour la requête SQL
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));


            // Construire la requête SQL
			$sql = "
			SELECT
			        s.store AS store_id,
        Date(s.date) AS salepoint_date,
				(SELECT store.libelle FROM stores store WHERE store.id = s.store) AS magasin,
				SUM(total_a_payer_ht) AS Totalht,
				SUM(total_apres_reduction - montant_remise) AS Totalttc,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND s.reference NOT LIKE '%T09%' AND (a.mode = 'espece' or a.mode = 'cod'))) AS especes,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND s.reference LIKE '%T09%')) AS fdcaisse,
				SUM((SELECT (s3.total_apres_reduction - s3.montant_remise) FROM salepoints s3 WHERE s3.id = s.id AND s3.ecommerce_id != 0)) AS ecommerce,
				SUM((SELECT (s5.total_apres_reduction - s5.montant_remise) FROM salepoints s5 WHERE s5.id = s.id AND s5.glovo_id != 0)) AS glovo,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'wallet')) AS wallet,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode IN ('Carte', 'cmi', 'tpe'))) AS carte,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'cheque')) AS cheque,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'bon_achat')) AS bachat,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'cheque_cadeau')) AS ccadeau,
				SUM(CASE
    				WHEN remise = 100 THEN montant_remise
    				ELSE 0
    				END 
				) AS offert,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'delayed')) AS credit,
				SUM((SELECT SUM(a.montant) FROM avances a WHERE a.salepoint_id = s.id AND a.mode = 'virement')) AS virement,
				SUM(CASE
    				WHEN remise = 100 THEN 0
    				ELSE montant_remise
    				END 
				) AS remise,
				(SELECT SUM(s4.total_apres_reduction - s4.montant_remise) FROM salepoints s4 WHERE s4.etat = 3 AND s4.store = s.store AND DATE(s4.date) = DATE(s.date)) AS annules
			FROM salepoints s
			WHERE s.store != 0
				AND s.etat = 2
				AND DATE(s.date) >= '$startDate'
				AND DATE(s.date) <= '$endDate'
			GROUP BY s.store, Date(s.date);
		";
		



			// Exécuter la requête SQL à l'aide du modèle approprié
			$results = $this->StatStore->query($sql);

			// Supprimer les données existantes dans la plage de dates spécifiée
			$this->StatStore->deleteAll(
				array('date BETWEEN ? AND ?' => array($startDate, $endDate)),
				false // Ajoutez cette option pour ignorer la suppression logique
			);


			foreach ($results as $result) {

				$storeId = $result['s']['store_id'];
				//$salepointDate = $result['s']['salepoint_date'];
					
				// Construire les données à insérer dans la table stat_store
				$data = array(
					'storeid' => $storeId,
					'libelle' => $result[0]['magasin'],
					'date' => $result[0]['salepoint_date'],
					//'date' => $salepointDate,
					'totalht' => $result[0]['Totalht'],
					'totalttc' => $result[0]['Totalttc'],
					'fdcaisse' => $result[0]['fdcaisse'],
					'especes' => $result[0]['especes'],
					'carte' => $result[0]['carte'],
					'cheque' => $result[0]['cheque'],
					'wallet' => $result[0]['wallet'],
					'virement' => $result[0]['virement'],
					'bachat' => $result[0]['bachat'],
					'ccadeau' => $result[0]['ccadeau'],
					'offert' => $result[0]['offert'],
					'ecommerce' => $result[0]['ecommerce'],
					'glovo' => $result[0]['glovo'],
					'remise' => $result[0]['remise'],
					'annules' => $result[0]['annules'],
					'credit' => $result[0]['credit'],
					'created' => date('Y-m-d H:i:s')
				);
	

			// Si la valeur est null, remplacez-la par 0.00
			foreach ($data as $key => $value) {
				if ($value === null) {
					$data[$key] = '0.00';
				}
			}

			
				// Insérer les données dans la table stat_store
				$this->StatStore->create();
				if (!$this->StatStore->save($data)) {
					// Gérer les erreurs d'insertion si nécessaire
					$this->Flash->error(__('Erreur lors de l\'enregistrement des données.'));
				}
			}
			
			
		

            // Passer les résultats à la vue
            $this->set(compact('results'));
        }
    }





    // Méthode de validation des dates
    private function validateDates($startDate, $endDate) {
        if (!empty($startDate) && !empty($endDate)) {
            $start = strtotime($startDate);
            $end = strtotime($endDate);
            if ($start !== false && $end !== false && $start <= $end) {
                return true;
            }
        }
        return false;
    }
}
?>
