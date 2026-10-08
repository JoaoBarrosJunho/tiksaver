<?php
use App\classes\leemclasses;

                
if(isset($_FILES['files']) && !empty($_FILES['files'])){
    $message = '';
    $att = $_FILES['files'];
    $success = false;
    $uploaded = [];
    
    
    foreach($att['name'] as $key => $value){
        
        $extension = leemclasses::getExtension($value);
        if(!leemclasses::verify_format($extension)){
        
        $attTemp= $att['tmp_name'][$key];

         $up = leemclasses::uPloadAttachment($attTemp,$extension,$value,$att['type'][$key]);
         
         if($up['success']){
            $type_file = explode('/',$att['type'][$key]);

            $uploaded[]= ['url'=>$up['attachment'],'type'=>$type_file[0],'title'=>$up['file_name']];
            $message .= "$value uploaded in ".$up['attachment'].', ';
            
         }else{
            $message .= $up['message'];
            
         }
         $success=true;
        }else{
            $message = "$value format no autorized";
            $success=false;
        }

    }
    
    
    $response = [
        'success'=>$success,
        'message'=>"$message",
        'data'=> json_encode($uploaded)
    ];
}else{
    $response = [
        'success'=>false,
        'message'=>"No attachment received"
    ];
}
