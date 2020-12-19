<?php
require_once __DIR__.'/../model/Blog.php';
require_once __DIR__.'/../utils.php';
class BlogController{
    public static function getCategoriesNames(){
        $categories = Blog::getPublishedCategories();
        return array_map(fn ($category)=>$category['name'],$categories);
    }
    public static function getAllCategories(){
        return Blog::getCategories();
    }

    public static function getPostsByCategory( int $limit=null,int  $offset=null,string  $category=null){
        if($category ==='All'){
            $category = null; //select all posts
        }
        return Blog::getPosts('published',$limit,$offset,null,$category);
    }

    public static function getAuthorById($authorId){
        $authorInfo = Blog::getAuthor(['profileImage','firstName','lastName1'],null,$authorId);
        if(!externalResourceExists($authorInfo['profileImage'])){
            $authorInfo['profileImage'] = "https://i.imgur.com/wIHZKq1.png";
        }
        return $authorInfo;
    }
    public static function getPostsByText(string $text,int $limit=null,int $offset=null){
        return Blog::getPostsByText($text,'published',$limit,$offset);
    }
    public static function publishPost($id){
        return Post::updateStatus($id,'published');
    }
    public static function withdrawPost($id){
        return Post::updateStatus($id,'draft');
    }
    public static function deletePost($id){
        return Post::updateStatus($id,'deleted');
    }
    public static function createPost($title,$mainImage,$description,$mainCategory){
        $authorId=$_SESSION['authorId'];
        Blog::createPost($authorId,$title,$mainImage,$description,$mainCategory);
    }
}

//var_dump(BlogController::getCategoriesNames());