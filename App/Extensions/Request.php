<?php

class Request{
	public static function detect($type){
		if(strtoupper($type) == $_SERVER['REQUEST_METHOD']){
			return true;
		}

		if($type == 'ajax'){
			if(isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest'){
				return true;
			}
		}


		return false;
	}
}