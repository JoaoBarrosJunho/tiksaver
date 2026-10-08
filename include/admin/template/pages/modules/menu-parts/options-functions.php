<?php
use App\classes\metatags;
use App\classes\post;

function newListElement($value){
$element = '<li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 
dark:hover:text-gray-200 ">
'.$value.'
</li>';

return $element;
}

function getPageList(){
    $listResult = newListElement("<label class='flex gap-3 hover:pointer'>
            <input type='checkbox' id='pageListItem' value='".URI_NAME."@:Home'> <span>Home</span>
            <label>");
    $listResult .= newListElement("<label class='flex gap-3 hover:pointer'>
            <input type='checkbox' id='pageListItem' value='".URI_NAME."/blog@:Blog'> <span>Blog</span>
            <label>");
        
    $pages = post::selectPost("post_type = 'page' AND post_status = 'published' AND post_visibility='public'",NULL,NULL,'post_title,post_guid');

    if($pages){

        foreach($pages as $p){
            $element = "<label class='flex gap-3 hover:pointer'>
            <input type='checkbox' id='pageListItem' value='$p->post_guid@:$p->post_title'> <span>$p->post_title</span>
            <label>";
            $listResult .= newListElement($element);
        }
        $listResult.='<li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
        <label class="flex w-full">
            <button onclick="addLinkPage()" class="'.style['btn-purple-outline'].' w-full">
                '.tts['add_to_menu'].'
            </button>
        </label>
        </li>';
    }
return $listResult;
}


function getCategoryList(){
    $listResult = '';
    $pages = metatags::selectMetaTags("type = 'category'",'name,slug,type','name ASC');

    if($pages){

        foreach($pages as $p){
            $guid = metatags::getMetatagGuid($p->slug,$p->type);
            $element = "<label class='flex gap-3 hover:pointer'>
            <input type='checkbox' id='categoryListItem' value='$guid@:$p->name'> <span>$p->name</span>
            <label>";
            $listResult .= newListElement($element);
        }
        
    }
return $listResult;
}

function getLinkTemplate(){

    $template = '';
    $inputs = '<input type="text" id="linkTitle" class="'.style['input-text'].'" placeholder="Link title">
        <input type="text" id="linkURL" class="'.style['input-text'].' mt-2" placeholder="URL">';
    $template.= newListElement($inputs);

    $template.='<li class="px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 ">
    <label class="flex w-full">
        <button onclick="addLinkPersonalized()" class="'.style['btn-purple-outline'].' w-full">
            '.tts['add_to_menu'].'
        </button>
    </label>
    </li>';
    return $template;
}