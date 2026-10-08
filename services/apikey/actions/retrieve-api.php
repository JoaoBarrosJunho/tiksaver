<?php

use App\classes\api_tokens;
use App\login\user;


$id = $apikey_options->id??null;

if ($id) {
    $get = api_tokens::select("id=$id AND user_id=".user::logged('id'))[0]??null;
    if ($get) {
        $success = true;
        $message = tts["action_succedd"];
        $dataResponse = $get;
    } else {
        $message = tts["action_error_message"];
    }
} else {
    $message = tts['action_error_message'];
}
