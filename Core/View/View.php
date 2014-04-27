<?php

class View
{
    private static $parse = array();

    public static function make($view_name, $args = array())
    {

        $instance = new View;
        $instance->display($view_name, $args);

        return $instance;
    }

    private function display($view_name, $args)
    {
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }
        $file = dirname(__FILE__) . '/../../App/Views/' . $view_name . '.php';
        $view = file_get_contents($file);
       $view = View::parse($view);
        $view = str_replace('{{', '<?php echo ', $view);
        $view = str_replace('}}', ' ?>', $view);
        eval('?>' . $view );


        return $this;
    }

    public static function load($view_name){
        $file =  dirname(__FILE__) . '/../../App/Views/' . $view_name . '.php';
       
        $instance = new View;
        $instance->view = file_get_contents($file);
        $instance->view = View::parse($instance->view);
        return $instance;
    }

    private static function parse($view){
          $re1='(\\{)'; # Any Single Character 1
          $re2='(\\{)'; # Any Single Character 2
          $re3='(\\$)'; # Any Single Character 3
          $re4='((?:[a-z][a-z]+))'; # Word 1
          $re5='(_)';   # Any Single Character 4
          $re6='((?:[a-z][a-z]+))'; # Word 2
          $re7='(\\})'; # Any Single Character 5
          $re8='(\\})'; # Any Single Character 6

          $results = array();
          $txt = preg_split("/".$re1.$re2.$re3."/is", $view);

            foreach ($txt as $value) {
               if ($c=preg_match_all ("/".$re4.$re5.$re6."/is", $value, $matches))
              {
                  $c1=$matches[1][0];
                  $c2=$matches[2][0];
                  $c3=$matches[3][0];
                 array_push($results, $c1.$c2.$c3);
                 # print "($c1) ($c2) ($c3) ($word1) ($c4) ($word2) ($c5) ($c6) \n";
              }
            }
           
            foreach ($results as $key) {
                $operators = explode('_',$key);
               
                foreach (self::$parse as $key => $value){
                   if($key == $operators[0]){
                   $replacer = $value($operators[1]);
                   $search = '{{$'.$key.'_'.$operators[1]."}}";
                   
                  $view = str_replace($search, $replacer, $view);
                    
                   }
                }
            }
            return $view;
    }

    public static function addParser($key,$func){

        self::$parse[$key] = $func;

        if(is_callable($func)){
            return true;
        }

    }

    public function vars($args = array()){
        foreach ($args as $key => $value) {
            ${$key} = $value;
        }
        /*
            ?> inside eval() was suggested by Richard Dobron ! < yay >
        */
        
        $view =  $this->view;
        $view = str_replace('{{', '<?php echo ', $view);
        $view = str_replace('}}', ' ?>', $view);
        eval('?>' . $view );


       
    }


}
