<?php

use App\classes\leemclasses;
use App\controllers\sitemapes;

$map_control = isset($_GET['p']) && is_numeric(strpos($_GET['p'],"sitemap")) && !leemclasses::option('disable_sitemap')?sitemapes::check($_GET['p']):['success'=>false];
if(!$map_control['success']){
            include SITE_ROOT.'/contents/index.php';
}else{

    header('Content-Type: application/xml');
    echo $map_control['data'];
}