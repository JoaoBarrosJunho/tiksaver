
<div class="flex flex-col gap-6">

<div class="flex flex-col  dark:text-gray-200">
        <div class="cl-toggle-switch flex gap-3 py-4 items-center">
                <label class="cl-switch hover:pointer">
                    <input type="checkbox" onclick="setToogleValue('only_darkmode')"  <?=getOption('only_darkmode')==1?'checked':''?>  >
                    <span></span>
                </label>
                <span class="text-sm font-semibold"><?=tts['only_darkmode']?></span>
                <input type="hidden" id="only_darkmode"  name="only_darkmode" value="<?= getOption('only_darkmode')!=null?getOption('only_darkmode'):0;?>">
        </div>
        
    </div>

<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Primary color</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="square w-30"><input type="text" value="<?=getOption('primary_color')?>" name="primary_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>
</div>

</div>

<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Body Color</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('body_color')?>" name="body_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('body_background')?>" name="body_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>
</div>

</div>




<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Module Color</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('module_color')?>" name="module_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('module_background')?>" name="module_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>
</div>
</div>


<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Pagination Color</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('pagination_color')?>" name="pagination_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('pagination_background')?>" name="pagination_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>
</div>
</div>


<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Copyright Area</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('copyright_color')?>" name="copyright_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>

    <div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Background
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('copyright_background')?>" name="copyright_background" class="coloris <?=style['input-text']?>" data-coloris></span>
    </div>
</div>
</div>



<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Post content</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('content_color')?>" name="content_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>
</div>
</div>

<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Links</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
            Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('link_color')?>" name="link_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>
</div>
</div>

<div class="flex flex-col gap-3">
<span class="text-sm font-semibold">Meta info</span>
<div class="flex gap-6">
<div class="w-35 flex flex-col gap-3 dark:text-gray-200">
        <span class="text-xs">
           Text color
        </span>
        <span class="square w-30"><input type="text" value="<?=getOption('meta_color')?>" name="meta_color" class="coloris <?=style['input-text']?>" data-coloris></span>    
    </div>
</div>
</div>

</div>