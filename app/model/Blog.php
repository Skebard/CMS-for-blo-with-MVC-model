<?php
require_once 'db.php';
class Blog{
    public static function getPublishedCategories(){
        $sql = 'SELECT * FROM categories
                    WHERE id IN (
                        SELECT mainCategory from posts
                        WHERE STATUS = "published"
                    )';
        $stmt = Db::execute($sql);
        return $stmt->fetchAll();
    }
}