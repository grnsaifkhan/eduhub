<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Tests.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$tests = new Tests($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$tests->testname = $data->testname;
$tests->testdate = $data->testdate;
$tests->subjectid = $data->subjectid;
$tests->teacherid = $data->teacherid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method


    //create post
    if($tests->create()){
        echo json_encode(
            array('message' => 'test data created')
        );
    }else{
        echo json_encode(
            array('message' => 'test data not created')
        );
    }
}
