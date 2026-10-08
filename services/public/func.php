<?php

use App\classes\language;


switch($data['pub-action']){
    /**case 'get-comments':
        $coments = [];
        $id = isset($data['post']) && is_numeric($data['post'])?$data['post']:null;
        if($id){
            $coments = comment::select("post_id='$id' AND status='1'","id DESC",null,"(id) as ref,(post_id) as post,(comment) as comment_text,(author_name) as author, (comment_date) as date");
            $response = ['success'=>true,'message'=>'','data'=>$coments];
        }else{
            $response = ['success'=>false,'message'=>'Put the post ID'];
        }
        

    break;
   case 'new-comment':
        $success = false;
        $message = '';

        $recaptcha_response = $data['g-recaptcha-response'] ?? null;

if (leemclasses::option('rcp_comment') && !recaptcha::validate($recaptcha_response)['ok']) {
    print json_encode(['success' => $success, 'message' => 'Validate the captcha!']);
    die();
}

        $post_id = isset($data['comment-ref']) && is_numeric($data['comment-ref'])?$data['comment-ref']:null;
        $parent = isset($data['reply']) && is_numeric($data['reply'])?$data['reply']:0;
        $comment = isset($data['comment']) && !empty($data['comment'])?$data['comment']:' ';
        $author_name = isset($data['name']) && !empty($data['name'])?$data['name']:'Undefined';
        $author_email = isset($data['email']) && !empty($data['email'])?$data['email']:'undefined@mail.com';
        $author = user::logged('name')?user::logged('name'):$author_name;
        $email = user::logged('email')?user::logged('email'):$author_email;
        $user = user::logged('id')?user::logged('id'):0;

        if($post_id){
            $execute = comment::insert($post_id,$comment,$author,$email,$parent,$user);
            if($execute){
                $success = true;
                $message = user::isAdmin()?"Comment published, refresh the page!":"Your comment is awaiting moderation...";
            }else{
                $message = "Error to post your comment!";
            }
        }else{
            $message = 'Invalid content!';
        }
        
    $response = ['success'=>$success,'message'=>"$message"];
    break; */
    case 'set-lang':
        $success = false;
        $message = '';
        $value = isset($data['lang'])?$data['lang']:'en';
        if(language::setLang(1,$value)){
            $success = true;
            $message = 'Language was changed successfully!';
        }else{
            $message = 'Error changing language';
        }

        $response = ['success'=>$success,'message'=>"$message"];
        break;
        
        case 'video':
            include_once 'video/management.php';
        break;
   
    default:
    $response = ['success'=>false,'message'=>"Error: Undefined method!"];
    break;
}