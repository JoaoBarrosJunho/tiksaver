<?php

$success = false;
$message = '';
$dataResponse = '';

$importer = isset($data['options'])?json_decode($data['options']):[];

$importer_action = $importer->action??'none';

if(file_exists(SITE_ROOT."/services/importer/actions/$importer_action".".php")){
    include_once "actions/$importer_action".".php";
}else{
    $message = tts['not_found'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];
