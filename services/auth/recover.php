<?php
use App\login\user;

$message = '';
$success=false;
if(isset($data['email'])){
    $email = $data['email'];
    
      $send = user::sendRecoveryLink("$email",URI_NAME."/recovery");
      if($send['success']){
        $success = true;
        $message = $send['message'];
        
      }else{
        $message = $send['message'];
      }
    }else{
      $message = tts['insert_valid_email'];
    }

    $response = ['success'=>$success,'message'=>"$message"]
?>