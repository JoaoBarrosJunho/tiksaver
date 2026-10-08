<?php
use App\classes\leemclasses;

function styleString(){
    $dateUpdate = (new DateTime('now'))->format('d-m-Y h:i');
    $string = "/*This stylesheet is updated by php UPDATED: $dateUpdate */:root{--primary-color:@primary_color;}.text-primary{color: var(--primary-color);}.bg-primary{background-color: var(--primary-color);}.border-primary{border-color: var(--primary-color);}.theme-body{ background-color: @body_background;}.header-styling{ background-color: @header_background; color: @header_color;}.footer-styling{ background-color: @footer_background; color: @footer_color;}.module-styling{ background-color: @module_background; color: @module_color;}.pagination-styling{ background-color: @pagination_background; border-color: @pagination_background; color:@pagination_color;}.copy-area{ background-color: @copy_background; color: @copy_color;}.content-styling{ color: @content_color;}a{ color: @link_color;}.meta-styling{ color: @meta_color;}";
    
    $values = ['primary_color'=> StyleValue('primary_color','#7e3af2'),
    'body_background'=> StyleValue('body_background','#f9fafb'),
    'header'=>['background'=>StyleValue('header_background','#fff'),'color'=>StyleValue('header_color','#000')],
    'footer'=>['background'=>StyleValue('footer_background','#fff'),'color'=>StyleValue('footer_color','#000')],
    'module'=>['background'=>StyleValue('module_background','#fff'),'color'=>StyleValue('module_color','inherit')],
    'copy'=>['background'=>StyleValue('copyright_background','#fff'),'color'=>StyleValue('copyright_color','#000')],
    'pagination'=>['background'=>StyleValue('pagination_background','#7e3af2'),'color'=>StyleValue('pagination_color','#fff')],
    'content'=>StyleValue('content_color','#000'),
    'link'=>StyleValue('link_color','inherit'),
    'meta'=>StyleValue('meta_color','#9e9e9e'),];

    $elements = ['@primary_color'=>$values['primary_color'],
    '@body_background'=>$values['body_background'],
    '@header_background'=>$values['header']['background'],'@header_color'=>$values['header']['color'],
    '@footer_background'=>$values['footer']['background'],'@footer_color'=>$values['footer']['color'],
    '@module_background'=>$values['module']['background'],'@module_color'=>$values['module']['color'],
    '@copy_background'=>$values['copy']['background'],'@copy_color'=>$values['copy']['color'],
    '@pagination_background'=>$values['pagination']['background'],'@pagination_color'=>$values['pagination']['color'],
    '@content_color'=>$values['content'],
    '@link_color'=>$values['link'],
    '@meta_color'=>$values['meta'],
    ];
    return str_replace(array_keys($elements),array_values($elements),$string);
}



function getOption_s($option){
    return C_THEME_S->$option??null;
  }
  
  function StyleValue($option,$default){
      $isOption = getOption_s($option);
      return $isOption?$isOption:$default;
  }

function updateStyling(){
    $new_style = styleString();
    leemclasses::setOptions('theme-elements',json_encode($new_style));
    return true;

}

