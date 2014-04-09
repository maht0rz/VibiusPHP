<?php


class DB{

	public static $database;
	public static $query;
	public static $table;
	public static $where;
	
	public static function load($name){
		Hooks::preModel();
		Logger::write('Loading model: '.$name);
		require dirname(__FILE__)."/../../App/Models/".$name.'.php';
	}
	
	public  function query($query){
		self::$query = self::$database -> prepare($query); 

		return $this;
	}

	public  function execute($params = array()){

		self::$query->execute($params);
		$results = self::$query->fetchAll();
		return $results;

	}

	public static function Connect(){
		self::$database = 	new PDO(configDB::$type.":host=".configDB::$host.";dbname=".configDB::$dbname.";charset=utf8", configDB::$username, configDB::$password);
		$db = new DB();
		return $db;
	}
	public static function table($table){
		self::$database = new PDO(configDB::$type.":host=".configDB::$host.";dbname=".configDB::$dbname.";charset=utf8", configDB::$username, configDB::$password);
		self::$table = $table;
		$db = new DB;
		
		return $db;
	}
	
	public function get(){
		$table = self::$table;
		
		if (isset(self::$where)){
			
		self::$query = self::$database->prepare("SELECT * FROM ".$table." WHERE ".self::$where);
			
		}else{
			
		self::$query = self::$database->prepare("SELECT * FROM ".$table);
		
		}
		
		
		self::$query->execute();
		$rows = self::$query->fetchAll();
		return $rows;
	}
	
	public function pluck($string){
		$table = self::$table;
		
		if (isset(self::$where)){
			
		self::$query = self::$database->prepare("SELECT ".$string." FROM ".$table." WHERE ".self::$where);
			
		}else{
			
		self::$query = self::$database->prepare("SELECT ".$string." FROM ".$table);
		
		}
		
		self::$query->execute();
		$rows = self::$query->fetchAll();
		return $rows;
		
	}
	
	public function where($what,$operator,$whatTo){
		
		self::$where = $what." ".$operator." "."'".$whatTo."'";
		
		return $this;
		
	}
	
	public function delete(){
		
		self::$query = self::$database->prepare("DELETE FROM ".self::$table." WHERE ".self::$where);
		self::$query->execute();
		return $this;
		
	}
	
	public function update($what){
	
		foreach($what as $key => $value){
			
			$query = "SET ".$key."='".$value."'";
			
		}
		
		echo "UPDATE ".self::$table." ".$query." WHERE ".self::$where;
		self::$query = self::$database->prepare("UPDATE ".self::$table." ".$query." WHERE ".self::$where);
		self::$query->execute();
		return $this;
		
	}
	
	public function insert($what){
	
	
			$keys = array_keys($what);
			$values = array_values($what);
			
			$finalkeys="";
			foreach ($keys as $keys) {
				
			$finalkeys = $finalkeys.",".$keys;
				
			}
			$finalkeys = ltrim ($finalkeys,',');
			#echo $finalkeys;
			
			$finalvalues = "";
			foreach ($values as $values) {
				
			$finalvalues = $finalvalues.",'".$values."'";
				
			}
			$finalvalues = ltrim ($finalvalues,',');
			#echo $finalvalues;
			
			#var_dump($this->connector,"INSERT INTO ".$this->table." (".$finalkeys.") VALUES (".$finalvalues.")");
			
		
		self::$query = self::$database->prepare("INSERT INTO ".self::$table." (".$finalkeys.") VALUES (".$finalvalues.")");
		self::$query->execute();
		
		return $this;
		
	}
	
	
}



