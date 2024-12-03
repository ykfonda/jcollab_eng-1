<?php 

class TicketHelper extends AppHelper
{
	public function getEtat($etat = null){
		$data = array(1 => 'Brouillon',2 => 'Publié');
		if($etat === null) return $data;
		return $data[$etat];
	}

	public function getType($type = null){
		$data = array(1 => 'Réglementaire',2 => 'Fonctionnel',3 => 'Technique');
		if($type === null) return $data;
		return $data[$type];
	}

	public function getGravite($grave = null){
		$data = array(1 => 'Important',2 => 'Trés important',3 => 'Urgent');
		if($grave === null) return $data;
		return $data[$grave];
	}

	public function getStatut($statut = null){
		$data = array(1 => 'En attente',2 => 'En cours',3 => 'Résolu',4 => 'Non résolu');
		if($statut === null) return $data;
		else if($statut == 0) return '';
		return $data[$statut];
	}
}