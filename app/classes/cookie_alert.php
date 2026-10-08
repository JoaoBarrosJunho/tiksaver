<?php
namespace App\classes;

class cookie_alert{

    public static function check(){ 
        if(!isset($_COOKIE['cookies-accept'])){
            $btn = leemclasses::option('cookies_accept');
            $file = SITE_ROOT.'/app/views/cookies-alert.md';
            $personalized_message = leemclasses::option('cookies_message');
            $cookie_message = $personalized_message?$personalized_message:'We use cookies to ensure that we give you the best experience on our website. Please find more information <a href="@privacy_page"  target="_blank">here</a>.';
            $cookie_message = str_replace('@privacy_page',leemclasses::option('privacy_policy_page'),$cookie_message);
            $cookies_vars = ['@cookies_message'=>$cookie_message,
            '@cookies_button'=> $btn?$btn:'Accept',
            '@siteurl'=>URI_NAME];
            $cookie_message = file_exists($file)?file_get_contents($file):null;
            return str_replace(array_keys($cookies_vars),array_values($cookies_vars),$cookie_message);
        }
    }
}