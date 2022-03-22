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

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

$author->read_single();

if($author->id === null){
  //No authors found
  $author_arr = array(
    'message' => 'authorId Not found'
  );
}
else{
  $author_arr = array('id' => $author->id,
    'author' => $author->author
 );
}

echo json_encode($author_arr);


