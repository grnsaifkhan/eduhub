<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/TestWithGrade.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$testsgrade = new TestWithGrade($db);

$testsgrade->id = isset($_GET['testid']) ? $_GET['testid']: die();

//Blog post query
$result = $testsgrade->getAllPupilSingleGradeTest();
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $test_arr = array();
    $test_arr['singletestdata'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $test_item = array(
            'testid' => $testid,
            'testname' => $testname,
            'firstname'=> $firstname,
            'lastname'=> $lastname,
            'studentusername' => $studentusername,
            'grade' => $grade

        );

        //Push to 'data'
        array_push($test_arr['singletestdata'], $test_item);
    }

    //Turn to json
    echo json_encode($test_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No test data found')
    );

}