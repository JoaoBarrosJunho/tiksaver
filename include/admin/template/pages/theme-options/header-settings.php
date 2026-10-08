<?php
use App\classes\leemclasses;

?>

<div class="flex flex-col gap-6">
    <label>
        <span class="text-gray-700 dark:text-gray-400"><?= tts['webiste_logo'] ?></span>
        <div class="flex mt-2 text-sm" id="logo">
            <img class="h-12 w-12 flex rounded-md bg-gray-50" src="<?= getOption('website_logo')??URI_NAME . "/assets/media/no-image.png";?>" alt="Website logo">

            <input type="file" accept="image/jpeg,image/png,image/gif" onchange="newimage('logo')" name="website_logo" class="block w-full rounded-md border border-input bg-white ml-2 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </div>
    </label>

    <label>
        <span class="text-gray-700 mt-5 dark:text-gray-400"><?= tts['fav_icon'] ?></span>
        <div class="flex mt-2 w-48 text-sm" id="favicon">
            <img class="h-12 w-12 flex rounded-md bg-gray-50" src="<?= getOption('fav_icon')??URI_NAME . "/assets/media/no-image.png";?>" alt="Fav icon">

            <input type="file" accept="image/jpeg,image/png,image/gif" onchange="newimage('favicon')" name="fav_icon" class="block w-full rounded-md border border-input bg-white ml-2 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </div>
    </label>

    <label>
        <span class="text-gray-700 mt-5 dark:text-gray-400"><?= tts['mobile_logo'] ?></span>
        <div class="flex mt-2  text-sm" id="mobilelogo">
            <img class="h-12 w-12 flex rounded-md bg-gray-50" src="<?= getOption('mobile_logo')??URI_NAME . "/assets/media/no-image.png";?>" alt="Mobile logo">

            <input type="file" accept="image/jpeg,image/png,image/gif" onchange="newimage('mobilelogo')" name="mobile_logo" class="block w-full rounded-md border border-input bg-white  ml-2 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </div>
    </label>

    <h3 class="my-4 text-2md font-semibold text-gray-700 dark:text-gray-200 "><?= tts['header_appearance'] ?></h3>

    <?php
    function  NavbarIconStyle(){
            $option_value = getOption('nav_header');
            $values = ['logo'=>tts['only_logo'],'logo_title'=>tts['logo_title'],'title'=> tts['only_title']];
            $response = [];
            foreach($values as $key=>$value){
                $selected = $key==$option_value?'selected':'';
                $response[]= "<option value='$key' $selected>$value</option>";
            }

            return implode("\n",$response);

        }

        

    ?>




    <label class="flex flex-col w-64  py-2 dark:text-gray-200">
        <span class="text-sm font-semibold ">
            <?= tts['nav_header'] ?>
        </span>
        <select name="nav_header" class="<?=style['select']?>">
           <?= NavbarIconStyle()?>
        </select>
    </label>
    
   
    <div class="flex gap-3">
    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-sm font-semibold">
            Header text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('header_color')?>" name="header_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-sm font-semibold">
            Header Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('header_background')?>" name="header_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>
    </div>

    <!--Darkmode-->
    <div class="flex flex-col  border-t dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('darkmode')"  <?=getOption('show_darkmode')==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?=tts['occult_dark']?></span>
                <input type="hidden" id="darkmode"  name="show_darkmode" value="<?= getOption('show_darkmode')!=null?getOption('show_darkmode'):0;?>">
        </div>
        <span class="text-xs text-gray-600 dark:text-gray-100">
        <?=tts['occult_dark_description']?> 
        </span>
    </div>

    <!--Lang toogle-->
    <div class="flex flex-col  border-t dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('langtoogle')"  <?=getOption('show_langToogle')==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?=tts['occult_langtoogle']?></span>
                <input type="hidden" id="langtoogle"  name="show_langToogle" value="<?= getOption('show_langToogle')!=null?getOption('show_langToogle'):0;?>">
        </div>
        <span class="text-xs text-gray-600 dark:text-gray-100">
        <?=tts['occult_langtoogle_description']?> 
        </span>
    </div>

   
    
   


</div>