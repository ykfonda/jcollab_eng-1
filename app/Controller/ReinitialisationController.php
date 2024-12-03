<?php
class ReinitialisationController extends AppController {
	public $idModule = 97;
	public $uses = ['Parametreste'];

	public function index() {
		$this->getPath($this->idModule);
	}

	public function reset($table_name = 'produits') {
		$this->Parametreste->query('TRUNCATE TABLE '.$table_name.';');

		if ( $table_name == 'devis' ) $this->Parametreste->query('TRUNCATE TABLE devidetails;');
		if ( $table_name == 'factures' ) $this->Parametreste->query('TRUNCATE TABLE facturedetails;');
		if ( $table_name == 'bonretours' ) $this->Parametreste->query('TRUNCATE TABLE bonretourdetails;');
		if ( $table_name == 'bonlivraisons' ) $this->Parametreste->query('TRUNCATE TABLE bonlivraisondetails;');
		if ( $table_name == 'boncommandes' ) $this->Parametreste->query('TRUNCATE TABLE boncommandedetails;');
		if ( $table_name == 'bonreceptions' ) $this->Parametreste->query('TRUNCATE TABLE bonreceptiondetails;');
		if ( $table_name == 'bonavoirs' ) $this->Parametreste->query('TRUNCATE TABLE bonavoirdetails;');
		if ( $table_name == 'bonentrees' ) $this->Parametreste->query('TRUNCATE TABLE bonentreedetails;');
		if ( $table_name == 'bontransferts' ) $this->Parametreste->query('TRUNCATE TABLE bontransfertdetails;');

		$this->Session->setFlash('La mise à jour a été effectué avec succès.','alert-success');
		return $this->redirect($this->referer());
	}
}