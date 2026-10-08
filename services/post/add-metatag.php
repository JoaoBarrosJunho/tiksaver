<?php
use App\classes\leemclasses;
use App\classes\metatags;



$success = false;
$message = '';
$name = isset($data['nameMetaTag']) && !empty($data['nameMetaTag'])?$data['nameMetaTag']:null;
$type = isset($data['typeMetaTag']) && !empty($data['typeMetaTag'])?$data['typeMetaTag']:'undefined';

if($name){
    $slug = leemclasses::genUnicSlug($name,null,'metatags','slug',"type = '$type'");
    $execute = metatags::addMetaTags($name,$type,$slug);
    if($execute){
        $success = true;
        $message = 'Action has been succedded!';
    }else{
        $message = 'Error to execute this action!';
    }

}else{
    $message = "Insert a valid name";
}

$response = ['success'=>$success,'message'=>$message];