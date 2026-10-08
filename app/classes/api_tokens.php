<?php
namespace App\classes;

use App\db\database;
use App\login\user;
use DateTime;
use PDO;

define("CURRENT_U_API",user::logged('id'));
class api_tokens{

    
    public static function insert($api_name,$auth_token,$asLimited=false,$day_limit=0,$user_id = null,$status=1){
        $user = $user_id??CURRENT_U_API;
        $created = (new DateTime('Now'))->format('Y-m-d H:i:s');
       

        return (new database('api_tokens'))->insert(['user_id'=>$user,
                                                    'api_name'=>$api_name,
                                                    'auth_token'=>"$auth_token",
                                                    'status'=>$status, 
                                                    'created'=>$created,
                                                    'updated'=>$created,
                                                    'asLimited'=>$asLimited,
                                                    'day_limit'=>$day_limit,
                                                ]);

    }

    public static function update($VALUES,$WHERE){
        $VALUES['updated']=(new DateTime('Now'))->format('Y-m-d H:i:s');
        return (new database('api_tokens'))->update($VALUES,$WHERE);
    }

    public static function delete($WHERE){
        return (new database('api_tokens'))->delete($WHERE);
    }

    public static function select($WHERE = null,$ORDER=null,$LIMIT=null,$FIELDS = '*'){
        return (new database('api_tokens'))->select($WHERE,$ORDER,$LIMIT,$FIELDS)->fetchAll(PDO::FETCH_CLASS);
    }

    
    public static function generateAPIKey($id){
        
        $save = false;
        $user = user::logged('id');
        $key = "tka_".bin2hex(random_bytes(15));

        if(self::select("user_id=$user")){
            $save = self::update(['auth_token'=>$key],"id=$id AND user_id=$user");
        }

        if($save){
            return $key;
        }else{
            return false;
        };
    }

    public static function newAPI($apiname,$asLimited=false,$day_limit=0,$id=null,$user_id =null){
        
        $save = false;
        $user = $user_id??user::logged('id');
        
        if($id){
            $save = self::update(['api_name'=>$apiname,'asLimited'=>$asLimited,'day_limit'=>$day_limit],"id=$id AND user_id=$user");
        }else{
            $key = "tka_".bin2hex(random_bytes(15));
            $save = self::insert($apiname,$key,$asLimited,$day_limit,$user_id);
        }

        if($save){
            return $save;
        }else{
            return false;
        };
    }

    public static function getKey($user_id=null){
        $user = $user_id??user::logged('id');
        return self::select("user_id=$user","id ASC",1,'auth_token')[0]->auth_token??self::generateAPIKey($user);
    }

    

    public static function checkAuthorization(){
        $key = $_GET['key']??null;
        if($key){
            $data = self::select("auth_token='$key' AND status=1",'id ASC',1)[0]??[];
            
            return $data;
        }
        return [];
    }
}