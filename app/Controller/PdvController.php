<?php
class PdvController extends AppController {
	public $idModule = 120;
	public $uses = array('Produit', 'Client','Salepoint');

	public function index() {
		$data = [];
		$clients = $this->Client->find('list',['order'=>'id asc']);
		$categorieproduits = $this->Produit->Categorieproduit->find('list',['order'=>'id asc']);
		$produits = $this->Produit->find('all',[
			'fields'=>['id','libelle','image','prix_vente','categorieproduit_id','code_barre'],
			'order'=>'libelle asc',
		]);
		foreach ($categorieproduits as $k => $v) {
			$data[ $k ] = [ 'libelle' => $v, 'produits' => [] ];
		}
		foreach ($produits as $k => $v) {
			if ( isset( $data[ $v['Produit']['categorieproduit_id'] ]['produits'] ) ) $data[ $v['Produit']['categorieproduit_id'] ]['produits'][] = $v;
		}

		$details = $this->Salepoint->Salepointdetail->find('all',[
			'conditions' => ['stat' => -1,'onhold' => -1],
			'contain' => ['Produit'],
		]);

		$onhold = $this->Salepoint->Salepointdetail->find('count',['conditions' => ['stat' => -1,'onhold' => 1]]);

		$this->set(compact('produits','categorieproduits','data','clients','details','onhold'));
		$this->getPath($this->idModule);
		$this->layout = 'pos';
	}

	public function search($libelle = null,$categorieproduit_id = null) {
		$conditions = [];
		if( !empty( $libelle ) ) $conditions['Produit.libelle LIKE '] = "%$libelle%";
		if( !empty( $categorieproduit_id ) ) $conditions['Produit.categorieproduit_id'] = $categorieproduit_id;
		$produits = $this->Produit->find('all',[
			'fields'=>['id','libelle','image','prix_vente','categorieproduit_id','code_barre'],
			'conditions'=>$conditions,
			'order'=>'libelle asc',
		]);
		$this->set(compact('produits'));
		$this->layout = false;
	}

	public function details() {
		$details = $this->Salepoint->Salepointdetail->find('all',[
			'conditions' => ['stat' => -1,'onhold' => -1],
			'contain' => ['Produit'],
		]);

		$onhold = $this->Salepoint->Salepointdetail->find('count',['conditions' => ['stat' => -1,'onhold' => 1]]);

		$this->set(compact('details','onhold'));
		$this->layout = false;
	}

	public function onhold() {
		$details = $this->Salepoint->Salepointdetail->find('all',[
			'conditions' => ['stat' => -1,'onhold' => 1],
			'contain' => ['Produit'],
		]);

		$this->set(compact('details'));
		$this->layout = false;
	}

	public function paiement() {
		$details = $this->Salepoint->Salepointdetail->find('all',[
			'conditions' => ['stat' => -1,'onhold' => -1],
			//'contain' => ['Produit'],
		]);
		$total = 0;
		foreach ($details as $k => $v) { $total = $total+$v['Salepointdetail']['prix_vente']; }

		$this->set(compact('total'));
		$this->layout = false;
	}

	public function scan($code_barre = null) {
		$response['error'] = true;
		$response['message'] = "";
		if ( !empty( $code_barre ) ) {
			$produit = $this->Produit->find('first',['fields'=>['id','prix_vente','categorieproduit_id'],'conditions' => [ 'Produit.code_barre' => $code_barre ]]);
			if ( isset( $produit['Produit']['id'] ) AND !empty( $produit['Produit']['id'] ) ) {

				$data['Salepointdetail']['categorieproduit_id'] = $produit['Produit']['categorieproduit_id'];
				$data['Salepointdetail']['prix_vente'] = $produit['Produit']['prix_vente'];
				$data['Salepointdetail']['total'] = $produit['Produit']['prix_vente']/1.2;
				$data['Salepointdetail']['ttc'] = $produit['Produit']['prix_vente'];
				$data['Salepointdetail']['produit_id'] = $produit['Produit']['id'];
				$data['Salepointdetail']['onhold'] = -1;
				$data['Salepointdetail']['stat'] = -1;
				$data['Salepointdetail']['qte'] = 1;

				if($this->Salepoint->Salepointdetail->save($data)){
					$response['message'] = "L'enregistrement a été fait avec succès. !";
					$response['error'] = false;
				}else $response['message'] = "Erreur de sauvgarde des donnée !";

			} else $response['message'] = "Code a barre incorrect produit introuvable !";
		} else $response['message'] = "Code a barre incorrect ou vide !";
		header('Content-Type: application/json; charset=UTF-8');
		die( json_encode( $response ) );
	}

	public function cancel() {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) die('Vous n\'avez pas la permission de supprimer !');
		if ($this->Salepoint->Salepointdetail->deleteAll(['Salepointdetail.stat' => -1,'Salepointdetail.onhold' => -1])) die('La suppression a été effectué avec succès.');
		else die('Il y a un problème');
	}

	public function holdon() {
		if ($this->Salepoint->Salepointdetail->updateAll(['Salepointdetail.onhold' => 1],['Salepointdetail.stat' => -1,'Salepointdetail.onhold' => -1])) die('La suppression a été effectué avec succès.');
		else die('Il y a un problème');
	}

	public function deleteline($id = null) {
		if ( isset( $this->globalPermission['Permission']['s'] ) AND $this->globalPermission['Permission']['s'] == 0 ) die('Vous n\'avez pas la permission de supprimer !');
		$this->Salepoint->Salepointdetail->id = $id;
		if (!$this->Salepoint->Salepointdetail->exists()) throw new NotFoundException(__('Invalide line'));
		if ($this->Salepoint->Salepointdetail->delete()) die('La suppression a été effectué avec succès.');
		else die('Il y a un problème');
	}

}