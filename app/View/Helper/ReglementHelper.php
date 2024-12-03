<?php 

/**
* 
*/
class ReglementHelper extends AppHelper
{
	public function getModepaiment($k = null){
		$Arr = [1=>'Espéce',2=>'Réglement retenu sur salaire',3=>'Chéque',4=>'Imputer sur le chambre'];
		if($k === null)
			return $Arr;
		return $Arr[$k];
	}
}

 ?>