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

$tsubjectname = isset($_GET['subjectname']) ? $_GET['subjectname']: die();

//Blog post query
$result = $pupiltest->readSingleArchivedSubject($tsubjectname,$studentusername);
//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $pupiltest_arr = array();
    $pupiltest_arr['singlearchivedsubjecttests'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $pupiltest_item = array(
            'testname' => $testname,
            'subjectname' => $subjectname,
            'grade'=> $grade

        );

        //Push to 'data'
        array_push($pupiltest_arr['singlearchivedsubjecttests'], $pupiltest_item);
    }

    //Turn to json
    echo json_encode($pupiltest_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'no test data found')
    );

}