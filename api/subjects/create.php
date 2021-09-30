<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Subjects.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$subjects = new Subjects($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$subjects->subjectname = $data->subjectname;
$subjects->teacherid = $data->teacherid;
$subjects->classid = $data->classid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method

    //create post
    if($subjects->create()){
        echo json_encode(
            array('message' => 'subject data created')
        );
    }else{
        echo json_encode(
            array('message' => 'Subject data not created. Subject name already exist.')
        );
    }
}
