<?php
namespace App\login;

use App\classes\usermeta;

class access_checker{

    public function saveAccess(){
        $success = false;
        $message = '';

        if(user::logged('id')){
            $this->remove();
            $token = md5(LOGIN_TOKEN.user::logged('email').$_SERVER['HTTP_USER_AGENT']);
            $save = usermeta::add('user_login',$token);
            if($save){
                setcookie("uAuth_",$token,time()+60*60*24*30);
            }
        }else{
            $message = 'Invalid user';
        }
        return ['success'=>$success,'message'=>$message];
    }

    public function remove(){
        $token = isset($_COOKIE['uAuth_'])?$_COOKIE['uAuth_']:null;

        if($token){
           $remove = usermeta::delete("meta_key='user_login' AND meta_value='$token'");
           if($remove){
            setcookie("uAuth_",$token,time()+0);
           }
        }
        return true;
    }

    public function checkUser(){
        $success = false;
        $data = [];
        $token = isset($_COOKIE['uAuth_'])?$_COOKIE['uAuth_']:null;
        if($token){
            $login = usermeta::select("meta_key='user_login' AND meta_value='$token'");
            if($login){
                $user = user::getData("id=".$login[0]->user_id." AND status=1",null,1,'id,email');
                if($user){
                    $U_token = md5(LOGIN_TOKEN.$user[0]->email.$_SERVER['HTTP_USER_AGENT']);
                    if($token == $U_token){
                        $success = true;
                        $data = ['user'=>$user[0]->id];
                    }else{
                        $this->remove();
                    }
                }else{
                    $this->remove();
                }
        }else{
            $this->remove();
        }
    }
        return ['success'=>$success,'data'=>$data];
    }
}