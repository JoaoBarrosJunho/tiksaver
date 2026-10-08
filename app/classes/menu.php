<?php

namespace App\classes;

use App\db\database;
use PDO;

class menu{

//DATA BASE FUNCTIONS
public function insertMenu($name,$content,$area = 0){
    $response = (new database('navitems'))->insert(['nav_name'=>"$name",'nav_items'=>"$content",'nav_area'=>$area]);
    return $response;
}

public function selectMenu($WHERE=NULL, $ORDER = NULL,$LIMIT=NULL,$FIELDS = '*'){
    $response = (new database('navitems'))->select($WHERE,$ORDER,$LIMIT,$FIELDS)->fetchAll(PDO::FETCH_CLASS);
    return $response;
}

public function updateMenu($VALUES,$WHERE){
    $response = (new database('navitems'))->update($VALUES,$WHERE);
    return $response;
}

public function deleteMenu($WHERE){
    $response = (new database('navitems'))->delete($WHERE);
    return $response;
}
//DATA BASE FUNCTIONS


public static function setItems($VALUES,$ID){
$response = (new menu())->updateMenu(['nav_items'=>$VALUES],"id='$ID'");
return $response;
}

public static function getMenu($id){
   return $response = (new menu())->selectMenu("id='$id'");
}

public static function getItems($id){
    $result = self::getMenu($id);
    $response =[];
    if($result){
        if(str_word_count($result[0]->nav_items)>0){
            $response = json_decode($result[0]->nav_items);
        }
    }

    return $response;
}
}