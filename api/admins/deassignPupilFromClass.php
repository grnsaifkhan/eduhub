<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/ClassWithStudent.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$classeswithstudent = new ClassWithStudent($db);

//Get raw posted data
//$data = json_decode(file_get_contents("php://input"));



//Set ID to delete
//$post->id = $data->id;
$classeswithstudent->studentusername = $_GET['studentusername'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //delete post
    if($classeswithstudent->removePupil()){
        echo json_encode(
            array('message' => 'Pupil is deassigned')
        );
    }else{
        echo json_encode(
            array('message' => 'Pupil not deassigned')
        );
    }
}