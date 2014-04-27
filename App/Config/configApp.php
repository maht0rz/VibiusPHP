<?php

class configApp
{

    public static $localhost = true;

    public static $local_folder = 1;

    public static $debug = false;

    public static $log = true;

    public static $keep_log_files = 7; //DAYS


    public static function Error($e)
    {

        echo "<b>An error has occured!</b><small>".$e."</small>";

    }


}
