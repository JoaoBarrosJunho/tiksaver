<?php
use App\login\auth;
use App\controllers\emailgen;

if(auth::vT("email")!=null && auth::vT("code")!=null){
    $email = auth::vT("email");
    auth::inite();
    emailgen::sendVerificationMail("$email");
    $response = ['success'=>true,"message"=>'New code has been sent.'];
}else{
    $response = ['success'=>false,"message"=>'The action cannot be execute.'];
}

?>