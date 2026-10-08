<?php
include_once THEME_CLASSES.'/post.php';


function ArticlesByCategory($meta_id,$order=null,$limit=6){ 
    $order = $order?$order:'post_id DESC';
    $num_rows = $limit;
    $articles = postsByCategory($meta_id,$order,$num_rows);
    return $articles;
}