<?php

class Router{
	
	
	
	public static function setRoutes($routes){
		
		Hooks::preRouter();
		
		$request = $_SERVER['REQUEST_URI'];
		$request = explode('?',$request);
		$requestArray = explode("/", $request[0]);
		
		$localhost = configApp::$localhost;
		$local_folders = configApp::$local_folder+1;
		
		$requestArray = array_slice($requestArray,$local_folders);
	
		$request="";
		foreach ($requestArray as $r) {
			$request = $request."/".$r;
		}
		$request = substr($request, 1);
		

function generateRandomString($length = 200) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
				    }
			    return $randomString;
		}


		$randstr = generateRandomString();
		
		foreach ($routes as $route => $controller) {
			
				$pattern = '/\{[a-zA-Z]*?\}/';
				$replacement = $randstr;
				$subject = $route;
				$gentext =  preg_replace($pattern, $replacement, $subject, -1 );
				
				
				
				$pattern = '/\//';
				$replacement = '\/';
				$subject = $gentext;
				$gentext2 =  preg_replace($pattern, $replacement, $subject, -1 );
				
				
				
				$gentext3 = "/^".str_replace($randstr,".*?",$gentext2)."$/";
			
			
			if (preg_match($gentext3, $request)) {
				   
					
					$found = true;
					$finCont = $controller;
					break;
				} else {
					if($request==""){
						if($route=="/"){
							$finCont = $controller;
							$found = true;
							break;
						}else{
							
						}
					}
						$found = false;
				   
				}
			
		}
		
		
		
			
			if($found){
				
				
				Hooks::preController();
				#echo "found!<br>";
				if(is_callable($finCont)){
					$message = "Route requested(success):  	".$_SERVER['REQUEST_URI']." | Route => function has been called.";
					Logger::write($message);
					$finCont($requestArray);
					
				}else{

				$ar = explode('@',$finCont);
				$finCont = $ar[0];
				require dirname(__FILE__)."/../../App/Controllers/".$finCont.'.php';
				$class = new $finCont;
				if(isset($ar[1])){
					if(method_exists($class, $ar[1])){
						$class->$ar[1]($requestArray);
						$message = "Route requested(success):  	".$_SERVER['REQUEST_URI']." | Method '".$ar[1]."' of controler: ".$finCont." has been called";
						Logger::write($message);
					}else{
					$message = "Route requested(failure):  	".$_SERVER['REQUEST_URI']." | Method '".$ar[1]."' of controller ".$ar[0]." does not exists";
					Logger::write($message);
					trigger_error('Method of controller: <b>'.$ar[0].'</b> does not exists!');
					}
					
					

				}else{
					$message = "Route requested(failure):  	".$_SERVER['REQUEST_URI']." | Method of controller ".$ar[0]." was not defined in routes";
					Logger::write($message);
				
					
					trigger_error('Method of controller: <b>'.$ar[0].'</b> was not defined in routes');
				}

				}
				
				
				
			}else{
				$message = "Route requested(failure):  	".$_SERVER['REQUEST_URI']." | No route found";
				Logger::write($message);
				trigger_error('No route was found!');

			}
		
	
		
		
	}
	
}
