<?php 

    class Mssql {
        private $connexion_sql;
        
        function __construct() {
            //$this->connexion_bdd = new PDO("odbc:Driver={SQL Server};Server=MOUHSSINE\SQLEXPRESS;Database=plasgum;", 'lorem', 'lorem');
            $this->connexion_bdd = new PDO("odbc:Driver={SQL Server};Server=MOUHSSINE\SQLEXPRESS;Database=plasgum;");

            // Fixe les options d'erreur (ici nous utiliserons les exceptions)
            $this->connexion_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        public function requete($requete) {
            $prepare = $this->connexion_bdd->prepare($requete);
            $prepare->execute();
            
            return $prepare;
        }
    }

?>