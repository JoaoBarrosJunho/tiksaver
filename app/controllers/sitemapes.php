<?php
namespace App\controllers;

class sitemapes{

    public static function check($name){
        $file = SITE_ROOT."/app/views/sitemap/$name";

        if(file_exists($file)){
            $result = file_get_contents($file);
            return ['success'=>true,'data'=>$result];

        }else{
            return ['success'=>false,'data'=>null];
        }
    }
}