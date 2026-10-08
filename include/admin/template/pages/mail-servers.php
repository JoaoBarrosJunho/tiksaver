<?php

use App\classes\leemclasses;


include_once 'functions/mail-servers.php';

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="flex items-center gap-3 my-6 text-2xl font-semibold text-gray-700 dark:text-gray-100 "><?= $TITLE ?>
            <label>
                <button id="add-server" class="<?= style['btn-purple-outline'] ?>">Add Server</button></label>
        </h2>

        <div class="grid  items-center gap-6 mb-6" x-data="{showFilter:false}">
            <div class="flex items-center gap-3">
                <form action="" class="flex items-center gap-3">
                    <input type="search" name="s" class="<?= style["input-text"] ?>" placeholder="Search domain...">
                    <label>
                        <button id="add-server" class="<?= style['btn-purple-np'] ?>">Search</button>
                    </label>
                </form>

                <label>
                    <button id="add-server" @click="showFilter = !showFilter" class="<?= style['btn-purple-np'] ?>">
                        <span x-show="!showFilter" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>

                            Filter</span>
                        <span x-show="showFilter" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                            </svg>
                            Close</span>
                    </button>
                </label>


            </div>

            <form x-show="showFilter" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="grid xl:grid-cols-4 items-center gap-3 md:col-span-2">
                <select name="status" title="status" class="<?= style['select'] ?>">
                    <option value="1" <?= ($_GET['status'] ?? null) == 1 ? 'selected' : '' ?>><?= tts['active'] ?></option>
                    <option value="0" <?= ($_GET['status'] ?? null) == 0 ? 'selected' : '' ?>><?= tts['inactive'] ?></option>
                </select>

                <label>
                    <button id="add-server" class="<?= style['btn-purple-np'] ?>">Apply</button>
                </label>
            </form>


        </div>



        <!--Table Posts-->
        <div class="w-full mb-4 overflow-hidden <?= style['bg'] ?> ">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="<?= !$posts ? 'hidden' : '' ?> text-xs font-semibold tracking-wide text-left text-gray-500 
        uppercase border-b dark:border-gray-700  dark:text-gray-400 ">
                            <th class="px-4 py-3">Domain</th>
                            <th class="px-4 py-3">Host</th>
                            <th class="px-4 py-3">Mail</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <?= !$posts ? '<tr>
                                <td colspan="6"><span class="flex items-center py-4 justify-center text-sm text-gray-600 dark:text-gray-400">' . tts['no_results'] . '...</span></td>
                            </tr>' : $table ?>


                    </tbody>
                </table>
            </div>

            <!--Pagination START-->


            <!--Pagination HTML Result-->

            <?= leemclasses::nextprev($posts) ?>

            <?php $posts ? include_once 'modules/number-registers.php' : '' ?>
        </div>
        <!--Table Posts-->
    </div>
</main>


<div class="modal  fade" id="modal-server" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="Manage Server" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
            <div class="modal-header">
                <h1 class="modal-title text-lg font-semibold" id="staticBackdropLabel">Add server</h1>
            </div>
            <div class="modal-body">
                <div class="grid gap-3">
                    <div class="rounded-md text-xs shadow-xs bg-orange-100 py-2 px-4">
                        <b>Note:</b> Make sure the email you are configuring has the catch-all feature enabled.
                    </div>
                    <label class="flex flex-col">
                        <span class="text-sm font-semibold">Domain</span>
                        <input type="text" id="domain" placeholder="maildomain.com" class="<?= style['input-text'] ?>">
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-semibold">Imap Host</span>
                        <input type="text" id="host" placeholder="imap.example.com" class="<?= style['input-text'] ?>">
                    </label>


                    <label class="flex flex-col">
                        <span class="text-sm font-semibold">Usename</span>
                        <input type="text" id="mail" class="<?= style['input-text'] ?>" placeholder="yourmail@maildomain.com">
                    </label>

                    <label class="flex flex-col">
                        <span class="text-sm font-semibold">Password</span>
                        <input type="password" placeholder="******" id="password" class="<?= style['input-text'] ?>">
                    </label>

                    <label class="flex flex-col">
                        <span>Status</span>
                        <select id="status" class="w-full <?= style['select'] ?>">
                            <option value="1"><?= tts['active'] ?></option>
                            <option value="0"><?= tts['inactive'] ?></option>
                        </select>
                    </label>
                    </label>

                    <input type="hidden" id="current_server">
                </div>
            </div>
            <div class="modal-footer">
            
                <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['cancel'] ?></button>
                <label><button  id="test-server" class="<?= style['btn-purple-outline'] ?>">Test Connection</button></label>
                <label><button type="button" id="save-server" class="<?= style['btn-purple-np'] ?>">Save</button></label>
            </div>
        </div>
    </div>
</div>


<script src="<?= URI_NAME ?>/assets/js/functions/server-management.js"></script>