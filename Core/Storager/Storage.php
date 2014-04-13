<?php
/*
	//create a local database
	Storage::createDB('dbName');

	//with created database we can procced to table creation

	Storage::open('dbName')->table('tableName',true);
    	//->table(nameOfTable,mode);, if mode is true, table is created if it
    	 does not already exists, same goes for MODE in another functions
	
	//if we have our table created, we have to define its structure, we can do so
	by creating __structure.php, inside of App/Storage/dbName/tableName/__structure.php
	structure file must look like this:
	
	#############################################################################################

	<?php

	$structure = array('username' => '','password' => '' ,'email' => '');
	
	#############################################################################################

	//for now keep the structure of 'key' => 'key', but keep the key empty => ''

	//Now we have our database and table, we can create table record(row)
   	Storage::open('dbName')->table('tableName')->row('rowName',true);
   		//we can set our mode to true, if we want to create row if it doesnt already exists

   	//we can operate our database by selecting desired table and row, and using those operations:
	
   	$data = Storage::open('dbName')->table('tableName')->row('rowName',true)->get();
   	//this will get our row content into a variable
   	instead of get we can use ->pluck('username') //or any other thing we want to get from our row
   							  ->insert(array('username' => 'value','key' => value))
   							  ->update(array('username' => 'Newvalue'))
   					Remember to check for errors using ->error(); at the end of operation // returns boolean
	$data = Storage::open('testDB')->table('testTable')->getTable(); //get all rows from table

	Where function:

	$data = Storage::open('dbName')->table('tableName')->getWhere('something','=','value');
	$data = Storage::open('dbName')->table('tableName')->pluckWhere('something','>=','value');
	We can also check if database/table/row exists using:

	Storage::exists(database,table,row);
	//table and row are optional parameters, so we can use it like Storage::exists('myDb')
	or Storage::exists('myDb','myTable') or just Storage::exists('myDb','myTable','myRow') 

	We can do the same for Storage::delete(database,table,row), both exists and delete return boolean values


*/
class Storage{

	

	public static function createDB($database){
		$file = dirname(__FILE__)."/../../App/Storage/".$database;
		if(file_exists($file)){
				return false;
		}
		return mkdir($file);
	}

	public static function delete($database,$table = false,$row = false){
		if($database && $table && $row){
			$file = dirname(__FILE__)."/../../App/Storage/".$database."/".$table."/".$row.".php";
			if(file_exists($file)){
				unlink($file);
				return true;
			}
		}else if($database && $table){
			$file = dirname(__FILE__)."/../../App/Storage/".$database."/".$table;
			if(file_exists($file)){
				unlink($file);
				return true;
				}
		}else{
			$file = dirname(__FILE__)."/../../App/Storage/".$database;
			if(file_exists($file)){
				unlink($file);
				return true;
			}
		}
		return false;
	}
 

	public static function exists($database,$table = false,$row = false){
		if($database && $table && $row){
			$file = dirname(__FILE__)."/../../App/Storage/".$database."/".$table."/".$row.".php";
			if(file_exists($file)){
				return true;
			}
		}else if($database && $table){
			$file = dirname(__FILE__)."/../../App/Storage/".$database."/".$table;
			if(file_exists($file)){
				return true;
			}
		}else{
			$file = dirname(__FILE__)."/../../App/Storage/".$database;
			if(file_exists($file)){
				return true;
			}
		}
		return false;
	}

	public static function open($database){
		$file = dirname(__FILE__)."/../../App/Storage/".$database;
		if(file_exists($file)){
			$instance = new Storage($database);
			return $instance;
		}
	}

	function __construct($database){
		$this->database = $database;
		$this->error = true;
	}

	public function table($table, $mode = false){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$table;
		if(file_exists($file)){
			$this->table = $table;
			return $this;
		}
		else if($mode){
				mkdir($file);
				$this->table = $table;
				return $this;
			}
		
		$this->error = false;
		return $this;
	}

	public function row($row, $mode = false){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$row.".php";
		if(file_exists($file)){
			$this->row = $row;
			return $this;
		}
		else if($mode){
				fopen($file,'a+');
				$this->row = $row;
				return $this;
			}
		
		$this->error = false;
		return $this;
	}

	public function update($data){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$this->row.".php";
		if(file_exists($file)){
			$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
			if(file_exists($struct)){

			include $struct;
				
				$dif = array_diff_key($data, $structure);
				if(empty($dif)){
					$old = unserialize(file_get_contents($file));
					foreach ($old as $key => $value) {
						$old[$key] = $data[$key];
					}
					$data = $old;
						$handle = fopen($file, "w+");
						fwrite($handle, serialize($data));
						fclose($handle);
						
				}else{
					$this->error = false;
				}
				

			}else{
				$this->error = false;
			}
		}else{
			$this->error = false;
		}
		return $this;
	}

	public function deleteWhere($what,$operator,$whatTo){


			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
				$table = array_slice($table, 2);
			$table = array_diff($table, array("__structure.php"));

			$content = array();
				foreach ($table as $key) {
					$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
					$handle = fopen($file, "r");
					$stuff = unserialize(file_get_contents($file));
					$thing = $stuff[$what];
					
					$checker = $whatTo;
					switch($operator){
						case '>':
							if($thing > $whatTo){
								unlink($file);
							}					
							break;
						case '>=':
							if($thing >= $whatTo){
								unlink($file);	
							}					
							break;
						case '<':
							if($thing < $whatTo){
									unlink($file);
							}					
							break;
						case '<=':
							if($thing <= $whatTo){
								unlink($file);
							}					
							break;
						case '=':
							if($thing == $whatTo){
								unlink($file);
							}					
							break;

					}
					
					#fclose($handle);
				}
			return $content;
		}
		return $this;


	}


	public function updateWhere($data,$what,$operator,$whatTo){


			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
				$table = array_slice($table, 2);
			$table = array_diff($table, array("__structure.php"));

			$content = array();
				foreach ($table as $key) {
					$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
					$handle = fopen($file, "r");
					$stuff = unserialize(file_get_contents($file));
					$thing = $stuff[$what];
					
					$checker = $whatTo;
					switch($operator){
						case '>':
							if($thing > $whatTo){
								$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
									if(file_exists($struct)){

									include $struct;
										
										$dif = array_diff_key($data, $structure);
										if(empty($dif)){
											$old = unserialize(file_get_contents($file));
											foreach ($old as $key => $value) {
												$old[$key] = $data[$key];
											}
											$data = $old;
												$handle = fopen($file, "w+");
												fwrite($handle, serialize($data));
												fclose($handle);
												
										}else{
											$this->error = false;
										}
										

									}else{
										$this->error = false;
									}
							}					
							break;
						case '>=':
							if($thing >= $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
									if(file_exists($struct)){

									include $struct;
										
										$dif = array_diff_key($data, $structure);
										if(empty($dif)){
											$old = unserialize(file_get_contents($file));
											foreach ($old as $key => $value) {
												$old[$key] = $data[$key];
											}
											$data = $old;
												$handle = fopen($file, "w+");
												fwrite($handle, serialize($data));
												fclose($handle);
												
										}else{
											$this->error = false;
										}
										

									}else{
										$this->error = false;
									}
							}					
							break;
						case '<':
							if($thing < $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
									if(file_exists($struct)){

									include $struct;
										
										$dif = array_diff_key($data, $structure);
										if(empty($dif)){
											$old = unserialize(file_get_contents($file));
											foreach ($old as $key => $value) {
												$old[$key] = $data[$key];
											}
											$data = $old;
												$handle = fopen($file, "w+");
												fwrite($handle, serialize($data));
												fclose($handle);
												
										}else{
											$this->error = false;
										}
										

									}else{
										$this->error = false;
									}
							}					
							break;
						case '<=':
							if($thing <= $whatTo){
								$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
									if(file_exists($struct)){

									include $struct;
										
										$dif = array_diff_key($data, $structure);
										if(empty($dif)){
											$old = unserialize(file_get_contents($file));
											foreach ($old as $key => $value) {
												$old[$key] = $data[$key];
											}
											$data = $old;
												$handle = fopen($file, "w+");
												fwrite($handle, serialize($data));
												fclose($handle);
												
										}else{
											$this->error = false;
										}
										

									}else{
										$this->error = false;
									}
							}					
							break;
						case '=':
							if($thing == $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
									if(file_exists($struct)){

									include $struct;
										
										$dif = array_diff_key($data, $structure);
										if(empty($dif)){
											$old = unserialize(file_get_contents($file));
											foreach ($old as $key => $value) {
												$old[$key] = $data[$key];
											}
											$data = $old;
												$handle = fopen($file, "w+");
												fwrite($handle, serialize($data));
												fclose($handle);
												
										}else{
											$this->error = false;
										}
										

									}else{
										$this->error = false;
									}
							}					
							break;

					}
					
					#fclose($handle);
				}
			return $content;
		}
		return $this;


	}

	public function insertWhere($data,$what,$operator,$whatTo){


			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
				$table = array_slice($table, 2);
			$table = array_diff($table, array("__structure.php"));

			$content = array();
				foreach ($table as $key) {
					$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
					$handle = fopen($file, "r");
					$stuff = unserialize(file_get_contents($file));
					$thing = $stuff[$what];
					
					$checker = $whatTo;
					switch($operator){
						case '>':
							if($thing > $whatTo){
								$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
								if(file_exists($struct)){
								include $struct;
									
									$dif = array_diff_key($data, $structure);
									if(empty($dif)){
											$handle = fopen($file, "w+");
											fwrite($handle, serialize($data));
											fclose($handle);
									}else{
										$this->error = false;
									}
									

								}else{
									$this->error = false;
								}
							}					
							break;
						case '>=':
							if($thing >= $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
								if(file_exists($struct)){
								include $struct;
									
									$dif = array_diff_key($data, $structure);
									if(empty($dif)){
											$handle = fopen($file, "w+");
											fwrite($handle, serialize($data));
											fclose($handle);
									}else{
										$this->error = false;
									}
									

								}else{
									$this->error = false;
								}
							}					
							break;
						case '<':
							if($thing < $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
								if(file_exists($struct)){
								include $struct;
									
									$dif = array_diff_key($data, $structure);
									if(empty($dif)){
											$handle = fopen($file, "w+");
											fwrite($handle, serialize($data));
											fclose($handle);
									}else{
										$this->error = false;
									}
									

								}else{
									$this->error = false;
								}
							}					
							break;
						case '<=':
							if($thing <= $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
								if(file_exists($struct)){
								include $struct;
									
									$dif = array_diff_key($data, $structure);
									if(empty($dif)){
											$handle = fopen($file, "w+");
											fwrite($handle, serialize($data));
											fclose($handle);
									}else{
										$this->error = false;
									}
									

								}else{
									$this->error = false;
								}
							}					
							break;
						case '=':
							if($thing == $whatTo){
									$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
								if(file_exists($struct)){
								include $struct;
									
									$dif = array_diff_key($data, $structure);
									if(empty($dif)){
											$handle = fopen($file, "w+");
											fwrite($handle, serialize($data));
											fclose($handle);
									}else{
										$this->error = false;
									}
									

								}else{
									$this->error = false;
								}
							}					
							break;

					}
					
					#fclose($handle);
				}
			return $content;
		}
		return $this;


	}

	public function insert($data){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$this->row.".php";
		if(file_exists($file)){
			$struct = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/__structure.php";
			if(file_exists($struct)){

			include $struct;
				
				$dif = array_diff_key($data, $structure);
				if(empty($dif)){
						$handle = fopen($file, "w+");
						fwrite($handle, serialize($data));
						fclose($handle);
				}else{
					$this->error = false;
				}
				

			}else{
				$this->error = false;
			}
		}else{
			$this->error = false;
		}
		return $this;
	}

	public function get(){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$this->row.".php";
		if(file_exists($file)){
			$handle = fopen($file, "r");
			$stuff = unserialize(file_get_contents($file));
			fclose($handle);
			return $stuff;
		}
		return $this;
	}

	public function getTable(){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
			
			$content = array();
			$table = array_slice($table, 2);
			$table = array_diff($table, array("__structure.php"));
			foreach ($table as $key) {
			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
			$handle = fopen($file, "r");
			$stuff = unserialize(file_get_contents($file));
			array_push($content, $stuff);
			fclose($handle);
			
			}
			return $content;
		}
		return $this;
	}

	public function getWhere($what,$operator,$whatTo){

			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
			$table = array_slice($table, 2);
			$content = array();
			$table = array_diff($table, array("__structure.php"));
				foreach ($table as $key) {
					$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
					$handle = fopen($file, "r");
					$stuff = unserialize(file_get_contents($file));
					$thing = $stuff[$what];
					
					$checker = $whatTo;
					switch($operator){
						case '>':
							if($thing > $whatTo){
								array_push($content, $stuff);
							}					
							break;
						case '>=':
							if($thing >= $whatTo){
								array_push($content, $stuff);
							}					
							break;
						case '<':
							if($thing < $whatTo){
								array_push($content, $stuff);
							}					
							break;
						case '<=':
							if($thing <= $whatTo){
								array_push($content, $stuff);
							}					
							break;
						case '=':
							if($thing == $whatTo){
								array_push($content, $stuff);
							}					
							break;

					}
					
					fclose($handle);
				}
			return $content;
		}
		return $this;
	}

	public function pluckWhere($pluck,$what,$operator,$whatTo){

			$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table;
		if(file_exists($file)){
			$table = scandir($file);
			$table = array_slice($table, 2);
			$content = array();
			$table = array_diff($table, array("__structure.php"));
				foreach ($table as $key) {
					$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$key;
					$handle = fopen($file, "r");
					$stuff = unserialize(file_get_contents($file));
					$thing = $stuff[$what];
					
					$checker = $whatTo;
					switch($operator){
						case '>':
							if($thing > $whatTo){
								array_push($content, $stuff[$pluck]);
							}					
							break;
						case '>=':
							if($thing >= $whatTo){
								array_push($content, $stuff[$pluck]);
							}					
							break;
						case '<':
							if($thing < $whatTo){
								array_push($content, $stuff[$pluck]);
							}					
							break;
						case '<=':
							if($thing <= $whatTo){
								array_push($content, $stuff[$pluck]);
							}					
							break;
						case '=':
							if($thing == $whatTo){
								array_push($content, $stuff[$pluck]);
							}					
							break;

					}
					
					fclose($handle);
				}
			return $content;
		}
		return $this;
	}

	public function pluck($name){
		$file = dirname(__FILE__)."/../../App/Storage/".$this->database."/".$this->table."/".$this->row.".php";
		if(file_exists($file)){
			$handle = fopen($file, "r");
			$stuff = unserialize(file_get_contents($file));
			fclose($handle);
			return $stuff[$name];
		}
		return $this;
	}

	public function status(){
		if(isset($this->error)){
			return $this->error;
		}
		return false;
	}






}