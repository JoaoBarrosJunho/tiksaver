<?php

use App\activities\activity;
use App\login\logout;
use App\login\user;

$success = false;
$message = '';
$id = isset($data['user']) && is_numeric($data['user'])?$data['user']:null;

if($id){

    $user = (new user())->getData("id='$id'",null,null,'name');
    $user = $user? $user[0]->name:'null user';
    $us = (new user())->deleteUser("id=$id");
    if($us){
        $success = true;
        $message = tts['user_has_deleted'];
        $finnaly = $id == user::logged('id')? (new logout())->Logout():null;
        activity::insert('Account Management',user::logged('name')." deleted the account of  ".$user,user::logged('id'));
    }else{
        $message = tts['error_delete_user'];
    }

}else{
    $message = 'Not found!';
}

$response = ['success'=>$success,'message'=>"$message"];