<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$quote = new Quotes($db);

$data = json_decode(file_get_contents("php://input"));

$quote->id = $data->id;

if($quote->delete()){
     if($quote->id){
       echo json_encode(
       array('id' => $quote->id)
       );      
     }
     else{
          echo json_encode(
               array('message' => 'No Quotes Found')
          );
     }
}

else{
        echo json_encode(
        array('message' => 'Fail Delete')
        );
     }  
