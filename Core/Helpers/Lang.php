<?php

class Lang {
	
	function __construct(){
		
		 #configLang::source;
		
	}
	
	public static function get($lang,$selector){
		
		require dirname(__FILE__)."/../../App/Lang/".$lang.'.php';
		return $lang[$selector];
		
		
	}
	
	public static function all($lang){
		
		require dirname(__FILE__)."/../../App/Lang/".$lang.'.php';
		return $lang;
		
	}
	
	public static function find(){
		
		function get_client_ip() {
			#return "178.41.147.191";
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if($_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if($_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if($_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if($_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if($_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';
	
     return $ipaddress; 
	}
		
		$xml=simplexml_load_file("http://freegeoip.net/xml/".get_client_ip());
		$ip =  $xml->CountryCode;
		
		return $ip;
		
	}
	
}



	

