<?php

namespace App\classes;

class script_addoms{

    public static function get(){
        $code = "<script>
        const appApi = '".URI_NAME."/api';
        </script>";

        return implode("\n",[$code]);
    }
}