<?php
include_once SITE_ROOT . '/include/admin/template/pages/modules/genius/configs.php';
?>

<!-- Modal files-->
<div class="modal fade" id="Modal-files" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
            <div class="modal-header">
                <h1 class="flex gap-3 text-2xl font-semibold text-gray-700 dark:text-gray-200 fs-5" id="staticBackdropLabel"><?= tts['add_multimedia'] ?><span class="flex items-center text-gray-400 text-2xl" id="spin_load_file"><i class='bx bxs-cloud-upload '></i></span></h1>
                <button type="button" class="btn-close dark:text-gray-400" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-sm text-gray-700 dark:text-gray-400">

                    <!--Tab Start-->
                    <!--TabMenu-->
                <div class="nav-files w-full bg-white">
                    <ul class="flex" style="gap: 4px;">
                        <li class="flex justify-center">
                            <button class="menuElement flex focus:outline-none justify-center bg-gray-50 hover:bg-gray-50 py-4 px-4 text-sm w-full" onclick="tabLibrary(event,'upload')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>

                                <?= tts['upload'] ?>
                            </button>

                        </li>
                        <li class="flex justify-center">
                            <button class="menuElement flex focus:outline-none justify-center bg-white hover:bg-gray-50 py-4 px-4 text-sm w-full" id="BtnLibrary">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z" />
                                </svg>
                                <?= tts['library'] ?>
                            </button>
                        </li>
                       
                    </ul>
                </div>
                <!--TabMenu-->
                <div class="container">

                    <div class="panel-files bg-gray-50 px-4 py-4 border-md ">
                        <div class="tabContent" id="upload">
                            <div class="flex items-center justify-center">
                                <div>
                                    <form id="FrmAttachment" action="">


                                        <label for="file_upload" class="flex items-center justify-center text-gray-700">

                                            <span class="flex py-2 px-3 justify-center  text-md mt-2 bg-gray-100 rounded-md text-gray" style="cursor: pointer;"><?= tts['upload'] ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                                                </svg>
                                            </span>



                                            <input id="file_upload" type="file" name="files[]" multiple onchange="uploadAttachment()" class="hidden">
                                        </label>

                                        <button type="submit" class="hidden" id="startupload"></button>
                                    </form>

                                    <p><?= tts['upload_max_size'] ?> <?= ini_get('upload_max_filesize') ?></p>
                                </div>

                            </div>

                            <!-- New Upload area -->

                            <div class="flex flex-wrap gap-6" id='new-files'>



                            </div>

                            <!-- New Upload area -->

                        </div>

                        <!-- Library -->

                        <div class="tabContent" style="display: none;" id='library'>

                            <div class="flex flex-wrap gap-6 justify-center" id='library-Contet'>
                                <!-- Result area -->
                            </div>

                            <div class="flex mt-4  w-full justify-center hidden" id="load-more">
                                <button class="flex items-center justify-center w-64 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" aria-level="2" id="more-btn" aria-label="Load More"><?= tts['load_more'] ?></button>
                            </div>

                        </div>


                    </div>
                </div>


                <!--Tab End-->
                </p>
            </div>
            <div class="modal-footer up_ft_modal">
                <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['cancel'] ?></button>
                <button type="button" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple" data-bs-dismiss="modal" id="InserAttachment" aria-valuetext="<?= tts['insert'] ?>"><?= tts['insert'] ?></button>
            </div>
        </div>
    </div>
</div>