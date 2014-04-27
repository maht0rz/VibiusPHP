<?php

class Cache
{

    public static function getExact($name)
    {
        $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files); 

        if (!empty($file)) {
                $file = explode('.', $file[1]);
                if (!empty($file[0])) {

                    $filee = explode('^', $file[0]);
                    if ($filee[2] == $name) {
                        var_dump($filee);
                        $returned = implode('^', $filee);
                        $returned = dirname(__FILE__) . "/../../App/Cache/" . $returned;
                        $ser = file_get_contents($returned . ".php");
                        return unserialize($ser);
                    }

                }
        }
    }

    public static function createExact($timeout, $name, $content)
    {

        $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files); 

        if (!empty($file)) {
                $file = explode('.', $file[1]);
                if (!empty($file[0])) {

                    $filee = explode('^', $file[0]);

                    if ($filee[2] == $name) {
                        Cache::delete($name);
                    }

                }
        }

        $f = dirname(__FILE__) . "/../../App/Cache/" . $timeout . "^" . time() . "^" . $name . ".php";

        $file = fopen($f, 'w+');
        $cacheData = $content;
        fwrite($file, serialize($cacheData));


    }

 

    public static function create($timeout, $name)
    {

         $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files); 

        if (!empty($file)) {
                $file = explode('.', $file[1]);
                if (!empty($file[0])) {
                    $filee = explode('^', $file[0]);
                    if ($filee[2] == $name) {
                        Cache::delete($name);
                    }
                } 
        }

        $f = dirname(__FILE__) . "/../../App/Cache/" . $timeout . "^" . time() . "^" . $name . ".php";

        $file = fopen($f, 'w+');
        $cacheData = OutputBuffer::getCurrentOutput();
        fwrite($file, $cacheData);

    }


    public static function get($name)
    {
        $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files);
        
        if(!empty($file)){
             $file = explode('.', $file[1]);
                if (!empty($file[0])) {

                    $filee = explode('^', $file[0]);

                    if ($filee[2] == $name) {
                        $returned = implode('^', $filee);
                        $returned = dirname(__FILE__) . "/../../App/Cache/" . $returned;
                        $f = file_get_contents($returned . ".php");
                        return $f;
                    }

            }
        }
    }

    public static function delete($name)
    {
        $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files);

        if (!empty($file)) {
                $file = explode('.', $file[1]);
                if (!empty($file[0])) {
                    $ex = explode('^', $file[0]);

                    if ($ex[2] == $name) {
                        $file = dirname(__FILE__) . "/../../App/Cache/" . $file[0] . ".php";
                        unlink($file);
                    }

                }
        }
    }

    public static function exists($name)
    {

        $files = scandir(dirname(__FILE__) . "/../../App/Cache/", 1);
         $re1='(\\d+)'; # Integer Number 1
          $re2='(\\^)'; # Any Single Character 1
          $re3='(\\d+)';    # Integer Number 2
          $re4='(\\^)'; # Any Single Character 2
           $re5='('.$name.')';   # Word 1
          $re6='(\\.)'; # Any Single Character 3
          $re7='(php)'; # Word 2

        $file = preg_grep("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is",$files);

        if (!empty($file)) {
                $file = explode('.', $file[1]);
                if (!empty($file[0])) {
                    $filee = explode('^', $file[0]);
                    $file = explode('^', $file[0]);
                    if(($file[1] - time()) >= -$file[0]){
                        return true;
                    }
                }
        }
    }

}
