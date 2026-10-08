<?php
use App\login\user;
if(isset($data['password'],$data['password-repeat']) && $data['password']!='' && $data['password-repeat']!=''){

    if(isset($data['t']) && $data['t']!=''){

        if($data['password'] != $data['password-repeat']){
            $response=['success'=>false,'message'=>'Passwords do not match']; 
        }else{
            $checkToken = user::tokenCheck($data['t']);
            if($checkToken['success']){
                if(user::resetPassword($data['password'],$checkToken['data'])){
                    $response=['success'=>true,'message'=>'Password has been updated','redirect'=>"./login"];
                    user::destroyToken($data['t']);
                }else{
                    $response=['success'=>false,'An error occurred when trying to save new password'];
                }
           
            }else{
                $response=['success'=>false,'message'=>$checkToken['message']];
                
            }

        }
        
    }else{
        $response=['success'=>false,'message'=>'Invalid token.']; 
    }

}else{
    $response=['success'=>false,'message'=>'Invalid data.'];
}


?>