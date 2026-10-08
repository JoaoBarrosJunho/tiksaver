<?php
use App\classes\post;

$success = false;
                $message = '';
                $dataResponse = [];

                $id = isset($data['idAttachment']) && is_numeric($data['idAttachment'])?$data['idAttachment']:'';
                $title = isset($data['titleAttachment']) && !empty($data['titleAttachment']) ? $data['titleAttachment']:'';
                $description = isset($data['descriptionAttachment'])?$data['descriptionAttachment']:'';

                if($id && (new post())->selectPost("id='$id' AND post_type = 'attachment'")){
                    $update = (new post())->updatePost(['post_title'=>$title,'post_content'=>$description],"id='$id' AND post_type='attachment'");
                    if($update){
                        $success = true;
                        $message = 'Attachment has been updated!';
                        $dataResponse = ['title'=>$title];
                    }else{
                        $message = 'Error to update this attachment!';
                    }

                }else{
                    $message = 'Invalid attachemnt!';
                }

                $response = ['success'=>$success,'message'=>$message,'data'=>$dataResponse];