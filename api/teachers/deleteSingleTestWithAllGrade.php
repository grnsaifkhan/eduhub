<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/TestWithGrade.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$testWithGrade = new TestWithGrade($db);

//Get raw posted data
//$data = json_decode(file_get_contents("php://input"));



//Set ID to delete
//$post->id = $data->id;
$testWithGrade->testid = $_GET['testid'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //delete post
    if($testWithGrade->deleteTestWithAllPupilAndGrade()){
        echo json_encode(
            array('message' => 'Test data deleted')
        );
    }else{
        echo json_encode(
            array('message' => 'Test data not deleted')
        );
    }
}