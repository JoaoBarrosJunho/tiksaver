<?php
namespace App\classes;
use Marshmallow\NovaGenerateString\GenerateString;

class getstring{

    public static function get(){
        $lenght = rand(6,15);
        return self::generateRandomString($lenght);

    }


    public static function generateRandomString($length) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
    
        // Gera a string aleatória
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, strlen($characters) - 1)];
        }
    
        return $randomString;
    }
}