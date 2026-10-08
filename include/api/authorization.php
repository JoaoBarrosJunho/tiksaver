<?php

use App\classes\api_logs;
use App\classes\api_tokens;

if ($_SERVER["REQUEST_METHOD"] != 'GET') {
    newError('Method not supported.');
}

$validate = api_tokens::checkAuthorization();
if ($validate) {
    checkLimit($validate);
    api_logs::new($validate->id);
} else {
    newError("Invalid key!");
}


function checkLimit($data)
{
    if ($data->asLimited && api_logs::requestsToday($data->id) >= $data->day_limit) {
        newError('You have reached your daily usage limit.');
    }
}


function newError($message)
{
    echo json_encode(['ok' => false, 'message' => $message]);
    header('HTTP/1.1 403 Forbidden');
    exit;
}

function successoProcess($message,$data)
{
    echo json_encode(['ok' => true, 'message' => $message,'data'=>$data]);
    header('HTTP/1.1 200 OK');
    exit;
}
