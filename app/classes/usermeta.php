<?php
namespace App\classes;

use App\db\database;
use App\login\user;
use DateTime;
use PDO;

define("DEFAULT_USER_META",user::logged('id'));
class usermeta{


    /**META TAGS DATABASE STRINGS**/

    public static function add($metakey,$metavalue,$user_id = DEFAULT_USER_META){
  $created = (new DateTime('now'))->format("Y-m-d H:i:S");
  
        return (new database('usermeta'))->insert(['user_id'=>"$user_id",
        'meta_key'=>"$metakey"
        ,'meta_value'=>"$metavalue"
        ,"status"=>1
        ,"created"=>$created
        ,"updated"=>$created
    ]);
   
    }
    
    public static function select($WHERE, $ORDER= null,$LIMIT=null,$fields = '*'){
    $response = (new database('usermeta'))->select($WHERE,$ORDER,$LIMIT,$fields)->fetchAll(PDO::FETCH_CLASS);
    return $response;
    }
    
    public static function update($VALUES, $WHERE){
        $VALUES['updated'] = (new DateTime('now'))->format("Y-m-d H:i:S");
        return (new database('usermeta'))->update($VALUES,$WHERE);
    }
    
    public static function delete($WHERE){
        if((new database('usermeta'))->delete($WHERE)){
            return true;
        }
        return false;
    }


    public static function set($meta_key,$meta_value=null,$user_id = DEFAULT_USER_META){
        if(!self::select("meta_key = '$meta_key' AND user_id=$user_id")){
           return self::add($meta_key,$meta_value,$user_id);
        }else{
    
            return self::update(["meta_value"=>$meta_value],"meta_key='$meta_key' AND user_id=$user_id");
            
        }
    }


    

    public static function Meta($meta_key,int $user = DEFAULT_USER_META){
        $meta =  self::select("meta_key='$meta_key' AND user_id=$user AND meta_status=1",null,null,'meta_value');
        if($meta){
            return !empty($meta[0]->meta_value)?$meta[0]->meta_value:null;
        }
        return null;
    }

}