<?php
use App\classes\routes;



include_once './config.php';

extract(routes::pages());

$header?include_once 'header.php':null;
include_once $view;
$footer?include_once 'footer.php':null;





 