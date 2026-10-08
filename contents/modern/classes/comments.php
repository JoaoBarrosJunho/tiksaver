<?php

use App\classes\comment;
use App\classes\leemclasses;
use App\login\user;

function userInfo()
{
    if (!user::logged('name') && !user::logged('email')) {
        return '<div class="flex gap-3 justify-between">
        <input type="text" required class="' . style['input-text'] . '" name="name" placeholder="'.tts_t['name'].'">
        <input type="email" required class="' . style['input-text'] . '" name="email" placeholder="'.tts_t['email'].'">
        </div>';
    }

    return '';
}

function commentTitle($num)
{
    $title = '';
    switch ($num) {
        case 0:
            $title = tts_t['no_comments'];
            break;

        case 1:
            $title = tts_t['one_comment'];

            break;

        default:
            $title = "$num ".tts_t['comments'];
            break;
    }
    return $title;
}


function commentDOM()
{
    $html = '<div class="flex flex-col gap-3 border-b border-gray-100 py-2 ">
    <label class="flex gap-3">
        <img src="@picture" alt="Avatar" class="w-8 h-8 rounded-full">
    
        <div class="flex flex-col gap-3">
            <label class="flex w-full gap-6">
                <span class="font-semibold text-sm dark:text-gray-100">@name</span>
                <span class="text-xs text-gray-500">24/10/2023</span>
            </label>
    
            <span class="w-auto word-wrap text-sm text-gray-600 dark:text-gray-400">
                @text
            </span>
            <label class="font-semibold text-xs hover:pointer w-12" onclick="reply(@id,\'@name\')">
            '.tts_t['reply'].'
            </label>
    
            <label class="ml-4 flex-col gap-3">
                @sons
            </label>
    
        </div>
    </label>
    </div>';


    return $html;
}

function replyDOM()
{

    $html = '<div class="flex  flex-col gap-3 border-t border-gray-100 py-2">
        <label class="flex gap-3">
            <img src="@picture" alt="Avatar" class="w-8 h-8 rounded-full">
    
            <div class="flex flex-col gap-3">
                <label class="flex w-full gap-6">
                    <span class="font-semibold text-sm dark:text-gray-100">@name</span>
                    <span class="text-xs text-gray-500">@date</span>
                </label>
    
                <span class="w-auto word-wrap text-sm text-gray-600 dark:text-gray-400 mr-6">
                    @text
                </span>
                <label class="font-semibold text-xs hover:pointer w-12" onclick="reply(@parentId,\'@name\')">
                    '.tts_t['reply'].'
                </label>
            </div>
        </label>
    </div>
    ';

    return $html;
}

function getSons($comment_id){
    $response = [];
    $reply = comment::select("parent_id='$comment_id'  AND status='1'",'id ASC',null);
    if($reply){
        foreach($reply as $r){
            $picture = user::getAvatar($r->user_id);
            $date = (new DateTime("$r->comment_date"))->format(leemclasses::option('date_format')." ".leemclasses::option('time_format'));
            $response[] = str_replace(['@parentId','@name','@date','@text','@picture'],["$comment_id","$r->author_name","$date","$r->comment","$picture"],replyDOM());
        }
    }

    return implode("\n",$response);
}


function getComments($post_id)
{
    $comments_list = [];
    $comments = comment::select("post_id='$post_id' AND parent_id= '0' AND status='1'",'id ASC',null);
    if($comments){
        foreach($comments as $comment){
            $sons = getSons($comment->id);
            $picture = user::getAvatar($comment->user_id);
            $date = (new DateTime("$comment->comment_date"))->format(leemclasses::option('date_format')." ".leemclasses::option('time_format'));
            $comments_list[] = str_replace(['@id','@name','@date','@text','@sons','@picture'],["$comment->id","$comment->author_name","$date","$comment->comment","$sons","$picture"],commentDOM());
        }
    }

    return implode("\n",$comments_list);

}


