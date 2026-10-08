<?php
use App\login\logout;

$pagename = 'Sign Up';
include_once SITE_ROOT.'/include/header.php';


if((new logout)->isLoged()){
    header("location:".URI_NAME."/panel");
    die();
    }else{
        include_once SITE_ROOT."/include/header.php";
        include_once 'auth/signup-form.php';
        include_once SITE_ROOT."/include/footer.php";
        
        
}

?>

