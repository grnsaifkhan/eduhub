<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$users = new Users($db);

$users->username = isset($_GET['studentusername']) ? $_GET['studentusername']: die();


//Blog post query
$result = $users->readSinglePupilWithUsername();
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $user_arr = array();
    $user_arr['singlestudentwithusername'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $user_item = array(
            'id' => $id,
            'usertype'=> $usertype,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username

        );

        //Push to 'data'
        array_push($user_arr['singlestudentwithusername'], $user_item);
    }

    //Turn to json
    echo json_encode($user_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'no user data found')
    );

}