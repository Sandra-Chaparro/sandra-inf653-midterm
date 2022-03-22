<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$quote = new Quotes($db);

//Get the raw  data
$data = json_decode(file_get_contents("php://input"));

$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

if($quote->create()){
    echo json_encode(
        array('message' => 'Quote created')
    );
} else{
    echo json_encode(
        array('message' => 'Quote NO Created')
    );
}