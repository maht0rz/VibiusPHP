<?php
/**
 * Cookie-Handler is part of VibiusPHP.
 * Autor: Aaqib Anees
 * Date: 7.4.2014
 * Time: 5:29 AM
 * update : 8.4.2014 10:44 PM
 */
 
 
/*
// Set Cookie, Get Cookie and Remove Cookie
// $cook = Cookie::set( name, value, expiration)->get(name);
// $cook->get(name);
// $cook->remove();
// and check if cookie exist
// if( $cook->get(name) ) :
// and Also Check By Exists Function
// if(Cookie::exists('Mahtr0z'))
*/
class Cookie {
 
 
 
        function __construct( $key, $value, $expire ) {
                setcookie( $key, $value, $expire );
 
                        if(isset($_COOKIE[$key])) {
                                return true;
                        }else {
                                return false;
                        }
       
        }
 
 
        public static function set( $key, $value, $expire ) {
 
                if(!empty($expire) && !empty($key) && !empty($value)) {
 
                        $maker = new Cookie( $key, $value, time()+$expire );
                        return $maker;
                }else {
 
 
                }
 
               
        }
 
 
        public static function get( $name ) {
 
                if(!empty($name)) {
 
                        return ( isset( $_COOKIE[ $name ] ) ) ? $_COOKIE[ $name ] : '';
               
                }else{
 
                        return false;
                }
 
        }
 
 
        public static function exists( $name ) {
                if(isset( $_COOKIE[$name] )) {
                        return true;
                }else {
                        return false;
                }
        }
 
        public static function remove( $name ) {
                if( isset( $_COOKIE[$name]) ) {
 
                        unset( $_COOKIE[$name]);
 
                }
        }
 
 
 
}