<?php

/*
	VibiusPHP Router

*/
Router::setRoutes(
    array(
        '/' => function ($args) {
      		 View::make('welcomeView');
         }
    )
);
 