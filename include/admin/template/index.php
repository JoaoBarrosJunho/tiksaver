<?php
use App\login\logout;
$lc = new logout();



$lc->loginCheck();
$header = SITE_ROOT.'/include/header.php';

$TITLE;
include_once 'router.php';
?>

</div>