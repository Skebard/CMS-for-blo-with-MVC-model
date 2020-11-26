<?php

require_once __DIR__."/../model/Post.php";
require_once __DIR__."/../view/V_adminPanel.php";

class AdminPanelController{
    public $posts;
    //from each post we want the following info
    // title,id, publishingData, creationDate, lastModificationDate
    //deletionDate = lastModificationDate
    public function __construct(int $authorId){
        $this->posts = Post::getPostsByAuthor($authorId);
        $publishedPosts = array_values(array_filter($this->posts,fn($post)=>$post['STATUS']==='published'));
        $draftPosts = array_values(array_filter($this->posts,fn($post)=>$post['STATUS']==='draft'));
        $deletedPosts = array_values(array_filter($this->posts,fn($post)=>$post['STATUS']==='deleted'));
        $this->view = new AdminPanelView($publishedPosts,$draftPosts,$deletedPosts);
    }
    public function generateTables(){
        $this->view->printPublishedTable();
        $this->view->printDraftTable();
        $this->view->printDeletedTable();
    }

    public function generateCategoryOptions(){
        
    }
}