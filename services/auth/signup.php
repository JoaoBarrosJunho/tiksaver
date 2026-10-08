<?php

use App\api\recaptcha;
use App\classes\leemclasses;
use App\controllers\emailgen;
use App\login\user;

$success = false;
$message = '';
$code = 0;

$recaptcha_response = $data['g-recaptcha-response'] ?? null;

if (leemclasses::option('rcp_signup') && !recaptcha::validate($recaptcha_response)['ok']) {
    print json_encode(['success' => $success, 'message' => 'Validate the captcha!', 'code' => "$code"]);
    die();
}


$datavalidate = isset($data['name'], $data['email'], $data['password'])
&& !empty($data['name'])
&& !empty($data['email'])
&& !empty($data['password']) ? true : false;

$check_name = leemclasses::checkInvalidString($data['name']);
$datavalidate = $check_name['success'] ?false:$datavalidate;
$datavalidate = !empty($data['password']) && strlen($data['password'])<8?null:$datavalidate;
if ($datavalidate) {

$type = 2;

$status = leemclasses::option('new_user_status')?leemclasses::option('new_user_status'):2;


$u = new user();
$u->SetAllData($data['name'], $data['email'],md5($data['password']), $type, $status);
$u->addUser();

if ($u->getId() > 0) {

    if($status==2){
        $name = $data['name'];
        $email = $data['email'];
        emailgen::sendVerificationMail("$email","$name");
        $message = tts['verify_your_email'];
        $code = 502; //verifypage
        } else{
            $message = tts['account_has_been_created'];
            $code = 501; //Login page
        }

       $success = true;

} else {
    
        $message =  tts['check_your_detaile_data'];
}
} else {

    $message = $datavalidate === null? 'Very short password, needs 8 characters!':tts['invalid_data'];
}


$response = ['success'=>$success,'message'=>$message,'code'=>$code];

?>