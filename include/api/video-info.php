<?php

use App\http\tiktok\request;

$video_url = $_GET['url']??null;

if($video_url){
    $tk_request = new request($video_url);
    $video = $tk_request->fetch();
    if($video['ok']){
        successoProcess($video['message'],$video["data"]);
    }else{
        newError($video["message"]);
    }
}else{
    newError("Invalid video URL");
}
