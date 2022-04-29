<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/ClassWithStudent.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$classwithstudent = new ClassWithStudent($db);

$testid = isset($_GET['testid']) ? $_GET['testid']: die();

//Blog post query
$result = $classwithstudent->getStudentWithSameClassUsingTestId($testid);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $pupilwithclass_arr = array();
    $pupilwithclass_arr['pupilwithsameclass'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $peoplewithclass_item = array(
            'studentusername' => $studentusername,
            'classid'=> $classid

        );

        //Push to 'data'
        array_push($pupilwithclass_arr['pupilwithsameclass'], $peoplewithclass_item);
    }

    //Turn to json
    echo json_encode($pupilwithclass_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No student with class data found')
    );

}