<?php 

class PersonalisationHelper extends AppHelper 
{
	public function getTheme($type = null){
		$data = array('default' => 'Par défaut','grey' => 'Thème  gris','blue' => 'Thème bleu' ,'light' => 'Thème blanc','dark' => 'Thème sombre');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getHeader($type = null){
		$data = array('default' => 'Par défaut','fixed' => 'Fixé');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getFooter($type = null){
		$data = array('default' => 'Par défaut','fixed' => 'Fixé');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getLayout($type = null){
		$data = array('fluid' => 'Fluid','boxed' => 'Boxed');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getSidebarType($type = null){
		$data = array('none' => 'Accordion','page-sidebar-menu-hover-submenu' => 'Hover');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getSidebarPosition($type = null){
		$data = array('none' => 'Gauche','page-sidebar-reversed' => 'Droit');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getSidebarStyle($type = null){
		$data = array('page-sidebar-menu page-sidebar-menu-compact' => 'Petites icônes','page-sidebar-menu' => 'Grandes icônes');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}

	public function getTemplateStyle($type = null){
		$data = array('none' => 'Théme normal','page-sidebar-closed' => 'Théme compact');
		if($type === null) return $data;
		return ( isset( $data[$type] ) ) ? $data[$type] : '' ;
	}
}


 ?>