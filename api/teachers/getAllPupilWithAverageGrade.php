<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/TestWithGrade.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$testwithgrade = new TestWithGrade($db);

$subjectid = isset($_GET['subjectid']) ? $_GET['subjectid']: die();
//$studentusername = isset($_GET['studentusername']) ? $_GET['studentusername']: die();

//Blog post query
$result = $testwithgrade->getAverageTestGradeofAllStudent($subjectid);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $avggrade_arr = array();
    $avggrade_arr['stduentwithaveragegrade'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $avggrade_item = array(
            'studentusername' => $studentusername,
            'averagegrade' => $averagegrade

        );

        //Push to 'data'
        array_push($avggrade_arr['stduentwithaveragegrade'], $avggrade_item);
    }

    //Turn to json
    echo json_encode($avggrade_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No data found')
    );

}