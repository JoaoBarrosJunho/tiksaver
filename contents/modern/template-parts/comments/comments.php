<?php

use App\classes\comment;

include_once THEME_CLASSES . '/grids.php';
include_once THEME_CLASSES.'/comments.php';
$comments_count = comment::count("post_id ='$post->id'");

if($comments_count){
    $title = commentTitle($comments_count);
    print newTitle($title);
    print  '<div class="w-full flex px-6 py-4 flex-col gap-6  ">'.getComments($post->id).' </div>';
}

?>

