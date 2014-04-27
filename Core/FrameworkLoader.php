<?php
session_start();
$_SESSION['log_message'] = "";

class FrameworkLoader
{
    public static $autoload;
    public static $autoloaded = array();
    public static $dependencies = array();

    public function loadDependencies()
    {

        //autoload classes
        function __autoload($name)
        {    
            
       $instance = Autoload::load('sd');
       $file = $instance->check($name);
       require_once $file;

            /*
            $helpers = array('Hash', 'URL', 'Filter', 'Lang');
            $core = array('Storage','DB','Cache','View','Logger');


            if(in_array($name, $core)){
                switch ($name) {
                    case 'Storage':
                       require_once 'Storager/Storage.php';
                        break;
                    case 'DB':
                        require 'Models/Modeler.php';
                        break;
                    case 'Cache':
                        require 'Cache/Cache.php';
                        break;
                    case 'Cache':
                        require 'Cache/Cache.php';
                        break;
                    case 'View':
                        require 'View/View.php';
                        break;
                    case 'Logger':
                        require 'Logger/Logger.php';    
                        break;                
                    default:
                        # code...
                        break;
                }
                
            }else{
                  if (in_array($name, $helpers)) {
                        Logger::write('Loading Helper: ' . $name);
                        require_once 'Helpers/' . $name . '.php';
                    } else {
                        Logger::write('Loading extension: ' . $name);

                        if (file_exists('../App/Extensions/' . $name . '.php')) {

                            require_once '../App/Extensions/' . $name . '.php';
                        } else {

                            require_once dirname(__FILE__) . '../../App/Extensions/'.$name.'.php';
                        }


                    }
            }
          
            
            */
        }

        require 'Logger/Logger.php';
        require 'Autoloader/Autoload.php';
        require 'OutputBuffer/OutputBuffer.php';
        require 'ErrorHandler/ErrorHandler.php';
        
                         

     
        require '../App/Hooks/Hooks.php';

        require 'Router/Router.php';


        require '../App/Config/configApp.php';
        require '../App/Config/configDB.php';
        require '../App/routes.php';


    }


    public function run()
    {   
        $this->loadDependencies();
    }


}

$Framework = new FrameworkLoader();
