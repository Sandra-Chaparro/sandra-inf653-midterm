<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Authors.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$author = new Authors($db);

$data = json_decode(file_get_contents("php://input"));

$author->id = $data->id;

$result = $author->delete();

if($result){
        echo json_encode(
           $result
        );

        
} else{
    echo json_encode(
        array('message' => 'author NO deleted')
    );
}


