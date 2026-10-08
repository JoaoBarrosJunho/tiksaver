<?php
namespace App\classes;

use App\db\database;
use Exception;
use PDO;

class postmeta{


    /**META TAGS DATABASE STRINGS**/

    public static function addPostMeta($postid,$metakey,$metavalue){
  
        return (new database('postmeta'))->insert(['post_id'=>"$postid",'meta_key'=>"$metakey",'meta_value'=>"$metavalue"]);
   
    }
    
    public static function selectPostMeta($WHERE, $fields = '*'){
    $response = (new database('postmeta'))->select($WHERE,null,null,$fields)->fetchAll(PDO::FETCH_CLASS);
    return $response;
    }
    
    public static function updatePostMeta($VALUES, $WHERE){
        return (new database('postmeta'))->update($VALUES,$WHERE);
    }
    
    public static function deletePostMeta($WHERE){
        if((new database('postmeta'))->delete($WHERE)){
            return true;
        }
        return false;
    }
    /**META TAGS DATABASE STRINGS**/

    /**
     * Metodo responsavel por inserir novos metadados de postagens no banco de dados
     * @param int $postId
     * @param string $FeaturedValue
     * @return bool
     */
    public static function setFeaturedImage($postId,$FeaturedValue){
        $metakey = 'featured_img';
        if($FeaturedValue!=null && !empty($FeaturedValue)){
            
        try{
        $featuredSearch = self::selectPostMeta("post_id='$postId' AND meta_key = '$metakey'");
        if($featuredSearch){
            $metakeyID = $featuredSearch[0]->id;
            self::updatePostMeta(['meta_value'=>$FeaturedValue],"id = '$metakeyID'");
        }else{
            self::addPostMeta($postId,$metakey,$FeaturedValue);
        }
    
        return true;
        }catch(Exception $e){
            return false;
        }

        }else{
            $featuredSearch = self::selectPostMeta("post_id='$postId' AND meta_key = '$metakey'");
            if($featuredSearch){
                $metakeyID = $featuredSearch[0]->id;
                self::deletePostMeta("id = '$metakeyID'");
                return true;
            }
        }
    }

    /**
     * Metodo responsavel por inserir novos metadados de postagens no banco de dados
     * @param int $postId
     * @param array $CategoryValue
     * @return bool
     */
    public static function setPostCategory($postId,array $categoryes){
        $metakey = 'post_category';

        /**Checa na tabela PostMeta se existe alguma categoria do post referenciado, 
         * remove todos que não constam no arraycategories enviado **/
        
        $searchAllCategory = self::selectPostMeta("post_id='$postId' AND meta_key='$metakey'");
        if($searchAllCategory && $categoryes){
        foreach($searchAllCategory as $catResult){
                if(!in_array($catResult->meta_value,$categoryes)){
                    self::deletePostMeta("id = $catResult->id");
                }
            }
        }

        try{
        
        if(!$categoryes){
            $categoryes[]=1;
        }

        foreach($categoryes as $key => $CategoryValue){
            if(!empty($CategoryValue)){
                $CategorySearch = self::selectPostMeta("post_id='$postId' AND meta_key = '$metakey' AND meta_value = '$CategoryValue'");
                if(!$CategorySearch){
                    self::addPostMeta($postId,$metakey,$CategoryValue);
                }
            }
        }
        return true;

    }catch(Exception $e){
        return false;
    }
    }


    /**
     * Metodo responsavel por inserir novos metadados de postagens no banco de dados
     * @param int $postId
     * @param array $CategoryValue
     * @return bool
     */
    public static function setPostTag($postId,$tags = []){
        $metakey = 'post_tag';
        $tagList = [];
       
        //Cria a tagList atraves dos valores retornados ao executar o metodo addMetaTags
        if($tags){
            foreach($tags as $key => $value){
                if(!empty($value)){
                    $tagList[] = metatags::addMetaTags($value,'tag');
                }
            }
        }

        /**Checa na tabela PostMeta se existe alguma categoria do post referenciado, 
         * remove todos que não constam no arraycategories enviado **/
        
        $searchAllTags = self::selectPostMeta("post_id='$postId' AND meta_key='$metakey'");
        if($searchAllTags){
        foreach($searchAllTags as $tagResult){
                if(!in_array($tagResult->meta_value,$tagList)){
                    self::deletePostMeta("id = $tagResult->id");
                }
            }
        }

        try{

        foreach($tagList as $key => $TagValue){
            if(!empty($TagValue)){
                $TagSearch = self::selectPostMeta("post_id='$postId' AND meta_key = '$metakey' AND meta_value = '$TagValue'");
                if(!$TagSearch){
                    self::addPostMeta($postId,$metakey,$TagValue);
                }
            }
        }
        
        return true;

    }catch(Exception $e){
        return false;
    }
    }


public static function AIchecker($post){
    $search = self::selectPostMeta("post_id=$post AND meta_key='ai_writter'");
    return $search?true:false;
}

}