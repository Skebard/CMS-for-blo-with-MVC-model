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
        PostView::closeMain();

        // PostView::printCategories()

    }
}


