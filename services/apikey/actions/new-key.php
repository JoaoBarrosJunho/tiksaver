<?php

use App\classes\api_tokens;


$id = $apikey_options->id??null;

if ($id) {
    $get = api_tokens::generateAPIKey($id);
    if ($get) {
        $success = true;
        $message = tts["action_succedd"];
        $dataResponse = $get?['token'=>$get,'short_token'=>substr($get,0,20)."..."]:$get;
    } else {
        $message = tts["action_error_message"];
    }
} else {
    $message = tts['action_error_message'];
}
