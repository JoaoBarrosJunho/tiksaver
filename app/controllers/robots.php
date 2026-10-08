<?php
namespace App\controllers;

class robots{

    public static function get(){
        $file = SITE_ROOT.'/app/views/sitemap/robots.txt';
        return file_exists($file)?file_get_contents($file):self::ReseTset();
    }

    public static function ReseTset(){
        $file = SITE_ROOT.'/app/views/sitemap/robots.txt';
        $string = "User-agent: *\nAllow: /\nDisallow: /login\nDisallow: /api\nDisallow: /panel/*\n\nSitemap: ".URI_NAME."/sitemap.xml";
        $f = fopen($file,'w');
        if(fwrite($f,$string)){
            fclose($f);
            return null;
        }
    }
}
