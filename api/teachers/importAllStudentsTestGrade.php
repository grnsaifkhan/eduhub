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


$testwithgrade->testid = isset($_POST['testid']) ? $_POST['testid']: die();


$filename = isset( $_FILES['file']) ? $_FILES['file']: die();
/*$test_dict = array(
//        'filename' => $filename['name'],
    'filename' => $filename['name'],
    'testid' =>"gasdfasd"

) ;
echo json_encode($test_dict);*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method


    //create post
    if($testwithgrade->importAllStudentsGrade($filename)){
        echo json_encode(
            array('message' => 'test grade imported')
        );
    }else{
        echo json_encode(
            array('message' => 'test grade not imported')
        );
    }
}
