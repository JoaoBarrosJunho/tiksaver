<?php
use App\classes\leemclasses;
use App\classes\metatags;

function getLanguages($def=null){
    $languages = leemclasses::geniusLang();
    $default = $def??leemclasses::option('genius_default_lang');
    $html = [];

    if($languages){
        foreach($languages as $l){
            $selected = $l== $default?'selected':'';
            $html[]= "<option value='$l' $selected>$l</option>";
        }
    }
    return implode("\n",$html);

}




function getMarkers(){
    $markers = metatags::selectMetaTags('type="category"','id,name');
    $html = [];
    if($markers){
        foreach($markers as $mark){
            $html[]= "<option value='$mark->id'>$mark->name</option>";
        }
    }
    return implode("\n",$html);
}


function getSizes(){
$sizes = leemclasses::option('image_model')=='dall-e-3'?["1024x1024","1792x1024","1024x1792"]:["256x256","512x512","1024x1024"];
$default = leemclasses::option('genius_featured_img_size');

$html = [];
    
foreach($sizes as $s){
    $selected = $s == $default ? 'selected':'';
    $html[]= "<option value='$s' $selected>$s</option>";
}

return implode("\n",$html);
}

function getMaxParagraphs(){
    $paragraphs = leemclasses::option('genius_paragraphs');
    return $paragraphs?$paragraphs:5;
}

function getMaxLenght(){
    $lenghts = leemclasses::option('genius_lenght');
    return $lenghts?$lenghts:350;
}
