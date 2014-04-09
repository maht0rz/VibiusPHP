<?php

class Hash{
	
	public static function check($string,$salt,$oldpass){
		
		
		$hashSalt = array('hash' => md5($string.$salt));


		if($hashSalt['hash'] == $oldpass){
			return true;
		}
	}

	public static function make($string){
		
		
		function generateRandomString($length = 140) {
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
				    }
			    return $randomString;
		}
		$salt = generateRandomString();
		$hashSalt = array('hash' => md5($string.$salt),'salt' =>$salt);
		
		return $hashSalt;
		
	}
	
	public static function makeNoSalt($string){
		
		return md5($string);
		
	}
	
}
