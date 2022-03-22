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

// query
$result = $author->read();

$num = $result->rowCount();

if($num > 0 ){
  $authors_arr = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $author_item = array(
      'id' => $id,
      'author' => $author
    );

    array_push($authors_arr, $author_item);

  }

  //Turn to JSON and output
  echo json_encode($authors_arr);

}
else{
  echo json_encode(
    array('message' => 'No Authors found')
  );
}



