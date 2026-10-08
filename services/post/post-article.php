<?php
use App\activities\activity;
use App\api\onesignal;
use App\classes\leemclasses;
use App\classes\post;
use App\classes\postmeta;
use App\login\user;

$postData = json_decode($data['postdata']);
                
$post_Id = $postData->post_id;
$post_date = (new DateTime("$postData->post_date"))->format('Y-m-d H:i:s');
$title = $postData->title!='' && $postData->title !=null ? $postData->title : 'Untitled';
$content = $postData->content;
$visibility = isset($postData->visibility) && !empty($postData->visibility) ?strtolower($postData->visibility):'unlisted';
$post_featured = $postData->featured != null? $postData->featured: null;
$status = $visibility == 'public' ? 'published':'sketch';

$post_category = $postData->categoryes != null && !empty($postData->categoryes) ? explode(',',$postData->categoryes) : [1];
$post_tags = $postData->tags!=null && !empty($postData->tags) ? explode(',',"$postData->tags"):[];

$NotifySubscribers = $postData->notify_subs??false;


if($post_Id!=null && is_numeric($post_Id)){
    $checkPost = post::selectPost("id = '$post_Id'");

    if($checkPost){
    $slug = $postData->slug != null && !empty($postData->slug) && $postData->slug != $checkPost[0]->post_slug? post::genPostSlug($postData->slug):$checkPost[0]->post_slug;
    $guid = leemclasses::genGuid($slug);
    
    $post = (new post())->updateArticle($post_Id,$title,$slug,$guid,$status,$content,$visibility,1,$post_date);
    $message = "Post has been updated";
    activity::insert('Post Management',user::logged('name')." updated  ".$title,user::logged('id'));
    }
    
}else{
    
    
    $slug = $postData->slug != null && !empty($postData->slug) ? post::genPostSlug($postData->slug) : post::genPostSlug("$title");
    $guid = leemclasses::genGuid($slug);
    $post = (new post())->postArticle($title,$slug,$guid,$status,$content,$visibility,1,$post_date);
    $message = 'Post has been published.';
    activity::insert('Post Management',user::logged('name')." posted  ".$title,user::logged('id'));
}


if($post['success']){
    
    postmeta::setFeaturedImage($post['article_id'],$post_featured);
    postmeta::setPostCategory($post['article_id'],$post_category);
    postmeta::setPostTag($post['article_id'],$post_tags);
    
    
    
    $response = ['success'=>true,'message'=>"$message",'guid'=>"$guid",'id'=>$post['article_id'],'date'=> (new DateTime($post_date))->format('Y-m-d H:i'),'notify'=>$NotifySubscribers];
}else{
    
    $response = ['success'=>false,'message'=>'Error publishing new post'];
}
