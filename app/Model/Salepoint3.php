<?php 

class Salepoint3 extends AppModel
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
        stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
        caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
        users user where user.id = s.user_id) as nom,(Select user.prenom  from
        users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
        salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
        salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
        avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
        salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date >= '$date1' and s4.date <= '$date2' ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.date >= '$date1' and s.date <= '$date2' 
        and s.store = $magasin_id  GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin Asc 
          LIMIT $row_start, $limit
        ");
        }
        else if(!empty($date1) and !empty($date2) and empty($magasin_id)) {
            
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise, (Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date >= '$date1' and s4.date <= '$date2') as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.date >= '$date1' and s.date <= '$date2' 
          GROUP BY s.store,s.caisse_id, s.user_id, datec  Order by magasin, datec Asc LIMIT $row_start, $limit ");

        }
        else if(!empty($date1) and empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date >= '$date1') as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.date >= '$date1'  
        and s.store = $magasin_id  GROUP BY s.store,s.caisse_id, s.user_id, datec Order, datec by magasin Asc  LIMIT $row_start, $limit");
        }
        else if(empty($date1) and !empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date <= '$date2') as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.date <= '$date2' 
            and s.store = $magasin_id  GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin, datec Asc   LIMIT $row_start, $limit");
        }
        else if(empty($date1) and !empty($date2) and empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date <= '$date2') as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2  and s.date <= '$date2' 
              GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin, datec Asc  LIMIT $row_start, $limit ");
        }
        else if(!empty($date1) and empty($date2) and empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec, Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date >= '$date1') as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2  and s.date >= '$date1'  GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin, datec Asc
             LIMIT $row_start, $limit ");
        }
        else if(empty($date1) and empty($date2) and !empty($magasin_id)) {
            return $this->query("Select (Select store.libelle  from
            stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
            caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
            users user where user.id = s.user_id) as nom,(Select user.prenom  from
            users user where user.id = s.user_id) as prenom,  date(s.date) as datec,  Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
            salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
            salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
            avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit,Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
            salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id ) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.store = $magasin_id GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin, datec Asc
                LIMIT $row_start, $limit ");
        }


      
      return $this->query("Select (Select store.libelle  from
      stores store where store.id = s.store) as magasin ,(Select caisse.libelle  from
      caisses caisse where caisse.id = s.caisse_id) as caisse,(Select user.nom  from
      users user where user.id = s.user_id) as nom,(Select user.prenom  from
      users user where user.id = s.user_id) as prenom,  date(s.date) as datec,  Sum(total_apres_reduction - montant_remise) as Totalttc, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and s.reference NOT LIKE '%T09%' and (a.mode ='cod' or a.mode = 'espece') )) as Especes, Sum((Select s2.total_apres_reduction from
      salepoints s2 where s2.id = s.id and s2.reference LIKE '%T09%' )) as T09,Sum((Select s3.total_apres_reduction from
      salepoints s3 where s3.id = s.id and s3.ecommerce_id != 0 )) as Ecommerce, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='wallet' )) as Wallet, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and (a.mode ='Carte' or a.mode ='cmi' or a.mode ='tpe') )) as Carte, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='cheque' )) as Cheque, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='bon_achat' )) as Bon_achat, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='cheque_cadeau' )) as cheque_cadeau, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='offert' )) as offert, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='virement' )) as virement, SUM((Select Sum(a.montant) from
      avances a where a.salepoint_id = s.id and a.mode ='delayed' )) as Credit, Sum(remise) as remise,(Select SUM(s4.total_apres_reduction) from
      salepoints s4 where  s4.etat = 3 and s4.reference not like '%PROV%' and s4.caisse_id = s.caisse_id and s4.date >= DATE( NOW()) and s4.date <= concat(DATE( NOW()),' ','23:59:59')) as mntAnnule FROM salepoints s where s.store != 0 and s.etat = 2 and s.date >= DATE( NOW()) and s.date <= concat(DATE( NOW()),' ','23:59:59')  GROUP BY s.store,s.caisse_id, s.user_id, datec Order by magasin, datec Asc 
       
        LIMIT $row_start, $limit
      ");

    }

    public function paginateCount($conditions = null, $recursive = 0, $extra = array())
  {
  if( isset($extra['totallimit']) ) return $extra['totallimit'];
  }

	public function beforeSave($options = array()){
		parent::beforeSave($options);
		
		if (empty($this->data[$this->alias]['id'])) {
		
			$this->data[$this->alias]['reference'] = "Prov";
				
		}
        App::uses('CakeSession', 'Model/Datasource');
        $save = CakeSession::read("Pos.save");
     /*    var_dump($save);die(); */   
		if($save === "1") {
            App::uses('CakeSession', 'Model/Datasource');
            $paiement = CakeSession::read("Vente.paiement");
            App::uses('CakeSession', 'Model/Datasource');
            $prefix_t09 = CakeSession::read("Vente.T09");
           
            if ($prefix_t09 === "1") {
                if (!empty($this->data[$this->alias]['id'])) {
                    $conditions['Salepoint.reference LIKE '] = "%T09%";
                    $salepoint = $this->find('first', array('conditions' => $conditions,'order' => array('id' => 'DESC') ));
                    if ($salepoint) {
                        $str = explode("T09-", $salepoint["Salepoint"]["reference"]);
                        $numero = intval($str[1]) +1;
                    } else {
                        $numero = 0;
                    }
                    App::uses('CakeSession', 'Model/Datasource');
                    $options = array('conditions' => array("id" => CakeSession::read('caisse_id')));
                    $caisse = ClassRegistry::init('Caisse');
                    $caisse = $caisse->find('first', $options);
                    $prefix = trim($caisse["Caisse"]["prefix"]);
                    //$this->data[$this->alias]['reference'] = $prefix . "-T09-" .str_pad($numero, 8, '0', STR_PAD_LEFT);
                    $this->data[$this->alias]['reference'] = $prefix . "-T09-" .$numero;
                }
            }
            App::uses('CakeSession', 'Model/Datasource');
            $prefix_t09 = CakeSession::read("Vente.T09");
            
            
            if (isset($paiement)  and $prefix_t09 != "1" and !empty($this->data[$this->alias]['id'])) {
                $options = array('conditions' => array("id" => CakeSession::read('caisse_id')));
                $caisse = ClassRegistry::init('Caisse');
                $caisse = $caisse->find('first', $options);
                $caisse_id = $caisse["Caisse"]["id"];
                $prefix = trim($caisse["Caisse"]["prefix"]);
                $numero = $caisse["Caisse"]["numero"];
                $count = strlen($numero);
                $numero = intval($numero);
                //$prefix = $prefix . "-POS";
                if ($caisse["Caisse"]["compteur_actif"] == "1") {
                    $this->data[$this->alias]['reference'] = $prefix . "-" .str_pad($numero, $count, '0', STR_PAD_LEFT);
                    $caisse2 = ClassRegistry::init('Caisse');
                    $caisse2->updateAll(['Caisse.compteur_actif'=>0], ['Caisse.id'=>$caisse["Caisse"]["id"]], ['Caisse.numero'=>$numero]);

                } else {
                    $conditions['Salepoint.reference LIKE '] = "%$prefix%";
                    $conditions['Salepoint.reference not LIKE'] = "%T09%"; 
                    $salepoint = $this->find('first', array('conditions' => $conditions,'order' => array('id' => 'DESC') ));
                    
                    if (isset($salepoint["Salepoint"]["reference"])) {
                        //$str = explode("POS-", $salepoint["Salepoint"]["reference"]);
                        $before_prefix = $prefix."-";
                        $str = explode($before_prefix,$salepoint["Salepoint"]["reference"]);


                        // add +1 on the last one
                        $numero = intval($str[1]) +1;


                    // formater le nombre avec des Zéros
						$length = 6;
						$numero = substr(str_repeat(0, $length).$numero, - $length);
                        
                    } else {
                        $numero = 1;

                        // formater le nombre avec des Zéros
						$length = 6;
						$numero = substr(str_repeat(0, $length).$numero, - $length);
                    }
                    
                    //$this->data[$this->alias]['reference'] = $prefix . "-" .str_pad($numero, $count, '0', STR_PAD_LEFT);
                    $this->data[$this->alias]['reference'] = $prefix . "-" .$numero;

                    $caisse = ClassRegistry::init('Caisse');
                    $caisse->id = $caisse_id;
                    $caisse->saveField("numero", $numero);
                }
                CakeSession::delete("Vente.paiement");
            }
            if ($prefix_t09 === "1") {
                CakeSession::delete("Vente.T09");
            }
            CakeSession::delete("Pos.save");
        }
			/* $number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
			$this->data[$this->alias]['reference'] = 'POS-'.str_pad($number, 6, '0', STR_PAD_LEFT);
	 */	
	    if (!empty($this->data[$this->alias]['date'])){
	        $this->data[$this->alias]['date'] = $this->dateFormatBeforeSave( $this->data[$this->alias]['date'] );
	    }	
	    if (!empty($this->data[$this->alias]['date_c'])){
	        $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date_c'] );
	    }	   
	    return true;
	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateFormatAfterFind( $val[$this->alias]['date'] );
	        }
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}

}
 ?>