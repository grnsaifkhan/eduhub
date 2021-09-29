<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Classes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$classes = new Classes($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$classes->classname = $data->classname;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method

    //create post
    if($classes->create()){
        echo json_encode(
            array('message' => 'class data created')
        );
    }else{
        echo json_encode(
            array('message' => 'class data not created. Class name already exist.')
        );
    }
}
