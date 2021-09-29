<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
/*header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
        Access-Control-Allow-Methods, Authorization, X-Requested-With');*/

include_once '../../config/Database.php';
include_once '../../models/Users.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$users = new Users($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$users->usertype = $data->usertype;
$users->firstname = $data->firstname;
$users->lastname = $data->lastname;
$users->username = $data->username;
$users->password = $data->password;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // The request is using the POST method


    //create post
    if($users->create()){
        echo json_encode(
            array('message' => 'user data created')
        );
    }else{
        echo json_encode(
            array('message' => 'user data not created. Username has already been taken')
        );
    }
}
