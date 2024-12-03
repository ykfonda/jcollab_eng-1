<?php 


class ReservationHelper extends AppHelper
{
	public function getEtat($k = null){
		$Arr = [1=>'En attente',3=>'Réalisée'];
		if($k === null)
			return $Arr;
		return $Arr[$k];
	}

	public function getOrigine($k = null){
		$Arr = [1=>'Nouveau client',2=>'Client existant'];
		if($k === null)
			return $Arr;
		return $Arr[$k];
	}

	public function getModePaiment($k = null){
		$Arr = array(1 => 'Retenue sur salaire', -1 => ' Espèce');
		if($k === null) return $Arr;
		return $Arr[$k];
	}
}



 ?>