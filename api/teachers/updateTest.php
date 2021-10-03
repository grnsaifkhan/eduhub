<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$test->id = $data->id;

$test->testname = $data->testname;
$test->testdate = $data->testdate;


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // The request is using the PUT method
    //update post
    if($test->updateTest()){
        echo json_encode(
            array('message' => 'test data updated')
        );
    }else{
        echo json_encode(
            array('message' => 'test data not updated')
        );
    }

}
