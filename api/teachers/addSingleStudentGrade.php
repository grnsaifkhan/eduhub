<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/TestWithGrade.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$testwithgrade = new TestWithGrade($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$testwithgrade->testid = $data->testid;
$testwithgrade->studentusername = $data->studentusername;
$testwithgrade->grade = $data->grade;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method


    //create post
    if($testwithgrade->addSingleStudentGrade()){
        echo json_encode(
            array('message' => 'test grade added')
        );
    }else{
        echo json_encode(
            array('message' => 'test grade not added')
        );
    }
}
