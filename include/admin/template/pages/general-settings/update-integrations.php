<?php
use App\classes\leemclasses;
function update($data){
    $status = leemclasses::setGeneralSettings($data);
     return $status;
}

$status = $_POST ? update($_POST):null;


function getCompletionModels(){
  $models = "gpt-4o,gpt-4-turbo-2024-04-09,gpt-4-turbo,gpt-4,gpt-3.5-turbo,gpt-3.5-turbo-instruct,gpt-3.5-turbo-16k-0613,babbage-002, davinci-002,text-davinci-003,text-davinci-002,davinci,curie,babbage,ada";
  
    $models = explode(',',$models);
    $model_selected = leemclasses::option('completion_model');
    $model_selected = $model_selected?$model_selected:'gpt-3.5-turbo-instruct';
    $html = [];
    foreach($models as $model){
      $selected = $model_selected==$model?'selected':'';
      $html[] = "<option value='$model' $selected>$model</option>";
    }
  
    return implode("\n",$html);
  
  }
  
  function getImageModels(){
    $models = ["dall-e-2"=>'Dall-e-2',"dall-e-3"=>'Dall-e-3'];
    $model_selected = leemclasses::option('image_model');
    $html = [];
    foreach($models as $key=>$value){
      $selected = $model_selected==$key?'selected':'';
      $html[]="<option value='$key' $selected>$value</option>";
    }
  
    return implode("\n",$html);
  
  }
  
  function getImageStyle(){
    $models = ["vivid"=>'Vivid',"natural"=>'Natural'];
    $style_selected = leemclasses::option('image_style');
    $html = [];
    foreach($models as $key=>$value){
      $selected = $style_selected==$key?'selected':'';
      $html[]="<option value='$key' $selected>$value</option>";
    }
  
    return implode("\n",$html);
  
  }