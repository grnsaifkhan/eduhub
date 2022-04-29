<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
//$data = json_decode(file_get_contents("php://input"));



//Set ID to delete
//$post->id = $data->id;
$subjects->id = isset($_GET['subjectid']) ? $_GET['subjectid']: die();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //delete post
    if($subjects->archiveOrRemoveSubject()){
        echo json_encode(
            array('message' => 'Subject is removed')
        );
    }else{
        echo json_encode(
            array('message' => 'Subject not removed')
        );
    }
}