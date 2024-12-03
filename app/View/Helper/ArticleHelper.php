<?php 


/**
* 
*/
class ArticleHelper extends AppHelper
{
	public function getType($type = null){
		$data = array(1 => 'Restaurant',2 => 'Café');
		if($type === null) return $data;
		return $data[$type];
	}

	public function getOperation($type = null){
		$data = array(1 => 'Entrée',2 => 'Sortie');
		if($type === null) return $data;
		return $data[$type];
	}
}

 ?>