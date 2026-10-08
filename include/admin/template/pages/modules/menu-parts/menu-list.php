<?php
use App\classes\menu;
function getMenuList(){
    $Menu = isset($_GET['menu']) && !empty($_GET['menu'])? $_GET['menu']:'';
    $MenuList = (new menu())->selectMenu(NULL,NULL,NULL,"id,nav_name");
    if($MenuList){
      foreach($MenuList as $menu){
        $selected = $Menu == $menu->id?'selected':'';
        echo "<option value='$menu->id' $selected>$menu->nav_name</option>";
      }
    }
}