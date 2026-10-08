<?php

namespace App\classes;

use App\db\commands;
use DateTime;



class api_logs extends commands{

    
    protected static $DB_NAME ='api_logs';
    
    
    
    private static function setDB(){
        self::$database = self::$DB_NAME;
    }

    public static function new($api_id,$action_key='new_request'){
        self::setDB();

        $user_agent = $_SERVER["HTTP_USER_AGENT"];
        $date = (new DateTime('now'))->format("Y-m-d H:i:s");
        $user_ip = $_SERVER["REMOTE_ADDR"];


        return self::insert(['api_id'=>$api_id,'action_key'=>$action_key,'created'=>$date,'updated'=>$date,'user_agent'=>$user_agent,'user_ip'=>$user_ip]);
    }


    public static function find($WHERE=null,$ORDER=null,$LIMIT=null,$FIELDS = '*'){
        self::setDB();
        return self::select($WHERE,$ORDER,$LIMIT,$FIELDS);
    }

    public static function save($VALUES,$WHERE){
        self::setDB();
        $VALUES['updated'] = (new DateTime('now'))->format("Y-m-d H:i:s");
        return self::update($VALUES,$WHERE);
    }


    public static function remove($where){
        self::setDB();
        return self::delete($where);
    }

    

    public static   function requestsToday($api_id){
        $date = (new DateTime('now'))->format("Y-m-d");
        $date_in =(new DateTime($date))->format("Y-m-d 00:00:00");
        $date_fin =(new DateTime($date))->format("Y-m-d 23:59:59");
        return self::find("api_id=$api_id AND action_key='new_request' AND created BETWEEN '$date_in' AND '$date_fin'",null,null,'COUNT(id) as Results')[0]->Results??0;
    }

}