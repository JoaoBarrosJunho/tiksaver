<?php

use App\classes\leemclasses;
use App\classes\metatags;


$success = false;
                $message = '';
                $name = isset($data['nameMetaTag']) ? $data['nameMetaTag']:'';
                $slug = isset($data['slugMetaTag']) ? $data['slugMetaTag'] : '';
                $id = isset($data['idMetaTag']) && is_numeric($data['idMetaTag']) ? $data['idMetaTag']:null;

                if($id){
                    $checkMeta = metatags::selectMetaTags("id='$id'");
                    if($checkMeta){
                        if(!empty($name) && !empty($slug)){
                            $type = $checkMeta[0]->type;
                            $slug = $slug != $checkMeta[0]->slug ? leemclasses::genUnicSlug($name,$slug,'metatags','slug',"type = '$type'") : $slug;

                            $update = metatags::updateMetaTags(['name'=>"$name",'slug'=>"$slug"],"id='$id'");
                            if($update){
                                $success = true;
                                $message = 'Action has been succedded!';
                            }else{
                                $message = 'Error to execut this action';
                            }

                        }else{
                            $message = 'Insert all data!';
                        }

                    }else{
                        $message = 'Invalid data';
                    }
                }else{  
                    $message = 'Invalid data';
                }

                $response = ['success'=>$success, 'message'=>$message,'name'=>$name,'slug'=>$slug];