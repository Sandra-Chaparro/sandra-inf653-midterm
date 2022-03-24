<?php
header('Access-Control-Allow-Origin: *'); // allow CORS
header('Content-Type: application/json'); //returning JSON
$method = $_SERVER['REQUEST_METHOD'];     //fetches the request method:GET, POST, PUT, DELETE
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); 
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}

if($method === 'PUT') {
        include_once 'update.php';  
} 
elseif($method === 'POST') {
      include_once  'create.php'; 
}
elseif($method === 'GET') {
    if(isset( $_GET['id'] )) {
        include_once  'read_single.php';
    } else {
        include_once  'read.php';
        }   
    }
elseif($method === 'DELETE') {
    include_once  'delete.php';   
    }
  

