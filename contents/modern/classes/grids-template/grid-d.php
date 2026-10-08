<?php

use App\classes\leemclasses;
include_once THEME_CLASSES.'/post.php';

class grid_d{
public function getElementString($is_latest=false){
    $html = $is_latest?'<div class=" flex hvr-shrink flex-col gap-3  rounded-md  dark:text-gray-200">
    
    <a href="@postUrl"><div class="w-full h-64 rounded-md" style="background-image: url(@postFeatured);background-size:cover;background-position:center;" title="@fullTitle" alt="@fullTitle"></div></a>
    
    <div class="w-full  flex flex-col  justify-center items-center  py-2">
    <label class="flex w-full gap-3"><span class="flex gap-3 dark:text-gray-200">@postCategories</span>
    <span class="text-xs font-semibold text-gray-400 dark:text-gray-200">|</span><span class="text-xs font-semibold text-gray-400 dark:text-gray-200">@postDate</span></label>
    <h2 class="flex w-full"><a href="@postUrl" class="'.theme_t['grid-b'].' text-ellipsis text-gray-700 hover:text-gray-800 dark:text-gray-100" title="@fullTitle">@postTitle</a></h2>
    </div>
    </div>'
    :
    '<div class="flex hvr-shrink w-full h-25 overflow-hidden  dark:text-gray-200" >
    <a href="@postUrl"><div class="w-25 h-25 shadow rounded-md " style="background-image: url(@postFeatured);background-size:cover;background-position:center;" title="@fullTitle" alt="@fullTitle"></div></a>
    <div class="flex  overflow-hidden flex-col gap-2 px-6 py-2">
    <label class="flex gap-3">@postCategories</label>
    <h2 class="flex " ><a href="@postUrl" class="'.theme_t['default-grid'].' text-ellipsis mr-2 text-gray-700  hover:text-gray-800 dark:text-gray-100" title="@fullTitle">@postTitle</a></h2>    
    </div>
    </div>';

    return $html;
}

public function createElement($id,$title,$url,$date,$full_title,$is_latest=false){
    $date = (new DateTime("$date"))->format(leemclasses::option('date_format'));
    $categories = getCategories($id,'');
    $featuredImage = featuredImage($id);

    return str_replace(['@postTitle','@fullTitle','@postFeatured','@postUrl','@postDate','@postCategories'],
                    ["$title",$full_title,"$featuredImage","$url","$date","$categories"],$this->getElementString($is_latest));

}

public function gridArea($posts,$gridTitle = null){
$title = $gridTitle?$gridTitle:'';
$html_title = '<div class="w-full flex
mt-2 mb-2 px-4 gap-3 '.theme_t['heading'].' dark:text-gray-200"><h2>'.$title.'</h2></div>';
$list_=[];
$latest='';
if($posts){
    $is_latest=true;
    foreach($posts as $post){

        
        $ellipsis = strlen($post->post_title)>60?' ...':'';

        if($is_latest){
            $latest = $this->createElement($post->id,$post->post_title,$post->post_guid,$post->post_date,$post->post_title,$is_latest);
        }else{
            $list_[]=$this->createElement($post->id,substr($post->post_title,0,60).$ellipsis,$post->post_guid,$post->post_date,$post->post_title,$is_latest);
        } 
        $is_latest = false;
    }

}

$html = $html_title.'<div class="w-full grid md:grid-cols-2 gap-4    py-4 px-4  dark:bg-gray-800 dark:text-gray-200">
<div>'.$latest.'</div>
<div class="flex flex-col gap-3">'.implode("\n",$list_).'</div>
</div>';

return $html;
}


}
?>



