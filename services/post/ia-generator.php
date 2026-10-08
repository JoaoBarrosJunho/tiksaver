<?php
use App\api\openai_classes;
use App\classes\contentwritter;
use App\classes\leemclasses;
use App\classes\postmeta;

$success=false;
$message = '';
$data_response = [];
$options = isset($data['options'])? (array)json_decode($data['options']):[];
$content_options = isset($data['content_options'])?(array)json_decode($data['content_options']):[];
$contentW = new contentwritter($content_options);

switch($options['action']){
 
    case 'gen-content':
        $content = $contentW->generate();

        if($content['success']){
            $data_response = $content['data'];
            $success = true;
            $message = $content['message'];
        }else{
            $message = $content['message'];
        }
        break;
        case 'get-sugestion':
            if(!isset($content_options['title'])){
                $message = 'Set a title for this content!';
            }else{
            
                $content = $contentW->generate();

                if($content['success']){
                    $data_response = $content['data'];
                    $success = true;
                    $message = $content['message'];
                }else{
                    $message = $content['message'];
                   }
            }

            
        break;
        case 'gen-image':
            $prompt = isset($data['prompt']) && !empty($data['prompt'])? $data['prompt']:null;
            if($prompt){
                $gpt = new openai_classes();
                $content = $gpt->getImage($prompt,$options);
                if($content['success']){
                    $data_response = $content['data'];
                    $success = true;
                    $message = $content['message'];

                }else{
                    $message = $content['message'];
                }


            }else{
                $message = 'I need more details about how you want the image!';
            }

        break;


        case 'auto-editor':
                $new_content = $contentW->postContent();
                $success = $new_content['success'];
                $message = $new_content['message'];
                $data_response = $new_content['data'];
        break;

        default:
        $message = 'Undefined!';
        break;

    
}

 $response = ['success'=>$success,'message'=>$message,'data'=>$data_response];



