<?php

use App\activities\activity;
use App\login\user;
$success=false;
$message='';
$id = isset($data['user']) && is_numeric($data['user'])?$data['user']:null;
$option = isset($data['option']) && $data['option']>=1?1:0;
if($id){
    $user = (new user())->update("id=$id",['status'=>$option]);
    if($user){
        $success = true;
        $message = tts['action_succedd'];
        setActivity($option,$id);
    }else{
        $message = tts['action_error_message'];
    }

}else{
    $message ='Not found!';
}

$response = ['success'=>$success,'message'=>"$message"];

function setActivity($action,$id){
    $action = $action ==0?'Blocked':'Approved';
    $user = (new user())->getData("id='$id'",null,1,'name');
    $user = $user? $user[0]->name: 'null user';
    
    activity::insert('Account Management',user::logged('name')." $action $user",user::logged('id'));
}