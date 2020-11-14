<?php
require_once 'db.php';
class Post{


    public static function getPosts($status=null,$limit=null,$offset=null,$categoryId=null,$categoryName=null,$excludedTitle=null,$excludedTitleId=null){
        $params =[];
        $sql = 'SELECT * FROM posts ';

        $status = $status ?? 'published';
        $sql .= 'WHERE STATUS = ?';
        array_push($params,$status);

        if($categoryName || $categoryId){
            $sql .= ' AND mainCategory IN (
                            SELECT id
                            FROM categories
                            WHERE ';
            if($categoryName){
                $sql .= 'name = ?) ';
                array_push($params,$categoryName);
            }else{
                $sql .= 'id = ?) ';
                array_push($params,$categoryId);
            }
        }

        if($excludedTitle || $excludedTitleId){
            $sql .= 'AND NOT ';
            if($excludedTitle){
                $sql .= 'title = ?';
                array_push($params,$excludedTitle);
            }else{
                $sql .= 'id = ?';
                array_push($params,$excludedTitleId);
            }
        }

        //for limit and offset we can not use ? cause the execute function form post
        //puts directly the params in the execute method of PDO and for numbers we should use bindValue
        if($limit){
            $sql .= 'LIMIT '.intval(htmlentities($limit)).' ';
        }
        if($offset){
            $sql .= 'OFFSET '.intval(htmlentities($offset)).' ';
        }
        return [$sql,$params];
    }
}


$query = Post::getPosts('published',5,0,null,null,null,8);
$stmt = Db::execute(...$query);

while($row = $stmt->fetch()){
    echo "<br>";
    echo "<br>";
    echo "<br>";
    print_r($row);
}
