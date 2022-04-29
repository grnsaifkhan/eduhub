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

$pupiltest->studentusername = isset($_GET['studentusername']) ? $_GET['studentusername']: die();

$pupiltest->subjectid = isset($_GET['subjectid']) ? $_GET['subjectid']: die();

//Blog post query
$result = $pupiltest->readSingleSubject();
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $pupiltest_arr = array();
    $pupiltest_arr['singlesubjecttests'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $pupiltest_item = array(
            'classname' => $classname,
            'subjectname'=> $subjectname,
            'testname' => $testname,
            'grade' => $grade

        );

        //Push to 'data'
        array_push($pupiltest_arr['singlesubjecttests'], $pupiltest_item);
    }

    //Turn to json
    echo json_encode($pupiltest_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'no test data found')
    );

}