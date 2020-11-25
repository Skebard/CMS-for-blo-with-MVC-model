<?php
require_once __DIR__.'db.php';
define('MAX_ATTEMPTS',200);

class Login{
    private $ipAddress;
    public function __construct($ipAddress){
        $this->ipAddress = $ipAddress;
    }
    public function clientExists(){
        $sql = 'SELECT 1 FROM login WHERE ip_address=?';
        $stmt = Db::execute($sql,[$this->ipAddress]);
        if($stmt){
            return true;
        }
        return false;
    }
    public function addAttempt(){
        if(!$this->clientExists()){
            $this->insertIpAddress();
        }else{
            $attempts = $this->getAttempts() +1;
            $sql = 'UPDATE login  SET  attempts=?,last_attempt=CURRENT_TIMESTAMP WHERE ip_address=?';
            Db::execute($sql,[$attempts,$this->ipAddress]);
        }

    }
    private function insertIpAddress(){
        $sql = 'INSERT INTO login (ip_address,attempts) VALUES (?,?)';
        Db::execute($sql,[$this->ipAddress,1]);
        return true;
    }
    public function isAllowed(){
        $attempts = $this->getAttempts();
        if($attempts>MAX_ATTEMPTS){
            return false;
        }else{
            return true;
        }
    }

    private function getAttempts(){
        $sql = 'SELECT attempts FROM login WHERE ip_address=?';
        $stmt = Db::execute($sql,[$this->ipAddress]);
        return $stmt->fetch();
    }
}