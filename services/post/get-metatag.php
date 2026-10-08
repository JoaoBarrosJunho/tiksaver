<?php
use App\classes\metatags;


$success = false;
                $message = '';
                $name = '';
                $slug = '';
                $id = isset($data['metatag']) && is_numeric($data['metatag']) ? $data['metatag'] : null;
                
                if($id){
                    $searchMetaTag = metatags::selectMetaTags("id='$id'");
                    if($searchMetaTag){
                        $success = true;
                        $result = $searchMetaTag[0];
                        $name = $result->name;
                        $slug = $result->slug;
                        $message = '';
                    }else{
                        $message = 'MetaTag does not exist!';
                    }
                }else{
                    $message = 'Insert a valid MetaTag!';
                }

                $response = ['success'=> $success, 'message'=>$message, 'name'=>$name, 'slug'=>$slug];
