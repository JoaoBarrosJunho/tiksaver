<?php

use App\api\recaptcha;
use App\classes\leemclasses;
use App\http\tiktok\request;

$url = $video->url??null;
$recaptcha_response = $data['g-recaptcha-response'] ?? null;
if (leemclasses::option('rcp_savebox') && !recaptcha::validate($recaptcha_response)['ok']) {
    print json_encode(['success' => $success, 'message' => 'Validate the captcha!', 'data'=>"recaptcha_fail"]);
    die();
}

if($url){
    $tk_request = new request($url);
    $tk_response = $tk_request->fetch();

    if($tk_response["ok"]){
        $dataResponse = updateMediaLinks($tk_response['data']);
    }else{
        $dataResponse= $tk_response["data"];
    }
    $success=$tk_response["ok"];
    $message = $tk_response['message'];
}else{
    $message = 'Please insert a valide video link!';
}


function updateMediaLinks($data){
    foreach($data->medias as $key=>$value){
        $data->medias[$key]->url = URI_NAME."/download?sid=$data->sid&media=$key";
    }

    return $data;
}
