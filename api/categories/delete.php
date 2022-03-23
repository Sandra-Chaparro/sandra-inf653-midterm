<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, 
Access-Control-Allow-Methods, Authorization, X-Requested-With');
include_once '../../config/Database.php';
include_once '../../models/Categories.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$category = new Categories($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

$result = $category->delete();

if($result){
        echo json_encode(
           $result
        );

        
} else{
    echo json_encode(
        array('message' => 'category NO deleted')
    );
}


