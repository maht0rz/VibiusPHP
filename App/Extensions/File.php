<?php


/*
##########################################################################################
	@maht0rz, VibiusPHP
##########################################################################################

  $_FILES[THIS IS FILENAME];
  
  File::handle(filename)->save('save folder');

  If file with the name of uploaded file exists, random string will be prepended to file name and file will be saved.
  
   File::handle(filename)->save('save folder',true);
  
  Before ->save(); we can use ->type(array('jpg','png','jpeg')) to set allowed extensions

   File::handle(filename)->type(array('jpg','png','jpeg'))->save('save folder',true);

  Before ->save(); we can use ->size(80000) to set maximum possible size of uploaded files

   File::handle(filename)->size(80000)->save('save folder',true);

  We can combine those methods:

   File::handle(filename)->type(array('jpg','png','jpeg'))->size(80000)->save('save folder',true);

  Our handler returns names of uploaded files:

  if($names = File::handle(filename)->type(array('jpg','png','jpeg'))->size(80000)->save('save folder',true)){
    print_r($names); //Array with names of uploaded files
  }else{
    echo "upload failed!";
  }


  Another methods:
	
	File::handle(filename)->getSize();

  HTML FORMS:
	usage of [] in name='' is important
  <input type='file' name='myFile[]' multiple='multiple' >



*/

class File{

	public static function handle($file){

		$instance = new File($file);
		return $instance;
	}

	public function __construct($file){

		$this->file = $file;
		$this->type = true;
		$this->maxSize = true;
		$this->error = false;
	}

	public function type($type){
		
	foreach ($_FILES[$this->file]['name'] as $t) {

	$t =explode('.',$t);
			if(in_array($t[1], $type)){

				$this->type = true;
			}else{
				$this->type = false;
				break;
			}
		}
		return $this;
	}

	public function getInfo(){
		return $_FILES[$this->file];
	}

	public function getSize(){
		$ar = array();
		foreach ($_FILES[$this->file]['size'] as $s) {
			array_push($ar,$s);
		}
		return($ar);
	}

	public function size($size){
		$this->size = $size;
		
		foreach ($_FILES[$this->file]['size'] as $s) {
			if(($s) <= $size){
				$this->maxSize = true;
			}else{
				$this->maxSize = false;
				break;
			}	
		}
		return $this;
		

	}

	public function status(){
		print_r($_FILES[$this->file]);
		print_r(get_object_vars($this));
		return $this;
	}

	public function names(){
		return $this->files;
	}

	public function error(){
		foreach ($_FILES[$this->file]['error'] as $e) {
			if($e == 0){
				$this->error = false;
			}else{
				$this->error = true;
				break;
			}
		}

		return $this;
	}

	public function randStr($l = 20){

		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randomString = '';
		   
		    for ($i = 0; $i < $l; $i++) {
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
				    }
			return $randomString;
	
	}

	public function save($path,$name = false,$c=5){
		$this->files = array();
		if(empty($path)){
			$f = "storage/";
		}else{
			$f = "storage/".$path."/";
		}
		
		if($this->type && $this->maxSize && !$this->error){
			
	        $num = count($_FILES[$this->file]['tmp_name']);

	        for($i=0;$i < $num;$i++){
	        	$fname = $_FILES[$this->file]['name'][$i];
	        	if(file_exists($f.$fname)){
	        		if($name){
		        		while(file_exists($f.$fname)){
		        				$fname = $this->randStr($c)."_".$_FILES[$this->file]['name'][$i];
		        		}
		        		array_push($this->files,$fname);
		        		move_uploaded_file($_FILES[$this->file]['tmp_name'][$i], $f.$fname);
	        		}else{

	        		}
	        	}
	        	else{
	        		move_uploaded_file($_FILES[$this->file]['tmp_name'][$i], $f.$fname);
	        		array_push($this->files,$fname);
	        	}
	        }
	        	return $this->files;
		}

			return false;

		
	}

}