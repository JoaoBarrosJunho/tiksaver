<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST,GET");
header('Content-Type: application/json');

use App\classes\leemclasses;
use App\classes\routes;
use App\login\logout;

date_default_timezone_set(leemclasses::GetTimeZone());

function accessBlock($types){
    return leemclasses::apiAccessBlock($types);
}


$data = $_POST;
if (isset($data['action'])) {

    if ($data['action'] != 'signin') {

        $loged = new logout();
        extract(routes::api());
        is_numeric($autorization)? accessBlock($autorization):null;
        include_once $view;


    } else {
        include_once 'auth/authentication.php';
    }
}else if(isset($data['pub-action'])){
include_once 'public/func.php';
}else{
    $response = [
        'success' => false,
        'message' => 'Action cannot be performed',
    ];
}





echo json_encode($response);

die();
