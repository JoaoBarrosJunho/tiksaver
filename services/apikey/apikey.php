<?php

$success = false;
$message = '';
$dataResponse = '';

$apikey_options = isset($data['options'])?json_decode($data['options']):[];

$apikey_action = $apikey_options->action??'none';

if(file_exists(SITE_ROOT."/services/apikey/actions/$apikey_action".".php")){
    include_once "actions/$apikey_action".".php";
}else{
    $message = tts['not_found'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];
