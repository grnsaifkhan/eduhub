<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Classes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();


//Instantiate blog post object
$class = new Classes($db);

$class->id = isset($_GET['classid']) ? $_GET['classid']: die();

//Blog post query
$result = $class->getClassName($class->id);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $class_arr = array();
    $class_arr['classdata'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $class_item = array(
            'classname'=> $classname

        );

        //Push to 'data'
        array_push($class_arr['classdata'], $class_item);
    }

    //Turn to json
    echo json_encode($class_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No class data found')
    );

}