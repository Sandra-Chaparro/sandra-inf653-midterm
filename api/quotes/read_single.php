<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
include_once '../../config/Database.php';
include_once '../../models/Quotes.php';
include_once '../../models/Categories.php';
include_once '../../models/Authors.php';

//Instantiate DB $ connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$quote = new Quotes($db);

//Get ID
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

 $quote->read_single();

$category = new Categories($db);
$category->id = $quote->categoryId;
$category->read_single();

$author = new Authors($db);
$author->id = $quote->authorId;
$author->read_single(); 

$quote_arr;

 if($quote->id === null){
  $quote_arr = array('message' => 'quoteId Not found');
}
else{

  $quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $author->author,
    'category' => $category->category
  );
 
}

print_r(json_encode($quote_arr));
