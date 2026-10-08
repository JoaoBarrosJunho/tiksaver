<?php

use App\classes\leemclasses;
use App\classes\tk_video;

include_once 'functions/download-logs.php';

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-100 "><?= $TITLE ?> (<?= tk_video::find(null,null,null,'COUNT(id) as Res')[0]->Res??0 ?>)</h2>

        <div class="grid  items-center gap-6 mb-6" x-data="{showFilter:false}">
            <div class="flex items-center gap-3">
                <form action="" class="flex items-center gap-3">
                    <input type="search" name="s" class="<?= style["input-text"] ?>" placeholder="Search video...">
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
            

                <input type="datetime-local" name="date_in" title="Created between" value="<?= ($_GET['date_in'] ?? null) ? $_GET['date_in'] : '' ?>" class="<?= style["input-text"] ?>">
                <input type="datetime-local" name="date_fin" title="Created between" value="<?= ($_GET['date_fin'] ?? null) ? $_GET['date_fin'] : '' ?>" class="<?= style["input-text"] ?>">
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
        <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Video</th>
                            <th class="px-4 py-3">User IP</th>
                            <th class="px-4 py-3">Created</th>
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



<script src="<?= URI_NAME ?>/assets/js/functions/video-logs.js"></script>


<script>
    
    window.addEventListener("DOMContentLoaded",()=>{

        document.querySelectorAll(".user_ip").forEach((u_ip) => {
            u_ip.addEventListener("click",()=>{
                const show = u_ip.getAttribute("data-show");
                if(show==0){
                    u_ip.setAttribute("data-show",'1');
                    u_ip.innerText=u_ip.getAttribute('data-ip');
                }else{
                    u_ip.setAttribute("data-show",'0');
                    u_ip.innerText=u_ip.getAttribute('data-short');
                }
            })
        });

    })
</script>