
<div class="flex flex-col gap-6">



    <div class="flex flex-col  dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('footer_nav')"  <?=getOption('show_footer_nav')==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?= tts['disable_footer_menu']?></span>
                <input type="hidden" id="footer_nav"  name="show_footer_nav" value="<?= getOption('show_footer_nav')!=null?getOption('show_footer_nav'):0;?>">
        </div>
        <span class="text-xs text-gray-600 dark:text-gray-100">
        <?= tts['disable_footer_menu_description']?> 
        </span>
    </div>

    <div class="flex gap-3">
    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-sm font-semibold">
            Footer text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('footer_color')?>" name="footer_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-sm font-semibold">
            Footer Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('footer_background')?>" name="footer_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>

    </div>

    

    <label class="flex flex-col  border-t py-2 dark:text-gray-200">
        <span class="text-sm font-semibold py-4">
            Copyright
        </span>
        <span class="text-xs text-gray-600 dark:text-gray-100">
       <b><?= tts['supported_shortcodes']?>:</b> <span class="font-semibold">@site_url, @site_title, @site_description, @this_year</span>
        </span>
        <label class="w-f-50 mt-2">
        <textarea name="copy_text" class="<?= style['input-text']?>" cols="15" rows="5"><?=getOption('copy_text')?></textarea>
        </label>
        
        
    </label>



</div>