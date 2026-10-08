<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");
header('Content-Type: Application/json');

include_once 'api/authorization.php';
include_once 'api/video-info.php';