<?php
$post = isset($router_response['post_data']) ? $router_response['post_data']:null;

if($post){
    switch($post->post_type){
        case 'article':
            include_once 'post/article.php';
        break;
        case 'page':
            include_once 'post/page.php';
        break;
        default:
        break;
    }


}


