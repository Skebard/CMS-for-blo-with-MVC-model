<?php
require '../config.php';

/**
 * This class provides a connection with a database and methods to execute queries.
 * @author Antonio Jorda
 */
class Db
{

    /**
     * Represents the connection with the database
     * @var Db
     */
    private static $_Database = null;

    /**
     * Connection with the database
     * @var PDO
     */
    public $conn = null;

    /**
     * Data source name
     * @var String
     */
    private $dsn = null;

    private $host = null;
    private $dbname = null;
    private $username = null;
    private $password = null;
    private $charset = null;
    private $options = null;

    /**
     * Creates the connection with the database
     *
     * Depending on the  CONFIG::MODE it will create or not the database in case that it
     * does not exist
     */
    public function __construct()
    {
        try {
            //data source name
            $this->host = CONFIG::DATABASE_HOST;
            $this->dbname = CONFIG::DATABASE_NAME;
            $this->charset = CONFIG::DATABASE_CHARSET;
            $this->dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . $this->charset;
            $this->username = CONFIG::DATABASE_USERNAME;
            $this->password = CONFIG::DATABASE_PASSWORD;
            $this->options = CONFIG::PDO_OPTIONS;
            $this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {

            //1049 is the code for unknown database  list of codes in: https://mariadb.com/kb/en/mariadb-error-codes/
            if ($e->getCode() ===1049 && CONFIG::DATABASE_ON_ERROR_CONNECTION_CREATE === true) {
                if($this->createDb()){
                    if($this->createTables()){
                        $this->insertInitialData();
                    }
                }
            } else {
                die($e->getMessage());
            }
        }
    }


    /**
     * Creates an empty database
     * @return Boolean
     */
    private function createDb()
    {
        try {
            $conn = new PDO('mysql:host' . $this->host, $this->username, $this->password, $this->options);
            $sql = 'CREATE DATABASE ' . $this->dbname;
            $conn->exec($sql);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Create the tables of the database
     * @return Boolean
     */
    private function createTables(){
        try{
            $this->conn = new PDO($this->dsn, $this->username, $this->password, $this->options);
            require '../importDB/tables.php';
            $sql = '';
            foreach($tables as $table){
                $sql .= strpos($table,';')?$table:$table.';';
            }
            $this->conn->exec($sql);
            return true;
        }catch(PDOException $e){
            return false;
        }

    }

    /**
     * Insert initial data to the database
     * @return Boolean
     */
    private function insertInitialData(){
        try{
            require '../importDB/initialData.php';
            return true;
        }catch(PDOException $e){
            return false;
        }

    }

    /**
     * Returns an instance of a PDO object. Before creating a new instance checks
     * if one already exists
     * @return PDO
     */
    public static function getConnection()
    {
        if (!isset(self::$_Database)) {
            self::$_Database = new Db;
        }
        return self::$_Database->conn;
    }

    /**
     * Executes the given query scaping the set parameters
     * @access public
     * @param string $query
     * @param array $parameter
     * @return PDOStatement
     */
    public static function execute(string $query, array $parameter = [])
    {
        try {
            $conn = self::getConnection();
            $stmt = $conn->prepare($query);
            $stmt->execute($parameter);
            $result = $stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            $result = false;
        }
        return $result;
    }
}

// $d = new Db;
// $conn = $d->conn;
// $stmt = $conn->prepare('INSERT INTO users (id) VALUES(3)');
// $stmt->execute([]);


// if ($result = Db::execute('SELECT * FROM users')) {

//     echo var_dump($result->fetchAll());
// }

//$stmt = $conn->exec('CREATE TABLE usersa ( id INT AUTO_INCREMENT PRIMARY KEY)');
