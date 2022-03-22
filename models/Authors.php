<?php

class Authors{
    //DB 
    private $conn;
    private $table = 'authors';

    //Authors Properties
    public $id;
    public $author;

    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    public function read(){
        try{
      
        //Create query
        $query = 'SELECT *
                  FROM ' . $this->table. ' 
                  ORDER BY 
                  id ASC';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }//try curly bracket

    catch(Exception $e){
        return $e->getMessage();
    }//catch curly bracket
  }//read method

    public function read_single(){
        $query = 'SELECT
        id, 
        author
        FROM ' . $this->table. '
        WHERE id = :id';

        $stmt = $this->conn->prepare($query);        //Prepare statement
        $stmt->bindParam(':id', $this->id);        //Bind ID
        $stmt->execute();//Execute query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            //Set  properties
            $this->id = $row['id'];
            $this->author = $row['author'];
        } else{
            $this->id = null;
            $this->author = null;
        }
        
    }

    //Create Post
    public function create(){
        //Create query
        $query = 'INSERT INTO ' . 
        $this->table . '
        SET 
        author = :author';

        $stmt = $this->conn->prepare($query); //Prepare statement

        //clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind para
        $stmt->bindParam(':author', $this->author);

        //Execute query
        if($stmt->execute()){
            return true;
        }else{
  //Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);
  return false; 
        }

      
    }//create function

    //Update Post
    public function update(){
        //Create query
        $query = 'UPDATE ' . 
        $this->table . '
        SET 
        author = :author
        WHERE 
        id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id)); 
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind para
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //Delete post
    public function delete(){
        //Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

    //Execute query
    if($stmt->execute()){
        $my_array = array('id' => $this->id);
        return $my_array;
    }

    //Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);
    
    return false;
    }
  
}//class