<?php

use App\classes\widget;


$success = false;
                $message = '';

                $widget_id = isset($data['widget_id']) && is_numeric($data['widget_id'])?$data['widget_id']:null;
                $elements = isset($data['element'])? json_encode($data['element']):' ';
                if($widget_id){
                    $update = (new widget())->updateWidget(['widget_content'=>"$elements"],"id='$widget_id'");
                    if($update){
                        if($elements != ' '){
                            foreach(json_decode($elements) as $item){
                                $updateItem = (new widget())->updateWidget(['widget_parent'=>$widget_id],"id='$item'");
                            }
                        }
                        
                        $success=true;
                        $message = "Widget $widget_id as been updated!";
                    }else{
                        $message = "Error to update Widget $widget_id";
                    }
                }

                $response = ['success'=>$success, 'message'=>$message];
