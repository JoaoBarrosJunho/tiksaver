<?php

use App\classes\api_tokens;


$id = $data['current_api'] ?? null;
$name = $data['api_name'] ?? null;
$asLimited = $data['as_limited']??false;
$day_limit = $data['day_limit']??0;

if ($name) {
    $store = api_tokens::newAPI($name,$asLimited,$day_limit,$id);
    if ($store) {
        $success = true;
        $message = tts["action_succedd"];
    } else {
        $message = tts["action_error_message"];
    }
} else {
    $message = tts['action_error_message'];
}
