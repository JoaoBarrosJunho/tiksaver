<?php

use App\classes\tk_video;

$id = $v_logs->log??null;
if($id && is_numeric($id)){
    $delete = tk_video::remove("id=$id");
}else{
    $message = 'Invalid log!';
}


if($delete){
    $success=true;
    $message=tts['action_succedd'];
}else{
    $message = tts['action_error_message'];
}