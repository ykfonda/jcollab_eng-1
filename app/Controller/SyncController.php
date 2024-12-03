<?php
class SyncController extends AppController
{
  
    public $uses = ["Salepoint","Salepointdetail","Ecommerce","Commande"];
    

    public function index()
    {
        $conn = new mysqli("5.153.23.19","iafjb_test_user","l5FjGl2OnBPWhupR","iafjb_test_database");
         $settings = [
			'contain'=>['Salepointdetail',"Avance","Caisse" => ["Societe"],"Store"],
            'conditions' => ["Salepoint.sync" => 0]
		]; 
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          
		$salepoints = $this->Salepoint->find('all',$settings);
        $msg_salepoint = "";
        $msg_salepoint_d = "";
        $msg_salepoint_avances = "";
        $msg_salepoint_ecommerce = "";
        if(empty($salepoints)) {
            $msg_salepoint = "Nothing to update";
        }
        $sql = "INSERT INTO salepoints (id, reference, barecode, client_id, commande_id, ecommerce_id, depot_id, etat, paye, onhold, type_vente, print, total_a_payer_ht, total_a_payer_ttc, total_paye, reste_a_payer, total_apres_reduction, total_cmd, montant_remise, remise, montant_tva, rendu, fee, expedition, user_id, date, store, caisse_id, payment_method, boucher, deleted, user_c, date_c, user_u, date_u) VALUES ";

        $sql_d = "INSERT INTO salepointdetails (id, produit_id, client_id, salepoint_id, commandedetail_id, ecommercedetail_id, categorieproduit_id, qte_cmd, qte, prix_vente, unit_price, total, ttc, marge, remise, montant_remise, stat, onhold, deleted, user_c, date_c, user_u, date_u) VALUES ";
        $sql_avances = "INSERT INTO avances (id, reference, numero_piece, emeteur, vente_id, facture_id, user_id, versement_id, bonlivraison_id, bonreception_id, boncommande_id, client_id, salepoint_id, mode, etat, verse, montant, date, date_echeance, deleted, user_c, date_c, user_u, date_u) VALUES ";
        $appmodel = new AppModel();
        $caisses = [];
      
        if (!empty($salepoints)) {
            foreach ($salepoints as $salepoint) {
                //var_dump($salepoint["Salepoint"]["id"]);
                $caisse = $salepoint["Caisse"]["libelle"];
                if(isset($salepoint["Societe"]["designation"]))
                    $societe = $salepoint["Societe"]["designation"];
                else $societe = null;
                if($caisse != null and $salepoint["Store"]["libelle"] != null)
                $caisses[$caisse] = [$salepoint["Store"]["libelle"],$societe];
                $id = "''";
                $ref = !empty($salepoint["Salepoint"]["reference"]) ? "'" . $salepoint["Salepoint"]["reference"] . "'" : 'NULL';
                $barecode = !empty($salepoint["Salepoint"]["barecode"]) ? $salepoint["Salepoint"]["barecode"] : 'NULL';
                $client_id = !empty($salepoint["Salepoint"]["client_id"]) ? $salepoint["Salepoint"]["client_id"] : 'NULL';
                $commande_id = !empty($salepoint["Salepoint"]["commande_id"]) ? $salepoint["Salepoint"]["commande_id"] : 'NULL';
                $ecommerce_id = !empty($salepoint["Salepoint"]["ecommerce_id"]) ? $salepoint["Salepoint"]["ecommerce_id"] : 'NULL';
                $depot_id = !empty($salepoint["Salepoint"]["depot_id"]) ? $salepoint["Salepoint"]["depot_id"] : 'NULL';
                $etat = !empty($salepoint["Salepoint"]["etat"]) ? $salepoint["Salepoint"]["etat"] : -1;
                $paye = !empty($salepoint["Salepoint"]["paye"]) ? $salepoint["Salepoint"]["paye"] : -1;
                $onhold = !empty($salepoint["Salepoint"]["onhold"]) ? $salepoint["Salepoint"]["onhold"] : -1;
                $type_vente = !empty($salepoint["Salepoint"]["type_vente"]) ? $salepoint["Salepoint"]["type_vente"] : -1;
                $print = !empty($salepoint["Salepoint"]["print"]) ? $salepoint["Salepoint"]["print"] : -1;
                $total_a_payer_ht = !empty($salepoint["Salepoint"]["total_a_payer_ht"]) ? $salepoint["Salepoint"]["total_a_payer_ht"] : 0;
                $total_a_payer_ttc = !empty($salepoint["Salepoint"]["total_a_payer_ttc"]) ? $salepoint["Salepoint"]["total_a_payer_ttc"] : 0;
                $total_paye = !empty($salepoint["Salepoint"]["total_paye"]) ? $salepoint["Salepoint"]["total_paye"] : 0;
                $reste_a_payer = !empty($salepoint["Salepoint"]["reste_a_payer"]) ? $salepoint["Salepoint"]["reste_a_payer"] : 0;
                $total_apres_reduction = !empty($salepoint["Salepoint"]["total_apres_reduction"]) ? $salepoint["Salepoint"]["total_apres_reduction"] : 0;
                $total_cmd = !empty($salepoint["Salepoint"]["total_cmd"]) ? $salepoint["Salepoint"]["total_cmd"] : 'NULL';
                $montant_remise = !empty($salepoint["Salepoint"]["montant_remise"]) ? $salepoint["Salepoint"]["montant_remise"] : 0;
                $remise = !empty($salepoint["Salepoint"]["remise"]) ? $salepoint["Salepoint"]["remise"] : 'NULL';
                $montant_tva = !empty($salepoint["Salepoint"]["montant_tva"]) ? $salepoint["Salepoint"]["montant_tva"] : 'NULL';
                $rendu = !empty($salepoint["Salepoint"]["rendu"]) ? $salepoint["Salepoint"]["rendu"] : 'NULL';
                $fee = !empty($salepoint["Salepoint"]["fee"]) ? $salepoint["Salepoint"]["fee"] : 0;
                $expedition = !empty($salepoint["Salepoint"]["expedition"]) ? "'" . $salepoint["Salepoint"]["expedition"] . "'" : 'NULL';
                $user_id = !empty($salepoint["Salepoint"]["user_id"]) ? $salepoint["Salepoint"]["user_id"] : 'NULL';
                $date = !empty($salepoint["Salepoint"]["date"]) ? "'" . $appmodel->dateTimeFormatBeforeSave($salepoint["Salepoint"]["date"]) . "'" : 'NULL';
                $store = !empty($salepoint["Salepoint"]["store"]) ? $salepoint["Salepoint"]["store"] : 'NULL';
                $caisse_id = !empty($salepoint["Salepoint"]["caisse_id"]) ? $salepoint["Salepoint"]["caisse_id"] : 'NULL';
                $payment_method = !empty($salepoint["Salepoint"]["payment_method"]) ? "'" . $salepoint["Salepoint"]["payment_method"] . "'" : 'NULL';
                $boucher = !empty($salepoint["Salepoint"]["boucher"]) ? $salepoint["Salepoint"]["boucher"] : 'NULL';
                $deleted = !empty($salepoint["Salepoint"]["deleted"]) ? $salepoint["Salepoint"]["deleted"] : 0;
                $user_c = !empty($salepoint["Salepoint"]["user_c"]) ? $salepoint["Salepoint"]["user_c"] : 'NULL';
                $date_c = !empty($salepoint["Salepoint"]["date_c"]) ? "'" . $appmodel->dateTimeFormatBeforeSave($salepoint["Salepoint"]["date_c"]) . "'" : 'NULL';
                $user_u = !empty($salepoint["Salepoint"]["user_u"]) ? $salepoint["Salepoint"]["user_u"] : 'NULL';
                $date_u = !empty($salepoint["Salepoint"]["date_u"]) ? "'" .  $salepoint["Salepoint"]["date_u"] . "'" : 'NULL';

                $sql .= "(NULL,$ref, $barecode, $client_id, $commande_id, $ecommerce_id, $depot_id, $etat, $paye, $onhold, $type_vente, $print, $total_a_payer_ht, $total_a_payer_ttc, $total_paye, $reste_a_payer, $total_apres_reduction, $total_cmd, $montant_remise, $remise, $montant_tva, $rendu, $fee, $expedition, $user_id, $date, $store, $caisse_id, $payment_method, '$boucher', $deleted, $user_c, $date_c, $user_u, $date_u),";
            
           
                foreach ($salepoint["Salepointdetail"] as $salepoint_d) {
                    //var_dump($salepoint_d["id"]);
                    $produit_id = !empty($salepoint_d["produit_id"]) ? $salepoint_d["produit_id"] : 'NULL';
                    $client_id = !empty($salepoint_d["client_id"]) ? $salepoint_d["produit_id"] : 'NULL';
                    $salepoint_id = !empty($salepoint_d["salepoint_id"]) ? $salepoint_d["salepoint_id"] : 'NULL';
                    $commandedetail_id = !empty($salepoint_d["commandedetail_id"]) ? $salepoint_d["commandedetail_id"] : 'NULL';
                    $ecommercedetail_id = !empty($salepoint_d["ecommercedetail_id"]) ? $salepoint_d["ecommercedetail_id"] : 'NULL';
                    $categorieproduit_id = !empty($salepoint_d["categorieproduit_id"]) ? $salepoint_d["categorieproduit_id"] : 'NULL';
                    $qte_cmd = !empty($salepoint_d["qte_cmd"]) ? $salepoint_d["qte_cmd"] : 'NULL';
                    $qte = !empty($salepoint_d["qte"]) ? $salepoint_d["qte"] : 'NULL';
                    $prix_vente = !empty($salepoint_d["prix_vente"]) ? $salepoint_d["prix_vente"] : 'NULL';
                    $unit_price = !empty($salepoint_d["unit_price"]) ? $salepoint_d["unit_price"] : 'NULL';
                    $total = !empty($salepoint_d["total"]) ? $salepoint_d["total"] : 'NULL';
                    $ttc = !empty($salepoint_d["ttc"]) ? $salepoint_d["ttc"] : 'NULL';
                    $marge = !empty($salepoint_d["marge"]) ? $salepoint_d["marge"] : 'NULL';
                    $remise = !empty($salepoint_d["remise"]) ? $salepoint_d["remise"] : 'NULL';
                    $montant_remise = !empty($salepoint_d["montant_remise"]) ? $salepoint_d["montant_remise"] : 'NULL';
                    $stat = !empty($salepoint_d["stat"]) ? $salepoint_d["stat"] : 'NULL';
                    $onhold = !empty($salepoint_d["onhold"]) ? $salepoint_d["onhold"] : 'NULL';
                    $deleted = !empty($salepoint_d["deleted"]) ? $salepoint_d["deleted"] : 'NULL';
                    $user_c = !empty($salepoint_d["user_c"]) ? $salepoint_d["user_c"] : 'NULL';
                    $date_c = !empty($salepoint_d["date_c"]) ? "'" . $appmodel->dateTimeFormatBeforeSave($salepoint_d["date_c"]) . "'" : 'NULL';
                    $user_u = !empty($salepoint_d["user_u"]) ? $salepoint_d["user_u"] : 'NULL';
                    $date_u = !empty($salepoint_d["date_u"]) ? "'" . $salepoint_d["date_u"] . "'" : 'NULL';
               
                    $sql_d .= "(NULL,$produit_id, $client_id, $salepoint_id, $commandedetail_id, $ecommercedetail_id, $categorieproduit_id, $qte_cmd, $qte, $prix_vente, $unit_price, $total, $ttc, $marge, $remise, $montant_remise, $stat, $onhold, $deleted, $user_c, $date_c, $user_u, $date_u),";
                }

            
           
                foreach ($salepoint["Avance"] as $avance) {
                    $reference = !empty($avance["reference"]) ? $avance["reference"] : 'NULL';
                    $numero_piece = !empty($avance["numero_piece"]) ? $avance["numero_piece"] : 'NULL';
                    $emeteur = !empty($avance["emeteur"]) ? $avance["emeteur"] : 'NULL';
                    $vente_id = !empty($avance["vente_id"]) ? $avance["vente_id"] : 'NULL';
                    $facture_id = !empty($avance["facture_id"]) ? $avance["facture_id"] : 'NULL';
                    $user_id = !empty($avance["user_id"]) ? $avance["user_id"] : 'NULL';
                    $versement_id = !empty($avance["versement_id"]) ? $avance["versement_id"] : 'NULL';
                    $bonlivraison_id = !empty($avance["bonlivraison_id"]) ? $avance["bonlivraison_id"] : 'NULL';
                    $bonreception_id = !empty($avance["bonreception_id"]) ? $avance["bonreception_id"] : 'NULL';
                    $boncommande_id = !empty($avance["boncommande_id"]) ? $avance["boncommande_id"] : 'NULL';
                    $client_id = !empty($avance["client_id"]) ? $avance["client_id"] : 'NULL';
                    $salepoint_id = !empty($avance["salepoint_id"]) ? $avance["salepoint_id"] : 'NULL';
                    $mode = !empty($avance["mode"]) ? $avance["mode"] : 'NULL';
                
                    $montant = !empty($avance["montant"]) ? $avance["montant"] : 'NULL';
                    $date = !empty($avance["date"]) ? $appmodel->dateFormatBeforeSave($avance["date"]) : 'NULL';
                    $date_echeance = !empty($avance["date_echeance"]) ? $avance["date_echeance"] : 'NULL';
                    $user_c = !empty($avance["user_c"]) ? $avance["user_c"] : 'NULL';
                    $date_c = !empty($avance["date_c"]) ? $avance["date_c"] : 'NULL';
                    $user_u = !empty($avance["user_u"]) ? $avance["user_u"] : 'NULL';
                    $date_u = !empty($avance["date_u"]) ? $avance["date_u"] : "NULL";
                
                    $etat = !empty($avance["etat"]) ? $avance["etat"] : -1;
                    $verse = !empty($avance["verse"]) ? $avance["verse"] : -1;
                    $deleted = !empty($avance["deleted"]) ? $avance["deleted"] : 0;
                

                    $sql_avances .= "(NULL,'$reference', $numero_piece, $emeteur, $vente_id, $facture_id, $user_id, $versement_id, $bonlivraison_id, $bonreception_id, $boncommande_id, $client_id, $salepoint_id, '$mode', $etat, $verse, $montant, '$date', $date_echeance, $deleted, '$user_c', '$date_c', $user_u,  $date_u),";
                }
            }
        }
        //update
        $this->Salepoint->updateAll(['Salepoint.sync'=>1],['Salepoint.sync'=>0]);

        $settings = [
			'conditions' => ["Ecommerce.sync" => 0]
		]; 
        $ecommerces = $this->Ecommerce->find('all',$settings);
        $sql_ecommerce = "INSERT INTO ecommerces (id, reference, barcode, payment_method, shipment, client_id, adresse, facture_id, depot_id, bonlivraison_id, online_id, etat, total_qte, fee, total_a_payer_ht, total_a_payer_ttc, total_paye, reste_a_payer, montant_remise, total_apres_reduction, remise, montant_tva, active_remise, user_id, date, statut, deleted, user_c, date_c, user_u, date_u, store_id) VALUES ";
        if (!empty($ecommerces)) {        
            $sql_tr  = "TRUNCATE TABLE ecommerces";

      
            if ($conn->query($sql_tr) === true) {
                foreach ($ecommerces as $ecommerce) {
                    $reference = !empty($ecommerce["Ecommerce"]["reference"]) ? $ecommerce["Ecommerce"]["reference"] : 'NULL';
                    $barcode = !empty($ecommerce["Ecommerce"]["barcode"]) ? $ecommerce["Ecommerce"]["barcode"] : 'NULL';
                    $payment_method = !empty($ecommerce["Ecommerce"]["payment_method"]) ? $ecommerce["Ecommerce"]["payment_method"] : 'NULL';
                    $shipment = !empty($ecommerce["Ecommerce"]["shipment"]) ? $ecommerce["Ecommerce"]["shipment"] : 'NULL';
                    $adresse = !empty($ecommerce["Ecommerce"]["adresse"]) ?  $conn->real_escape_string($ecommerce["Ecommerce"]["adresse"]) : 'NULL';
                    $client_id = !empty($ecommerce["Ecommerce"]["client_id"]) ?  $ecommerce["Ecommerce"]["client_id"] : 'NULL';
                    $facture_id = !empty($ecommerce["Ecommerce"]["facture_id"]) ? $ecommerce["Ecommerce"]["facture_id"] : 'NULL';
                    $depot_id = !empty($ecommerce["Ecommerce"]["depot_id"]) ? $ecommerce["Ecommerce"]["depot_id"] : 'NULL';
                    $bonlivraison_id = !empty($ecommerce["Ecommerce"]["bonlivraison_id"]) ? $ecommerce["Ecommerce"]["bonlivraison_id"] : 'NULL';
                    $online_id = !empty($ecommerce["Ecommerce"]["online_id"]) ? $ecommerce["Ecommerce"]["online_id"] : 'NULL';
                    $etat = !empty($ecommerce["Ecommerce"]["etat"]) ? $ecommerce["Ecommerce"]["etat"] : 'NULL';
                    $total_qte = !empty($ecommerce["Ecommerce"]["total_qte"]) ? $ecommerce["Ecommerce"]["total_qte"] : 'NULL';
                    $fee = !empty($ecommerce["Ecommerce"]["fee"]) ? $ecommerce["Ecommerce"]["fee"] : 'NULL';
                    $total_a_payer_ht = !empty($ecommerce["Ecommerce"]["total_a_payer_ht"]) ? $ecommerce["Ecommerce"]["total_a_payer_ht"] : 'NULL';
                    $total_a_payer_ttc = !empty($ecommerce["Ecommerce"]["total_a_payer_ttc"]) ? $ecommerce["Ecommerce"]["total_a_payer_ttc"] : 'NULL';
                    $total_paye = !empty($ecommerce["Ecommerce"]["total_paye"]) ? $ecommerce["Ecommerce"]["total_paye"] : 'NULL';
                    $reste_a_payer = !empty($ecommerce["Ecommerce"]["reste_a_payer"]) ? $ecommerce["Ecommerce"]["reste_a_payer"] : 'NULL';
                    $montant_remise = !empty($ecommerce["Ecommerce"]["montant_remise"]) ? $ecommerce["Ecommerce"]["montant_remise"] : 'NULL';
                    $total_apres_reduction = !empty($ecommerce["Ecommerce"]["total_apres_reduction"]) ? $ecommerce["Ecommerce"]["total_apres_reduction"] : 'NULL';
                    $remise = !empty($ecommerce["Ecommerce"]["remise"]) ? $ecommerce["Ecommerce"]["remise"] : 'NULL';
                    $montant_tva = !empty($ecommerce["Ecommerce"]["montant_tva"]) ? $ecommerce["Ecommerce"]["montant_tva"] : 'NULL';
                    $active_remise = !empty($ecommerce["Ecommerce"]["active_remise"]) ? $ecommerce["Ecommerce"]["active_remise"] : 'NULL';
                    $user_id = !empty($ecommerce["Ecommerce"]["user_id"]) ? $ecommerce["Ecommerce"]["user_id"] : 'NULL';
                    $date = !empty($ecommerce["Ecommerce"]["date"]) ? $appmodel->dateFormatBeforeSave($ecommerce["Ecommerce"]["date"]) : 'NULL';
                    $statut = !empty($ecommerce["Ecommerce"]["statut"]) ? $ecommerce["Ecommerce"]["statut"] : 'NULL';
                    $deleted = !empty($ecommerce["Ecommerce"]["deleted"]) ? $ecommerce["Ecommerce"]["deleted"] : 'NULL';
                    $user_c = !empty($ecommerce["Ecommerce"]["user_c"]) ? $ecommerce["Ecommerce"]["user_c"] : 'NULL';
                    $date_c = !empty($ecommerce["Ecommerce"]["date_c"]) ? "'" . $appmodel->dateTimeFormatBeforeSave($ecommerce["Ecommerce"]["date_c"]) . "'" : 'NULL';
                    $user_u = !empty($ecommerce["Ecommerce"]["user_u"]) ? $ecommerce["Ecommerce"]["user_u"] : 'NULL';
                    $date_u = !empty($ecommerce["Ecommerce"]["date_u"]) ? "'" . $ecommerce["Ecommerce"]["date_u"] . "'" : 'NULL';
                    $store_id = !empty($ecommerce["Ecommerce"]["store_id"]) ? $ecommerce["Ecommerce"]["store_id"] : 'NULL';
                
                    $sql_ecommerce .= "(NULL,'$reference', '$barcode', '$payment_method', '$shipment', $client_id, '$adresse', $facture_id, $depot_id, $bonlivraison_id, $online_id, '$etat', $total_qte, $fee, $total_a_payer_ht, $total_a_payer_ttc, $total_paye, $reste_a_payer, $montant_remise, $total_apres_reduction, $remise,$montant_tva, $active_remise,  $user_id,'$date', '$statut', $deleted, $user_c, $date_c, $user_u,  $date_u, $store_id),";
                }
            }
        }

        //update
        $this->Ecommerce->updateAll(['Ecommerce.sync'=>1],['Ecommerce.sync'=>0]);

       //var_dump($sql_ecommerce);die();
        $sql = substr_replace($sql ,"",-1);
        $sql .= ";";
        $sql_d = substr_replace($sql_d ,"",-1);
        $sql_d .= ";";
        $sql_avances = substr_replace($sql_avances ,"",-1);
        $sql_avances .= ";";
        $sql_ecommerce = substr_replace($sql_ecommerce ,"",-1);
        $sql_ecommerce .= ";";
        

        $sql_journal = "INSERT INTO journal (id, caisse, store, societe, date_sync, message_sync) VALUES ";
        $caisse = "NULL";
        $store = "NULL";
        $societe = "NULL";
        $date_sync = date('Y-m-d H:i:s');
        $message_sync = "";

        $msg = "";
        if($msg_salepoint == "Nothing to update") {
            
            $msg = "Nothing to update";
            $sql_journal .= "(NULL, $caisse,$store, $societe, '$date_sync','Nothing to update')";
            if ($conn->query($sql_journal) !== true) {
                $msg = "Erreur de connection a la base distante";
            }
            echo $msg;
            die();
        }
        else {
            if ($conn->query($sql) !== true) {
                $msg = "Erreur de connection a la base distante";
            }
        }

        $rest_details = substr($sql_d, -7);
        if($rest_details != "VALUES ") {
            if ($conn->query($sql_d) !== true) {
                $msg = "Erreur de connection a la base distante";
            }
        } 
        $rest_avance = substr($sql_avances, -7);
        if($rest_avance != "VALUES ") {
            if ($conn->query($sql_avances) !== true) {
                $msg = "Erreur de connection a la base distante";
            }
        } 
        if(!empty($ecommerces)) {
            if ($conn->query($sql_ecommerce) !== true) {
                $msg = "Erreur de connection a la base distante";
            }
        }
        
       
        if (!empty($caisses)) {
           
            foreach($caisses as $key => $value) {
                $caisse = $key;
                $store = $value[0];
                $societe = !empty($value[1]) ? $value[1] : "NULL";
                $sql_journal .= "(NULL, '$caisse','$store', '$societe', '$date_sync','Sync succesfull'),";
                
            }
            $sql_journal = substr_replace($sql_journal ,"",-1);
            $sql_journal .= ";";
            if ($conn->query($sql_journal) !== true) {
                echo "Error: " . $sql_journal . "<br>" . $conn->error;
            }
            else {
                $msg = "Sync succesfull!";
            }
            
        }
        echo $msg;
        die();
        
        /* if ($conn->query($sql_ecommerce) === TRUE) {
            echo "New records created successfully";
          } else {
            echo "Error: " . $sql_ecommerce . "<br>" . $conn->error;
          } */
          die();
    }
}
?>