<?php

class Dbh
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    private $dsn;

    public function connect()
    {
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = '123456';
        $this->dbname = 'employees';
        $this->charset = 'utf8mb4';

        //data source name
        $this->dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->dbname . ';charset=' . $this->charset;
        //try to connect
        try {
            $pdo = new PDO($this->dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}


$a = new Dbh;
$conn = $a->connect();
$sql = 'desc employees';
$stmt = $conn->query($sql);
var_dump($stmt->fetchAll());