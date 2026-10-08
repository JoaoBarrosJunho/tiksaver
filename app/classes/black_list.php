<?php

namespace App\classes;

use App\db\database;
use DateTime;
use PDO;

class black_list
{


    public static function insert($ip)
    {
        $created = (new DateTime('now'))->format("Y-m-d H:i:s");
        

        return (new database('black_list'))->insert([
            "ip" => $ip,
            "created" => $created,
            "updated" => $created
        ]);
    }

    public static function select($WHERE = null, $order = null, $limit = null, $fields = '*')
    {
        $response = (new database('black_list'))->select($WHERE, $order, $limit, $fields)->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }

    public static function update($VALUES, $WHERE)
    {
        $VALUES["updated"] = (new DateTime('now'))->format("Y-m-d H:i:s");
        return (new database('black_list'))->update($VALUES, $WHERE);
    }

    public static function delete($WHERE)
    {
        if ((new database('black_list'))->delete($WHERE)) {
            return true;
        }
        return false;
    }

    public static function ban($ip){
        $success=false;
        $message = '';

        if(self::insert($ip)){
            $success = true;
            $message = 'This IP address has been blacklisted';
        }else{
            $message = 'Error to ban this IP address';
        }

        return ['success'=>$success,'message'=>$message]; 
    }

    public static function remove($ip){
        $success=false;
        $message = '';

        if(self::delete("ip='$ip'")){
            $success = true;
            $message = 'IP removed from blacklist!';
        }else{
            $message = 'Error to remove IP from blacklist';
        }

        return ['success'=>$success,'message'=>$message]; 
    }

    public static function check($ip=null){
        $ip = $ip??$_SERVER["REMOTE_ADDR"];
        return self::select("ip='$ip'");
    }

    


}
