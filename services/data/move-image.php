<?php
use App\classes\leemclasses;


$success=false;
$message='';
$dataResponse =[];

if(isset($data['url']) && !empty($data['url'])){

    $image = leemclasses::uploadImage($data['url'], md5(date('Y-md-d H:i:s').$data['url']));
    if($image['success']){
        $success = true;
        $message = tts['action_succedd'];
        $dataResponse['link'] = $image['data']['guid'];
    }else{

    }
}else{
    $message = 'Add image link';
}


$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];