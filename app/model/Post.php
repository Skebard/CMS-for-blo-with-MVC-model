<?php
declare(strict_types = 1);
require_once __DIR__.'/db.php';
class Post{
    //white list to avoid sql injections
    const AUTHOR_COLUMNS = ['id','username','password','firstName','lastName1','lastName2','birthdate','profileImage','email','*'];
    protected $title;
    protected $conn;
    public $postInfo;
    protected $categories = [];
    protected $author;
    protected $contents;
    function __construct($title)
    {
    }




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
     * @return array  Found posts
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

    public static function getAuthor(array $columns = null,string $authorUsername=null,int $authorId=null){
        $params = [];
        $sql = 'SELECT ';
        if($columns){
            foreach($columns as $column){
                if(in_array($column,Post::AUTHOR_COLUMNS)){
                    $sql .= $column;
                    if($column!==end($columns)){
                        $sql .=',';
                    }
                }
            }
        }else{
            $sql .= '* ';
        }
        $sql .=' FROM authors ';
        if($authorUsername){
            $sql .= ' WHERE username =? ';
            array_push($params,$authorUsername);
        }else if($authorId){
            $sql .= ' WHERE id =? ';
            array_push($params,$authorId);
        }
        //var_dump($params);
        $stmt = Db::execute($sql,$params);
        return $stmt->fetch();

    }

    public static function getPostsByText(string $text,string $status,int $limit=null,int $offset=null){
        $likeText = '%'.htmlentities($text).'%';
        $sql = 'SELECT * FROM (
            SELECT * FROM posts WHERE title LIKE "'. $likeText . '"
            UNION
            SELECT * FROM posts WHERE id IN (
                SELECT postId
                FROM htmlelements
                WHERE content LIKE "'. $likeText . '"
                GROUP BY postId
            )
            UNION
            SELECT * FROM posts WHERE authorId IN (
                SELECT id
                FROM authors
                WHERE firstName LIKE "'. $likeText . '"
            )
            UNION
            SELECT * FROM posts WHERE authorId IN (
                SELECT id
                FROM authors
                WHERE lastName1 LIKE "'. $likeText . '"
            )
        ) AS foundPosts WHERE STATUS = ? ';
        if($limit){
            $sql .= 'LIMIT '.intval(htmlentities(strval($limit))).' ';
        }
        if($offset){
            $sql .= 'OFFSET '.intval(htmlentities(strval($offset))).' ';
        }
        $stmt = Db::execute($sql,[$status]);
        return $stmt->fetchAll();
    }

    public static function getPost(int $id=null ,string $title=null,string $status=null){
        $sql = 'SELECT * FROM posts WHERE ';
        $params = [];
        if($id){
            $sql .= 'id = ? ';
            $params[]=$id;
        }else if($title){
            $sql .= 'title = ? ';
            $params[]=$title;
        }else{
            return false;
        }

        if($status){
            $sql .= 'AND STATUS=? ';
            $params[]=$status;
        }else{
            $sql .= 'AND STATUS= "published" ';
        }
        $stmt = Db::execute($sql,$params);
        return $stmt->fetch();
    }

    /**
     * Returns an array containing assoc array that contain the id and the name of the post categories, excluding the main category
     * @param int $id post id
     * @return array
     */
    public static function getPostCategories(int $id){
        $sql='SELECT * FROM categories
                WHERE id IN ( SELECT categoryId FROM postcategories
                                WHERE postId=? AND categoryId NOT IN(
                                    SELECT mainCategory FROM posts
                                    WHERE id=?))';
        return Db::execute($sql,[$id,$id])->fetchAll();
    }
    public static function getCategoryName(int $id){
        $sql = 'SELECT name FROM categories
                WHERE id =?';

        $name = Db::execute($sql,[$id])->fetch();
        if($name){
            return $name['name'];
        }else{
            return false;
        }
    }
    public static function postExists(int $id = null, string $title = null){
        
    }

}

//var_dump(Post::getPostCategories(1));
//var_dump(Post::getPost(3,null,null));

//var_dump(Post::getPostsByText('a','published'));

// $posts = Post::getPosts('published',5,9,null,null,null,8);
// $allPosts = Post::getAllPosts();
// print_r($posts);

// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo "<br>";
// echo $_SERVER['REMOTE_ADDR'];
//print_r($allPosts);

