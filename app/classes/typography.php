<?php
namespace App\classes;
use App\classes\leemclasses;

class typography{

   public static function getStyle($element){
    $font_family = '';
    $font_size = '';
    $font_weight='';
    switch($element){
        case 'text':
            $data = ['font'=> getOption('main_text_font'),'size'=>getOption('main_text_size'),'weight'=>getOption('main_text_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-sm';
            $font_weight = $data['weight']? $data['weight']:null;
            
        break;
        case 'nav':
            $data = ['font'=> getOption('nav_font'),'size'=>getOption('nav_text_size'),'weight'=>getOption('nav_text_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:null;
            $font_weight = $data['weight']? $data['weight']:null;
        break;
        case 'heading':
            $data = ['font'=> getOption('heading_font'),'size'=>getOption('heading_size'),'weight'=>getOption('heading_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-2xl';
            $font_weight = $data['weight']? $data['weight']:'font-semibold';
        break;
        case 'default-grid':
            $data = ['font'=> getOption('default_grid_font'),'size'=>getOption('default_grid_size'),'weight'=>getOption('default_grid_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-sm';
            $font_weight = $data['weight']? $data['weight']:'font-semibold';
        break;
        case 'grid-a':
            $data = ['font'=> getOption('grid_a_font'),'size'=>getOption('grid_a_size'),'weight'=>getOption('grid_a_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-2xl';
            $font_weight = $data['weight']? $data['weight']:'font-semibold';
        break;
        case 'grid-b':
            $data = ['font'=> getOption('grid_b_font'),'size'=>getOption('grid_b_size'),'weight'=>getOption('grid_b_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-2xl';
            $font_weight = $data['weight']? $data['weight']:'font-semibold';
        break;
        case 'grid-c':
            $data = ['font'=> getOption('grid_c_font'),'size'=>getOption('grid_c_size'),'weight'=>getOption('grid_c_weight')];
            $font_family = $data['font']? $data['font']:'font-roboto';
            $font_size = $data['size']? $data['size']:'text-sm';
            $font_weight = $data['weight']? $data['weight']:'font-semibold';
            break;
        default:
        $data = ['font'=> getOption('main_text_font')];
        $font_family = $data['font']? $data['font']:'font-roboto';
        $font_size = null;
        $font_weight = null;
        break;      
    }

    return " $font_family $font_size $font_weight ";

    }
}
