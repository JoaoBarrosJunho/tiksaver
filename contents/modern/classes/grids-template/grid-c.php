<?php

use App\classes\leemclasses;
include_once THEME_CLASSES.'/post.php';

class grid_c{
public function getElementString(){
    $html = '<div class="flex flex-col  dark:text-gray-200">
    
    <a href="@postUrl">
    <div class="w-full flex py-2 px-4 items-end h-32 rounded-md" style="background-image: url(@postFeatured);background-size:cover;background-position:center;" title="@postTitle" alt="@postTitle">
    </div>
    </a>
    <div class="w-full flex justify-center items-center px-2 mb-2">
    <h2 class="flex w-full"><a href="@postUrl" class="'.theme_t['grid-c'].' text-ellipsis text-gray-700 hover:text-gray-800 dark:text-gray-200" title="@postTitle">@postTitle</a></h2>
    </div>
    </div>';

    return $html;
}

public function createElement($id,$title,$url,$date){
    $date = (new DateTime("$date"))->format(leemclasses::option('date_format'));
    #$categories = getCategories($id,'');
    $featuredImage = featuredImage($id);

    return str_replace(['@postTitle','@postFeatured','@postUrl','@postDate'],
                    ["$title","$featuredImage","$url","$date"],$this->getElementString());

}

public function gridArea($posts,$gridTitle = null){
    $title = $gridTitle?$gridTitle:'';
    $html_title = '<div class="w-full flex
    mt-2 mb-2 px-4  gap-3 '.theme_t['heading'].' dark:text-gray-200"><h2>'.$title.'</h2></div>';

    $list_ = [];
    if($posts){
        foreach($posts as $post){
            $list_[]=$this->createElement($post->id,$post->post_title,$post->post_guid,$post->post_date);
        }

    }

    $html = $html_title.'<div class="w-full grid grid-cols-2 md:grid-cols-4 gap-4    py-4 px-4  dark:bg-gray-800 dark:text-gray-200">
    '.implode("\n",$list_).'
    </div>';

return $html;
}


}
?>



