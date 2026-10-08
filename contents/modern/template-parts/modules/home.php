<?php

use App\classes\leemclasses;
use App\classes\postmodule;

include_once THEME_CLASSES . '/grids.php';



function creatModule($data)
{
    $type = $data->type_module;
    switch ($type) {
        case 'blank':
          
            $html = '<div class="w-full my-8 ">@content
        </div>';
            //$title = $data->title?newTitle("$data->title"):null;
            $text = str_replace(['%site_name%', '%site_description%', '%site_url%'], [SITE_TITLE, SITE_DESCRIPTION, URI_NAME], leemclasses::text_encode($data->text, 'get'));
            return str_replace('@content', "<div class='w-full flex flex-col gap-3'>" . $text . "</div>", $html);
            break;


        case 'post':

            

            $html = '<div class=" mb-4">@content
        </div>';
            $title = $data->title ? $data->title : null;
            $grid = 'grid-c';
            $limite = $data->limite && is_numeric($data->limite) ? $data->limite : 6;

            $order = $data->order ? $data->order : null;
            //        include_once  gridTemplate($grid);

            $g = instanceGrid($grid);


            include_once 'post-loop.php';
            return str_replace('@content', $g->gridArea(showArticles(null, $limite, getOrder($order)), $title), $html);


            break;
        default:
            return null;
            break;
    }
}


function getOrder($order)
{
    switch ($order) {
        case 'date':
            return 'id DESC';
            break;
        case 'update':
            return 'post_date_update DESC';
            break;
        case 'random':
            return 'RAND()';
            break;
        default:
            return 'id DESC';
            break;
    }
}

function getModules()
{
    $modules = postmodule::getHomeModule();
    if ($modules) {

        foreach ($modules as $mod) {
            print creatModule($mod);
        }
    }
}

getModules();
