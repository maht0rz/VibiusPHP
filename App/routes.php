<?php

/*
	VibiusPHP Router

*/



Router::setRoutes(
	array(
		//this route is to demonstrate custom query within DB class, feel free to delete this route
	'profile/{id}' => function($args){
		$id=$args[1];
		$r = DB::Connect()->query("SELECT * FROM profiles WHERE id=:id OR id=:nextid")->execute(array(':id'=>$id,':nextid' => $id+1));
		var_dump($r);
	
	},
	'localStorage' => function($args){
		//this route is used to demonstrate usage of local storage, feel free to delete this route
		$database = 'myDB';
		if(!Storage::exists($database)){
			Storage::createDB($database);
		}else{
			Storage::open($database)->table('myNewTable',true)->row('myNewTableRecord',true)->update(array('username' => 'Matej Sima'));
		}
		
	},
    '/' => function($args){
      	
    	View::make('welcomeView');

    }

	)
);

