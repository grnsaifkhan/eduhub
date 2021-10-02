<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: PUT');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/ClassWithStudent.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$classesWithPupil = new ClassWithStudent($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$classesWithPupil->classid = $data->classid;
$classesWithPupil->studentusername = $data->studentusername;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method

    //create post
    if($classesWithPupil->insertStudentWithClass()){
        echo json_encode(
            array('message' => 'student data inserted or updated to new class')
        );
    }else{
        echo json_encode(
            array('message' => 'data not created/updated')
        );
    }
}
