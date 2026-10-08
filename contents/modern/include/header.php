<?php

use App\classes\leemclasses;
use App\classes\language;
use App\classes\script_addoms;

$canonical_url = isset($_REQUEST['p']) && !empty($_REQUEST['p']) ? URI_NAME . "/" . $_REQUEST['p'] : URI_NAME;


   
?>
<!DOCTYPE html>
<html :class="{ 'theme-dark': <?=getOption('only_darkmode')?'true':'dark'?> }" x-data="data()" lang="<?= language::getLang() ?>" <?= language::getLang() == 'ar' ? 'dir="rtl"' : null ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="<?= $canonical_url ?>" />
    <meta name="keywords" content="<?= SITE_KEYWORDS ?>" />
    <meta name="description" content="<?= isset($seo['description']) ? $seo['description'] : SITE_DESCRIPTION ?>" />

    <title><?= $page_title != null ? $page_title . ' - ' .SITE_TITLE :SITE_TITLE . ' - ' . SITE_DESCRIPTION ?></title>
    <link rel="stylesheet" href="<?= THEME_URI ?>/assets/css/style.css">
    
    <link rel="stylesheet" href="<?= THEME_URI ?>/assets/css/tailwind.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="<?= getOption('fav_icon') ?>" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= getOption('mobile_logo') ?>">


    <meta property="og:title" content="<?= isset($seo['title']) ? $seo['title'] :SITE_TITLE ?>" />
    <meta property="og:description" content="<?= isset($seo['description']) ? $seo['description'] : SITE_DESCRIPTION ?>" />
    <meta property="og:image" content="<?= isset($seo['image']) && $seo['image'] ? $seo['image'] :  getOption('website_logo') ?>" />
    <meta property="og:url" content="<?= $canonical_url ?>" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= isset($seo['title']) ? $seo['title'] :SITE_TITLE ?>" />
    <meta name="twitter:description" content="<?= isset($seo['description']) ? $seo['description'] : SITE_DESCRIPTION ?>" />
    <meta name="twitter:image" content="<?= isset($seo['image']) && $seo['image'] ? $seo['image'] :  getOption('website_logo') ?>" />
    <?= $seo['schema'] ?? null ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= URI_NAME ?>/assets/js/alpine.min.js" defer></script>
    <script src="<?= THEME_URI ?>/assets/js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css"/>
 

    <style>
        <?=leemclasses::getThemeElements()?>
    </style>
    <?=script_addoms::get()?>
       <?= getOption('header') ?>
       <?= getOption('custom_css') ? "<style>\n" . getOption('custom_css') . "\n</style>" : null ?>
</head>


<body class="theme-body dark:bg-gray-700 dark:text-gray-200">

    <?php include_once THEME_ROOT . "/template-parts/headers/nav.php"; ?>

    <?= isset($ads_header) ? $ads_header : null ?>
    <?= getOption('body_area') ?>

    <?= getOption('custom_html') ?>
    <?= getOption('custom_script') ? "<script>\n" . getOption('custom_script') . "\n</script>" : null ?>

