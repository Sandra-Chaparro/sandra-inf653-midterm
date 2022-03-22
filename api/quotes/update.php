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

//Instantiate authors object
$quote = new Quotes($db);

//Get the raw  data

$data = json_decode(file_get_contents("php://input"));

if($data->authorId == null || $data->categoryId == null || $data->quote ==null){
echo json_encode(array('message' => 'Missing required parameters'));
die();
}

$category = new Categories($db);
$category->id = $data->categoryId;
$category->read_single();
$author = new Authors($db);
$author->id = $data->authorId;
$author->read_single();

if($author->id == null ){
    echo json_encode(array('message'=>'authorId not found'));
    die();
}else if ($category->id ==null){
    echo json_encode(array('message'=>'categoryId not found'));
    die();
}

$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->authorId = $data->authorId;
$quote->categoryId = $data->categoryId;

if($quote->update()){

    if($quote->id){
        echo json_encode(
            array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'authorId' => $quote->authorId,
                'categoryId' => $quote->categoryId,
            )
            );
    }else{
        echo json_encode(array(
            'message'=>'No quotes Found'
        ));
    }

} else{
    echo json_encode(
        array('message' => 'Quote NO updated')
    );
}


