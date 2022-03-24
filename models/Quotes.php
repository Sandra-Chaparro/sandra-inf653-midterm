<?php

class Quotes{
    //DB 
    private $conn;
    private $table = 'quotes';

    //Authors Properties
    public $id;
    public $quote;
    public $authorId;
    public $categoryId;

    //Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }
    public function read(){
        try{
        //Create query
        $query = 'SELECT
                  q.id, 
                  q.quote,
                  a.author,
                  c.category
                  FROM ' . $this->table. ' q
                  LEFT JOIN 
                  authors a ON q.authorId = a.id
                  LEFT JOIN 
                  categories c ON q.categoryId = c.id
                  ORDER BY 
                  q.id ASC';

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
                  quote,
                  categoryId,
                  authorId
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
       
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->authorId = $row['authorId'];
        $this->categoryId = $row['categoryId'];
   
    }//read_single 

    //Create Quote
    public function create(){
        //Create query
        $query = 'INSERT INTO ' . 
        $this->table . '
        SET 
        quote = :quote,
        authorId = :authorId,
        categoryId = :categoryId';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));

        //Bind para
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);

        //Execute query
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //Update Quote
    public function update(){

        //Create query
        $query = 'UPDATE ' . 
        $this->table . '
        SET 
        quote = :quote,
        authorId = :authorId,
        categoryId = :categoryId
        WHERE 
        id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        //$this->quote = htmlspecialchars(strip_tags($this->quote));
        //$this->authorId = htmlspecialchars(strip_tags($this->authorId));
        //$this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':authorId', $this->authorId);
        $stmt->bindParam(':categoryId', $this->categoryId);
        

        //Bind para
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
            if($stmt->rowCount()==0){
                $this->id = null;
            }
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    //Delete quote
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
        if($stmt->rowCount()==0){
            $this->id = null;
        }
        return true;
    }
    
    //Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);
    
    return false;
    }
  
}//class
