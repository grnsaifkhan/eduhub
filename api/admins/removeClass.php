<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
//$data = json_decode(file_get_contents("php://input"));



//Set ID to delete
//$post->id = $data->id;
$classId = $_GET['classid'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //delete post
    if($classes->removeClass($classId)){
        echo json_encode(
            array('message' => 'Class is removed')
        );
    }else{
        echo json_encode(
            array('message' => 'Class not removed')
        );
    }
}