<?php

class Database {
  
    private $conn;
    private $host;
    private $db_name;
    private $username;
    private $password;
  
  function __construct() {
    $url = getenv('JAWSDB_URL');
    $dbparts = parse_url($url);
    $this->host = $dbparts['host'];
    $this->db_name = ltrim($dbparts['path'], '/');
    $this->username = $dbparts['user'];
    $this->password = $dbparts['pass'];
    }
  
    //DB Connect
    public function connect(){
        $this->conn = null;

        try{
            $this->conn = new PDO('mysql:host='. $this->host . ';dbname='. $this->db_name,
            $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
