<?php

class Cache{

	public static function getExact($name){
		$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
		
				if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						
							$filee = explode('^',$file[0]);
				
							if($filee[2] == $name){
								$returned = implode('^',$filee);
								$returned = dirname(__FILE__)."/../../App/Cache/".$returned;
								$ser = file_get_contents($returned.".php");
								Logger::write('');
								return unserialize($ser);
								break;
							}
						
						}else{

						}
					
						

					}
			}
	}

	public static function createExact($timeout,$name,$content){

		$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
		
				if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						
							$filee = explode('^',$file[0]);
				
							if($filee[2] == $name){
								Cache::delete($name);
								break;
							}
						
						}else{

						}
					
						

					}
			}
		
		$f = dirname(__FILE__)."/../../App/Cache/".$timeout."^".time()."^".$name.".php";
		
		$file = fopen($f, 'w+');
		$cacheData = $content;
		fwrite($file, serialize($cacheData));
		

	}

	public static function action(){

	}
	public static function create($timeout,$name){
		
			$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
		
				if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						
							$filee = explode('^',$file[0]);
				
							if($filee[2] == $name){
								Cache::delete($name);
								
							}
						
						}else{

						}
					
						

					}
			}
		
		$f = dirname(__FILE__)."/../../App/Cache/".$timeout."^".time()."^".$name.".php";
		
		$file = fopen($f, 'w+');
		$cacheData = OutputBuffer::getCurrentOutput();
		fwrite($file, $cacheData);
		
	}



	public static function get($name){
		$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
		
				if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						
							$filee = explode('^',$file[0]);
				
							if($filee[2] == $name){
								$returned = implode('^',$filee);
								$returned = dirname(__FILE__)."/../../App/Cache/".$returned;
								require $returned.".php";
								
								break;
							}
						
						}else{

						}
					
						

					}
			}
	}

	public static function delete($name){
		$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
		
				if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						
							$filee = explode('^',$file[0]);
				
							if($filee[2] == $name){
								$file = dirname(__FILE__)."/../../App/Cache/".$file[0].".php";
								unlink($file);
							}
						
						}else{

						}
					
						

					}
			}
	}

	public static function exist($name){
		$files = scandir(dirname(__FILE__)."/../../App/Cache/", 1);
			if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
						$filee = explode('^',$file[0]);
							$file = explode('^',$file[0]);
							
				
							if($filee[2] == $name){
									if(($file[1] - time()) >= -$file[0]){
										
										return true;
										break;

								}else{

								}
							}
							
						
						}else{

						}
					
						

					}
			}
	}

}