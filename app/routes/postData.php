<?php
require_once '../controller/C_blog.php';
require_once '../utils.php';
require_once '../model/Post.php';
//This endpoint provides the required data to show the main blog page

//1-Return all Categories that have at least 1 published post
//2-Return published posts by category, offset and limit (pagination) all this parameters should be optional


//** Security measures for post/put/delete
//it would not be necessary since it is for public data but might be useful
/**
 *  1-Make sure the right method is used (GET) Done
 *  2-Give a maximum of 20 request per minute. if exceeded then block the ip address for 1 hour
 *  3-Make sure the request comes from a legitimate site (token, something)
 */

$response = new stdClass;
//create new post
if($_SERVER['REQUEST_METHOD']==='POST'){

//Update post
}else if($_SERVER['REQUEST_METHOD']==='PUT'){
    echo file_get_contents("php://input");
    exit();
    // we get the author from the session

}else if($_SERVER['REQUEST_METHOD']==='DELETE'){

}
else if($_SERVER['REQUEST_METHOD']==='GET'){
    
    //send published categories
    if(isset($_GET['categories'])){
        $categories = BlogController::getCategoriesNames();
        //$categories = BlogController::getCategories();
        echo json_encode($categories);

    //Send post info for the editor
    //! to improve security we should add a token or check some variable on the session
    }else if(isset($_GET['allCategories'])){
        $categories = BlogController::getAllCategories();
        echo json_encode($categories);
    }
    else if(isset($_GET['title'])){
        $_GET['id']=25;
        $post = Post::getPost($_GET['id']);
        $authorInfo = Post::getAuthor(['profileImage','username','email','id'],null,$post['authorId']);
        $mainCategory = Post::getCategoryName($post['mainCategory']);
        $categories = Post::getPostCategories($_GET['id']);
        $postContents = Post::getPostContents($_GET['id']);
        $response = (object)[
            'postInfo'=>$post,
            'mainCategory'=>$mainCategory,
            'authorInfo'=>$authorInfo,
            'categories'=>$categories,
            'postContents'=>$postContents,
            'completed'=>true
        ];
        echo json_encode($response);
        exit;

    //Send published posts
    }else{

        $limit = isset($_GET['limit'])? intval($_GET['limit']): null;
        $offset = isset($_GET['offset'])? intval($_GET['offset']): null;
        $category = $_GET['category'] ?? null;
        $text = $_GET['text'] ?? null;
        $response->limit = $limit;
        $response->offset = $offset;
        $response->results = [];

        $posts;
        if($text){
            $posts = BlogController::getPostsByText($text,$limit,$offset);
        }else{
            $posts = BlogController::getPostsByCategory($limit,$offset,$category);
        }
        $response->posts = $posts;
        $response->category = $category;
        //var_dump($results);
        foreach($posts as $post){
            $postInfo = new stdClass;
            $postInfo->id = $post['id'];
            $postInfo->title = $post['title'];
            if(!externalResourceExists($post['mainImage'])){
                $postInfo->tadn='adasfasdfasdfasdf';
                $post['mainImage']="https://i.imgur.com/YcjzYu0.jpg";
            }
            $postInfo->mainImage = $post['mainImage'];
            $postInfo->publishingDate = $post['publishingDate'];
            $postInfo->body = $post['description'];
            $postIdentifier = str_replace(' ','-',$post['title']);
            $postInfo->url = 'blog/post.php?id='.$postIdentifier;
            $postInfo->authorInfo = BlogController::getAuthorById($post['authorId']);
            array_push($response->results,$postInfo);
        }
        echo json_encode($response);

    }
}
