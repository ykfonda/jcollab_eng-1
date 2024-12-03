<?php
class GetproduitsController extends AppController {
	
	public $uses = ['Produit'];

 	public function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allow();
	} 

    public function produitDetails() {	
		/////////////////////
		//exec('Runas /user:User mysqldump  -u "root"  -p"" jcollab salepoints > "file3.sql" 2>&1',$output);
		//var_dump($output);die();
		
		$db['host'] = '5.153.23.19';
		$db['user'] = 'iafjb_iafjb_jco';
		$db['pass']   = '^=f&53V6)b,c';
		$db['name'] = 'iafjb_jco';
		$db['port'] = '3306';

		$conn = mysqli_connect($db['host'],$db['user'],$db['pass'],$db['name'], $db['port']);
        if (mysqli_connect_errno($conn)) {
            trigger_error('Database connection failed: '  . mysqli_connect_error());
        }
		die();
		  /////////////////////
		if($_SERVER["PHP_AUTH_USER"] == "jcoapi" and $_SERVER["PHP_AUTH_PW"] == "1563dfyc") {

			$produits = $this->Produit->find('all');
			
		    $data = [];
			
            for($i = 0;$i < sizeof($produits); $i++) {
							
					$data[$i] = [
						"code_barre" => $produits[$i]["Produit"]["code_barre"],
						"designation" => $produits[$i]["Produit"]["libelle"],
						"prix_achat" => $produits[$i]["Produit"]["prixachat"],
						"prix_vente" => $produits[$i]["Produit"]["prix_vente"],
						"date_u" => $produits[$i]["Produit"]["date_u"],
								
					];
            }	
			
            header('Content-Type: application/json; charset=UTF-8');
			die( json_encode( array_values($data) ) );
		}
		else { 
			header('Content-Type: application/json; charset=UTF-8');
			$data = [
				"Erreur" => "le nom d'utilisateur ou mot de passe est incorrect"
			]; 
			die( json_encode( $data ) );
			
		}
		/* var_dump($salepoints[1]["Salepoint"]);die(); */	
	}
}
