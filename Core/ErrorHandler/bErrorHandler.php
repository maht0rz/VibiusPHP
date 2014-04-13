<?php

class ErrorHandler{
	
	public static function getLayout(){
	
	echo "
	
		<html>
			<head>
				<link href='http://fonts.googleapis.com/css?family=Gafata' rel='stylesheet' type='text/css'>
				<style>
				html,body{
					font-family: 'Gafata', sans-serif;
					}
				.box{
					box-shadow:0px 0px 2px #333;
					width:60%;
					min-width:305px;
					margin:0 auto;
					padding:15px;
					padding-top:2px;
					margin-top:35px;
					}
				</style>
			</head>
			
			<body>
	
	";	
		
	}
	
	public static function CheckForError(){
		
		$error = error_get_last();
		if($error['type'] > 0){
			OutputBuffer::cleanBuffer();
			
			$message = "Debugger: ".$error['message'].", ".$error['file']." at line ".$error['line'];
			Logger::write($message);
			
				if(configApp::$debug){
					
					ErrorHandler::getLayout();
					
			echo "
			
				<div class='box'>
				<CENTER>
				<h1>VibiusPHP | Debugger</h1>
				</center>
				<h2>What's wrong?</h2>
					".$error['message']."			
				<h2>Where it is wrong?</h2>
					".$error['file']." at line ".$error['line']."
					
				<center>
				<br><br><span style='padding-right:7px;'>Memory usage: ".(memory_get_peak_usage(true) /1024 / 1024)." MB</span>
				|<span style='padding-left:7px;'>Generated in: ".(round((microtime(true) - $GLOBALS['start']) * 1000, 2))."ms<span></div>
		
				
				
				
				</div>
			
			";
					
				}else{

					configApp::Error();
				}
	
	 		}else{
		OutputBuffer::displayBufferContent();
		}
		
		
	}
	
	public static function HandleError($error){
	echo "<pre>";
		var_dump($error);
	}
	
}
error_reporting(0);
function shutdown(){
	
	ErrorHandler::CheckForError();
	Logger::addToLog();
}
register_shutdown_function('shutdown');


