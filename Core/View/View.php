<?php
class View{
	
	public static function make($view_name,$args = array()){
		
		$instance = new self("contruct!");
		$instance->display($view_name,$args);
		
		return $instance;
	}
	
	public function display($view_name,$args){
		foreach ($args as $key => $value) {
			${$key} = $value;
		}
		require dirname(__FILE__).'/../../App/Views/'.$view_name.'.php';
		
		return $this;
	}
	
	
	
	
}
