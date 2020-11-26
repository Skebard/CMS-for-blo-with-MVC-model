<?php
require_once __DIR__.'/Post.php';
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

    public static function createPost($authorId,$title,$mainImage,$description,$mainCategory){
        $sql = 'INSERT INTO posts (authorId,title,mainImage,description,STATUS,mainCategory)
                    VALUES(?,?,?,?,"draft",?)';
        Db::execute($sql,[$authorId,$title,$mainImage,$description,$mainCategory]);
    }
}
