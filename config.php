<?php

use App\api\tikdrop_updates;
use App\classes\language;
use App\classes\leemclasses;
use App\classes\logintoken;


/* ==============================
   Author Description
   ============================== */

/*
  Name: João Junho
  Group: LeemByte
  Portfolio: https://www.codester.com/leembyte/
  Script: TikDrop v1.0.
  Telegram: https://t.me/leembyte
*/

//GLOBAL_VARS
//WARNING: Changing any global variable in this file may corrupt the script.
$script_name = dirname($_SERVER["SCRIPT_NAME"]) != '/'? dirname($_SERVER["SCRIPT_NAME"]):'';
define('SITE_ROOT', __DIR__);
define('SCRIPT_NAME',$script_name);

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']==='on'?'https://':'http://';
$domain = $_SERVER['HTTP_HOST'];
$uribase = $protocol.$domain.$script_name;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


define('LOGIN_TOKEN',(new logintoken())->getappID());
define('URI_NAME',$uribase);

#APP Configs
include 'assets/css/frameworks/classes.php';
define('style',$class);
define('fonts',$fonts_);
define('APP_VERSION',$_ENV["APP_VERSION"]);
define('APP_NAME',$_ENV["APP_NAME"]);
define('V_',$_ENV["V_"]);


#permalinks
define('CATEGORY_SLUG',$_ENV["CATEGORY_SLUG"]);
define('PAGE_SLUG',$_ENV["PAGE_SLUG"]);
define('TAG_SLUG',$_ENV["TAG_SLUG"]);

#Instalation status checker
include_once SITE_ROOT.'/app/setup/setup.php';
date_default_timezone_set(leemclasses::GetTimeZone());
//SITE DESCRIPTION
define("C_THEME",leemclasses::getThemeOptions());
define('SITE_TITLE',leemclasses::option('site_title'));
define('SITE_DESCRIPTION',leemclasses::option('site_description'));
define('SITE_KEYWORDS',leemclasses::option('site_keywords'));
define('UPDATE_VERSION',tikdrop_updates::checkVersion());
//SET SITE LANGUAGE
$lang_ = language::getLang();
require SITE_ROOT."/locale/$lang_.php";
define('tts',$tx);
define('tts_t',$theme_tts);








?>