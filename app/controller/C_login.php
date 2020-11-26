<?php

//check session
//validate password
//count attempts for IP address
require_once __DIR__.'/../Utility/Session.php';
session_start();


if($_SERVER['REQUEST_METHOD']!=='POST'){
    exit;
}else{

    $clientIP = $_SERVER['REMOTE_ADDR'];
    


    if(!isset($_POST['username'],$_POST['password'],$_POST['token_csrf'])){
        exit;
    }

    //check csrf
    if($_POST['token_csrf']!==$_SESSION['csrf']){
        echo 'wrong';
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    require __DIR__.'/../model/Author.php';
    if(!Author::login($username,$password)){
        header('Location: ../../adminLogin.php?username='.$username);
        exit;
    }
    $author = new Author($username);
    $authorId = $author->getAuthorId();
    $profileImage = $author->getProfileImage();
    echo $authorId;
    Session::put('authorId',$authorId);
    Session::put('logged',true);
    Session::put('expire',time()+EXPIRING_TIME*60);
    Session::put('profileImage',$profileImage);
    //redirect to the adminPanel
    header('Location: ../../adminPanel.php');
    exit;


}