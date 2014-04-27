<?php


class Input{

	public static function exists($inputs){
		foreach ($inputs as $input) {
			$a = explode(':',$input);
			if($a[0] == 'POST' || $a[0] == 'post'){
				if(empty($_POST[$a[1]])){
					return false;
				}
			}else{
				if(empty($_GET[$a[1]])){
					return false;
				}
			}
		}
		return true;
	}


}