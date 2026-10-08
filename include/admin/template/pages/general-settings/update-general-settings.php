<?php
use App\classes\leemclasses;
function update($data){
    $status = leemclasses::setGeneralSettings($data);
     return $status;
}

$status = $_POST ? update($_POST):null;

$tz='';
$timezoneselected = leemclasses::option('time_zone');
$timeFormate = leemclasses::option('time_format');
$dateFormat = leemclasses::option('date_format');

foreach(leemclasses::getTimeZoneList() as $zone){
    $selected = $zone==$timezoneselected?'selected':'';
    $tz.= '<option '.$selected.' value="'.$zone.'">'.$zone.'</option>';
}