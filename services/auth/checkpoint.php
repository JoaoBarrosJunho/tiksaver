<?php
use App\login\auth;
use App\login\user;

$success=false;
$message ='';
$code = isset($data['code']) && $data!=''?$data['code']:null;

                if(!$code){
                    
                    $message = tts['invalid_code'].'.';
                }else{
                    if(md5($code) == auth::vT('code')){
                       if((new user())->updateStatus(1,"email="."'".auth::vT('email')."'")){
                        unset($_SESSION['vToken']);
                        $success = true;
                        $message =  tts['account_as_verifiedy'];
                       }else{
                        $message =  'Internal error.';
                       }
                    }else{
                        $message =  tts['invalid_code'].'.';
                    }
                }


$response = ['success'=>$success,'message'=>"$message"];
?>