<?php 
use App\classes\leemclasses;



function success($message  = tts['action_succedd']){
    return isset($_GET['success']) ? leemclasses::notification($message):'';
}

function error($message = tts['action_error_message']){
    return isset($_GET['error']) ? leemclasses::notification($message,3000,'bg-red-100'):'';
}

function Alert(){
print success();
print error();
}

