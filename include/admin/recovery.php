<?php
use App\login\logout;
use App\login\user;


//print_r();


if((new logout)->isLoged()){
    header("location:".URI_NAME."/panel");
    die();
    
    }else{

      if(isset($_GET['t'])){
        $TokenVerify = user::tokenCheck($_GET['t']);
        if($TokenVerify['success']){
          $token = $_GET['t'];
          include_once 'auth/recovery-form-reset.php';
        }else{
          header("location:".URI_NAME."/login");
        };
        
        
      }else{
        
        include_once SITE_ROOT."/include/header.php";
        include_once 'auth/recovery-form.php';
            include_once SITE_ROOT."/include/footer.php";
      }
        
        
}







?>




