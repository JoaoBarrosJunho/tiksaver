<?php
namespace App\classes;
class postmodule{
    
    

    public static function getHomeModule(){
        $module = getOption('home_modules');
        if($module){
            return json_decode("[".$module."]");
        }     
        return null;
    }


}