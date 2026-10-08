<?php

$classAddoms = '';
$settingsAddoms = '';

function style($s=null){

    $response = [];
    $style = getOption('ss-style')?getOption('ss-style'):$s;
    switch($style){
        case 'flat':
            $response = ['class'=>'ss-flat','settings'=>" "];
        break;
        case 'rounded':
            $response = ['class'=>'ss-circle','settings'=>" data-ss-content='false' "];
        break;
        case 'pill':
            $response = ['class'=>'ss-pill','settings'=>" "];
        break;
        case 'default':
            $response = ['class'=>' ss-dark','settings'=>"  "];
        break;
        default:
            $response = ['class'=>' ss-dark','settings'=>"  "];
        break;
    }

return $response;
}

function ss_social($ss = ''){
$ss_list = getOption('ss_list')?getOption('ss_list'):$ss;

return 'data-ss-social="'.$ss_list.'"';

}

$style = style();
$classAddoms .= $style['class']." ".getOption('ss_hover');
$settingsAddoms .= $style['settings']." ".ss_social('share,facebook,twitter,whatsapp');



?>

<link rel="stylesheet" href="<?=THEME_URI?>/assets/css/social-share.css">
<script src="<?=THEME_URI?>/assets/js/social-share.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>-->

<div class="w-full">
<div class="ss-box  <?=$classAddoms?>" <?=$settingsAddoms?>  data-ss-content="false" ></div>
</div>