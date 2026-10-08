<?php

namespace App\api;

use App\login\user;
use Exception;

class tikdrop_updates{
    protected static $edpoint = 'https://genius.2jdev.com/';



    public static function getVersion(){
        $ok =false;
        $message = '';
        $edpoint = self::$edpoint."app/version?aplication=tikdrop";
        try{
            $ch = curl_init($edpoint);

            curl_setopt_array($ch,
            [CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_SSL_VERIFYPEER=>false]);
    
            $response = curl_exec($ch);
            if(curl_errno($ch)){
                $message = curl_error($ch);
            }else{
                $data = json_decode($response);
                $ok = ($data->version??false)?true:false;
                $message = $data->version??null;
            }
        }catch(Exception $e){
            $message = $e->getMessage();
        }
        
        
        return ['ok'=>$ok,'message'=>$message];
    }


    public static function checkVersion(){
        $page = $_GET['p']??null;
        if($page!='panel' || !user::isAdmin()){
            return null;
        }

        if(isset($_COOKIE['updates_checked'])){
            return $_COOKIE['updates_checked']!=V_?true:false;
        }

        $version = self::getVersion();
        if($version['ok']){
            setcookie('updates_checked',$version["message"],1);
            setcookie('updates_checked',$version["message"],time()+60*60*24*1);
            return $version["message"]!=V_?true:false;
        }else{
            setcookie('updates_checked',V_,1);
            setcookie('updates_checked',V_,time()+60*60*24*1);
            return false;
        }
    }
}