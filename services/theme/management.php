<?php

$success = false;
$message = '';
$dataResponse = '';

$theme = isset($data['options'])?json_decode($data['options']):[];

$theme_action = $theme->action??'none';

if(file_exists(SITE_ROOT."/services/theme/actions/$theme_action".".php")){
    include_once "actions/$theme_action".".php";
}else{
    $message = tts['not_found'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];
