<?php

use App\classes\widget;


$id = isset($data['widget_id']) && is_numeric($data['widget_id']) ? $data['widget_id']:" ";
$success = false;
$message = '';

if($id){
        $delete = (new widget())->deleteWidget("id='$id'");
        if($delete>0){
            $success = true;
            $message = 'Item has been deleted!';
        }else{
            $message = 'Error to delete this item!';
        }
}else{
    $message = 'Invalid item id';
}

$response = ['success'=>$success,'message'=>$message];