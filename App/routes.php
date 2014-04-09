<?php

/*
	VibiusPHP Router

*/

Router::setRoutes(array(
    '/' => function($args){
    	//Return welcomeView to user
    	View::make('welcomeView');
	}
));

