<?php
use App\classes\leemclasses;
?>
<div class="flex flex-col gap-6 dark:text-gray-100">

<label class="block mt-4 text-sm">
                <span class="text-sm font-semibold">CSS Code</span><br>
                <span class="text-gray-400 text-sm dark:text-gray-400"><?=tts['not_write_tag']?> <?= leemclasses::text_prepare('<style> </style>') ?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="Your css here..." name="custom_css"
                ><?= getOption('custom_css')?></textarea>
</label>

         <label class="block mt-4 text-sm">
                <span class="text-sm font-semibold">HTML Code</span><br>
                <span class="text-gray-400 text-sm dark:text-gray-400"><?=tts['custom_html_description']?> <?=leemclasses::text_prepare('<body>')?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="Your html here..." name="custom_html"
                ><?= getOption('custom_html')?></textarea>
         </label>
        
         <label class="block mt-4 text-sm">
                <span class="text-sm font-semibold">JavaScript Code</span><br>
                <span class="text-gray-400 text-sm dark:text-gray-400"><?=tts['not_write_tag']?> <?= leemclasses::text_prepare('<script></script>') ?></span>
                <textarea
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  rows="5" autocomplete="off" cols="40"
                  placeholder="Your Script here..." name="custom_script"
                ><?= getOption('custom_script')?></textarea>
         </label>
</div>