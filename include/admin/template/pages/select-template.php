<?php

use App\classes\leemclasses;

if(isset($_POST['active_theme'])){
    leemclasses::setOptions('active_theme',$_POST['active_theme']);
}


$template = leemclasses::option('active_theme');

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="flex gap-3 items-center my-6  text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>


        <div class="w-full grid md:grid-cols-4 gap-6" method="POST" action="">
            <form method="POST" class="flex flex-col shadow-md items-center py-2 px-2 justify-center bg-white items-start  w-full   hover:pointer rounded-md border @option_label">
                <input type="hidden" name="active_theme" value="modern" >
                <img src="<?= URI_NAME ?>/assets/media/theme/modern.png" class="w-full h-30 rounded-md" alt="Modern theme" title="Modern theme">
                <button type="submit" class="<?=$template!='modern'?style['btn-purple']:"w-full ".style['btn-disabled']?>" <?=$template!='modern'?'':'Disabled'?>><?=$template!='modern'?'Activate':'Active'?></button>
            </form>

            <form method="POST" class="flex flex-col shadow-md items-center py-2 px-2 justify-center bg-white items-start  w-full   hover:pointer rounded-md border @option_label">
                <input type="hidden"  name="active_theme" value="classic" >
                <img src="<?= URI_NAME ?>/assets/media/theme/classic.png" class="w-full h-30 rounded-md" alt="Classic theme" title="Classic theme">
                <button type="submit" class="<?=$template!='classic'?style['btn-purple']:"w-full ".style['btn-disabled']?>" <?=$template!='classic'?'':'Disabled'?>><?=$template!='classic'?'Activate':'Active'?></button>
            </form>

        </div>


    </div>
</main>