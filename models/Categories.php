<?php

class Categories{
    //DB 
    private $conn;
    private $table = 'categories';

    //Authors Properties
    public $id;
    public $category;

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
        category
        FROM ' . $this->table. ' 
        WHERE id = :id
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);
        
        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
            //Set  properties
            $this->id = $row['id'];
            $this->category = $row['category'];    

    }

    //Create Post
    public function create(){
        //Create query
        $query = 'INSERT INTO ' . 
        $this->table . '
        SET 
        category = :category';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->category = htmlspecialchars(strip_tags($this->category));

        //Bind para
        $stmt->bindParam(':category', $this->category);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //Update Post
    public function update(){
        //Create query
        $query = 'UPDATE ' . 
        $this->table . '
        SET 
        category = :category
        WHERE 
        id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));
       
        //Bind para
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);

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
