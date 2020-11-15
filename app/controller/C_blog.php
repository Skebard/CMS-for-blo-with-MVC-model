<?php
require_once '../model/Blog.php';
require_once '../utils.php';
class BlogController{
    public static function getCategoriesNames(){
        $categories = Blog::getPublishedCategories();
        return array_map(fn ($category)=>$category['name'],$categories);
    }

    public static function getPostsByCategory( int $limit=null,int  $offset=null,string  $category=null){
        if($category ==='All'){
            $category = null; //select all posts
        }
        return Blog::getPosts('published',$limit,$offset,null,$category);
    }

    public static function getAuthorById($authorId){
        $authorInfo = Blog::getAuthors(['profileImage','firstName','lastName1'],null,$authorId);
        if(!externalResourceExists($authorInfo['profileImage'])){
            $authorInfo['profileImage'] = "https://i.imgur.com/wIHZKq1.png";
        }
        return $authorInfo;
    }
    public static function getPostsByText(string $text,int $limit=null,int $offset=null){
        return Blog::getPostsByText($text,'published',$limit,$offset);
    }
}

//var_dump(BlogController::getCategoriesNames());