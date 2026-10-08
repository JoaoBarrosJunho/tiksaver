<?php

use App\activities\activity;
use App\classes\post;
use App\classes\postmeta;
use App\login\user;

$id = isset($data['post']) && is_numeric($data['post'])? $data['post']:-1;

                $searchPost = post::selectPost("id='$id'");
                if($searchPost){
                    if($searchPost[0]->post_type == 'attachment'){
                    //IS  ATTACHMENT
                        $unlink = post::deleteAttachment($id);
                        if($unlink['success']){
                            $deletePostMeta = postmeta::deletePostMeta("post_id='$id'");
                        }
                        $response = ['success'=>$unlink['success'],'message'=>$unlink['message'],'post'=>$id];
                        activity::insert('Post Management',user::logged('name')." deleted  ".$searchPost[0]->post_title,user::logged('id'));
                    }else{

                    //IS NOT ATTACHMENT
                    $delete = post::deletePost("id='$id'");
                    if($delete){
                        $deletePostMeta = postmeta::deletePostMeta("post_id='$id'");
                        if(!$deletePostMeta){
                            $metamessage = 'Internal error to delete post metatags';
                        }else{
                            $metamessage ='';
                        }
                        $response = ['success'=>true,'message'=>tts['action_succedd']." $metamessage",'post'=>$id];
                        activity::insert('Post Management',user::logged('name')." deleted  ".$searchPost[0]->post_title,user::logged('id'));
                    }else{
                        $response = ['success'=>false,'message'=>"Error to delete this post"];
                    }

                    }

                }else{
                    $response = ['success'=>false,'message'=>"Post does not exist"];
                }

