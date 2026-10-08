<?php

use App\classes\leemclasses;
use App\classes\post;
use App\login\user;

use App\classes\black_list;

if(black_list::check()){
    include 'blacklist/index.php';
    die();
}

user::reConect();

function getOption($option){
  $val = C_THEME->$option??null;
  return $val && in_array($option,leemclasses::customCodesVars())?htmlspecialchars_decode($val):$val;
}
define('THEME',leemclasses::themeName());
define('THEME_ROOT',SITE_ROOT.'/contents/'.THEME);
define('THEME_URI',URI_NAME.'/contents/'.THEME);
define('THEME_CLASSES',THEME_ROOT.'/classes');
define('POSTS_LIMIT_DEFAULT',10);


include_once THEME_ROOT.'/classes/typography.php';
define('theme_t',getTypography());
post::check_schedule();



