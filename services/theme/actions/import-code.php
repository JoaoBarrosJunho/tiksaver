<?php


$code_list = ['ad'=>'ad_backup.html','features'=>'features_backup.html'];
$code = $theme->code??'';


if(in_array($code,array_keys($code_list))){
    $file = SITE_ROOT."/app/views/components/".$code_list[$code];
    $dataResponse= file_get_contents($file);
    $success=true;
    $message = 'Done!';

}else{
    $message = 'Invalid component!';
}