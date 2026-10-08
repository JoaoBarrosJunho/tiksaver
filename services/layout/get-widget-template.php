<?php

use App\classes\gadget;
use App\classes\widget;


$success = false;
$widget_item_id = isset($data['gadget_id']) && is_numeric($data['gadget_id'])?$data['gadget_id']:null;
$message = '';
$dataResponse = '';

$option = isset($data['option']) && is_numeric($data['option'])?$data['option']:'';
if(!$widget_item_id){
    $template = gadget::newGadget(['option'=>$option]);
}else{
    //GET DATA OF EXISTENT WIDGET ITEM
    $searchWidgetItem = (new widget())->selectWidget("id='$widget_item_id'");
    if($searchWidgetItem){
        $WidgetContent =  $searchWidgetItem[0]->widget_content != ' ' && !empty($searchWidgetItem[0]->widget_content) ?(array) json_decode($searchWidgetItem[0]->widget_content): [];
        $WidgetContent['option'] = isset($WidgetContent['gadget_type']) ? $WidgetContent['gadget_type']:'';
        $WidgetContent['widget_item_id'] = $widget_item_id;
        $template = gadget::newGadget($WidgetContent);
    }else{
        $template = ['success'=>false] ;
    }

}
    
    
if($template['success']){
    $success = true;
    $message = 'Model has been sended!';
    $dataResponse = $template['data'];
}else{
    $message = 'Error getting model...';
}

    $response = ['success'=>$success,'message'=>"$message",'data'=>$dataResponse];