<?php
use App\classes\comment;
use App\classes\leemclasses;


$success = false;
$message = '';
$option = isset($data['option'])?$data['option']:null;
$id = isset($data['comment_id']) && is_numeric($data['comment_id'])?$data['comment_id']:0;
switch($option){
    case 'approve':
    leemclasses::apiAccessBlock(1);
    $execute = comment::approve($id);

    if($execute){
        $success = true;
        $message = 'Action has been succeed!';
    }else{
        $message = 'Error executing this action!';
    }
    
    break;
    case 'delete':
    leemclasses::apiAccessBlock(0);
    $execute =  comment::reject($id);

    if($execute){
        $success = true;
        $message = 'Action has been succeed!';
    }else{
        $message = 'Error executing this action!';
    }
        break;
    case 'occult':
    $execute =  comment::occult($id);
    if($execute){
        $success = true;
        $message = 'Action has been succeed!';
    }else{
        $message = 'Error executing this action!';
    }
    break;

    case 'approveAll':
        $execute =  comment::approveAll();
        if($execute){
            $success = true;
            $message = 'Action has been succeed!';
        }else{
            $message = 'Error executing this action!';
        }
    break;
    default:
    $message = 'Not found!';
    break;
}

$response = ['success'=>$success,'message'=>"$message"];