<?php 


/**
* 
*/
class ChambreHelper extends AppHelper
{
	public function getType($type = null){
		$data = array(1 => 'Chambre',2 => 'Bungalow');
		if($type === null) return $data;
		return $data[$type];
	}
}


 ?>