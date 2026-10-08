<?php
use App\login\user;



function authorExists($username){
    $data = user::getData("username='$username'",null,null,'id,name,username,picture');
    if($data){
        return ['success'=>true,'data'=>$data[0]];
    }else{
        return ['success'=>false];
    }
    }