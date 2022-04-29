<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$testWithGrade->testid = $data->testid;
$testWithGrade->studentusername = $data->studentusername;
$testWithGrade->grade = $data->grade;


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // The request is using the PUT method
    //update post
    if($testWithGrade->updatePupilSingleGradeTest()){
        echo json_encode(
            array('message' => 'test grade data updated')
        );
    }else{
        echo json_encode(
            array('message' => 'test grade data not updated')
        );
    }

}
