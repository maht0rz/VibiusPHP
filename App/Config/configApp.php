<?php

class configApp
{

    public static $localhost = true;

    public static $local_folder = 1;

    public static $debug = true;

    public static $log = true;

    public static $keep_log_files = 7; //DAYS


    public static function Error($e)
    {

        echo "<b>This is an error message, can be configured in App/Config/configApp.php</b>";
        echo $e;

    }


}
