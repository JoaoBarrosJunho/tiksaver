<?php

use App\login\user;


$success = false;
$message = '';
$data_response = [];
$id = isset($data['id']) && is_numeric($data['id']) ? $data['id']:false;

if($id){
    $user = user::getData("id=$id");
    if($user){
        $u = $user[0];
        $data_response=['id'=>$u->id,'name'=>"$u->name",'email'=>"$u->email",'type'=>"$u->type",'status'=>$u->status];
        $success = true;
        $message = tts['action_succedd'];

    }else{
        $message = 'Invalid user! ';
    }

}else{
    $message = 'Invalid id! ';
}

$response = ['success'=>$success,'message'=>"$message",'data'=>$data_response];