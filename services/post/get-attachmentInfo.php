<?php

use App\classes\post;


$success = false;
$message = 'Invalid attachment!';
$dataResponse = [];
$id = isset($data['attachment']) && is_numeric($data['attachment'])?$data['attachment']:null;
if($id){
    $search = post::selectPost("id='$id' AND post_type='attachment'");
    if($search){
        $result = $search[0];
        $success = true;
        $dataResponse = ['title'=>$result->post_title,'description'=>"$result->post_content",'permalink'=>"$result->post_guid"];
    }
}
$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];