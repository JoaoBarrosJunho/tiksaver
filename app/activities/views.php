<?php

namespace App\activities;

use App\classes\leemclasses;
use App\classes\postmeta;
use Exception;

class views
{


    public static function Add($id)
    {
        try {
            metrics::insert($id);
            $viewsCount = metrics::select("post_id='$id'", null, null, "COUNT(id) AS TotalPostViews");
            $TotalViews = $viewsCount[0]->TotalPostViews ? $viewsCount[0]->TotalPostViews : 0;

            if (postmeta::selectPostMeta("post_id='$id' AND meta_key='post_views'")) {
                postmeta::updatePostMeta(["meta_value" => "$TotalViews"], "post_id='$id' AND meta_key='post_views'");
            } else {
                postmeta::addPostMeta($id, 'post_views', "$TotalViews");
            }
            return true;
        } catch (Exception $e) {
            leemclasses::newLog("ERROR: (ADD VIEWS) " . $e->getMessage());
            return false;
        }
    }

    /**
     * Return the number of unique post views
     * @param int $id Post_Id
     * @return int
     */
    public static function get($id){
        $data = postmeta::selectPostMeta("post_id='$id' AND meta_key='post_views'",'meta_value');
        if($data){
            $response = $data[0]->meta_value;
        }else{
            $response = 0;
        }
        return $response;
    }
}
