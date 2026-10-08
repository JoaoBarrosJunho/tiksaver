<?php
use App\classes\leemclasses;
?>

<div class="flex flex-col gap-6 dark:text-gray-100">

<!--Ads in homepage-->
<div class="flex flex-col   dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <?php $show_ads_home = getOption('show_ads_home');?>
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('ads_in_home')"  <?=$show_ads_home==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?=tts['occult_ads_home']?></span>
                <input type="hidden" id="ads_in_home"  name="show_ads_home" value="<?= $show_ads_home!=null?$show_ads_home:0;?>">
        </div>
        <span class="text-xs text-gray-600 dark:text-gray-100">
        <?=tts['occult_ads_pages_description']?>
        </span>
  </div>



  <!--Ads in pages-->
<div class="flex flex-col   dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <?php $show_ads_page = getOption('show_ads_page'); ?>
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('ads_in_page')"  <?=$show_ads_page==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?=tts['occult_ads_pages']?></span>
                <input type="hidden" id="ads_in_page"  name="show_ads_page" value="<?= $show_ads_page!=null?$show_ads_page:0;?>">
        </div>
        <span class="text-xs text-gray-600 dark:text-gray-100">
        <?=tts['occult_ads_home_description']?>
        </span>
  </div>

<label class="block mt-4 text-sm">
                <span class="text-sm font-semibold"><?=tts['after_header']?></span><br>
                
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                   name="ads_after_header" placeholder="<?=tts['ads_place_holder']?>"
                ><?= getOption('ads_after_header')?></textarea>
         </label>

         <label class="block mt-4 text-sm">
                <span class="text-sm font-semibold"><?=tts['ads_between_searchbar_result_section']?></span><br>
                
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                   name="ads_between_searchbar_result_section" placeholder="<?=tts['ads_place_holder']?>"
                ><?= getOption('ads_between_searchbar_result_section')?></textarea>
         </label>

        
        
        

         <label class="block mt-4 text-sm">
                <span class="text-sm font-semibold"><?=tts['before_footer']?></span><br>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                   name="ads_before_footer" placeholder="<?=tts['ads_place_holder']?>"
                ><?= getOption('ads_before_footer')?></textarea>
         </label>

        

</div>