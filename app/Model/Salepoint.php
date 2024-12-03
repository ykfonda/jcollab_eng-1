<?php 

class Salepoint extends AppModel
{
	public $displayField = 'reference';

	public $belongsTo = [
		'User','Client','Caisse','Depot','Ecommerce','Commande','Store'=> [
			'className' => 'Store',
            'foreignKey' => 'store'
		],
		'Creator' => [
			'className' => 'User',
            'foreignKey' => 'user_c'
		],
        'Chequecadeau' => [
			'className' => 'Chequecadeau',
            'foreignKey' => 'id_chequecadeau'
		],
        'Commandeglovo' => [
			'className' => 'Commandeglovo',
            'foreignKey' => 'glovo_id'
		],
	];

	public $hasMany = ['Salepointdetail','Facture','Avance','Email','Depot'];

    
	public function beforeSave($options = array()){

        if (!$this->syncing) { // Vérifiez si la synchronisation est en cours



            ///// code avant modif sync
            parent::beforeSave($options);
            
            if (empty($this->data[$this->alias]['id'])) {
            
                /* $this->data[$this->alias]['reference'] = "Prov"; */
                $options = array('conditions' => array("id" => CakeSession::read('caisse_id')));
                    $caisse = ClassRegistry::init('Caisse');
                    $caisse = $caisse->find('first', $options);

                if (isset($caisse["Caisse"])) {
                        $caisse_id = $caisse["Caisse"]["id"];
                        $prefix = trim($caisse["Caisse"]["prefix"]);
                        $numero = $caisse["Caisse"]["numero"];
                        $count = strlen($numero);
                        $numero = intval($numero);
                    

                    //$prefix = $prefix . "-POS";
                    if ($caisse["Caisse"]["compteur_actif"] == "1") {
                        $this->data[$this->alias]['reference'] = $prefix . "-Prov-" .str_pad($numero, $count, '0', STR_PAD_LEFT);
                        $caisse2 = ClassRegistry::init('Caisse');
                        $caisse2->updateAll(['Caisse.compteur_actif'=>0], ['Caisse.id'=>$caisse["Caisse"]["id"]], ['Caisse.numero'=>$numero]);

                    } else {
                        $prefix = $prefix . "-Prov";
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

                    
                    }
                
                } // End IF $caisse["Caisse"] 
                    
                    
            }
            if (!empty($this->data[$this->alias]['id'])) {
                
                App::uses('CakeSession', 'Model/Datasource');
                $save = CakeSession::read("Pos.save");
                
            
                if (isset($this->data[$this->alias]['etat']) and ($this->data[$this->alias]['etat'] == 2)) { //if ($save === "1") { 
                    //var_dump($this->data[$this->alias]['total_apres_reduction']);die(); 
                    App::uses('CakeSession', 'Model/Datasource');
                    $paiement = CakeSession::read("Vente.paiement");
                    App::uses('CakeSession', 'Model/Datasource');
                    $prefix_t09 = CakeSession::read("Vente.T09");
            
                    if ($prefix_t09 === "1") {
                        if (!empty($this->data[$this->alias]['id'])) {
                            App::uses('CakeSession', 'Model/Datasource');
                            $options = array('conditions' => array("id" => CakeSession::read('caisse_id')));
                            $caisse = ClassRegistry::init('Caisse');
                            $caisse = $caisse->find('first', $options);
                            $prefix = trim($caisse["Caisse"]["prefix"]);
                            $prefixF = $prefix . "-T09-";
                        
                            $conditions[] = array(
                                'AND' => array(
                                    array('Salepoint.reference LIKE ' => "%$prefix%"),
                                    array('Salepoint.reference LIKE ' => "%T09%"),
                                )
                            );
                            $salepoint = $this->find('first', array('conditions' => $conditions,'order' => array('id' => 'DESC') ));
                            if (!empty($salepoint["Salepoint"]["id"])) {
                                $str = explode($prefixF, $salepoint["Salepoint"]["reference"]);
                                $numero = intval($str[1]) +1;
                            } else {
                                $numero = 1;
                            }
                        
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
                        $conditions = [];
                        //$prefix = $prefix . "-POS";
                        if ($caisse["Caisse"]["compteur_actif"] == "1") {
                            $this->data[$this->alias]['reference'] = $prefix . "-" .str_pad($numero, $count, '0', STR_PAD_LEFT);
                            $caisse2 = ClassRegistry::init('Caisse');
                            $caisse2->updateAll(['Caisse.compteur_actif'=>0], ['Caisse.id'=>$caisse["Caisse"]["id"]], ['Caisse.numero'=>$numero]);
                        } else {
                            $prefixF = $prefix;
                        
                            $salepoint = $this->find('first', array('conditions' => array(
                                
                                    array('Salepoint.reference LIKE'=> "%$prefixF%"),
                                    array('Salepoint.reference NOT LIKE'=>'%T09%'),
                                    array('Salepoint.reference NOT LIKE'=>'%Prov%')
                            ),'order' => array('id' => 'DESC') ));
                        
                        
                            if (isset($salepoint["Salepoint"]["reference"])) {
                                //$str = explode("POS-", $salepoint["Salepoint"]["reference"]);
                                $before_prefix = $prefixF."-";
                                $str = explode($before_prefix, $salepoint["Salepoint"]["reference"]);


                                // add +1 on the last one
                                //$numero = intval($str[1]) +1; 
                                $numero++;
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
                        /*   $this->data[$this->alias]['id'] = $salepoint["Salepoint"]["id"]; */ 
                            /* $this->id = $salepoint["Salepoint"]["id"]; */
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
            }
                /* $number = $this->find('count',['conditions'=>[$this->alias.'.deleted'=>[0,1]]]) + 1; 
                $this->data[$this->alias]['reference'] = 'POS-'.str_pad($number, 6, '0', STR_PAD_LEFT);
        */	
            if (!empty($this->data[$this->alias]['date'])){
                $this->data[$this->alias]['date'] = $this->dateTimeFormatBeforeSave2( $this->data[$this->alias]['date'] );
            }	
            if (!empty($this->data[$this->alias]['date_c'])){
                $this->data[$this->alias]['date_c'] = $this->dateTimeFormatBeforeSave( $this->data[$this->alias]['date_c'] );
            }	   
            return true;

             ///// END _ code avant modif sync



        } // END IF 
        return parent::beforeSave($options);



	}

	public function afterFind($results, $primary = false){
	    foreach ($results as $key => $val) {
	        if (isset($val[$this->alias]['date'])) {
	            $results[$key][$this->alias]['date'] = $this->dateTimeFormatAfterFind2( $val[$this->alias]['date'] );
	        }
	        if (isset($val[$this->alias]['date_c'])) {
	            $results[$key][$this->alias]['date_c'] = $this->dateTimeFormatAfterFind( $val[$this->alias]['date_c'] );
	        }
	    }
	    return $results;
	}

}
 ?>