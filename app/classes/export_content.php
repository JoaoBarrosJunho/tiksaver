<?php
namespace App\classes;

use App\login\user;
use DateTime;

class export_content{


    protected $datei;
    protected $datef;
    protected $status;
    protected $type;

    public function __construct($type='all',$status = null,$initial_date=null,$final_date=null)
    {
        $this->datei = $initial_date?(new DateTime($initial_date))->format("Y-m-d H:i:s"):null;
        $this->datef = $final_date?(new DateTime($final_date))->format("Y-m-d H:i:s"):null;
        $this->status = $status;
        $this->type = $type;
    }


    public function getContents(){
        $type = $this->type!='all'?" AND post_type='$this->type' ":'';
        $status = $this->status? " AND post_visibility='$this->status' ":'';
        
        $date = $this->getDateFilter();
        $where = "id>0 $type $status $date";

        $posts = post::selectPost($where,null,"id ASC");
        return ["lenght"=>count($posts),"items"=>$posts];

    }

    public function getDateFilter(){
        if($this->datei && $this->datef){
            return " AND post_date BETWEEN '$this->datei' AND '$this->datef'";
        }else if($this->datei){
            return "AND post_date >= '$this->datei'";
        }else if($this->datef){
            return "AND post_date <= '$this->datef'";
        }

        return '';
    }


    public function gen(){
        $posts = $this->getContents();
        $results = [];
        foreach($posts['items'] as $item){
            if($item->post_type=='article'){
                $results['articles'][] = $this->formatArticle($item);
                
            }
            if($item->post_type=='attachment'){
                $results['attachments'][] = $this->formatAttachment($item);
                
            }
            if($item->post_type=='page'){
                $results['pages'][] = $this->formatPage($item);
                
            }
        }

        $data = ["name"=>"GeniusBlog/Import file",
                        "AppVersion"=>V_,
                        "generated"=>(new DateTime("now"))->format("Y-m-d H:i:s"),
                        "blog"=>leemclasses::option('site_title'),
                        "description"=>leemclasses::option("site_description"),
                        "url"=>URI_NAME,
                        "posts"=>$results];

                        return json_encode($data);
    }


    public function formatArticle($item){
        $category = postmeta::selectPostMeta("post_id=$item->id AND meta_key='post_category'")[0]->meta_value??null;
        $category_string = $category?metatags::selectMetaTags("id=$category")[0]->name:null;
        return ['title'=>htmlentities($item->post_title),
            'published'=>$item->post_date,
            'updated'=>$item->post_date_update,
            'author'=>user::getData("id=$item->post_author")[0]->name??'undefined',
            'thumb'=>postmeta::selectPostMeta("post_id=$item->id AND meta_key='featured_img'")[0]->meta_value??null,
            'category'=>$category_string,
            'content'=>htmlentities($item->post_content)];
    }

    public function formatPage($item){
       
        return ['title'=>htmlentities($item->post_title),
            'published'=>$item->post_date,
            'updated'=>$item->post_date_update,
            'author'=>user::getData("id=$item->post_author")[0]->name??'undefined',
            'content'=>htmlentities($item->post_content)];
    }

    public function formatAttachment($item){
       
        return ['title'=>$item->post_title,
            'published'=>$item->post_date,
            'updated'=>$item->post_date_update,
            'author'=>user::getData("id=$item->post_author")[0]->name??'undefined',
            "att_type"=>$item->post_att_type,
            "guid"=>$item->post_guid
        ];
    }


}