<?php
define('EXPIRING_TIME',10);
class Session{

    public static function delete(){
        session_destroy();
    }
    
    public static function put($key,$value){
        return ($_SESSION[$key]=$value);
    }

    public static function exists($key){
        return isset($_SESSION[$key]);
    }

    //we need to check if the session is active, expired and renew the session
    public static function checkSession(){
        if(!isset($_SESSION['logged']) || (time()>$_SESSION['expire'])){
            return false;
        }
        $_SESSION['expire'] = time() + EXPIRING_TIME*60;
        return true;
    }


}