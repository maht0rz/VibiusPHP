<?php

class Container{

	private static $container = array();

	public static function add($key, $value){
		self::$container[$key] = $value;
	}

	public static function remove($key){
		if(isset(self::$container[$key])){
			unset(self::$container[$key]);	
			return true;
		}
		return false;
	}

	public static function get($key,$param = NULL){
		if(!isset(self::$container[$key])){return false;}

		if(is_callable(self::$container[$key])){
			return call_user_func(self::$container[$key],$param);
			
		}else{
			return self::$container[$key];
		}
	}

}