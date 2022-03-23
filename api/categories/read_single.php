<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Categories.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$category = new Categories($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single();

$category_array;
if($category->id === null){
  //No authors found
  $category_array = array(
     'message' => 'categoryId Not Found'
  );
}
else{
  $category_array = array(
  'id' => $category->id,
    'category' => $category->category
    );
}

echo json_encode($category_array);

