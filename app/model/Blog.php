<?php
require_once 'Post.php';
class Blog extends Post{
    public static function getPublishedCategories(){
        $sql = 'SELECT * FROM categories
                    WHERE id IN (
                        SELECT mainCategory from posts
                        WHERE STATUS = "published"
                    )';
        $stmt = Db::execute($sql);
        return $stmt->fetchAll();
    }
    public static function getCategories(string $status=null){
        $sql = 'SELECT * FROM categories ';
        $params =[];
        if($status){
            $sql .= 'WHERE STATUS=?';
            array_push($params,$status);
        }
        $stmt = Db::execute($sql,$params);
        return $stmt->fetchAll();

    }
}