<?php

use App\classes\api_tokens;
use App\login\user;

$id = $apikey_options->id??null;

if ($id) {
    $remove = api_tokens::delete("id=$id AND user_id=".user::logged('id'));
    if ($remove) {
        $success = true;
        $message = tts["action_succedd"];
    } else {
        $message = tts["action_error_message"];
    }
} else {
    $message = tts['action_error_message'];
}
