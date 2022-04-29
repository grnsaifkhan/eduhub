<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Tests.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$tests = new Tests($db);

$tests->subjectid = isset($_GET['subjectid']) ? $_GET['subjectid']: die();

//Blog post query
$result = $tests->readTestForOneSubject();
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $test_arr = array();
    $test_arr['testdataofonesubject'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $test_item = array(
            'id' => $id,
            'testname'=> $testname,
            'testdate' => $testdate,
            'subjectid' => $subjectid,
            'teacherid' => $teacherid

        );

        //Push to 'data'
        array_push($test_arr['testdataofonesubject'], $test_item);
    }

    //Turn to json
    echo json_encode($test_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No test data found')
    );

}