<?php

class Logger{

	public static function write($message){
		
		$date = date("d-m-y");
		$time = date("h:m:s");
		if(isset($_SESSION['log_message'])){
			$_SESSION['log_message'] = $_SESSION['log_message']." =\= ".$message;
		}else{
			$_SESSION['log_message'] = $message;
		}

		
	}

	public static function addToLog(){
	$date = date("y-m-d");
	

	if(configApp::$log){
		#error_reporting(E_ALL);


			$files = scandir(dirname(__FILE__)."/../../App/Log/", 1);
			if(!empty($files)){
					foreach ($files as $file) {
						$file = explode('.',$file);
						if(!empty($file[0])){
							
								$d1 = "20".$file[0];
								$d2 = "20".$date;
					
								$date1 = new DateTime($d1);
								$date2 = new DateTime($d2);
								$interval = $date1->diff($date2);
								if($interval->d >= configApp::$keep_log_files){

									$f = dirname(__FILE__)."/../../App/Log/".$file[0].".log";
									unlink($f);
								}else{
									
								}
						}else{

						}
					
						

					}
			}
	
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

		$date = date("y-m-d");
		$time = date("H:i:s");  
		$f = dirname(__FILE__)."/../../App/Log/".$date.".log";
		$file = fopen($f,"a+");
		
		fwrite($file ,"\r\n".$time." | SessionID: ".session_id()."".$_SESSION['log_message']."\r\n");
		fclose($file);
	}else{

		
	}
	}

}




