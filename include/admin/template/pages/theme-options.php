<?php
use App\classes\leemclasses;
include_once 'theme-options/update-settings.php';

define("THEME_OPTIONS",leemclasses::getThemeOptions());

function getOption($option){
  $val = THEME_OPTIONS->$option??null;
  return $val && in_array($option,leemclasses::customCodesVars())?htmlspecialchars_decode($val):$val;
}
?>

<link rel="stylesheet" href="<?=URI_NAME?>/assets/css/coloris.css">

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>


        <div class="w-full py-2 px-2">
        <?php if($_POST || $_FILES){echo leemclasses::notification($status);}?>
        </div>

        <div class="mb-8   rounded-lg  ">
        
        
        <div class="w-full h-full flex gap-3">

            <!--Panel nav-->
            <div class="w-64 hidden md:flex flex-col bg-gray-700 rounded-lg py-4 px-4 shadow-md" >
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg   text-white bg-purple-600  focus:outline-none  nav-btn"  onclick="Setsection(event,'header-options')"><i class='bx bx-bookmark-plus'></i><?=tts['header']?></button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'footer-options')"><i class='bx bx-bookmark-minus' ></i><?=tts['footer']?></button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'home-page')"><i class='bx bx-home-alt-2'></i>Home</button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'ads-page')"><i class='bx bx-dollar-circle'></i>Ads</button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'jscode-page')"><i class='bx bx-code-alt'></i>Analytics/JS Code</button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'customcode-page')"><i class='bx bx-code-block'></i>Custom Code</button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'typography-page')"><i class='bx bx-text'></i>Typography</button>
                <button class="w-full flex gap-3 items-center py-2 px-4 text-sm dark:text-gray-600 rounded-lg  text-white   focus:outline-none  nav-btn"  onclick="Setsection(event,'colors-options')"><i class='bx bx-palette'></i>Theme colors</button>
            </div>
            <!--Panel nav-->

            <!--Panel options-->
            <div class="w-full">
            <form action="" method="POST" enctype="multipart/form-data">
            
            <!--Header-->
            <div class="px-4 py-2 panel-item bg-white rounded-lg shadow-xs dark:bg-gray-800" id="header-options">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 "><?=tts['header']?></h3>
                <?php include_once 'theme-options/header-settings.php' ?>
            </div>

            <!--Footer-->
            <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="footer-options">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 "><?=tts['footer']?></h3>
            <?php include_once 'theme-options/footer-settings.php' ?>
            </div>

          

           

             <!--Home Page-->
             <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="home-page">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Home</h3>
            <?php include_once 'theme-options/homepage-settings.php' ?>
            </div>

            

             <!--Custom code Page-->
             <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="ads-page">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Ads</h3>
            <?php include_once 'theme-options/ads-settings.php' ?>
            </div>

            <!--JSCode Page-->
            <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="jscode-page">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Analytics and JS Code</h3>
            <?php include_once 'theme-options/code-settings.php' ?>
            </div>

            <!--Custom code Page-->
            <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="customcode-page">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Custom code</h3>
            <?php include_once 'theme-options/customcode-settings.php' ?>
            </div>

            <!--Typography age-->
            <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="typography-page">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Typography</h3>
            <?php include_once 'theme-options/typography-settings.php' ?>
            </div>

              <!--Content Styling-->
              <div class="px-4 py-2 panel-item md:hidden bg-white rounded-lg shadow-xs dark:bg-gray-800" id="colors-options">
            <h3 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200 ">Theme colors</h3>
            <?php include_once 'theme-options/theme-colors.php' ?>
            </div>

            <div class="w-full flex justify-end gap-3 py-4 px-4 bg-white rounded-lg shadow-xs mt-2 dark:bg-gray-700">
            <label>
            <button type="submit" class="<?=style['btn-purple-np']?>"><?=tts['save']?></button>
            </label>
            <label>
            <button id="restore-theme" data-restore-uri="<?=URI_NAME?>/panel/restore-theme" class="<?=style['btn-purple-outline']?>">Restore</button>
            </label>
            </div>
            
            </form>
            </div>
            
       <!--Panel options-->

        </div>
        
        


        </div>
        
       

        
    </div>
</main>
<script src="<?=URI_NAME?>/assets/js/functions/theme-options.js" defer></script>
<script src="<?=URI_NAME?>/assets/js/functions/coloris.js"></script>

<script type="text/javascript">

Coloris({
      el: '.coloris',
      theme: 'polaroid',
      closeButton: true,
      swatches: [
        '#7e3af2',
        '#000000',
        '#24262d',
        '#e02424',
        '#0694a2',
        '#1c64f2',
        '#023e8a',
        '#0077b6',
        '#0096c7',
        '#00b4d8',
        '#48cae4'
      ]
    });

</script>
