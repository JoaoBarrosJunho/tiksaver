<?php
 namespace App\classes;

use App\login\user;

 class notification{

    public static function newcomments(){
        return comment::count('status=0');
    }

    public static function newposts(){
        $posts = post::selectPost('post_type="article" AND post_visibility="Unlisted"',null,null,'COUNT(id) as Total_posts');
        return $posts[0]->Total_posts;
    }

    public static function pendingUsers(){
        $users = user::getData('status=2',null,null,'COUNT(id) as Total_users');
        return $users[0]->Total_users;
    }

    public static function count($for = 0){

        $total = $for==0?(self::newcomments() + self::newposts() + self::pendingUsers()):(self::newcomments() + self::newposts());
        return $total;
    }

    public static function getBadget($for = 0){
        $html = '<span aria-hidden="true" class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full dark:border-gray-800"></span>';
        return self::count($for)>0?$html:null;
    }

    public static function getResult(){
            $count = [self::newcomments(),self::newposts(),self::pendingUsers()];
            $comments =  $count[0]? '<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">'.$count[0].'</span>':null;
            $posts = $count[1]? '<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">'.$count[1].'</span>':null;
            $users = $count[2]? '<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">'.$count[2].'</span>':null;
            return ['comments'=>"$comments",'posts'=>"$posts",'users'=>"$users"];
    }


 }