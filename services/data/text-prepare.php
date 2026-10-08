<?php

use App\classes\leemclasses;


$text = isset($data['value'])?$data['value']:'';
$mode = isset($data['mode'])?$data['mode']:'get';
$data = $text;
$formated_text = $mode == 'set'? leemclasses::text_encode($data,'set'):leemclasses::text_encode($data,'get');
$response = ['success'=>true,'message'=>'Text has been prepared','data'=>"$formated_text"];