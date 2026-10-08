<?php
use App\classes\menu;

function getFooter(){

    $footer = (new menu())->selectMenu("nav_area='footer'",null,null,'nav_items');
    if($footer){
        $footerItems = [];
        $items = (array)json_decode($footer[0]->nav_items);

        foreach($items as $key => $value){
            $footerItems[] = explode('@:',$value);
        }
        return $footerItems;
        
    }else{
        return null;
    }

}

function footerList($class = null, $addoms = null,$aclass = null){
 $items = getFooter();
 $list = [];
 $style = $class ? " class='$class' ":'';
 $astyle = $aclass ? " class='$aclass' ":'';

 
 if($items){    
    foreach($items as $i){
        $list[]= '<span '.$style.' '.$addoms.'><a href="'.$i[1].'" '.$astyle.'>'.$i[0].'</a></span>'."\n";
    }
 }

 return implode("<span>|</span>",$list);
}
