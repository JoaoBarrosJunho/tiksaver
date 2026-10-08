<?php 
namespace App\classes;
use Behat\Transliterator\Transliterator;

class urilize{

public static function text($text,$separator='-'){
    return Transliterator::transliterate($text,$separator);
}
}