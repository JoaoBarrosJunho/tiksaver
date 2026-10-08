<?php

use App\classes\leemclasses;
include_once THEME_CLASSES.'/post.php';

class grid_b{
public function getElementString(){
    $html = '<div class=" flex hvr-shrink flex-col gap-3  rounded-md   dark:text-gray-200">
    
    <a href="@postUrl"><div class="w-full h-64 rounded-md" style="background-image: url(@postFeatured);background-size:cover;background-position:center;" title="@fullTitle" alt="@fullTitle"></div></a>
    
    <div class="w-full  flex flex-col  justify-center items-center  py-2">
    <label class="flex w-full gap-3"><span class="flex gap-3 dark:text-gray-200">@postCategories</span>
    <span class="text-xs font-semibold text-gray-400 dark:text-gray-200">|</span><span class="text-xs font-semibold text-gray-400 dark:text-gray-200">@postDate</span></label>
    <h2 class="flex w-full"><a href="@postUrl" class="'.theme_t['grid-b'].' text-ellipsis text-gray-700 hover:text-gray-800 dark:text-gray-100" title="@fullTitle">@postTitle</a></h2>
    </div>
    </div>';

    return $html;
}

public function createElement($id,$title,$url,$date){
    $date = (new DateTime("$date"))->format(leemclasses::option('date_format'));
    $categories = getCategories($id,'');
    $featuredImage = featuredImage($id);

    return str_replace(['@postTitle','@postFeatured','@postUrl','@postDate','@postCategories'],
                    ["$title","$featuredImage","$url","$date","$categories"],$this->getElementString());

}

public function gridArea($posts,$gridTitle = null){
$title = $gridTitle?$gridTitle:'';
$list_ = [];
if($posts){
    foreach($posts as $post){
        $list_[]=$this->createElement($post->id,$post->post_title,$post->post_guid,$post->post_date);
    }

}

$html_title = '<div class="w-full flex
mt-2 mb-2 px-4 gap-3 '.theme_t['heading'].' dark:text-gray-200"><h2>'.$title.'</h2></div>';
$html = $html_title.'<div class="w-full grid md:grid-cols-2 gap-4    py-4 px-4  dark:bg-gray-800 dark:text-gray-200">
'.implode("\n",$list_).'
</div>';

return $html;
}


}
?>



