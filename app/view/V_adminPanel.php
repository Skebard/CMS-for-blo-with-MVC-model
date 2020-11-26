<?php

class AdminPanelView{
    private $publishedPosts;
    private $draftPosts;
    private $deletedPosts;

    public function __construct($publishedPosts,$draftPosts,$deletedPosts){
        $this->publishedPosts =$publishedPosts;
        $this->draftPosts = $draftPosts;
        $this->deletedPosts = $deletedPosts;
    }

    public function printPublishedTable()
    {
        $html = '<div class="table published ">';
        $header =['Title','Publishing date','Creation date'];
        $html .= $this->createTableHeader('green',$header);
        foreach($this->publishedPosts as $post){
            if($post['STATUS']!='published'){
                continue;
            }
            $params = [$post['title'],$post['lastModificationDate'],$post['creationDate']];
            $html .= $this->createRow($params,$post['id']);
        }
        $html .='</div>';
        echo $html;
    }
    public function printDraftTable()
    {
        $html = '<div class="table draft ">';
        $header =['Title','Last modification date','Creation date'];
        $html .= $this->createTableHeader('blue',$header);
        foreach($this->draftPosts as $post){
            $params = [$post['title'],$post['lastModificationDate'],$post['creationDate']];
            $html .= $this->createRow($params,$post['id']);
        }
        $html .='</div>';
        echo $html;
    }
    public function printDeletedTable()
    {
        $html = '<div class="table deleted ">';
        $header =['Title','Deletion date','Creation date'];
        $html .= $this->createTableHeader('',$header);
        foreach($this->deletedPosts as $post){
            $params = [$post['title'],$post['lastModificationDate'],$post['creationDate']];
            $html .= $this->createRow($params,$post['id']);
        }
        $html .='</div>';
        echo $html;
    }
    private function createRow($params,$id)
    {
        $html = '<div data-id="'.$id.'" class="row post">';
        foreach ($params as $param) {
            $html .= '<div class="cell">'
                . htmlentities($param) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
    private function createTableHeader($color, $params)
    {
        $html = '<div class="row header ' . $color . ' ">';
        foreach ($params as $param) {
            $html .= '<div class="cell">'
                . htmlentities($param) .
                '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    public function printCategoryOptions($categories){
        foreach($categories as $category){
            echo "<option value='".$category['id']."' >".$category['name']."</option>";
        }
    }
}
