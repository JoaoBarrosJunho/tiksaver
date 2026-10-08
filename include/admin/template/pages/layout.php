<?php

use App\classes\leemclasses;
use App\classes\widget;
?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="flex gap-3 items-center my-6  text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>
        

        <!--Layout Buttons area-->
        <div class="flex gap-6 justify-end bg-white shadow-md rounded-lg w-full px-4 py-2 mb-8 dark:bg-gray-800 dark:text-gray-200">
            <button class="<?= style['btn-purple-outline']?>" id="save-all" aria-label="<?= tts['save']?>"><i class='bx bx-save'></i> <?= tts['save']?></button>
        </div>
        <!--Layout Buttons area-->

        <!--Layout management area-->
        
        <div class="grid gap-6 px-4 py-3 mb-8 bg-white shadow-md rounded-lg  md:grid-cols-4 dark:bg-gray-800 dark:text-gray-200">
        
        <div class="w-full  h-full px-2 py-2 rounded-lg bg-gray-50  dark:bg-gray-700 md:col-span-3">
        </div>
        
        <div class="w-full flex flex-col gap-6 h-full px-2 py-2 rounded-lg bg-white  dark:bg-gray-700 ">
            <!-- Sidebar Area -->
            <?= widget::getWidgets('sidebar_area');?>
            <!-- sidebar Area -->
        </div>

        </div>


        <!--Layout management area-->
        <div class="grid gap-6 px-4 py-3 mb-8 bg-white shadow-md rounded-lg  md:grid-cols-4 dark:bg-gray-800 dark:text-gray-200">
            <?= leemclasses::themeName()=='default'? widget::getWidgets('footer_area'):null?>
        </div>
        <!--Layout management area-->
    </div>
</main>


<!-- Modal Delete-->
<div class="modal fade" id="widgetModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Manage Gadget</h1>
        <button type="button" class="btn-close dark:text-gray-400 " data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div id="template-area" >
            
       </div>
       <input type="hidden" id="selectedArea">
       <input type="hidden" id="widgetId">
      </div>
      <div class="modal-footer hidden">
        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal">Cancel</button>
        <button id="submit-form" aria-label="Submit" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">Submit</button>
      </div>
    </div>
  </div>
</div>
<script src="<?= URI_NAME?>/assets/js/functions/widget-construtor.js"></script>
