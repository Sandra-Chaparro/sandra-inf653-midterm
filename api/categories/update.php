<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Categories.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$category = new Categories($db);

//Get the raw  data
$data = json_decode(file_get_contents("php://input"));

if($data->id == null || $data->category == null){
echo json_encode('message' => 'Missing Required Parameters");
    die();
}

$category->id = $data->id;
$category->category = $data->category;

if($category->update()){
    echo json_encode(
        array('id' => $category->id,
        'category' => $category->category)
    );
} else{
    echo json_encode(
        array('message' => 'Category NO updated')
    );
}


