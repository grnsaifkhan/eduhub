<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Users.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$user = new Users($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$user->id = $data->id;

$user->firstname = $data->firstname;
$user->lastname = $data->lastname;


if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // The request is using the PUT method
    //update post
    if($user->update()){
        echo json_encode(
            array('message' => 'User data updated')
        );
    }else{
        echo json_encode(
            array('message' => 'User data not updated')
        );
    }

}
