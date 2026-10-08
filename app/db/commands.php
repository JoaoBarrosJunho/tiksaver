<?php

namespace App\db;

use PDO;

class commands{

    protected static $database ;
    


    public static function insert(array $data)
    {
        return (new database(self::$database))->insert($data);
    }

    public static function select($WHERE = null, $order = null, $limit = null, $fields = '*')
    {
        $response = (new database(self::$database))->select($WHERE, $order, $limit, $fields)->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }

    public static function update($VALUES, $WHERE)
    {
        return (new database(self::$database))->update($VALUES, $WHERE);
    }

    public static function delete($WHERE)
    {
        if ((new database(self::$database))->delete($WHERE)) {
            return true;
        }
        return false;
    }


}