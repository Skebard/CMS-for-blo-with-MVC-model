<?php
declare(strict_types = 1);
require_once 'db.php';
class Post{

    /**
     * Searches the posts given certain constraints and returns a query with question mark placeholders and the corresponded values
     * to be used in a prepare/execute methods of PDO
     *
     * @param string  $status (optional) indicates whether the post is 'published', 'draft' or 'deleted'. By default it is set to 'published'
     * @param string $limit  (optional) if set, it defines maximum number of posts to retrieve. If not set there it will return all the posts that match the conditions
     * @param string $offset (optional) Number of results to skip. If not set it will not be applied
     * @param string $categoryId (optional) if set it will match only posts belonging to that category
     * @param string $categoryName (optional) as $categoryId but using the name of the category
     * @param string $excludedTitle (optional) post to skip in case it is found
     * @param string $excludedTitleId (optional) as $excludedTitle but indicating the id
     * @return array  The first element contains the query with the question mark placeholders and the second element contains the array of values ordered as the ? placeholder
     */
    public static function getPosts(string $status=null,int $limit=null,int $offset=null, int $categoryId=null, string $categoryName=null,string $excludedTitle=null,int $excludedTitleId=null){
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

        //for limit and offset we can not use ? (question mark placeholders) cause the execute function form post
        //puts directly the params in the execute method of PDO and for numbers we should use bindValue
        if($limit){
            $sql .= 'LIMIT '.intval(htmlentities(strval($limit))).' ';
        }
        if($offset){
            $sql .= 'OFFSET '.intval(htmlentities(strval($offset))).' ';
        }
        $stmt =  Db::execute($sql,$params);
        return $stmt->fetchAll();
    }

    public static function getAllPosts(){
        $sql = 'SELECT * FROM posts';
        Db::execute($sql);
        $stmt = Db::execute($sql);
        return $stmt->fetchAll();
    }

}


$posts = Post::getPosts('published',5,9,null,null,null,8);
$allPosts = Post::getAllPosts();
print_r($posts);

echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo $_SERVER['REMOTE_ADDR'];
//print_r($allPosts);

