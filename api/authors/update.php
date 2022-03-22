<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Authors.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$author = new Authors($db);

//Get the raw  data
$data = json_decode(file_get_contents("php://input"));
$author->id = $data->id;
$author->author = $data->author;

if($author->update()){
    echo json_encode(
        array('message' => 'Post updated')
    );
} else{
    echo json_encode(
        array('message' => 'Post NO updated')
    );
}


