<?php
require_once __DIR__.'/db.php';

class Author{

    private $username;
    public function __construct($username){
        $this->username = $username;

    }
    public static function login($username,$password){
        //$password = password_hash($password,PASSWORD_BCRYPT);
        // $sql = 'SELECT 1 FROM authors WHERE username=? AND password=?';
        // $stmt = Db::execute($sql,[$username,$password]);
        // return $stmt->fetch();

        $sql = 'SELECT password FROM authors WHERE username = ?';
        $stmt = Db::execute($sql,[$username]);
        $correctPass = $stmt->fetch()['password'];
        if(password_verify($password,$correctPass)){
            return true;
        }
        return false;
    }
    public static function register($username,$password,$firstName,$lastName,$email,$profileImage=null,$lastName2=''){
        $password = password_hash($password,PASSWORD_BCRYPT);
        $profileImage = $profileImage ?? 'http://localhost/myProjects/CMS-for-blog-with-MVC-model/client/image/defaultAvatar.png';
        $sql='INSERT INTO authors (username,password,firstName,lastName1,lastName2,profileImage,email)
            VALUES (?,?,?,?,?,?,?)';
        $stmt = Db::execute($sql,[$username,$password,$firstName,$lastName,$lastName2,$profileImage,$email]);
    }
    public function getAuthorId(){
        $sql = 'SELECT id FROM authors WHERE username=?';
        $stmt = Db::execute($sql,[$this->username]);
        return $stmt->fetch()['id'];
    }
    public function getProfileImage(){
        $sql = 'SELECT profileImage FROM authors WHERE username=?';
        $stmt = Db::execute($sql,[$this->username]);
        return $stmt->fetch()['profileImage'];
    }
    private function getField($field){
        $sql = 'SELECT';
    }

}

//Author::register('New','1234','Antonio','Jorda','tonijorda1997@gmail.com');

