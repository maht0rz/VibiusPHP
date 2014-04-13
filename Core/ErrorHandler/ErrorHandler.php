<?php

class ErrorHandler{
	
	public static function getLayout(){
	
	echo "
	
		<html>
			<head>
				<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>


				<style>
				html,body{
					padding:0;
					margin:0;
					background-color:#1C1C19;
				font-family: 'Open Sans Condensed', sans-serif;
					min-width:1300px;
					height:100%;
					max-height:100%;
					}
					
						::-webkit-scrollbar
						{
						  width: 12px;  /* for vertical scrollbars */
						  height: 12px; /* for horizontal scrollbars */
						}

						::-webkit-scrollbar-track
						{
						  background: rgba(0, 0, 0, 0.1);
						}

						::-webkit-scrollbar-thumb
						{
						  background: rgba(0, 0, 0, 0.5);
						}
					.sidebar{
						position:relative;
						top:0;
						color:#fff;
						overflow-y:scroll;
						width:20%;
						height:100%;
						background:#121110;
						box-shadow:inset 0px 0px 2px #333;
						
					}
					.topbar{
						position:relative;
						float:right;
						top:0;
						width:78%;
						padding:1%;
						min-height:50px;
						padding-top:10px;
						padding-bottom:10px;
						background:#FFb43e;
						box-shadow:inset 0px 0px 2px #333;
					}
					.head{
						position:relative;
						top:-10px;
						font-weight:bold;
						font-size:25px;
						text-shadow:0px 0px px #222;
						color:#121110;
					}
					.msg{
						max-height:100px;
						overflow-y:scroll;
						position:relative;
						top:-20px;
						font-size:16px;
						color:#1112;
					}
					.dumper{
						padding:15px;
						background:#1C1C19;
						padding-right:13px;
						max-height:150px;
						overflow-y:scroll;
						
					}
					.dumperh{
						padding-left:15px;
						padding-bottom:0px;
					}
					.main{
						position:relative;
						top:-80%;
						float:right;
						background-color:#1C1C19;
						width:78%;
						padding:1%;
						color:#fff;
					}
					.code{
						width:98%;
						padding:15px;
						padding-top:0px;
						border-radius:1px;
						background:#121110;
						overflow-y:scroll;
					}
					.linewrong{
						color:#FF3C2D;
					}
					.linenum{
						background:#222;
						padding:2px;
						padding-right:5px;
						padding-left:5px;
					}
				</style>
			</head>
			
			<body>
	
	";	
		
	}
	
	public static function CheckForError(){
		/*
.(memory_get_peak_usage(true) /1024 / 1024).

.(round((microtime(true) - $GLOBALS['start']) * 1000, 2)).

		*/
		$error = error_get_last();
		if($error['type'] > 0){
			OutputBuffer::cleanBuffer();
			
			$message = "Debugger: ".$error['message'].", ".$error['file']." at line ".$error['line'];
			Logger::write($message);
			function getByLine(){
				
			}

			function dump($what){
			return print_r($what, true);
			}
			
				if(configApp::$debug){
					
					ErrorHandler::getLayout();
					
				echo '

					<div class="topbar">
					<p class="head"><b>VibiusPHP Debug Panel</b></p>
					<p class="msg">
					'.$error['message'].' in file '.$error['file'].', at line '.$error['line'].'
					</p>
					</div>
				<div class="sidebar">
				<p class="dumperh">REQUEST LOG:</p>
					<p class="dumper"> 
						'.$_SESSION['log_message'].'
					</p>
				<p class="dumperh">Memmory usage:</p>
					<p class="dumper"> 
						'.(memory_get_peak_usage(true) /1024 / 1024).' MB
					</p>
					<p class="dumperh">Execution time:</p>
					<p class="dumper"> 
						'
.(round((microtime(true) - $GLOBALS['start']) * 1000, 2)).' ms
					</p>
				<p class="dumperh">POST:</p>
					<p class="dumper"> 
						'.dump($_POST).'
					</p>
					<p class="dumperh"7F3027>GET:</p>
					<p class="dumper"> 
						'.dump($_GET).'
					</p>
					<p class="dumperh">COOKIE:</p>
					<p class="dumper"> 
						'.dump($_COOKIE).'
					</p>
					<p class="dumperh">SESSION:</p>
					<p class="dumper"> 
						'.dump($_SESSION).'
					</p>
					</div>	

					<div class="main">
<p>'.$error['file'].' :</p>
<p class="code">
'; 
				
				$error = error_get_last();
				$lines = file($error['file']);
				$num = $error['line'];
				for($i=$num-7;$i<$num+7;$i++){
					if($i == $num-1){
						echo "<span class='linewrong'>";
					}
					$k = $i+1; 
					if($k >= 1){
						echo "<br><span class='linenum'>".$k."</span> <b style='padding-left:5px;'>".htmlentities($lines[$i])."</b>";
					
					}
					if($i == $num-1){
						echo "</span>";
					}
				}
echo '
</p>
					</div>
				';
					
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


