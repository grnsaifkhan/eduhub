<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Subjects.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();


//Instantiate blog post object
$subjects = new Subjects($db);

$subjects->id = isset($_GET['subjectid']) ? $_GET['subjectid']: die();

//Blog post query
$result = $subjects->getSubjectName($subjects->id);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $subject_arr = array();
    $subject_arr['subjectdata'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $subject_item = array(
            'subjectname'=> $subjectname

        );

        //Push to 'data'
        array_push($subject_arr['subjectdata'], $subject_item);
    }

    //Turn to json
    echo json_encode($subject_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No post found')
    );

}