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

$result = $category->read();

$num = $result->rowCount();

if($num > 0 ){
  $categories_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $category_item = array(
      'id' => $id,
      'category' => $category
    );

    array_push($categories_arr, $category_item);

  }

  //Turn to JSON and output
  echo json_encode($categories_arr);

}
else{
  echo json_encode(
    array('message' => 'No Categories Found')
  );
}



