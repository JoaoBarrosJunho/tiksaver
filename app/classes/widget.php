<?php
namespace App\classes;

use App\db\database;
use PDO;

class widget{


    /**DATABASE MANAGER*/
    public function insertWidget($name = '',$content = '',$type = '',$parent = NULL){
        $response = (new database('widgets'))->insert(['widget_name'=>"$name",
                                                        'widget_content'=>"$content",
                                                        'widget_type'=>"$type",
                                                        'widget_parent'=>$parent]);
        return $response;
    }

    public function selectWidget($WHERE,$FIELDS='*',$ORDER = NULL, $LIMIT = NULL){
        $response = (new database('widgets'))->select($WHERE,$ORDER,$LIMIT,$FIELDS)->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }

    public function updateWidget($VALUES,$WHERE){
        $response = (new database('widgets'))->update($VALUES,$WHERE);
        return $response;
    }

    public function deleteWidget($WHERE){
        $response = (new database('widgets'))->delete($WHERE);
        return $response;
    }


    /**DATABASE MANAGER*/


    /**BACK-END (LAYOUT WIGDET)*/

    public static function widgetBody(){
        $html = '<div class="w-full  px-2 py-2 rounded-lg bg-gray-50  dark:bg-gray-700 ">
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 ">@widgettitle</h3>
        <button class="'.style['btn-purple-outline'].' w-full" onclick="newGadget(\'@type_@id\',@id)" data-bs-toggle="modal" data-bs-target="#widgetModal">Add widget</button>
        <form class="flex flex-col gap-3 w-full mt-4 bg-gray-100 rounded-lg py-4 px-4 column" id="@type_@id" >          
        @widgetitens

        <input type="hidden" name="widget_id" id="widget_id" value="@id">
        </form>
        </div>';

        return $html;
    }

    public static function itemBody(){
        $html = '<label id="item_body_@id" class="flex py-4 px-4 bg-white gap-3 item mt-4 mb-4 hover:mouse-move rounded-md" draggable="true">
                <span class="flex flex-col gap-3 text-sm font-semibold text-gray-700 hover:pointer">
                   <span id="item_title_@id">@title</span>
                    
                   <label class="flex gap-3 ">
                    <span class="text-lg font-semibold text-blue-500 hover:pointer" data-bs-toggle="modal" data-bs-target="#widgetModal" onclick="editWidget(@id)"><i class="bx bx-edit"></i></span>
                    <span class="text-lg font-semibold text-red-600 hover:pointer" onclick="deleteWidget(@id)"><i class="bx bx-trash"></i></span>
                   </label>
                </span>
                <input type="hidden" name="element[]" value="@id">
                </label>';

    return $html;
    }

    public static function creatWidget($id, $title,$type,$item){
        
        $view = self::widgetBody();

        $widget = str_replace(['@id','@widgettitle','@type','@widgetitens'],[$id,$title,$type,$item],$view);
        return $widget;

    }

    public static function creatItem($title,$id){
        $item = self::itemBody();
        return str_replace(['@title','@id'],[$title,$id],$item);
    }

    public static function getWidgets($type){
        $response = [];
        $sidebars = (new widget())->selectWidget("widget_type = '$type'");
        if($sidebars){
            foreach($sidebars as $sidebar){
                $sidebar_content = $sidebar->widget_content != ' '?(array)json_decode($sidebar->widget_content):[];
                $items = self::getWidgetItem($sidebar->id,$sidebar_content);
                $response [] = self::creatWidget($sidebar->id,$sidebar->widget_name,$sidebar->widget_type,$items);
            }
        }
        
        return implode("\n",$response);

    }


    public static function getWidgetItem($parent = null,$sidebar_content = []){
        $result = [];
        
        if($sidebar_content){
            foreach($sidebar_content as $itemId){
                $item = (new widget())->selectWidget("id='$itemId' AND widget_type = 'widget_item' AND widget_parent = '$parent'");
                if($item){
                    $i = $item[0];
                $result[] = self::creatItem($i->widget_name,$i->id);
                }
                
            }
        }
        return implode("\n",$result);
    }
/**BACK-END (LAYOUT WIGDET)*/


/**FRONT-END (WIDGET VIEWS) */


public static function WidgetItems($type,$addoms=[]){
    $response = [];
    $i=0;
    $widget_result = (new widget())->selectWidget("widget_type='$type'");
    //VERIFICA SE O WIDGET EXIST
    if($widget_result){
        foreach($widget_result as $w){
            //VERIFICA SE O WIDGET POSSUI ELEMENTOS E RETORNA ESSES ELEMENTOS
            $w_item = (array) json_decode($w->widget_content);
            if($w_item){
                foreach($w_item as $item){
                    if((new widget())->selectWidget("id='$item'")){
                        $response[$i]['item'][] = gadget::getGadged($item,$addoms);
                    }
                    
                }
            }
            $i++;
        }
    }

    return $response;

}
/**FRONT-END (WIDGET VIEWS) */

}