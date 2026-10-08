<?php
namespace App\classes;

use App\http\method_checker;
use App\login\user;

class routes{

public static function pages(){

    $pages=[];
    $pages['public']=['view'=>'public.php','autorization'=>2,'pagename'=>'','header'=>false,'footer'=>false];
    $pages['login']=['view'=>'admin/login.php','autorization'=>2,'pagename'=>tts['sign_in'],'header'=>false,'footer'=>false];
    $pages['logout']=['view'=>'admin/logout.php','autorization'=>2,'pagename'=>'Log out','header'=>false,'footer'=>false];
    #$pages['signup']=['view'=>'admin/signup.php','autorization'=>2,'pagename'=>tts['sign_up'],'header'=>false,'footer'=>false];
    $pages['checkpoint']=['view'=>'admin/checkpoint.php','autorization'=>2,'pagename'=>'Checkpoint','header'=>false,'footer'=>false];
    $pages['recovery']=['view'=>'admin/recovery.php','autorization'=>2,'pagename'=>'Reset Password','header'=>false,'footer'=>false];
    $pages['panel']=['view'=>'admin/template/index.php','autorization'=>2,'pagename'=>'','header'=>false,'footer'=>true];
    $pages['robots.txt']=['view'=>'robots.php','autorization'=>2,'pagename'=>'Robots.txt','header'=>false,'footer'=>false];
    $pages['api']=['view'=>SITE_ROOT."/services/api.php",'autorization'=>2,'pagename'=>'api','header'=>false,'footer'=>false];
    $pages['rss']=['view'=>"rss.php",'autorization'=>2,'pagename'=>leemclasses::option('site_title').' - RSS Items','header'=>false,'footer'=>false];
    
    $pages['download']=['view'=>"download.php",'autorization'=>2,'pagename'=>'Download','header'=>false,'footer'=>false];
    
    $pages['api/retrieve']=['view'=>"api.php",'autorization'=>2,'pagename'=>'Api','header'=>false,'footer'=>false];
    
    
   
    
    if(!isset($_GET['p'])){
        return $pages['public'];
    }

    return in_array($_GET['p'],array_keys($pages))?$pages[$_GET['p']]:$pages['public']; 
}


public static function panel(){
    $pages=[];
    $pages['dashboard']=['view'=>'pages/dashboard.php','autorization'=>1,'pagename'=>tts['dashboard'],'nav'=>true,'method'=>'get'];
    $pages['download-logs']=['view'=>'pages/download-logs.php','autorization'=>1,'pagename'=>tts['download_logs'],'nav'=>true,'method'=>'get'];
    
    $pages['404']=['view'=>'404.php','autorization'=>1,'pagename'=>tts['page_not_found'],'nav'=>true,'method'=>'get'];
    $pages['accounts']=['view'=>'pages/accounts.php','autorization'=>1,'pagename'=>tts['accounts'],'nav'=>true,'method'=>'get'];
    #$pages['comments']=['view'=>'pages/comments.php','autorization'=>1,'pagename'=>tts['comments'],'nav'=>true,'method'=>'get'];
    $pages['general-settings']=['view'=>'pages/general-settings.php','autorization'=>0,'pagename'=>tts['general_settings'],'nav'=>true,'method'=>'all'];
    $pages['integrations']=['view'=>'pages/integrations.php','autorization'=>0,'pagename'=>tts['integrations'],'nav'=>true,'method'=>'all'];
    $pages['theme-options']=['view'=>'pages/theme-options.php','autorization'=>0,'pagename'=>tts['theme_options'],'nav'=>true,'method'=>'all'];
    $pages['restore-theme']=['view'=>'pages/restore-theme.php','autorization'=>0,'pagename'=>'Restore Theme','nav'=>false,'method'=>'get'];
    $pages['testmail']=['view'=>'pages/testmail.php','autorization'=>0,'pagename'=>'Test SMTP','nav'=>true,'method'=>'post'];
    $pages['profile']=['view'=>'pages/profile.php','autorization'=>2,'pagename'=>tts['profile'],'nav'=>true,'method'=>'all'];
    $pages['stats']=['view'=>'pages/stats.php','autorization'=>0,'pagename'=>tts['stats'],'nav'=>true,'method'=>'get'];
    #$pages['select-template']=['view'=>'pages/select-template.php','autorization'=>0,'pagename'=>tts['template'],'nav'=>true,'method'=>'all'];
    $pages['new-page']=['view'=>'pages/new-page.php','autorization'=>1,'pagename'=>tts['new_page'],'nav'=>true,'method'=>'get'];
    $pages['pages']=['view'=>'pages/pages.php','autorization'=>1,'pagename'=>tts['pages'],'nav'=>true,'method'=>'get'];
    #$pages['layout']=['view'=>'pages/layout.php','autorization'=>0,'pagename'=>tts['layout'],'nav'=>true,'method'=>'get'];
    $pages['menu-settings']=['view'=>'pages/menu-settings.php','autorization'=>0,'pagename'=>tts['menu_settings'],'nav'=>true,'method'=>'all'];
    $pages['updates']=['view'=>'pages/updates.php','autorization'=>0,'pagename'=>tts['updates'],'nav'=>true,'method'=>'get'];
    $pages['logs']=['view'=>'pages/logs.php','autorization'=>0,'pagename'=>'Logs','nav'=>true,'method'=>'get'];
    $pages['attachments']=['view'=>'pages/attachments.php','autorization'=>1,'pagename'=>tts['attachments'],'nav'=>true,'method'=>'get'];
    $pages['new-post']=['view'=>'pages/add-new-post.php','autorization'=>1,'pagename'=>tts['new'],'nav'=>true,'method'=>'get'];
    $pages['blogs']=['view'=>'pages/all-posts.php','autorization'=>1,'pagename'=>tts['all_posts'],'nav'=>true,'method'=>'get'];
    $pages['api-keys'] = ['view' => 'pages/api-keys.php', 'autorization' => 1, 'pagename' => 'API Keys', 'nav' => true,'method'=>'get'];

    if(!isset($_GET['zone'])){
        $myRoute = user::logged('type')<2? $pages['dashboard']:$pages['profile'];
       return method_checker::check($myRoute);
    } 

    $myRoute = in_array($_GET['zone'],array_keys($pages))?$pages[$_GET['zone']]:$pages['404']; 
    return method_checker::check($myRoute);
}



public static function api(){
    
    $pages=[];
    $pages['404']=['view'=>'404.php','autorization'=>null];
    $pages['addUser']=['view'=>'auth/add-user.php','autorization'=>0];
    #$pages['signup']=['view'=>'auth/signup.php','autorization'=>null];
    $pages['text-prepare']=['view'=>'data/text-prepare.php','autorization'=>null];
    $pages['delete-user']=['view'=>'auth/delete-user.php','autorization'=>0];
    $pages['block-user']=['view'=>'auth/block-user.php','autorization'=>0];
    $pages['get-u-data']=['view'=>'auth/get-user-data.php','autorization'=>0];
    $pages['checkpoint']=['view'=>'auth/checkpoint.php','autorization'=>null];
    $pages['resend-code']=['view'=>'auth/resend-code.php','autorization'=>null];
    $pages['recover']=['view'=>'auth/recover.php','autorization'=>null];
    $pages['reset-password']=['view'=>'auth/reset-password.php','autorization'=>null];
    $pages['post-attachment']=['view'=>'post/post-attachment.php','autorization'=>1];
    $pages['upload-image']=['view'=>'post/upload-image.php','autorization'=>1];
    $pages['get-attachment']=['view'=>'post/get-attachment.php','autorization'=>1];
    $pages['post-article']=['view'=>'post/post-article.php','autorization'=>1];
    
    $pages['addCategory']=['view'=>'post/add-category.php','autorization'=>1];

    $pages['delete-post']=['view'=>'post/delete-post.php','autorization'=>0];
    $pages['delete-metatag']=['view'=>'post/delete-metatag.php','autorization'=>0];
    $pages['get-mettag']=['view'=>'post/get-metatag.php','autorization'=>1];
    $pages['edit-metatag']=['view'=>'post/edit-metatag.php','autorization'=>1];
    $pages['add-metatag']=['view'=>'post/add-metatag.php','autorization'=>1];
    $pages['post-page']=['view'=>'post/post-page.php','autorization'=>1];
    $pages['get-attachmentInfo']=['view'=>'post/get-attachmentInfo.php','autorization'=>1];
    $pages['update-attachment']=['view'=>'post/update-attachment.php','autorization'=>1];
    #$pages['comment']=['view'=>'comment/manage-comments.php','autorization'=>1];
    $pages['move-image']=['view'=>'data/move-image.php','autorization'=>1];
    #$pages['save-all-widgets']=['view'=>'layout/save-all-widgets.php','autorization'=>0];
    #$pages['delete-widget']=['view'=>'layout/delete-widget.php','autorization'=>0];
    #$pages['add-new-widget']=['view'=>'layout/add-new-widget.php','autorization'=>0];
    $pages['close-flash']=['view'=>'layout/close-flash.php','autorization'=>0];
    #$pages['get-widget-template']=['view'=>'layout/get-widget-template.php','autorization'=>0];
    $pages['video-logs']=['view'=>'video-logs/management.php','autorization'=>1];
    $pages['theme']=['view'=>'theme/management.php','autorization'=>0];

    $pages['apikey'] = ['view' => 'apikey/apikey.php', 'autorization' => 1];
    
    if(!isset($_POST['action'])){
        return $pages['404'];
    }

    return in_array($_POST['action'],array_keys($pages))?$pages[$_POST['action']]:$pages['404']; 
}

}