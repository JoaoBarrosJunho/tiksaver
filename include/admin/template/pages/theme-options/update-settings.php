<?php
use App\classes\leemclasses;


include_once 'update-styling.php';
function update($data,$files){
   $status = leemclasses::SetThemeOpition($data,$files);
   define("C_THEME_S",leemclasses::getThemeOptions());
    updateStyling();
    return $status;
}

$status = $_POST || $_FILES ? update($_POST,$_FILES):null;
