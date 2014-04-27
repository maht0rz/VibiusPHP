<?php

class Autoload{

	public static $instance;
	public static $autoloaded = array();

	public function buffer(){

	}
	public function check($name){
		
		$helpers = array('Hash', 'URL', 'Filter', 'Lang');
        $core = array('Storage','DB','Cache','View','Logger');

         if(in_array($name, $core)){
                switch ($name) {
                    case 'Storage':
                       $file = dirname(__FILE__) . '/../Storager/Storage.php';
                       return $file;
                        break;
                    case 'DB':
                        $file =  dirname(__FILE__) . '/../Models/Modeler.php';
                        return $file;
                        break;
                    case 'Cache':
                        $file =  dirname(__FILE__) . '/../Cache/Cache.php';
                        return $file;
                        break;
                    case 'View':
                        $file = dirname(__FILE__) . '/../View/View.php';
                        return $file;
                        break;
                    case 'Logger':
                        $file =  dirname(__FILE__) . '/../Logger/Logger.php';    
                        return $file;
                        break;                
                    default:
                        # code...
                        break;
                }
                
            }else{
                  if (in_array($name, $helpers)) {
                        Logger::write('Loading Helper: ' . $name);
                        $file = 'Helpers/' . $name . '.php';
                        return $file;
                    } else {
                        Logger::write('Loading extension: ' . $name);

                        if (file_exists('../App/Extensions/' . $name . '.php')) {

                            $file = '../App/Extensions/' . $name . '.php';
                            return $file;
                        } else {

                            $file =  dirname(__FILE__) . '../../App/Extensions/'.$name.'.php';
                            return $file;
                        }


                    }
            }

	}
	public static function load(){
		if(!isset(self::$instance)){
			self::$instance = new Autoload;
		}
		
		return self::$instance;
	}

}