<?php

use App\api\recaptcha;


$recaptchaBox = recaptcha::getRecaptcha('rcp_savebox');


?>

<section class="flex  flex-col gap-6 mb-8 justify-center items-center ">

    <div class="w-full max-w-2xl grid   py-4 px-10 gap-6   ">
        <form id="video-form" class="w-full flex flex-col gap-6 justify-center">
            <span class="text-2xl font-semibold  w-full text-center"><?= SITE_DESCRIPTION ?></span>
            <div id="video_box" class="w-full grid  gap-3  " data-recaptcha="<?= $recaptchaBox ? 1 : 0 ?>">


                <div class="w-full flex items-center bg-white gap-3 p-2 border-2 border-primary text-gray-600 rounded-full    dark:bg-gray-800 dark:text-gray-200">
                    <label class="w-full">
                        <input type="url" required name="video_url" value="<?=$_GET['url']??null?>" id="video_url" class="w-full px-4 bg-white text-gray-600 text-lg font-semibold focus:outline-none dark:bg-gray-800 dark:text-gray-200" placeholder="https://www.tiktok.com/xxx/video/747xxxx">
                    </label>

                    <button class="text-xl rounded-full flex items-center justify-center px-2 py-2   leading-5 text-white transition-colors duration-150 bg-primary border border-transparent   focus:outline-none focus:shadow-outline-purple" id="download_btn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                            <path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM294.6 151.2c-4.2-4.6-10.1-7.2-16.4-7.2C266 144 256 154 256 166.3l0 41.7-96 0c-17.7 0-32 14.3-32 32l0 32c0 17.7 14.3 32 32 32l96 0 0 41.7c0 12.3 10 22.3 22.3 22.3c6.2 0 12.1-2.6 16.4-7.2l84-91c3.5-3.8 5.4-8.7 5.4-13.9s-1.9-10.1-5.4-13.9l-84-91z" />
                        </svg>
                    </button>
                </div>






            </div>
            <div class="flex items-center justify-center"><?= $recaptchaBox ?></div>
            <span id="tmail_notification" class="hidden text-xs md:col-span-2 w-full text-center"></span>
        </form>


    </div>

</section>

<?= printAds('ads_between_searchbar_result_section',$adsEnable)?>

<section id="result-section" class="hidden mx-auto max-w-2xl w-full grid  gap-6 mb-8 justify-center items-center mt-8 p-4">
</section>

<script>
    const myBtn = {
        primary: `<?= theme_t["btn-primary"] ?>`,
        outline: `<?= theme_t["btn-outline"] ?>`,
        tts:{
            no_watermark:`<?=tts['no_watermark']?>`,
            watermark:`<?=tts['watermark']?>`,
            music:`<?=tts['music']?>`,
        }
    }

    window.addEventListener("DOMContentLoaded",()=>{
        if($("#video_url").val()){
            $("#download_btn").click();
        }
    })
</script>