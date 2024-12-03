<?php

App::uses('Helper', 'View');
class AppHelper extends Helper
{
    public function convertToList($Array = [], $key = 'libelle')
    {
        $string = '';
        $arrKey = [];

        if (strpos($key, '.') !== false) {
            $arrKey = split('\.', $key);
        }
        foreach ($Array as $k => $v) {
            if (!empty($arrKey)) {
                $string .= $v[$arrKey[0]][$arrKey[1]];
            } else {
                $string .= $v[$key];
            }
            $string .= (isset($Array[$k + 1])) ? ', ' : '';
        }

        return $string;
    }

    public function getTypeVente($k = null)
    {
        $Arr = [-1 => 'Directe', 1 => 'Commande client', 2 => 'E-Commerce'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getNature($k = null)
    {
        $Arr = [1 => 'Restaurant', 2 => 'Point de vente'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getNatureProduit($k = null)
    {
        $Arr = [1 => 'Restaurant', 2 => 'Point de vente', 3 => 'Les deux'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getDelimiteur($k = null)
    {
        $Arr = [',' => 'Virgule', ';' => 'Point-Virgule'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatCommandeGlovo($k = null)
    {
        $Arr = [-1 => 'En attente', 2 => 'Accepté', 3 => 'Annulé', 4 => 'prete pour livraison', 5 => 'prise par le client'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatCommande($k = null)
    {
        $Arr = [-1 => 'En attente', 2 => 'Livré', 3 => 'Annulé', 4 => 'Abondonnée'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatCommandeColor($k = null)
    {
        $Arr = [-1 => '#74b9ff', 2 => '#A3CB38', 3 => '#de6c6c', 4 => '#de6c6c'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatProduit($k = null)
    {
        $Arr = [1 => 'Acheté', 2 => 'Vendu', 3 => 'Acheté & Vendu'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutReception($k = null)
    {
        $Arr = [-1 => 'Non-reçu', 1 => 'Reçu partiellement', 2 => 'Reçu'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutPayment($k = null)
    {
        $Arr = [-1 => 'Impayé', 1 => 'Payé partiellement', 2 => 'Payé', 3 => 'Annulé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getColorPayment($k = null)
    {
        $Arr = [-1 => '#e74c3c', 1 => '#d69847', 2 => '#2ecc71'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function OuiNon($k = null)
    {
        $Arr = [1 => 'Oui', -1 => 'Non'];
        if ($k === null) {
            return $Arr;
        } elseif ($k == 0) {
            return null;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function NonOui($k = null)
    {
        $Arr = [-1 => 'Non', 1 => 'Oui'];
        if ($k === null) {
            return $Arr;
        } elseif ($k == 0) {
            return null;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getSexe($k = null)
    {
        $Arr = ['Masculin' => 'Masculin', 'Féminin' => 'Féminin'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getSituation($k = null)
    {
        $Arr = ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getDevis($k = null)
    {
        $Arr = [1 => 'MAD', 2 => ' EURO', 3 => 'USD'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getModePaiment($k = null)
    {
        $Arr = ['espece' => 'Espèces', 'cod' => 'cod',
         'wallet' => 'Wallet', 'bon_achat' => "Bon d'achat", 'cheque_cadeau' => 'Chèque cadeau',
          'cmi' => 'CMI', 'offert' => 'Offert', 'tpe' => 'Tpe',
          'Carte' => 'Carte', 'delayed' => 'Delayed', 'virement' => 'Virement', 'cheque' => 'Chèque', ];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getModePaiment_ecommerce($k = null)
    {
        $Arr = ['cod' => 'Paiement espèce', 'tpe' => 'Terminal de paiement', 'wallet' => 'E-commerce', 'cmi' => 'Paiement en ligne'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getModeVersement($k = null)
    {
        $Arr = [1 => 'Sur place', 2 => 'Banque'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getAvance($k = null)
    {
        $Arr = [2 => 'Tous', -1 => 'En cours', 1 => 'Validé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatFiche($k = null)
    {
        $Arr = [-1 => 'En cours', 1 => 'En attente de validation', 2 => 'Validé', 3 => 'Annulé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatFicheColor($k = null)
    {
        $Arr = [-1 => '#74b9ff', 1 => '#1289A7', 2 => '#A3CB38', 3 => '#EA2027'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getTypeOperation($k = null)
    {
        $Arr = [-1 => 'Entrée du stock', 1 => 'Sortie du stock', 2 => 'Transfert du stock', 3 => 'Inventaire du stock', 4 => 'Sortie Bon de livraison'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatVersement($k = null)
    {
        $Arr = [-1 => 'En cours', 1 => 'Clôturé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutInventaire($k = null)
    {
        $Arr = [-1 => 'En cours', 1 => 'Clôturé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutInventaireColor($k = null)
    {
        $Arr = [-1 => '#74b9ff', 1 => '#A3CB38'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutAvance($k = null)
    {
        $Arr = [-1 => 'Non-versé', 1 => 'Versé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getStatutAvanceColor($k = null)
    {
        $Arr = [-1 => '#e74c3c', 1 => '#2ecc71'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function format_interval(DateInterval $interval)
    {
        $result = '';
        if ($interval->y) {
            $result .= $interval->format('%y année(s) ');
        }
        if ($interval->m) {
            $result .= $interval->format('%m mois ');
        }
        if ($interval->d) {
            $result .= $interval->format('%d jour(s) ');
        }
        if ($interval->h) {
            $result .= $interval->format('%h heure(s) ');
        }
        if ($interval->i) {
            $result .= $interval->format('%i minute(s) ');
        }
        if ($interval->s) {
            $result .= $interval->format('%s seconds ');
        }

        return $result;
    }

    public function getAnnees($k = null)
    {
        $Arr = [
            date('Y', strtotime('-3 Years')) => date('Y', strtotime('-3 Years')),
            date('Y', strtotime('-2 Years')) => date('Y', strtotime('-2 Years')),
            date('Y', strtotime('-1 Years')) => date('Y', strtotime('-1 Years')),
            date('Y') => date('Y'),
            date('Y', strtotime('+1 Years')) => date('Y', strtotime('+1 Years')),
            date('Y', strtotime('+2 Years')) => date('Y', strtotime('+2 Years')),
            date('Y', strtotime('+3 Years')) => date('Y', strtotime('+3 Years')),
        ];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatRetour($k = null)
    {
        $Arr = [-1 => 'En attente', 1 => 'Saisie terminé', 2 => 'Validé', 3 => 'Clôturé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEtatRetourColor($k = null)
    {
        $Arr = [-1 => '#1289A7', 1 => '#FFC312', 2 => '#A3CB38', 3 => '#EA2027'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getImportance($importance = null)
    {
        $data = [1 => 'Non-évalué', 2 => 'Faible', 3 => 'Moyen', 4 => 'Fort', 5 => 'Trés fort'];
        if ($importance === null) {
            return $data;
        }

        return (isset($data[$importance]) and !empty($data[$importance])) ? $data[$importance] : '';
    }

    public function getDeclaration($declaration = null)
    {
        $data = [1 => 'Retour au stock principale', 2 => 'Retour defectueux'];
        if ($declaration === null) {
            return $data;
        }

        return (isset($data[$declaration]) and !empty($data[$declaration])) ? $data[$declaration] : '';
    }

    public function getClassification($classification = null)
    {
        $data = [1 => 'Gold', 2 => 'Platuim', 3 => 'Silver'];
        if ($classification === null) {
            return $data;
        }

        return (isset($data[$classification]) and !empty($data[$classification])) ? $data[$classification] : '';
    }

    public function getTVA($tva = null)
    {
        $data = [0 => '0%', 10 => '10%', 20 => '20%'];
        if ($tva === null) {
            return $data;
        }

        return (isset($data[$tva]) and !empty($data[$tva])) ? $data[$tva] : '';
    }

    public function getOnline($k = null)
    {
        $Arr = [-1 => 'Offline', 1 => 'Online'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getOnlineColor($k = null)
    {
        $Arr = [-1 => '#e74c3c', 1 => '#2ecc71'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getOrganisme($k = null)
    {
        $Arr = [1 => 'Particulier', 2 => 'Société'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getEntete($k = null)
    {
        $Arr = [1 => 'Afficher désignation text', 2 => 'Afficher logo société'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getValideEntree($k = null)
    {
        $Arr = [-1 => 'En attente', 1 => 'Validé'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }

    public function getValideEntreeColor($k = null)
    {
        $Arr = [-1 => '#1289A7', 1 => '#2ecc71'];
        if ($k === null) {
            return $Arr;
        }

        return (isset($Arr[$k])) ? $Arr[$k] : '';
    }
}
