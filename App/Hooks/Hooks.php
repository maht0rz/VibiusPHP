<?php

/*
 * Hooks determine what happens on some events, e.g: before router starts (preRouter)
 */

class Hooks
{

    public static function preRouter()
    {

        #echo "\nI am pre router";

    }

    public static function preController()
    {

        #echo "\nI am pre controller.";

    }


    public static function preModel()
    {

        #echo "\nI am pre model";

    }

    public static function preExtension()
    {


    }

    public static function preOutput()
    {

        #echo "\nI am pre output";

    }

}
