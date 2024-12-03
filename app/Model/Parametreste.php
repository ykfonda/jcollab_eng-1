<?php 
class Parametreste extends AppModel
{
	public function findList($conditions = []){
		$clients = $this->find('all',['order' => [$this->alias.'.id' => 'asc'],'conditions' => $conditions]);
		foreach ($clients as $k => $v) { 
			$list[ $v[$this->alias]['key'] ] = $v[$this->alias]['value']; 
		}

		return ( isset( $list ) AND !empty( $list ) ) ? $list : [];
	}	
}

 ?>