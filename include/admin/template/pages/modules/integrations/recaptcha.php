<?php

use App\classes\leemclasses;

$captcha_pages = ['login' => leemclasses::option('rcp_login'), 'signup' => leemclasses::option('rcp_signup'), 'search_box' => leemclasses::option('rcp_savebox')];

?>

<div class="hidden grid gap-6 md:grid-cols-2 w-full px-5 py-4 rounded-lg bg-gray-50  dark:bg-gray-700 md:col-span-2 panel-template" id="recaptcha-settings">

<div class="md:col-span-2 rounded-md text-xs shadow-xs bg-orange-100 py-2 px-4">
                        <b>Note:</b> The script uses v2 keys for authentication with recaptcha, <a href="https://www.google.com/recaptcha/about/" class="font-semibold text-purple-600">request your keys</a>
                </div>

        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Site Key</span>
                <input type="text" value="<?= leemclasses::option('recaptcha_site_key') ?>" name="recaptcha_site_key" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="6Lc6o24qAAAAANXilkdKkMGKjp1z_bxhXwb0cgW0" />
        </label>

        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Secret Key</span>
                <input type="text" value="<?= leemclasses::option('recaptcha_secret_key') ?>" name="recaptcha_secret_key" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="6Lc6o24qjKAllISj0icSv1PNaVLNKKm3EGLf1pzO" />
        </label>

        <div class="flex flex-col md:col-span-2">
                <span class="text-sm text-gray-700 dark:text-gray-400"><?= tts['validate_in'] ?>:</span>
                <div class="flex flex-col   dark:text-gray-200">
                        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                                <label class="cl-switch hover:pointer">
                                        <input type="checkbox" onclick="setToogleValue('rcp_login')" <?= $captcha_pages["login"] == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                </label>
                                <span class="text-sm font-semibold">Login Form</span>
                                <input type="hidden" id="rcp_login" name="rcp_login" value="<?= $captcha_pages["login"] ?? 0; ?>">
                        </div>
                </div>

                <div class="flex flex-col   dark:text-gray-200">
                        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                                <label class="cl-switch hover:pointer">
                                        <input type="checkbox" onclick="setToogleValue('rcp_signup')" <?= $captcha_pages["signup"] == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                </label>
                                <span class="text-sm font-semibold">Register Form</span>
                                <input type="hidden" id="rcp_signup" name="rcp_signup" value="<?= $captcha_pages["signup"] ?? 0; ?>">
                        </div>
                </div>

                <div class="flex flex-col   dark:text-gray-200">
                        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                                <label class="cl-switch hover:pointer">
                                        <input type="checkbox" onclick="setToogleValue('rcp_savebox')" <?= $captcha_pages["search_box"] == 1 ? 'checked' : '' ?>>
                                        <span></span>
                                </label>
                                <span class="text-sm font-semibold">Video search box</span>
                                <input type="hidden" id="rcp_savebox" name="rcp_savebox" value="<?= $captcha_pages["search_box"] ?? 0; ?>">
                        </div>
                </div>


        </div>


</div>