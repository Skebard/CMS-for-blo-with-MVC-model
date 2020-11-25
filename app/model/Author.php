<?php
require_once __DIR__.'/db.php';

class Author{

    public function __construct(){

    }
    public static function login($username,$password){
        $sql = 'SELECT 1 FROM authors WHERE username=? AND password=?';
        $stmt = Db::execute($sql,[$username,$password]);
        return $stmt->fetch();
    }
    public static function register($username,$password,$firstName,$lastName,$email){
    }
    public static function getAuthorId($username){
        $sql = 'SELECT id FROM authors WHERE username=?';
        $stmt = Db::execute($sql,[$username]);
        return $stmt->fetch()['id'];
    }
}

