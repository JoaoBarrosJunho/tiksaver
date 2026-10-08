<?php
use App\classes\menu;

if(isset($_GET['menu']) && is_numeric($_GET['menu'])){
    $html ='';
    $Menu = menu::getMenu($_GET['menu']);

    if($Menu){
        $name = $Menu[0]->nav_name;
        $html ="<span class='text-lg font-semibold'>".$name."</span> (<a href='".URI_NAME."/panel/menu-settings?action=edit&menu=".$_GET['menu']."' class='underline text-blue-500 text-sm'>edit</a>)";
        echo($html);
    }

    
}else{
    $html = "<span class='text-red-600 text-sm'>!".tts['menu_notselected']."</span>";
    echo($html);
}