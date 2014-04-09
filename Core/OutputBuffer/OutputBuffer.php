<?php

class OutputBuffer{
	
	public static $bufferedOutput;
	
	public static function startBuffering(){
		ob_start();
		
	}
	
	public static function cleanBuffer(){
		ob_clean();
	}
	
	public static function getBufferedOutput(){
		self::$bufferedOutput = ob_get_clean();

		
	}

	public static function getCurrentOutput(){
		return ob_get_contents();
	}
	
	public static function displayBufferContent(){
	
		OutputBuffer::getBufferedOutput();
		
		$error = error_get_last();
		if($error['type'] > 0){	
			
		}else{

			Hooks::preOutput();
			echo self::$bufferedOutput;
			
		}
		
		
	}
	
}

OutputBuffer::startBuffering();


