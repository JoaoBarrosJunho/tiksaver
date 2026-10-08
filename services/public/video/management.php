<?php

$success = false;
$message = '';
$dataResponse = '';

$video = isset($data['options'])?json_decode($data['options']):[];

$video_action = $video->action??'none';

if(file_exists(SITE_ROOT."/services/public/video/actions/$video_action".".php")){
    include_once "actions/$video_action".".php";
}else{
    $message = tts['not_found'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];
