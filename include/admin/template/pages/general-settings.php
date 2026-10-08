<?php

use App\classes\language;
use App\classes\leemclasses;
use App\classes\post;

require_once 'general-settings/update-general-settings.php';
?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>

        <form action="" method="POST">
            <div class="px-4 py-3 mb-8 <?= style["bg"] ?>">
                <?php if ($_POST) {
                    echo leemclasses::notification($status);
                } ?>

                <!--Menu-->
                <div class="flex flex-wrap gap-3 w-full">
                    <label class="flex gap-3 bg-gray-50 dark:bg-gray-700 py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'site-options')"><?= tts['site_options'] ?></label>
                    <label class="flex gap-3  py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'user-options')"><?= tts['users'] ?></label>
                    <label class="flex gap-3  py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'privacy-options')"><?= tts['privacy'] ?></label>
                    <label class="flex gap-3  py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'timezone-options')"> <?= tts['time_zone'] ?></label>
                    <label class="flex gap-3  py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'security-options')"><?= tts['security'] ?></label>
                </div>
                <!--Menu-->

                <!--Site Options-->
                <div class="w-full flex flex-col px-4 py-4 bg-gray-50 dark:bg-gray-700 gap-3 panel-template" id="site-options">
                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['site_title'] ?></span>
                        <input type="text" value="<?= leemclasses::option('site_title') ?>" name="site_title" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?= tts['site_title'] ?>" />
                    </label>

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['site_description'] ?></span>
                        <input type="text" value="<?= leemclasses::option('site_description') ?>" name="site_description" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?= tts['site_description'] ?>" />
                    </label>

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['website_address'] ?></span>
                        <input type="text" value="<?= leemclasses::option('website_address') ?>" name="website_address" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="<?= tts['website_address'] ?>" />
                    </label>

                    <?php
                    function getSiteLangs()
                    {

                        $langs = language::$langs;
                        $result = [];
                        $selected = leemclasses::option('site_language');

                        $html = '<option value="@key" @selected>@value</option>';
                        foreach ($langs as $key => $value) {
                            $lang = isset(tts[strtolower($value)]) ? tts[strtolower($value)] : $value;
                            $select = $key == $selected ? 'selected' : '';
                            $result[] = str_replace(['@key', '@value', '@selected'], [$key, $lang, $select], $html);
                        }

                        return implode("\n", $result);
                    }

                    
                    ?>
                    <label class="mt-4 text-sm  max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['site_language'] ?>
                        </span>
                        <select name="site_language" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                            <?= getSiteLangs() ?>
                        </select>
                    </label>

                    

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['site_keywords'] ?></span><br>
                        <span class="text-gray-400 text-xs dark:text-gray-400"><?= tts['site_keywords_description'] ?></span>
                        <textarea class="<?= style['input-text'] ?>" rows="5" autocomplete="off" cols="40" placeholder="" name="site_keywords"><?= leemclasses::option('site_keywords') ?></textarea>
                    </label>

                    <div class="flex flex-col">
                        <?php
                        $sitemap = leemclasses::option("disable_sitemap");
                        ?>

                        <div class="cl-toggle-switch flex gap-3 py-4 items-center ">
                            <label class="cl-switch hover:pointer">
                                <input type="checkbox" onclick="setToogleValue('sitemap')" <?= $sitemap ? 'checked' : '' ?>>
                                <span></span>
                            </label>
                            <span class="text-sm font-semibold"><?= tts['disable_sitemap'] ?></span>
                            <input type="hidden" id="sitemap" name="disable_sitemap" value="<?= $sitemap ?>">
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <a href="<?= URI_NAME ?>/sitemap.xml" class="font-semibold" target="_blank"><?= URI_NAME ?>/sitemap.xml</a>
                        </span>
                    </div>

                </div>

                <!--Site Options-->
                <div class="w-full hidden flex-col px-4 py-4 bg-gray-50 dark:bg-gray-700 gap-3 panel-template" id="privacy-options">
                    <label class="mt-4 text-sm  max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['privacy_policy_page'] ?>
                        </span>
                        <select name="privacy_policy_page" class="w-full <?= style['select'] ?>">
                            <?php
                            $pages = post::selectPost('post_type="page" AND post_visibility="public"', null, null, 'post_title,post_guid');
                            $html = [];
                            $selected_page = leemclasses::option('privacy_policy_page');
                            if ($pages) {
                                foreach ($pages as $page) {
                                    $select = $page->post_guid == $selected_page ? 'selected' : '';
                                    $html[] = "<option value='$page->post_guid' $select>$page->post_title</option>";
                                }
                            }
                            print implode("\n", $html);
                            ?>
                        </select>
                    </label>

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['cookies_accept_button'] ?></span>
                        <input type="text" value="<?= leemclasses::option('cookies_accept') ?>" placeholder="Accept" name="cookies_accept" class="<?= style['input-text'] ?>" />
                    </label>

                    <label class="block mt-4 text-sm w-f-50">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['cookies_message'] ?></span><br>
                        <span class="text-gray-400 text-xs dark:text-gray-400"><?= tts['supported_shortcode'] ?> <span class="font-semibold">@privacy_page.</span></span>
                        <textarea class="<?= style['input-text'] ?> text-xs" rows="5" autocomplete="off" cols="40" placeholder="Eg. This site use cookies, find more information <a href='@pivacy_page'>Privacy Page</a>" name="cookies_message"><?= leemclasses::option('cookies_message') ?></textarea>
                    </label>

                </div>


                <div class="w-full hidden flex-col px-4 py-4 bg-gray-50 dark:bg-gray-700 gap-3 panel-template" id="user-options">
                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['role_subscribers'] ?>
                        </span>
                        <select name="role_subscribers" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">

                            <option <?php $role_sub_ = leemclasses::option('role_subscribers');
                                    if ($role_sub_ == 'Subscriber') {
                                        echo 'selected';
                                    } ?> value="subscriber"><?= tts['subscriber'] ?></option>
                            <option <?php if ($role_sub_ == 'Editor') {
                                        echo 'selected';
                                    } ?> value="editor"><?= tts['editor'] ?></option>
                            <option <?php if ($role_sub_ == 'Contributor') {
                                        echo 'selected';
                                    } ?> value="contributor"><?= tts['contributor'] ?></option>
                        </select>
                    </label>

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['allow_user_update_email'] ?>
                        </span>
                        <select name="user_update_email" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">

                            <option <?php $user_update_ = leemclasses::option('user_update_email');
                                    if ($user_update_ == 1) {
                                        echo 'selected';
                                    } ?> value="1"><?= tts['yes'] ?></option>
                            <option <?php if ($user_update_ != 1) {
                                        echo 'selected';
                                    } ?> value="NULL"><?= tts['no'] ?></option>

                        </select>
                    </label>

                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['new_users_verify_email'] ?>
                        </span>
                        <select name="new_user_status" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">

                            <option <?php $newuserstatus_ = leemclasses::option('new_user_status');
                                    if ($newuserstatus_  == 2) {
                                        echo 'selected';
                                    } ?> value="2"><?= tts['yes'] ?></option>
                            <option <?php if ($newuserstatus_  == 1) {
                                        echo 'selected';
                                    } ?> value="1"><?= tts['no'] ?></option>

                        </select>
                    </label>

                </div>

                <div class="w-full hidden flex-col px-4 py-4 bg-gray-50 dark:bg-gray-700 gap-3 panel-template" id="timezone-options">
                    <label class="ml-2 mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['time_zone'] ?>
                        </span>
                        <select name="time_zone" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">

                            <?= $tz ?>
                        </select>
                    </label>


                    <div class="mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['date_format'] ?>
                        </span>
                        <br><br>
                        <label class="items-center ml-2 text-gray-600 dark:text-gray-400">
                            <input <?= $dateFormat == 'Y-m-d' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="date_format" value="Y-m-d" />
                            <span class="ml-2"><?= date('Y-m-d') . ' <span class="ml-2 px-2" style="background:#f0f0f0;">[Y-m-d]</span>' ?></span>
                        </label><br>
                        <label class="items-center ml-2 text-gray-600 dark:text-gray-400">
                            <input <?= $dateFormat == 'd-m-Y' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="date_format" value="d-m-Y" />
                            <span class="ml-2"><?= date('d-m-Y') . ' <span class="ml-2 px-2" style="background:#f0f0f0;">[d-m-Y]</span>' ?></span>
                        </label><br>
                        <label class="items-center ml-2 text-gray-600 dark:text-gray-400">
                            <input <?= $dateFormat == 'j \d\e F, Y' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="date_format" value="j \d\e F, Y" />
                            <span class="ml-2"><?= date('j \d\e F, Y') . ' <span class="ml-2 px-2" style="background:#f0f0f0;">[j \d\e F, Y]</span>' ?></span>
                        </label><br>
                        <label class="items-center ml-2 text-gray-600 dark:text-gray-400">
                            <input <?= $dateFormat == 'd/m/Y' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="date_format" value="d/m/Y" />
                            <span class="ml-2"><?= date('d/m/Y') . ' <span class="ml-2 px-2" style="background:#f0f0f0;">[d/m/Y]</span>' ?></span>
                        </label>

                    </div>

                    <div class="mt-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-400">
                            <?= tts['time_format'] ?>
                        </span>
                        <div class="mt-2">
                            <label class=" items-center ml-2 text-gray-600 dark:text-gray-400">
                                <input <?= $timeFormate == 'G:i' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="time_format" value="G:i" />
                                <span class="ml-2"><?= date('G:i') . '<span class="ml-2 px-2" style="background:#f0f0f0;">[G:i]</span> ' ?></span>
                            </label><br>
                            <label class=" items-center ml-2 text-gray-600 dark:text-gray-400">
                                <input <?= $timeFormate == 'G:i A' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="time_format" value="G:i A" />
                                <span class="ml-2"> <?= date('G:i A') . '<span class="ml-2 px-2" style="background:#f0f0f0;">[G:i A]</span>' ?></span>
                            </label><br>
                            <label class=" items-center ml-2 text-gray-600 dark:text-gray-400">
                                <input <?= $timeFormate == 'H:i' ? 'checked' : ''; ?> type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" name="time_format" value="H:i" />
                                <span class="ml-2"><?= date('H:i') . '<span class="ml-2 px-2" style="background:#f0f0f0;">[H:i]</span> ' ?></span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="w-full hidden flex-col px-4 py-4 bg-gray-50 dark:bg-gray-700 gap-3 panel-template" id="security-options">
                
                    <label class="block mt-4 text-sm max-w-xl w-full">
                        <span class="text-gray-700 dark:text-gray-400"><?= tts['not_allowed_formats'] ?></span><br>
                        <span class="text-gray-400 text-sm dark:text-gray-400"><?= tts['separate_formats_not_allowed'] ?></span>
                        <textarea class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" rows="5" autocomplete="off" cols="40" placeholder="" name="not_allowed_formats"><?= leemclasses::option('not_allowed_formats') ?></textarea>
                    </label>

                </div>

                <!--Genius Template-->
                <div class="w-full ">
                    <button class="<?= style['btn'] ?>"><?= tts['submit'] ?></button>
                </div>
            </div>

        </form>


    </div>
</main>

<script>
    function setToogleValue(id) {
        const Toogle = document.getElementById(id);
        Toogle.value = Toogle.value == 0 ? 1 : 0;

    }
</script>