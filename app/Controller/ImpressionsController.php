<?php

require '../../vendor/autoload.php';
class ImpressionsController extends AppController
{
    public $uses = ['Commandeglovo', 'Produit', 'Commandeglovodetail', 'Client'];

    public function index()
    {
    }

    public function impression()
    {
        $this->layout = false;
    }

    public function scan($code_barre = null, $depot_id = null)
    {
        $response['error'] = true;

        $response['data']['libelle'] = null;
        $response['data']['dlc'] = null;
        $longeur = strlen($code_barre);
        $this->loadModel('Parametreste');
        $params = $this->Parametreste->findList();
        $cb_identifiant = (isset($params['cb_identifiant']) and !empty($params['cb_identifiant'])) ? $params['cb_identifiant'] : '2900';
        $cb_produit_depart = (isset($params['cb_produit_depart']) and !empty($params['cb_produit_depart'])) ? $params['cb_produit_depart'] : 4;
        $cb_produit_longeur = (isset($params['cb_produit_longeur']) and !empty($params['cb_produit_longeur'])) ? $params['cb_produit_longeur'] : 3;
        $cb_quantite_depart = (isset($params['cb_quantite_depart']) and !empty($params['cb_quantite_depart'])) ? $params['cb_quantite_depart'] : 7;
        $cb_quantite_longeur = (isset($params['cb_quantite_longeur']) and !empty($params['cb_quantite_longeur'])) ? $params['cb_quantite_longeur'] : 5;
        $cb_div_kg = (isset($params['cb_div_kg']) and !empty($params['cb_div_kg']) and $params['cb_div_kg'] > 0) ? (int) $params['cb_div_kg'] : 1000;
        $identifiant = substr(trim($code_barre), 0, 4);
        if ($cb_identifiant != $identifiant) {
            $response['message'] = "Identifiant du code à barre est incorrect , veuillez vérifier votre paramétrage d'application !";
        } else {
            $code_article = substr(trim($code_barre), $cb_produit_depart, $cb_produit_longeur);

            $produit = $this->Produit->find('first', [
                    'fields' => ['Produit.*'],
                    'conditions' => ['Produit.code_barre' => $code_article],
                ]);
            if (!isset($produit['Produit']['id'])) {
                $response['message'] = 'Code a barre incorrect produit introuvable !';
            } else {
                $response['error'] = false;
                $response['data']['libelle'] = $produit['Produit']['libelle'];

                $dlc_jours = (isset($produit['Produit']['dlc_jours'])) ? $produit['Produit']['dlc_jours'] : 0;
                $dlc_mois = (isset($produit['Produit']['dlc_mois'])) ? $produit['Produit']['dlc_mois'] : 0;
                $dlc_annees = (isset($produit['Produit']['dlc_annees'])) ? $produit['Produit']['dlc_annees'] : 0;
                $dlc_heures = (isset($produit['Produit']['dlc_heures'])) ? $produit['Produit']['dlc_heures'] : 0;

                $dateVal = date('Y-m-d H:i:s', strtotime("+$dlc_annees year $dlc_mois months $dlc_jours days  $dlc_heures hours"));
                //date_add($dateVal, date_interval_create_from_date_sring('2 months + 10 days'));
                $response['data']['dlc'] = $dateVal;
            }
        }

        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }

    public function etiquette($code_barre = null, $libelle = null, $quantite = null, $lot = null)
    {
        $dlc = $_POST['dlc'];

        $this->loadModel('Parametreste');
        $params = $this->Parametreste->findList();
        $cb_identifiant = (isset($params['cb_identifiant']) and !empty($params['cb_identifiant'])) ? $params['cb_identifiant'] : '2900';
        $cb_produit_depart = (isset($params['cb_produit_depart']) and !empty($params['cb_produit_depart'])) ? $params['cb_produit_depart'] : 4;
        $cb_produit_longeur = (isset($params['cb_produit_longeur']) and !empty($params['cb_produit_longeur'])) ? $params['cb_produit_longeur'] : 3;
        $cb_quantite_depart = (isset($params['cb_quantite_depart']) and !empty($params['cb_quantite_depart'])) ? $params['cb_quantite_depart'] : 7;
        $cb_quantite_longeur = (isset($params['cb_quantite_longeur']) and !empty($params['cb_quantite_longeur'])) ? $params['cb_quantite_longeur'] : 5;
        $cb_div_kg = (isset($params['cb_div_kg']) and !empty($params['cb_div_kg']) and $params['cb_div_kg'] > 0) ? (int) $params['cb_div_kg'] : 1000;
        $identifiant = substr(trim($code_barre), 0, 4);
        if ($cb_identifiant != $identifiant) {
            $response['message'] = "Identifiant du code à barre est incorrect , veuillez vérifier votre paramétrage d'application !";
        } else {
            $code_article = substr(trim($code_barre), $cb_produit_depart, $cb_produit_longeur);

            $produit = $this->Produit->find('first', [
                    'fields' => ['Produit.*'],
                    'conditions' => ['Produit.code_barre' => $code_article],
                ]);
            if (!isset($produit['Produit']['id'])) {
                $this->Session->setFlash('Code a barre incorrect produit introuvable !', 'alert-danger');

                return $this->redirect($this->referer());
            }
        }
        $code_barre = substr(trim($code_barre), 0, 7);

        if ($produit['Produit']['pese'] == '1') {
            $quantite = $quantite * 1000;
        }

        $code_barre = intval($code_barre) * 100000;
        $code_barre = $code_barre + $quantite;
        $code_barre = str_pad($code_barre, 13, '1', STR_PAD_RIGHT);

        $societe = $this->GetSociete();

        $this->set(compact('societe', 'libelle', 'quantite', 'dlc', 'lot', 'code_barre', 'impr_codebar'));
        $this->layout = false;
    }
}
