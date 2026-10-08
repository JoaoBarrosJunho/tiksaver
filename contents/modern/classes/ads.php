<?php


function adsEnable($type_page){
switch($type_page){
    case 'post':
        return !getOption('show_ads_page')?true:false;
        break;
    case 'inbox':
        return !getOption('show_ads_inbox')?true:false;
    break;
    case 'home':
        return !getOption('show_ads_home')?true:false;
    break;
    default:
    return true;
    break;
}
}

function printAds($ads_area,$adsEnable){
$html = '<div class="w-full mt-4 mb-4 px-4">@code</div>';
$ads = getOption("$ads_area");
return $adsEnable && $ads?str_replace('@code',$ads,$html):null;
}