<?php
use App\classes\metatags;

$category_name = $data['name'];
                $checkCategory = metatags::selectMetaTags("name = '$category_name'");
                if($checkCategory){
                    $dataResponse = $checkCategory[0]->id;
                    $success= false;
                }else{
                    $newCategory = metatags::addMetaTags($category_name,'category');
                    $dataResponse = '<label class="flex gap-2 text-sm pointer w-full py-1">
                    <input type="checkbox" checked="true" value="'.$newCategory.'" id="post_category" name="post_category">	
                    <span>'.$category_name.'</span>
                    </label>';
                    $success = true;
                    
                };

                $response = ['success'=>$success,'data'=>$dataResponse];