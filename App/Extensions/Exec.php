<?php

class Exec{
	public static function memtime(){
		echo "Memmory usage: ". (memory_get_peak_usage(true) / 1024 / 1024) ." MB";
		echo " | Execution time: ". (round((microtime(true) - $GLOBALS['start']) * 1000, 2)) ." ms";
	}
}