<?php

include_once THEME_CLASSES.'/header/nav-items.php';
?>
<!-- Mobile sidebar -->
  <!-- Backdrop -->
  <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
  <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto header-styling dark:bg-gray-900 <?= $header_type =='header-b'?'':'md:hidden'?>" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="<?= theme_t['nav']?> py-4  dark:text-gray-100">
      <ul class="mt-2"> 
        
      
      <?= headerList('relative '.getOption('nav_font').'  px-6 py-3',null,'inline-flex items-center w-full text-lg font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200')?>

        <li class="relative  px-6 py-3"> 
          <ul class="flex items-center justify-between bg-gray-50 text-gray-700 dark:text-gray-400 rounded-md py-2 px-2 flex-shrink-0 space-x-6 dark:bg-gray-700">
          <?= darkmode_toogle()?>
          
          </ul>
        </li>
      </ul>

    </div>
  </aside>