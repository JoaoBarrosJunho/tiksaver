<?php

namespace App\classes;
use App\db\database;
use PDO;

class metatags{


/**META TAGS DATABASE STRINGS**/

public static function addMetaTags($name,$type,$slugNew = null){
$slug = $slugNew != null && !empty($slugNew)? $slugNew : urilize::text($name);
$result = self::selectMetaTags("slug ='$slug' AND type='$type'",'id');
if(!$result){
    return (new database('metatags'))->insert(['name'=>"$name",'slug'=>"$slug",'type'=>"$type"]);
}else{
    return $result[0]->id;
}

}

public static function selectMetaTags($WHERE=null, $fields = '*',$order=null,$limit=null){
$response = (new database('metatags'))->select($WHERE,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS);
return $response;
}

public static function updateMetaTags($VALUES, $WHERE){
    return (new database('metatags'))->update($VALUES,$WHERE);
}

public static function deleteMetaTags($WHERE){
    if((new database('metatags'))->delete($WHERE)){
        return true;
    }
    return false;
}
/**META TAGS DATABASE STRINGS**/

public static function getMetatagGuid($slug,$type){
    $type = $type=='category'?CATEGORY_SLUG:TAG_SLUG;
    $guid = URI_NAME."/$type/$slug";
    return $guid;
}

public static function getPostsByTag($tagId,$order=null,$limit=null,$fields = '*',$postVisibility = 'public'){
$data = post::selectPostInnerMeta("meta_key='post_tag' AND meta_value = '$tagId' AND post_type='article' AND post_visibility='$postVisibility'",$order,$limit,$fields);
return $data;
}

public static function getPostsByCategory($tagId,$order=null,$limit=null,$fields = '*',$postVisibility = 'public'){
    $data = post::selectPostInnerMeta("meta_key='post_category' AND meta_value = '$tagId'  AND post_type='article' AND post_visibility='$postVisibility'",$order,$limit,$fields);
    return $data;
    }

public static function getPostPopular($where=null,$limit = 4){
    $PopularPosts = (new database('postmetrics'))->selectINNERJOIN($where," posts ON postmetrics.post_id = posts.id GROUP BY  post_id HAVING post_type='article'","TotalViews DESC",$limit." OFFSET 0"," post_id,post_title,post_date,post_guid,post_type,COUNT(*) AS TotalViews ")->fetchAll(PDO::FETCH_CLASS);
    return $PopularPosts;
}
}