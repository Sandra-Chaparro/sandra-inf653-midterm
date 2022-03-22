<?php

class Database {
    //DB Params
    $url = getenv('JAWSDB_URL');
    $dbparts = parse_url($url);
    
    private $host = 'acw2033ndw0at1t7.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
    private $db_name = 'mrnpq02zo5ekan3h';
    private $username = 'qb9a5as9snhkq974';
    private $password = $dbparts['pass'];
    private $conn;

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
