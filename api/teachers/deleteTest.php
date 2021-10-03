<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Tests.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$test = new Tests($db);

//Get raw posted data
//$data = json_decode(file_get_contents("php://input"));



//Set ID to delete
//$post->id = $data->id;
$test->id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //delete post
    if($test->delete()){
        echo json_encode(
            array('message' => 'test deleted')
        );
    }else{
        echo json_encode(
            array('message' => 'test not Deleted')
        );
    }
}