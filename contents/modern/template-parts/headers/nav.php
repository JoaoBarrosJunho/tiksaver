<?php
$header_type = 'default-header';

$header_type = $header_type && file_exists(THEME_ROOT."/template-parts/headers/$header_type.php") ?$header_type:'default-header';
include_once "$header_type.php";