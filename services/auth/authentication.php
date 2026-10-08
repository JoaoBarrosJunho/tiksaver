<?php

use App\api\recaptcha;
use App\classes\leemclasses;
use App\login\auth;
use App\controllers\emailgen;
use App\login\access_checker;

$success = false;
$code = '404';
$message = '';

$recaptcha_response = $data['g-recaptcha-response'] ?? null;

if (leemclasses::option('rcp_login') && !recaptcha::validate($recaptcha_response)['ok']) {
    print json_encode(['success' => $success, 'message' => 'Validate the captcha!', 'code' => "$code"]);
    die();
}

if (isset($data['email'], $data['password']) && !empty($data['email'])  && !empty($data['password'])) {
    $email  = $data['email'];
    $pass = $data['password'];
    $login = (new auth($email, $pass))->sigin();
    $r = $login;

    if ($r['state']==1) {
        $code = 501;
        $success = true;
        $message = tts['welcome'];
        $remember = isset($data['remember_me'])?(new access_checker())->saveAccess():null;
    } else if($r['state']==0) {
        $code = 500;
        $message = tts['account_not_exist'];
    }else if($r['state']==2){
        $code = 502;
        $email = $data['email'];
        auth::inite();
        emailgen::sendVerificationMail("$email");
        $message = tts['verify_your_email'];   
    }

    $response = ['success' => $success, 'message' => "$message", 'code'=>"$code"];
} else {
    $message = tts['access_denied']."!";
    $response = ['success' => $success, 'message' => "$message", 'code'=>"500"];
}

?>