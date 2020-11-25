<?php
require_once __DIR__.'/../model/Post.php';
require_once __DIR__.'/../view/V_post.php';
require_once __DIR__.'/../utils.php';
class PostController {
    const NUM_RELATED_POSTS = 3;
    const DEFAULT_POST_IMAGE = "https://i.imgur.com/YcjzYu0.jpg";
    const DEFAULT_AUTHOR_PROFILE_IMAGE = "https://i.imgur.com/wIHZKq1.png";
    public $title;
    public $id;

    public function __construct($title){
        $this->title = $title;
        $this->postInfo = Post::getPost(null,$title,'published');
        if(!$this->postInfo){
            throw new Exception ('Post does not exist');
        }
        $this->id = $this->postInfo['id'];
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
        //order by position
        uasort($contents,fn($a,$b)=>$a['position']-$b['position']);
        PostView::printContents($contents);
        $relatedPosts = Post::getRelatedPosts($this->postInfo['id'],$this->postInfo['mainCategory'],self::NUM_RELATED_POSTS);
        //var_dump($relatedPosts);
        foreach($relatedPosts as &$relPost){
            $relPost['authorInfo']=Post::getAuthor(['firstName','lastName1','profileImage'],null,$relPost['authorId']);
            $relPost['mainCategoryName'] = Post::getCategoryName($relPost['mainCategory']);
            $relPost['mainImage'] = externalResourceExists($relPost['mainImage'])?$relPost['mainImage']:PostController::DEFAULT_POST_IMAGE;
            $relPost['authorInfo']['profileImage'] = externalResourceExists($relPost['authorInfo']['profileImage'])?$relPost['authorInfo']['profileImage']:PostController::DEFAULT_AUTHOR_PROFILE_IMAGE;
        }
        PostView::printRelated($relatedPosts);
        PostView::scripts();
        PostView::closeMain();

        // PostView::printCategories()

    }


}


