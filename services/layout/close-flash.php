<?php
use App\classes\flash_messages;

$success = false;
$message = '';
$mss = isset($data['message'])?$data['message']:null;
$flash = new flash_messages();
if($flash->closeMessage($mss)){
    $success = true;
    $message = 'Message closed!';
}

$response = ['success'=>$success,'message'=>$message];