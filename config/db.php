<?php
namespace Config;

class DB
{
    
    private $host;
    private $database;
    private $username;
    private $password;
    private $connection;

    public function __construct()
    {
        $this->host     = "localhost";
        $this->database = "order";
        $this->username = "root";
        $this->password = "";
        $this->connection = null;
    }

    public function connect()
    {
        try{
            $this->connection = new \PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->exec("set names utf8");
         }catch(\PDOException $exception){
            echo "Error: " . $exception->getMessage();
         }

         return $this->connection;

    }

}
