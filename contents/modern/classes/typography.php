<?php

use App\classes\typography;

function getTypography(){

    return ['text'=>typography::getStyle('text'),
    'nav'=>typography::getStyle('nav'),
    'heading'=>typography::getStyle('heading'),
    'default-grid'=>typography::getStyle('default-grid'),
    'grid-a'=>typography::getStyle('grid-a'),
    'grid-b'=>typography::getStyle('grid-b'),
    'grid-c'=>typography::getStyle('grid-c'),
    'btn-primary'=>'flex items-center justify-center px-4 py-2   leading-5 text-white transition-colors duration-150 bg-primary border border-transparent rounded-lg  focus:outline-none focus:shadow-outline-purple',
    'btn-outline'=>'flex  items-center justify-center px-4 py-2   leading-5 transition-colors duration-150 bg-white border border-primary rounded-lg active:bg-gray-50 hover:bg-gray-50 focus:outline-none focus:shadow-outline-purple dark:bg-gray-800 dark:text-gray-100'];
}