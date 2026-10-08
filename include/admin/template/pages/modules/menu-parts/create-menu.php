<?php
use App\classes\menu;

if(isset($_GET['action']) && $_GET['action'] == 'delete'){

    if(isset($_GET['menu']) && is_numeric($_GET['menu'])){
        $id = $_GET['menu'];
        $response = (new menu())->deleteMenu("id = '$id'");        
    }

    if($response>0){
        $location = URI_NAME."/panel/menu-settings?success";
    }else{
        $location = URI_NAME."/panel/menu-settings?error";
    }
    
   print "<script>
        window.location = '$location';
        </script>";
    die();

}

if(isset($_POST['menuName']) && !empty($_POST['menuName'])){
$name = $_POST['menuName'];
$response = 0;
$area = isset($_POST['menuArea']) && count($_POST['menuArea'])>0 ? implode(',',$_POST['menuArea']):'undefined';

switch($_GET['action']){
    case 'new':
       $response = (new menu())->insertMenu($name,' ',$area);
    break;
    case 'edit':
    if(isset($_GET['menu']) && is_numeric($_GET['menu'])){
    $id = $_GET['menu'];
    $response = (new menu())->updateMenu(['nav_name'=>"$name",'nav_area'=>"$area"],"id = '$id'");
    if($response){
        $response = $id;
    }
    }
    break;
    default:
    break;
}

$location = '';
if($response>0){
    $location = URI_NAME."/panel/menu-settings?menu=$response&success";
}else{
    $location = URI_NAME."/panel/menu-settings?error";
}

print "<script>
    window.location = '$location';
    </script>" ;
}

function menuInfo($key){
   
    if(isset($_GET['menu']) && is_numeric($_GET['menu'])){
    $id = $_GET['menu'];
    
    $result = [];
    $response = (new menu())->selectMenu("id='$id'",NULL,NULL,'nav_name,nav_area');
    if($response){
        $result =['name'=> $response[0]->nav_name,'area'=>$response[0]->nav_area];
    }

    if(isset($result[$key]))
    {
        return $result[$key];
    }else{
        return null;
    }

    }else{
        return null;
    }
}

function seletArea($value){
    $menuArea = menuInfo('area');


    if($menuArea){
        if(in_array($value,explode(',',$menuArea))){
            return 'checked';
        }
    }
    return '';
    
}

?>




<!--Menu selection area-->
<div class=" w-full px-4 py-3 mb-8 <?=style["bg"]?>">
        <form action="" method="POST">
         
        <label class="flex gap-3 w-full">
            <input type="text" name="menuName" value="<?= menuInfo('name')?>" class="<?= style['input-text']?>" placeholder="<?= tts['insert_menu_name']?>">
            <label>
            <button class="<?= style['btn-purple-np']?>"><?= tts['submit']?></button>
            </label>
            <label>
            <a href="<?= URI_NAME?>/panel/menu-settings<?=isset($_GET['menu'])?'?menu='.$_GET['menu'].'':''?>" class="<?=style['btn-red']?>"><?= tts['cancel']?></a>
            </label>
        </label>
         <label class="flex gap-6 mt-2">
            <span>Menu area: </span>
            <label class="flex gap-3">
            <span>Header</span>
            <input type="checkbox" name="menuArea[]" value="header" id="menu-area" <?= seletArea('header')?>>
            </label>
            <label class="flex gap-3">
            <span>Footer</span>
            <input type="checkbox" name="menuArea[]" value="footer" id="menu-area" <?= seletArea('footer')?>>
            </label>
            
         </label>
       </form>
</div>
<!--Menu selection area-->