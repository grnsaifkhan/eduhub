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

//Blog post query
$result = $users->getAllTeacher();
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $users_arr = array();
    $users_arr['teacherdata'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $user_item = array(
            'id'=> $id,
            'usertype' => $usertype,
            'firstname' => html_entity_decode($firstname),
            'lastname' => $lastname,
            'username' => $username

        );

        //Push to 'data'
        array_push($users_arr['teacherdata'], $user_item);
    }

    //Turn to json
    echo json_encode($users_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No post found')
    );

}