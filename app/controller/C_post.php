<?php
require_once __DIR__.'/../model/post.php';
require_once __DIR__.'/../view/V_post.php';
class PostController {
    const NUM_RELATED_POSTS = 3;
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
        $contents = Post::getPostContents($this->postInfo['id']);
        PostView::printContents($contents);
        $relatedPosts = Post::getRelatedPosts($this->postInfo['id'],$this->postInfo['mainCategory'],self::NUM_RELATED_POSTS);
        //var_dump($relatedPosts);
        foreach($relatedPosts as &$relPost){
            $relPost['authorInfo']=Post::getAuthor(['firstName','lastName1','profileImage'],null,$relPost['authorId']);
            $relPost['mainCategoryName'] = Post::getCategoryName($relPost['mainCategory']);
            // echo "<h1>new REL</h1>";
            // var_dump($relPost);
        }
        PostView::printRelated($relatedPosts);
        PostView::scripts();
        PostView::closeMain();

        // PostView::printCategories()

    }
}


