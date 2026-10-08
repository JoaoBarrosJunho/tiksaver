<?php

use App\login\auth;
use App\login\logout;

include_once THEME_CLASSES . '/header/nav-items.php';
auth::inite();
?>

<?php include_once 'mobile-menu.php'; ?>
<div class="<?= theme_t['nav'] ?> flex flex-col flex-1 w-full">
  <header class="z-10 py-4 header-styling  dark:bg-gray-900">
    <div class="container flex items-center justify-between h-full px-6 mx-auto  dark:text-gray-100">
      <!-- Mobile hamburger -->
      <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="toggleSideMenu" aria-label="Menu">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
        </svg>



      </button>
      <!-- Site Logo -->
      <div class="hidden md:flex">
        <?= headerlogo(URI_NAME) ?>
        <ul class="flex items-center ml-4 flex-shrink-0 space-x-6 uppercase">
          <!-- Theme toggler -->
          <?= headerList('menu-item  font-bold') ?>

        </ul>
      </div>

      <!-- Search input -->
      <div class="md:hidden  flex justify-center flex-1 lg:mr-32">
        <?= headerlogo(URI_NAME) ?>
      </div>
      <ul class="flex items-center flex-shrink-0 space-x-6">

        

        <li class="hidden md:block">
          <ul class="flex items-center flex-shrink-0 space-x-6">

            <?= darkmode_toogle() ?>
          </ul>
        </li>

        <li class="">
          <ul class="flex items-center flex-shrink-0 space-x-6">
            <?= setLangToogle() ?>
          </ul>
        </li>
        




      </ul>
    </div>
  </header>
</div>