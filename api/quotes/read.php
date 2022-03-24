<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../models/Authors.php';
include_once '../../models/Categories.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();
$quote = new Quotes($db);

$quote->categoryId = isset($_GET['categoryId']) ? $GET['categoryId'] : null;
$quote->authorId = isset($_GET['authorId']) ? $GET['authorId'] : null;

// query
$result = $quote->read();

$num = $result->rowCount();

if($num > 0 ){
  $quotes_arr = array();
  //$quotes_arr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $author = new Authors($db);
    $category = new Categories($db);
    $author->id = $authorId;
    $category->id = $categoryId;
    $author->read_single();
    $category->read_single();
    
    $quote_item = array(
      'id' => $id,
      'quote' => $quote,
      'author' => $author->author,
      'category' => $category->category
    );

    array_push($quotes_arr, $quote_item);

  }

  //Turn to JSON and output
  echo json_encode($quotes_arr);

}
else{
  echo json_encode(
    array('message' => 'No Quotes Found')
  );
}


