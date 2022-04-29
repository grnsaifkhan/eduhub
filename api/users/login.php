<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$userlogin = new Users($db);

/*$userlogin->username = isset($_GET['username']) ? $_GET['username']: die();
$userlogin->password = isset($_GET['password']) ? $_GET['password']: die();*/

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));
$userlogin->username = $data->username;
$userlogin->password = $data->password;

// For 4.3.0 <= PHP <= 5.4.0
if (!function_exists('http_response_code'))
{
    function http_response_code($newcode = NULL)
    {
        static $code = 200;
        if($newcode !== NULL)
        {
            header('X-PHP-Response-Code: '.$newcode, true, $newcode);
            if(!headers_sent())
                $code = $newcode;
        }
        return $code;
    }
}
//Blog post query
$result = $userlogin->login();
//Get row count
$num = $result->rowCount();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //check any post
    if ($num>0){
        if ($userlogin->login()){
            $userdata_arr = array();
            $userdata_arr['userdata'] = array();

            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                $userdata_item = array(
                    'id' => $id,
                    'usertype' => $usertype,
                    'username' => $username,
                    'firstname'=> $firstname,
                    'lastname' => $lastname,

                );
                http_response_code(200);
                //Push to 'data'
                array_push($userdata_arr['userdata'], $userdata_item);
            }
            http_response_code(200);
            //Turn to json
            echo json_encode($userdata_arr);
        }

    }else{
        //no post
        echo json_encode(
            array('message' => 'Username or Password does not match!!')
        );
        http_response_code(200);

    }

}