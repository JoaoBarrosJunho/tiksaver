<?php

use App\classes\widget;



$success = false;
$message = '';
$dataResponse = '';
$action = '';

$parent = isset($data['parent'])?$data['parent']:' ';
$title = isset($data['gadget']['gadget_title'])?$data['gadget']['gadget_title']:' ';
$widgetContent = isset($data['gadget'])? json_encode($data['gadget']):' ';
$widget_item_id = isset($data['widget_item_id']) && is_numeric($data['widget_item_id'])? $data['widget_item_id']:null;

if(!$widget_item_id){
    //CREAT A NEW WIDGET ITEM
$insertWidget = (new widget())->insertWidget($title,$widgetContent,'widget_item',$parent);
if($insertWidget){
    $searchParent = (new widget())->selectWidget("id='$parent'");
    
    if($searchParent){

        
        $parentContent = !empty($searchParent[0]->widget_content) && $searchParent[0]->widget_content != ' '?json_decode($searchParent[0]->widget_content):[];
        $parentContent[] = $insertWidget;
        $finalContent = json_encode($parentContent);
        $updateParent = (new widget())->updateWidget(['widget_content'=>"$finalContent"],"id='$parent'");

        if($updateParent){
            $success = true;
            $message = 'New item has been added!';
            $dataResponse = widget::creatItem($title,$insertWidget);
            $action = 'add';
        }else{
            $message = 'Error joining widget item and parent widget!';
        }

        
    }else{
        $message = 'Parent widget does not exist!';
    }
}else{
    $message = 'Error adding new widget item!';
}
//CREAT A NEW WIDGET ITEM
}else{
//UPDATE WIDGET ITEM
$searchWidgetItem = (new widget())->selectWidget("id='$widget_item_id'");
if($searchWidgetItem){
    $updateWidgetItem = (new widget())->updateWidget(['widget_name'=>"$title",'widget_content'=>"$widgetContent"],"id='$widget_item_id'");
    if($updateWidgetItem){
        $success=true;
        $message = 'Widget has been updated!';
        $dataResponse = ['id'=>"$widget_item_id",'title'=>"$title"];
        $action = 'update';
    }else{
        $message = 'Error updating widget item!';
    }
}else{
    $message = 'Widget item does not exist!';
}

}


$response = ['success'=>$success,'message'=>"$message",'data'=>$dataResponse,'action'=>$action];