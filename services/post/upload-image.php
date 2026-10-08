<?php
use App\classes\leemclasses;

$success=false;
$message='';
$data_response = [];

$file = isset($data['file']) && !empty($data['file']) ?$data['file']:null;
$name = $data['name'];

$uploadImage = leemclasses::uploadImage($file,$name);
if($uploadImage['success']){
    $success = true;
    $message = $uploadImage['message'];
    $data_response = ['file'=>$uploadImage['data']['id']];

}else{
    $message = $uploadImage['message'];
}


$response = ['success'=>$success,'message'=>$message,'data'=>$data_response];