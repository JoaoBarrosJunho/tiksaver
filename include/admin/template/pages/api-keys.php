<?php

use App\classes\dashboard;
use App\classes\integrations;
use App\classes\leemclasses;
use App\login\user;



$user = user::logged('id');


include_once 'functions/apikeys.php';

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>


<div class="flex items-flex justify-end gap-3 mb-4">
                <div class="flex items-center  ">
                    <button class="<?= style['btn-purple-np'] ?>" id="add-apikey">
                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg>
                        Add API Key</button>
                </div>

                <button onclick="$('#modal-docs').modal('show');" class="flex gap-3 items-center py-1 px-2 rounded-lg border  text-sm text-gray-600 dark:text-gray-200 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 0C43 0 0 43 0 96L0 416c0 53 43 96 96 96l288 0 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64c17.7 0 32-14.3 32-32l0-320c0-17.7-14.3-32-32-32L384 0 96 0zm0 384l256 0 0 64L96 448c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16zm16 48l192 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-192 0c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/></svg>
                Documentation
      </button>
  </div>

        <!--Table Posts-->
        <div class="w-full mb-4 overflow-hidden <?= style['bg'] ?>">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="<?= !$posts ? 'hidden' : '' ?> text-xs font-semibold tracking-wide text-left text-gray-500 
        uppercase border-b dark:border-gray-700  dark:text-gray-400 ">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3"><?=tts['name']?></th>
                            <th class="px-4 py-3">Token</th>
                            <th class="px-4 py-3">Requests/Limit(Today)</th>
                            <th class="px-4 py-3">Limitation</th>
                            
                            <th class="px-4 py-3">Action</th>
                            <th class="px-4 py-3"></th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?= !$posts ? '<tr>
                                <td colspan="5"><span class="flex items-center py-4 justify-center text-sm text-gray-600 dark:text-gray-400">' . tts['no_results'] . '...</span></td>
                            </tr>' : $table ?>
                    </tbody>
                </table>
            </div>


            <!--Pagination START-->

        </div>
        <?= leemclasses::nextprev($posts) ?>

        <?php $posts ? include_once 'modules/number-registers.php' : '' ?>
            
    </div>
</main>


<div class="modal modal-md fade" id="modal-apikey" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
            <div class="modal-header">
                <h1 class="modal-title text-lg font-semibold" id="staticBackdropLabel">Add Domain</h1>
            </div>
            <div class="modal-body">
                <form id="api-form" action=""  class="grid gap-3">
                    <label>
                        <span class="text-sm">API Key name</span>
                        <input type="text" placeholder="My APP" class="<?= style['input-text'] ?>" id="api_name" name="api_name">
                    </label>

                    <label>
                        <span class="text-sm">Daily limitation</span>
                        <select   class="w-full <?= style['select'] ?>" id="as_limited" name="as_limited">
                            <option value="1"><?=tts['active']?></option>
                            <option value="0"><?=tts['disabled']?></option>
                        </select>
                    </label>

                    <label>
                        <span class="text-sm">Requests per day</span>
                        <input type="number" min="1"  class="<?= style['input-text'] ?>" id="day_limit" name="day_limit">
                    </label>


                    <input type="hidden" name="current_api" id="current_api">
                    <button type="submit" id="submite_api"></button>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['cancel'] ?></button>
                <label><button onclick="$('#submite_api').click()" type="button" id="save-api"  class="<?= style['btn-purple-np'] ?>">Save</button></label>
            </div>
        </div>
    </div>
</div>

<?php
include_once 'modules/integration/api.php';
?>


<script src="<?=URI_NAME?>/assets/js/functions/api-management.js"></script>