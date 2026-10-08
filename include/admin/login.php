<?php
use App\login\logout;
use App\login\auth;

if((new logout)->isLoged()){
    header("location:".URI_NAME."/panel");
    die();
    
    }else{

       $reconect = (new auth(null,null))->reconectUser();
        if($reconect){
            header("location:".URI_NAME."/panel");
        die();
        }else{
            include_once SITE_ROOT."/include/header.php";
            include_once 'auth/login-form.php';
            include_once SITE_ROOT."/include/footer.php";
        }
        
}

?>




