<?php
use App\classes\post;

$page = isset($data['page']) && is_numeric($data['page'])?$data['page']:1;
$WHERE = isset($data['where'])?$data['where']:null;
$FIELDS = isset($data['fields'])?$data['fields']:'post_title,post_guid,post_att_type';
$ORDER = isset($data['order'])?$data['order']:'id DESC';
$LIMIT = isset($data['limit']) && is_numeric($data['limit'])?$data['limit']:15;

$attachments= post::getAttachemnt($page,$WHERE,$FIELDS,$LIMIT,$ORDER);

if(is_array($attachments)){
    $att = json_encode($attachments);
    $response = ['success'=>true,'message'=>'Action has been succedded','data'=>$att];
}else{
    $att = null;
    $response = ['success'=>false,'message'=>'Error to get attachemts','data'=>$att];
}

