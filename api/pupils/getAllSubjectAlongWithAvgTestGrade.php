<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Pupils.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$pupiltest = new Pupils($db);

$studentusername = isset($_GET['studentusername']) ? $_GET['studentusername']: die();

//Blog post query
$result = $pupiltest->getAllSubjectAlongWithAvgTestGrade($studentusername);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $pupilsubjectavggrade_arr = array();
    $pupilsubjectavggrade_arr['pupilavggradeofsubject'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $pupilsubjectavggrade_item = array(
            'subjectid' => $subjectid,
            'subjectname'=> $subjectname,
            'averagegrade' => $averagegrade

        );

        //Push to 'data'
        array_push($pupilsubjectavggrade_arr['pupilavggradeofsubject'], $pupilsubjectavggrade_item);
    }

    //Turn to json
    echo json_encode($pupilsubjectavggrade_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'no subject with avg grade found')
    );

}