<?php
require_once '../model/Blog.php';
class BlogController{
    public static function getCategoriesNames(){
        $categories = Blog::getPublishedCategories();
        return array_map(fn ($category)=>$category['name'],$categories);
    }
}

var_dump(BlogController::getCategoriesNames());