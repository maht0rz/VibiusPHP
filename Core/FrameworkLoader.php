<?php
session_start();
$_SESSION['log_message'] = "";
class FrameworkLoader{
	
	
	public function loadDependencies(){
		
		//autoload classes
		function __autoload($name){
			
			$helpers = array('Hash','URL','Filter','Lang');
			
			if(in_array($name, $helpers)){
				Logger::write('Loading Helper: '.$name);
				require 'Helpers/'.$name.'.php';
			}else{
				Logger::write('Loading extension: '.$name);
				
				if(file_exists('../App/Extensions/'.$name.'.php')){
					require '../App/Extensions/'.$name.'.php';
				}else{
					
					require dirname(__FILE__).'../../App/Extensions/myExtension.php';
				}
			
			
			}
			
		}
		
		
		require 'OutputBuffer/OutputBuffer.php';
		require 'ErrorHandler/ErrorHandler.php';
		require 'Logger/Logger.php';
		require 'Cache/Cache.php';
		
		require 'View/View.php';
		require 'Models/Modeler.php';
		require 'Storager/Storage.php';
		require '../App/Hooks/Hooks.php';
		
		require 'Router/Router.php';
		
		
		
		require '../App/Config/configApp.php';
		require '../App/Config/configDB.php';
		require '../App/routes.php';
		
		
		
		
		
		
	}
	
	
	public function run(){
		
		$this->loadDependencies();
		
		
		
		#require 'file.php';
		
	}
	
	
}

$Framework = new FrameworkLoader();
