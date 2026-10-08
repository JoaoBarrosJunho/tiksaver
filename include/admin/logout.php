<?php
use App\login\logout;

$logout = new logout();

if($logout->Logout()){
    header("location:".URI_NAME."/login?logout");
}else{
    header("location:".URI_NAME."/login");
}

