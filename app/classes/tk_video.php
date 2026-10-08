<?php

namespace App\classes;

use App\db\commands;
use DateTime;



class tk_video extends commands{

    
    protected static $DB_NAME ='tk_links';
    public static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
    
    
    private static function setDB(){
        self::$database = self::$DB_NAME;
    }

    public static function new($data){
        self::setDB();
        $date = (new DateTime('now'))->format("Y-m-d H:i:s");
        $user_ip = $_SERVER["REMOTE_ADDR"];

        $video_id = $data->sid;
        $video_cover = $data->thumbnail;
    
        return self::insert(['video_id'=>$video_id,'video_cover'=>$video_cover,'video_data'=>json_encode($data),'created'=>$date,'updated'=>$date,'user_ip'=>$user_ip]);
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

    

    

}