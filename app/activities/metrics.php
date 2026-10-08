<?php

namespace App\activities;

use App\db\database;
use DateTime;
use Exception;
use PDO;

class metrics{


public static function insert($postId){

$date = (new DateTime('now'))->format("Y-m-d");
$agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'undefined';
$ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:0;
$ip_country = isset($_SERVER['HTTP_CF_IPCOUNTRY'])?$_SERVER['HTTP_CF_IPCOUNTRY']:'null';

try{
    $response = (new database('postmetrics'))->insert(['post_id'=>$postId,
    'date'=>"$date",
    'ip'=>"$ip",
    'ip_country'=>"$ip_country",
    'agent'=>"$agent"]);
    return true;
}catch(Exception $e){
    return false;
}

}

public static function delete($id){
    try{
        $response = (new database('postmetrics'))->delete("id='$id'");
        return $response;
    }catch(Exception $e){
        return false;
    }
}

public static function select($WHERE=null,$ORDER=null,$LIMIT=null,$FIELDS = '*'){
    try{
        $response = (new database('postmetrics'))->select($WHERE,$ORDER,$LIMIT,$FIELDS)->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }catch(Exception $e){
        return false;
    }
}


}