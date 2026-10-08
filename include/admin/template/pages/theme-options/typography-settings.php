<?php
use App\classes\leemclasses;
use App\classes\typography;

function getFonts($option){
    $html = '<option value="@value" @selected >@name</option>';
    $response = [];
    $option_value = getOption($option);
    foreach(fonts as $key=>$value){
        $name = explode('-',$value);
        $selected = $value == $option_value ?'selected':null;
        $name_ =isset($name[1])? strtoupper($name[1]): strtoupper($value);
        $response[]=str_replace(['@value','@name','@selected'],[$value,$name_,$selected],$html);
    }

    return implode("\n",$response);

}

function getSizeList($option){
    $size_list = ['text-xs','text-sm','text-lg','text-xl','text-2xl','text-6xl'];
    $size_name = ['Small','Regular','Normal','Large','Extra large','Big'];
    $html = '<option value="@value" @selected>@name</option>';
    $response = [];
    $option_value = getOption($option);
    foreach($size_list as $key=>$value){
        $selected = $value == $option_value ?'selected':null;
        $response[]=str_replace(['@value','@name','@selected'],[$value,$size_name[$key],$selected],$html);
    }

    return implode("\n",$response);

}


function getWeightList($option){
    $weight_list =  ['','font-medium','font-semibold','font-bold'];
    $weight_name = ['Normal','Medium 500','Semi Bold 600','Bold 700'];
    $html = '<option value="@value" @selected>@name</option>';
    $response = [];
    $option_value = getOption($option);
    foreach($weight_list as $key=>$value){
        $selected = $value == $option_value ?'selected':null;
        $response[]=str_replace(['@value','@name','@selected'],[$value,$weight_name[$key],$selected],$html);
    }

    return implode("\n",$response);

}

?>






<div class="flex flex-col gap-6">
    
    <input type="hidden" id="my-fonts" value="<?= implode(',',fonts)?>">
    
    <!--Text font-->
    <div class="flex flex-col gap-3">
        <div class="flex flex-col py-2 dark:text-gray-200">
        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 ">Main text font</span>
              <div class="w-full flex gap-3 flex-wrap">  
                <select onchange="setFontOf(event,'main-text')" name="main_text_font" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Font Family</option>
                <?= getFonts('main_text_font')?> 
                </select>

                <select onchange="setSizeOf(event,'main-text')" name="main_text_size" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option  value="">Size</option>
                <?= getSizeList('main_text_size')?>
                </select>

                <select onchange="setWeightOf(event,'main-text')" name="main_text_weight" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option  value="">Font Weight</option>
                <?= getWeightList('main_text_weight')?>
                </select>


               </div>
    </div>

    <div class="<?= typography::getStyle('text')?> rounded border w-full py-2 px-2 dark:text-gray-200" id="main-text">
    An example of how your text will appear
        </div>

    </div>

    <!--Nav Area font-->
    <div class="flex flex-col gap-3 border-t">
        <div class="flex flex-col py-2 dark:text-gray-200">
        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 ">Nav Area font</span>
              <div class="w-full flex gap-3 flex-wrap">  
                <select onchange="setFontOf(event,'nav-text')" name="nav_font" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Font Family</option>
                <?= getFonts('nav_font')?> 
                </select>

                <select onchange="setSizeOf(event,'nav-text')" name="nav_text_size" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Size</option>
                <?= getSizeList('nav_text_size')?>
                </select>

                <select onchange="setWeightOf(event,'nav-text')" name="nav_text_weight" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Font Weight</option>
                <?= getWeightList('nav_text_weight')?>
                </select>


               </div>
    </div>
        
        <div class="<?=typography::getStyle('nav')?> rounded border w-full py-2 px-2 dark:text-gray-200" id="nav-text">
        <ul class="flex gap-6 ">
            <li>Item 1</li>
            <li>Item 2</li>
            <li>Item 3</li>
        </ul>
        </div>
    
    </div>

    <!-- Heading font-->
    <div class="flex flex-col gap-3 border-t">
        
        <div class="flex flex-col py-2 dark:text-gray-200">
                 <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 ">Heading font</span>
                <div class="w-full flex gap-3 flex-wrap">  
                <select onchange="setFontOf(event,'heading-font')" name="heading_font" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Font Family</option>
                <?= getFonts('heading_font')?> 
                </select>

                <select onchange="setSizeOf(event,'heading-font')" name="heading_size" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Size</option>
                <?= getSizeList('heading_size')?>
                </select>

                <select onchange="setWeightOf(event,'heading-font')" name="heading_weight" class="block w-48 mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="">Font Weight</option>
                <?= getWeightList('heading_weight')?>
                </select>
               </div>
    </div>
        
        <div class="<?= typography::getStyle('heading')?> rounded border w-full py-2 px-2 dark:text-gray-200" id="heading-font">
        A simple blog script
        </div>
    </div>

    


</div>