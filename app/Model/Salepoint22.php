<?php 

class Salepoint22 extends AppModel
{
	public $displayField = 'reference';
    public $useTable = "salepoints";

	public $belongsTo = [
		'User','Client','Depot','Ecommerce','Store'=> [
			'className' => 'Store',
            'foreignKey' => 'store'
		],
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
	];

	public $hasMany = ['Salepointdetail','Avance','Email'];

    public function paginate($conditions, $fields, $order, $limit, $page=1, $recursive=null, $extra=array())
    {
      $row_start = ($page-1) * $limit;
      
      App::uses('CakeSession', 'Model/Datasource');
      
      $date1 = CakeSession::read("date1");
      $date2 = CakeSession::read("date2");
      $magasin_id = CakeSession::read("magasin_id");
    
      
      
      if (!empty($date1) and !empty($date2) and !empty($magasin_id)) {
        
        return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date >= '$date1' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1' and s.date <= '$date2' 
        and s.store = $magasin_id  GROUP BY s.store 
          LIMIT $row_start, $limit
        ");
        }
        else if(!empty($date1) and !empty($date2) and empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date >= '$date1' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1' and s.date <= '$date2' 
          GROUP BY s.store  LIMIT $row_start, $limit ");
        }
        else if(!empty($date1) and empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date >= '$date1' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1'  
        and s.store = $magasin_id  GROUP BY s.store   LIMIT $row_start, $limit");
        }
        else if(empty($date1) and !empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date <= '$date2' 
        and s.store = $magasin_id  GROUP BY s.store   LIMIT $row_start, $limit");
        }
        else if(empty($date1) and !empty($date2) and empty($magasin_id)) {
            
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date <= '$date2' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%'  and s.date <= '$date2' 
              GROUP BY s.store  LIMIT $row_start, $limit ");
        }
        else if(!empty($date1) and empty($date2) and empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date >= '$date1' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= '$date1'  GROUP BY s.store  LIMIT $row_start, $limit ");
        }
        else if(empty($date1) and empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
        stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes,   Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%'  and s.store = $magasin_id  GROUP BY s.store LIMIT $row_start, $limit ");
        }


      
        
      return $this->query("Select (Select store.libelle  from
      stores store where store.id = s.store) as magasin,  Sum(total_a_payer_ht) as Totalht,Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s3.total_apres_reduction from
      salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode = 'Cmi' or a.mode = 'tpe') )) as Carte, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
      salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.date <= concat(DATE( NOW()),' ','23:59:59')  and s4.store = s.store ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.reference NOT LIKE '%T09%' and s.date >= DATE( NOW()) and s.date <= concat(DATE( NOW()),' ','23:59:59')  GROUP BY s.store 
        LIMIT $row_start, $limit
      ");


    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array())
  {
  if( isset($extra['totallimit']) ) return $extra['totallimit'];
  }

	
}
 ?>