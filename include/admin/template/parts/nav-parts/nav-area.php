<?php
use App\classes\navlinks;
use App\login\user;
$site_dir = URI_NAME;
$loggedType = user::UserType(user::logged('type'));
$loggedVal = user::logged('type');
$background = $loggedVal>1?"text-white bg-gray-700 dark:bg-gray-800":"bg-white dark:bg-gray-800";
$textColor = $loggedVal>1?"text-white dark:text-gray-400":"text-gray-500 dark:text-gray-400";

include_once 'logo.php'
?>
<div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
  <!-- Desktop sidebar -->
  <aside class="z-20 hidden w-64 overflow-y-auto <?=$background?> md:block flex-shrink-0 hidde-scroll">
    <div class="py-4 <?=$textColor?>">
      
    <?= $logo ?>

  
      <ul class="mt-6">
        <?=(new navlinks())->buildMenu()?>
      </ul>      
    </div>
    <div class="w-full px-4 mt-2 mb-2">
    <button class="<?=style["btn-purple"]?>" onclick="window.open('<?= URI_NAME?>')">
      <?=tts['go_to_home_page']?>
      <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l82.7 0L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3l0 82.7c0 17.7 14.3 32 32 32s32-14.3 32-32l0-160c0-17.7-14.3-32-32-32L320 0zM80 32C35.8 32 0 67.8 0 112L0 432c0 44.2 35.8 80 80 80l320 0c44.2 0 80-35.8 80-80l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 112c0 8.8-7.2 16-16 16L80 448c-8.8 0-16-7.2-16-16l0-320c0-8.8 7.2-16 16-16l112 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 32z"/></svg>
    </button>
    </div>
    
  
  </aside>

  <!-- Mobile sidebar -->
  <!-- Backdrop -->
  <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
  <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
    <?=$logo ?>
      <ul class="mt-6">
      <?=(new navlinks())->buildMenu()?>
      </ul>  
    </div>
    <div class="w-full px-4 mt-2 mb-2">
    <button class="<?=style["btn-purple"]?>" onclick="window.open('<?= URI_NAME?>')">
      <?=tts['go_to_home_page']?>
      <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l82.7 0L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3l0 82.7c0 17.7 14.3 32 32 32s32-14.3 32-32l0-160c0-17.7-14.3-32-32-32L320 0zM80 32C35.8 32 0 67.8 0 112L0 432c0 44.2 35.8 80 80 80l320 0c44.2 0 80-35.8 80-80l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 112c0 8.8-7.2 16-16 16L80 448c-8.8 0-16-7.2-16-16l0-320c0-8.8 7.2-16 16-16l112 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 32z"/></svg>
    </button>
    </div>
  </aside>
  <div class="flex flex-col flex-1 w-full">
    

  <?php include_once 'header.php'?>