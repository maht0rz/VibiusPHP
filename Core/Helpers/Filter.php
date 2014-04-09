<?php

class Filter{
	
	public static function sql($input){
		
		  $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
   		  $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

  		  return str_replace($search, $replace, $input);
		
		
	}
	
	public static function xss($input){
		
		return htmlspecialchars($input);
	}
	
}
