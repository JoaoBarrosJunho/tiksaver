<?php
namespace App\api;

use App\classes\leemclasses;

class recaptcha{

    public static function validate($token){
        $success = false;
        $message = '';
        $dataResponse = [];

        

        if($token){
            $dataResponse = self::checkToken($token);

            if($dataResponse['success'] && $dataResponse['hostname']==$_SERVER["HTTP_HOST"]){
                $success = true;
                $message = 'Done!';
            }else{
                $message = 'Invalide captcha response!';
            }

        }else{
            $message = 'Invalide captcha response!';
        }

        return ['ok'=>$success,'message'=>$message,'token'=>$token];

    }


    private static function checkToken($token){
        $endpoint = 'https://www.google.com/recaptcha/api/siteverify';
        $body = ['secret'=>leemclasses::option('recaptcha_secret_key'),
        'response'=>$token];
        $ch = curl_init($endpoint);
        
        curl_setopt_array($ch,[
            CURLOPT_POST=>true,
            CURLOPT_SSL_VERIFYPEER=>false,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_POSTFIELDS=>$body
        ]);

        $response = curl_exec($ch);

        if(curl_error($ch)){
           return ['success'=>false,'message'=>curl_errno($ch)];
        }else{
        return (array)json_decode($response); 
            
        }
        

    }

    public static function getRecaptcha($form){
        if(leemclasses::option($form)){
            return '<div class="g-recaptcha" data-sitekey="'.leemclasses::option('recaptcha_site_key').'"></div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        }

        return null;
    }


   
}