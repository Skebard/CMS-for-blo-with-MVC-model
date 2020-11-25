<?php
session_start();
require '../Utility/Session.php';

if(!Session::checkSession()){
    header('Location: adminLogin.php');
    exit;
}else{
    Session::delete();
    header('Location: ../../adminLogin.php');
}