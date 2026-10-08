<?php

use App\activities\views;
use App\classes\metatags;
use App\classes\post;
use App\classes\postmeta;
use App\classes\leemclasses;


function postExist($slug){
$data = post::selectPost("post_slug = '$slug' ",null,null);
if($data){
    return ['success'=>true,'data'=>$data[0]];
}else{
    return ['success'=>false];
}
}


function featuredImage($id){
$featured = postmeta::selectPostMeta("post_id = '$id' AND meta_key = 'featured_img'");
    return $featured?$featured[0]->meta_value:THEME_URI.'/assets/media/noimage.png';
}

function ArticlefeaturedImage($id){
    $featured = postmeta::selectPostMeta("post_id = '$id' AND meta_key = 'featured_img'");
        return $featured?$featured[0]->meta_value:null;
    }

function categories($id){
    $categories = [];
    $post_categories = postmeta::selectPostMeta("post_id='$id' AND meta_key='post_category'");
    if($post_categories){
        foreach($post_categories as $c){
            $cat_result = metatags::selectMetaTags("id='$c->meta_value' AND type='category'");
            if($cat_result){
                $categories[] = $cat_result[0]->name.'@:'.$cat_result[0]->slug;
            }
        }
    }

    return $categories;
}

function tags($id){
    $tags = [];
    $post_categories = postmeta::selectPostMeta("post_id='$id' AND meta_key='post_tag'");
    if($post_categories){
        foreach($post_categories as $c){
            $cat_result = metatags::selectMetaTags("id='$c->meta_value' AND type='tag'");
            if($cat_result){
                $tags[] = $cat_result[0]->name.'@:'.$cat_result[0]->slug;
            }
        }
    }

    return $tags;
}

function getCategories($id,$icon = '',$class = 'flex items-center text-sm uppercase font-semibold meta-styling dark:text-gray-200 hover:text-gray-500'){
    $data = '';
    $categories = categories($id);
    if($categories){
        foreach($categories as $c){
            $item = explode('@:',$c);
            $data.= ' <a href="'.URI_NAME.'/'.CATEGORY_SLUG.'/'.$item[1].'" class="'.$class.'">'.$icon.$item[0].'</a>';
        }
    }
    return $data;
}

function getTags($id,$separator = " ",$class = 'font-semibold text-purple-600 dark:text-purple-300',$icon='#'){
    $data = [];
    $tags = tags($id);
    if($tags){
        foreach($tags as $c){
            $item = explode('@:',$c);
            $data[] = '<button title="Tag: '.$icon.$item[0].'" class="'.$class.'" > '.$icon.$item[0].'</button>';
        }
    }
    return $data ? implode(" $separator",$data):'';
}


function getArticles($where = null, $order=null,$limit=null,$fields='*'){
    $ORDER = $order ? $order:'id DESC';
    $WHERE = $where?"AND $where":' ';

    $articles = post::selectPost("post_type='article' AND post_visibility = 'public' $WHERE",$limit,$ORDER,$fields);
    return $articles;

}

function getArticlesByCategory($category,$where = null, $order=null,$limit=null){
    $ORDER = $order ? $order:'id DESC';
    $WHERE = $where?"AND $where":' ';
    $articles = post::selectPostsByCategory($category,"post_type='article' AND post_visibility = 'public' $WHERE",$ORDER,$limit,"posts.id as id,post_title,post_guid,post_date,post_content,post_status,post_visibility,post_type");
    return $articles;
}

function postsByCategory($category_id,$order = null,$limit = null,$fields = '*',$posts_visibility = 'public'){
    return metatags::getPostsByCategory($category_id,$order,$limit,$fields,$posts_visibility);
}

function postsByTag($tag_id,$order = null,$limit = null,$fields = '*',$posts_visibility = 'public'){
    return metatags::getPostsByTag($tag_id,$order,$limit,$fields,$posts_visibility);
}

function getPagesNum($table,$num_posts,$where){
    return (new leemclasses())->pagination("$table",$num_posts,$where);
}

function calcPageNum($articles_num,$limit){
    return (new leemclasses())->Calc_pagination($articles_num,$limit);
}

function getAutorName($id){
    return leemclasses::getAuthorName($id);
}

function addView($id){
    views::Add($id);
}

function getViews($id){
    return views::get($id);
}

function getMeta($where = null,$order =null, $limit = null,$fields = '*'){
    
    $response = metatags::selectMetaTags($where,$fields,$order,$limit);
    return $response;

}


