<?php
require_once '../app/controller/C_post.php';

if($_SERVER['REQUEST_METHOD']!=='GET' || !isset($_GET['id'])){
    header('Location: ../blog.php');
    exit;
}else{
    try{
        $controller = new PostController($_GET['id']);
    }catch(Exception $e){
        echo 'id does not exist';
        exit;
    }
    require '../app/view/templates/header.php';
    $controller->generatePost();


    require '../app/view/templates/footer.php';
}

