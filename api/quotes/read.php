<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quotes($db);


// query
$result = $quote->read();

$num = $result->rowCount();

if($num > 0 ){
  $quotes_arr = array();
  $quotes_arr['data'] = array();

  while($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $quote_item = array(
      'id' => $id,
      'quote' => $quote,
      'author' => $author,
      'category' => $category
    );

    array_push($quotes_arr['data'], $quote_item);

  }

  //Turn to JSON and output
  echo json_encode($quotes_arr);

}
else{
  echo json_encode(
    array('message' => 'No quotes found')
  );
}


