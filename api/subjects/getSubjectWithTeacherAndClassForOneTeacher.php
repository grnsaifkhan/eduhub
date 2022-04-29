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

$subjects->teacherid = isset($_GET['teacherid']) ? $_GET['teacherid']:die();
//Blog post query
$result = $subjects->getSubjectWithTeacherAndClassForOneTeacher($subjects->teacherid);

//Get row count
$num = $result->rowCount();

//check any post
if ($num>0){
    $subject_arr = array();
    $subject_arr['subjectinfoforoneteacher'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $subject_item = array(
            'subjectid' => $subjectid,
            'subjectname' => $subjectname,
            'classid' => $classid,
            'classname'=> $classname,
            'teacherid' => $teacherid,
            'teacherusername' => $teacherusername

        );

        //Push to 'data'
        array_push($subject_arr['subjectinfoforoneteacher'], $subject_item);
    }

    //Turn to json
    echo json_encode($subject_arr);

}else{
    //no post
    echo json_encode(
        array('message' => 'No data found')
    );

}