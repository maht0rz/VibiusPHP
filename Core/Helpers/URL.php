<?php

class URL{
	
	public static function base(){
		
		$request = $_SERVER['REQUEST_URI'];
		$request = explode('/',$request);
		$folders ="";
		for($i=0;$i <= configApp::$local_folder;$i++){
			$folders = $folders.$request[$i]."/";
		}
		
		return 'http://'.$_SERVER['HTTP_HOST'].$folders;
		
	}
	
	public static function to($location){
		
		$request = $_SERVER['REQUEST_URI'];
		$request = explode('/',$request);
		$folders ="";
		for($i=0;$i <= configApp::$local_folder;$i++){
			$folders = $folders.$request[$i]."/";
		}
		
		return 'http://'.$_SERVER['HTTP_HOST'].$folders."".$location;
		
	}
	
}
