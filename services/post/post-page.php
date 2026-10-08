<?php
use App\activities\activity;
use App\classes\leemclasses;
use App\classes\post;
use App\login\user;

$success = false;
$message = '';
$dataResponse = [];

$postData = json_decode($data['postdata']);
$post_Id = isset($postData->post_id) && is_numeric($postData->post_id) ? $postData->post_id:null;
$post_date = (new DateTime("$postData->post_date"))->format('Y-m-d H:i:s');
$title = $postData->title!='' && $postData->title !=null ? $postData->title : 'Untitled';
$content = $postData->content;
$commentstatus = isset($postData->commentstatus) && is_numeric($postData->commentstatus)?$postData->commentstatus:0;
$slug = $postData->slug != null && $postData->slug != ''? $postData->slug : null;
$visibility = isset($postData->visibility) && !empty($postData->visibility) ? $postData->visibility:'Unlisted';
$status = $visibility == 'public' ? 'published':'sketch';

if(isset($postData->post_type) && $postData->post_type=='page'){

}
if($post_Id){
    //UPDATE PAGE
    $searchPost = post::selectPost("id='$post_Id'");
    if($searchPost){
        $slug = $searchPost[0]->post_slug != $slug && $slug != null ? leemclasses::genUnicSlug($title,$slug,'posts','post_slug', 'post_type = "page"'):$searchPost[0]->post_slug;
        $guid = leemclasses::genGuid($slug);
        $execute = (new post())->updatePage($post_Id,$title,$slug,$guid,$status,$content,$visibility,$commentstatus,$post_date);

        if($execute['success']){
            $success = true;
            $message = 'page has been updated!';
            $dataResponse = ['post_id'=>$post_Id,'permalink'=>"$guid",'date'=>"$post_date"];
            activity::insert('Page Management',user::logged('name')." updated  ".$title,user::logged('id'));
        }else{
            $message = 'Error to update this page';
        }

    }else{
        $message = 'Page not found!';
    }

}else{
    //PUBLISH NEW PAGE
    $slug = leemclasses::genUnicSlug($title,$slug,'posts','post_slug', 'post_type = "page"');
    $guid = leemclasses::genGuid($slug);
    $execute = (new post())->postPage($title,$slug,$guid,$status,$content,$visibility,$commentstatus,$post_date);
    if($execute['success']){
        $success = true;
        $message = 'Page has been published';
        $dataResponse = ['post_id'=>$execute['post_id'], 'permalink'=>"$guid",'date'=>"$post_date"];
        activity::insert('Page Management',user::logged('name')." posted  ".$title,user::logged('id'));
    }else{
        $message = 'Error to publish this post!';
    }

}

$response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];