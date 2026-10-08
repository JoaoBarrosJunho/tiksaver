<?php
namespace App\db;

$file = SITE_ROOT."/app/db/mydb.php";
file_exists($file)? include_once $file:null;
$conn_info = isset($conn_info)?$conn_info:null;
define('DB',$conn_info);


class dbinfo{

    
public static function inite(){
    
    return self::getMydb();
}

public static function getMydb(){
     
    return DB?DB:['host'=>'','user'=>'','pass'=>'','name'=>''];
}




}
