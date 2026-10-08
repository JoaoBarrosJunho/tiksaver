<?php
use App\login\logout;
use App\login\auth;

if((new logout)->isLoged()){
    header("location:".URI_NAME."/panel");
    die();
    
    }else{

  auth::inite();

  if(!auth::vT('code')){
   header("location:".URI_NAME."/login");
   die();
  }else{
    include_once SITE_ROOT."/include/header.php";
    include_once 'auth/checkpoint-form.php';
    include_once SITE_ROOT."/include/footer.php";
   

  }
        
        
}







?>




