<?php
$dir = explode("\\" ,__DIR__);
array_pop($dir);
$abs_dir = implode('\\',$dir);
require_once $abs_dir.'/vendor/autoload.php';
require_once $abs_dir.'/config.php';
