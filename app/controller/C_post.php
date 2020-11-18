<?php
require_once __DIR__.'/../model/post.php';
require_once __DIR__.'/../view/V_post.php';
class PostController {
    public $title;

    public function __construct($title){
        $this->title = $title;
        $this->postInfo = Post::getPost(null,$title,null);
        if(!$this->postInfo){
            throw new Exception ('Post does not exist');
        }
    }

    //use view methods to print the view
    public function generatePost(){

        PostView::printTitle($this->postInfo['title'],$this->postInfo['mainImage']);
        $author = Post::getAuthor(['firstName','lastName1','profileImage'],null,$this->postInfo['authorId']);
        PostView::printAuthor($author['firstName'],$author['lastName1'],$author['profileImage'],$this->postInfo['publishingDate']);
        $categories = array_map(fn($cat)=>$cat['name'],Post::getPostCategories($this->postInfo['id']));
        $mainCategoryName = Post::getCategoryName($this->postInfo['mainCategory']);
        PostView::printCategories($mainCategoryName,$categories);
        PostView::closeMain();

        // PostView::printCategories()

    }
}


