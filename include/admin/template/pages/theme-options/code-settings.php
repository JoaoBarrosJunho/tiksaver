<?php
use App\classes\leemclasses;
?>
<div class="flex flex-col gap-6 dark:text-gray-100">

<label class="block mt-4 text-sm">
                <span class="text-sm font-semibold "><?= tts['header']?></span><br>
                <span class="text-sm text-gray-400 text-sm dark:text-gray-400"><?= tts['description_header']?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="<?=tts['put_code_here']?>" name="header"
                ><?= getOption('header')?></textarea>
         </label>

         <label class="block mt-4 text-sm">
                <span class="font-semibold "><?= tts['body']?></span><br>
                <span class="text-sm text-gray-400 text-sm dark:text-gray-400"><?= tts['description_body']?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="<?=tts['put_code_here']?>" name="body_area"
                ><?= getOption('body_area')?></textarea>
         </label>
        
         <label class="block mt-4 text-sm">
                <span class="font-semibold "><?= tts['footer']?></span><br>
                <span class="text-sm text-gray-400 text-sm dark:text-gray-400"><?= tts['description_footer']?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="<?=tts['put_code_here']?>" name="footer"
                ><?= getOption('footer')?></textarea>
         </label>

        

</div>