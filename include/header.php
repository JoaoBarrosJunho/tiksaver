<?php

use App\classes\language;
use App\classes\script_addoms;

include_once './config.php';



?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="<?= language::getLang()?>" <?=language::getLang()=='ar'?'dir="rtl"':null?>>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php $title = isset($pagename)?$pagename.' < '.SITE_TITLE:SITE_TITLE; echo $title;?></title>
    <meta name="description" content="<?=SITE_DESCRIPTION?>">
    <link rel="shortcut icon" href="<?=C_THEME->fav_icon??URI_NAME.'/assets/media/logo-50px.png'?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=C_THEME->mobile_logo?? URI_NAME.'/assets/media/logo-100px.png'?>">
    <link rel="stylesheet" href="<?= URI_NAME?>/assets/css/style.css">    
    <link rel="stylesheet" href="<?= URI_NAME?>/assets/css/fonts.css">
    
    <link rel="stylesheet" href="<?= URI_NAME?>/assets/css/frameworks/tailwind.css" defer>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?=URI_NAME?>/assets/js/alpine.min.js" defer></script>
    <script src="<?= URI_NAME?>/assets/js/init-alpine.js"></script>

    <?=script_addoms::get()?>

    <style>
        .fade-image {
  opacity: 0;
  animation: fadeInOut 2s infinite;
}

/* Animação fade */
@keyframes fadeInOut  {
    0%, 100% {
    opacity: 0; 
  }
  50% {
    opacity: 1; 
  }
}


    </style>
    
    
    
</head>
<body >
<script>
        function preload(){
        const myDiv = document.createElement("div");
        myDiv.setAttribute("class","fixed flex flex-col items-center duration-300 transition-all opacity-100  justify-center p-4 w-full text-purple-600 h-screen bg-white dark:bg-gray-800 ");
        myDiv.setAttribute("style","z-index: 9999;");
        myDiv.setAttribute("id",'preload-screen');
        myDiv.innerHTML = `<img src="<?=C_THEME->website_logo??URI_NAME."/assets/media/logo-100px.png"?>" class="w-30 shadow-md fade-image"/>`
    document.querySelector("body").appendChild(myDiv);
    }
    preload();

    window.addEventListener("DOMContentLoaded",()=>{
      try{
        $("#preload-screen").removeClass('opacity-100');
        $("#preload-screen").addClass('opacity-0');
       setTimeout(()=>{
        $("#preload-screen").remove();
       },300);
      }catch(err){
        document.querySelector("#preload-screen").remove();
      }
        
    });
    </script>


    
    

  

    
