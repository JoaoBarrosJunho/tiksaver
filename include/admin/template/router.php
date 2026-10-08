<?php

use App\classes\leemclasses;
use App\classes\routes;
use App\login\user;

extract(routes::panel());


$nav?include_once $header:null;
$TITLE = $pagename;
$nav?include_once 'parts/nav.php':null;
user::logged('type')>$autorization?leemclasses::onlyAdmins():null;
include_once $view;

