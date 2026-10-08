<?php

$success = false;
$message = '';
$dataResponse = '';

$v_logs = isset($data['options'])?json_decode($data['options']):[];

$v_logs_action = $v_logs->action??'none';

if(file_exists(SITE_ROOT."/services/video-logs/actions/$v_logs_action".".php")){
    include_once "actions/$v_logs_action".".php";
}else{
    $message = tts['not_found'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];
