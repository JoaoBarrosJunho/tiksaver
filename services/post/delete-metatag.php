<?php

use App\classes\metatags;
use App\classes\postmeta;


$type = isset($data['type']) && !empty($data['type']) ? $data['type']:'';
                $id = isset($data['metatag']) && is_numeric($data['metatag'])? $data['metatag']:-1;
                $message = '';
                $success = false;
                $searchTag = metatags::selectMetaTags("id='$id'");

                if($searchTag){
                    $deleteTag = metatags::deleteMetaTags("id='$id'");
                    if($deleteTag){
                        $success = true;
                        $message = "$type has been delected!";

                        switch($type){
                            case 'Category':
                                $deletePostMeta = postmeta::deletePostMeta("meta_key='post_category' AND meta_value='$id'");
                                if(!$deletePostMeta){
                                    $postMetaMessage="Error to delete postmeta with this $type";
                                    $message .= " ".$postMetaMessage;
                                }
                            break;
                            case 'Tag':
                                $deletePostMeta = postmeta::deletePostMeta("meta_key='post_tag' AND meta_value='$id'");
                                if(!$deletePostMeta){
                                    $postMetaMessage="Error to delete postmeta with this $type";
                                    $message .= " ".$postMetaMessage;
                                }
                            break;
                            default:
                            break;
                        }

                    }else{
                        $success = false;
                        $message = "Erro to delete $type!";
                    }

                }else{
                    $success = false;
                    $message = "$type does not exist!";
                }

                $response= ['success'=>$success,'message'=>"$message",'metatag'=>$id];