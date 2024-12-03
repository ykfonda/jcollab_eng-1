<?php
App::import('Vendor', 'dompdf', array('file' => 'dompdf' . DS . 'dompdf_config.inc.php'));
class VentesmagasincomptableController extends AppController
{
    public $uses = ["Salepoint22"];
    public $idModule = 123;
    

    public function index()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');
        $this->loadModel("Store");

        $magasins = $this->Store->find("list");
        
        $this->set(compact('magasins', 'admins'));
        $this->getPath($this->idModule);
    }

    public function indexAjax()
    {
        $role_id = $this->Session->read('Auth.User.role_id');
        $user_id = $this->Session->read('Auth.User.id');
        $admins = $this->Session->read('admins');
        $date1 = 0;$date2 = 0;$magasin_id = 0;
        $arr = [];
        $arr["date1"] = null;
        $arr["date2"] = null;
        $arr["magasin_id"] = null;
        $conditions['Salepoint.etat'] = [2,3];
        /* if ( in_array($role_id, $admins) ) $conditions['Salepoint.etat'] = [2,3];
        else $conditions['Salepoint.user_c'] = $user_id;
 */

        foreach ($this->params['named'] as $param_name => $value) {
           
                 if ($param_name == 'Salepoint2.magasin_id') {
                    /* $this->loadModel("Store");
                    $stores = $this->Store->find("all", ["conditions" => ["societe_id" => $value]]);
                    $stores_id = [];
                    foreach ($stores as $store) {
                        $stores_id[] = $store["Store"]["id"];
                    }
                    $conditions['Salepoint.store'] = $stores_id;
 */                   $arr["magasin_id"] = $value;
                      $magasin_id = $value;
 
                 } 
                 if ($param_name == 'Salepoint2.date1') {
                    $arr["date1"] = date('Y-m-d H:i:s', strtotime($value.' 00:00:00'));
                    $date1 = date('Y-m-d H:i:s', strtotime($value.' 00:00:00'));
                } if ($param_name == 'Salepoint2.date2') {
                    //$arr["date2"] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                    $arr["date2"] = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                    $date2 = date('Y-m-d H:i:s', strtotime($value.' 23:59:59'));
                }
                else{
								
					$this->request->data['Filter'][$param_name] = $value;
				}
            
        }
       // var_dump($arr["date1"],$arr["date2"],$arr["magasin_id"]);
       $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date >= DATE( NOW()) and s4.date <= concat(DATE( NOW()),' ','23:59:59') and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= DATE( NOW()) and s.date <= concat(DATE( NOW()),' ','23:59:59') 
         GROUP BY s.store 
         
        ");
        
      /*   $selected_store  = $this->Session->read('Auth.User.StoreSession.id');
        $this->loadModel("Depot");
        $conditions['Salepoint.store'] = $selected_store; */
         if(!empty($date1) and !empty($date2) and !empty($magasin_id)) {
            
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date >= '$date1' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1' and s.date <= '$date2' 
        and s.store = $magasin_id  GROUP BY s.store  ");
      
        }
        else if(!empty($date1) and !empty($date2) and empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,  Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date >= '$date1' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1' and s.date <= '$date2' 
          GROUP BY s.store  ");
        }
        else if(!empty($date1) and empty($date2) and !empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,  Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date >= '$date1' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1'  
        and s.store = $magasin_id  GROUP BY s.store  ");
        }
        else if(empty($date1) and !empty($date2) and !empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,  Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date <= '$date2' 
        and s.store = $magasin_id  GROUP BY s.store  ");
        }
        else if(empty($date1) and !empty($date2) and empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%'  and s.date <= '$date2' 
              GROUP BY s.store  ");
        }
        else if(!empty($date1) and empty($date2) and empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and  a.mode ='cod' )) as Especes,  Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.date >= '$date1' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1'  GROUP BY s.store  ");
        }
        else if(empty($date1) and empty($date2) and !empty($magasin_id)) {
            $counts = $this->Salepoint22->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,  Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%'  and s.store = $magasin_id  GROUP BY s.store  ");
        }
        
         
            $this->paginate = array(
            'limit' => 10,
            'totallimit' => count($counts),
            
            //'magasin_id' => array($date1,$date2,$magasin_id),
            );
        

      
            $this->Session->write("date1", $arr["date1"]);
            $this->Session->write("date2", $arr["date2"]);
            $this->Session->write("magasin_id", $arr["magasin_id"]);

            $totalht = 0;$totalttc = 0;$especes = 0;$T09 = 0;$Ecommerce = 0;$Wallet = 0;$Carte = 0;
			$Cheque = 0;$Bon_achat = 0;$cheque_cadeau = 0;$offert = 0;$virement = 0;$Credit = 0;
			$tpe = 0;$remise = 0;$mntAnnule = 0; 

            foreach ($counts as $dossier) {
                $totalht += $dossier[0]['Totalht'];
                $totalttc += $dossier[0]['Totalttc'];
                $especes += $dossier[0]['Especes'];
                //$T09  += $dossier[0]['T09'];
                $Ecommerce  += $dossier[0]['Ecommerce'];
                $Wallet  += $dossier[0]['Wallet'];
                $Carte += $dossier[0]['Carte'];
                $Cheque += $dossier[0]['Cheque'];
                $Bon_achat += $dossier[0]['Bon_achat'];
                $cheque_cadeau  += $dossier[0]['cheque_cadeau'];
                $offert += $dossier[0]['offert'];
                $virement += $dossier[0]['virement'];
                $Credit += $dossier[0]['Credit'];
                $remise += $dossier[0]['remise'];
                $mntAnnule += $dossier[0]['mntAnnule'];
            }
            $results = $this->Paginator->paginate();
          $this->set(compact('results','totalht','totalttc','especes',
            'Ecommerce','Wallet','Carte','Cheque','Bon_achat','cheque_cadeau',
          'offert','virement','Credit','tpe','remise','mntAnnule'));

     
       
        //$bonlivraisons = $this->Salepoint->find('all', $settings);
        
        //$this->set(compact('results'));
        $this->layout = false;
    }
    
}