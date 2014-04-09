<?php

class myModel{

	public static function myFunction(){
		$query = DB::table('profiles')->get();
		return $query;
	}
	
}