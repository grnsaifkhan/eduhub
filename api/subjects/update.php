<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Subjects.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$subject = new Subjects($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$subject->id = $data->id;

$subject->subjectname = $data->subjectname;
$subject->teacherid = $data->teacherid;
$subject->classid = $data->classid;


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // The request is using the PUT method
    //update post
    if($subject->update()){
        echo json_encode(
            array('message' => 'Subject data updated')
        );
    }else{
        echo json_encode(
            array('message' => 'Subject data not updated or Subject name already exist.')
        );
    }

}
