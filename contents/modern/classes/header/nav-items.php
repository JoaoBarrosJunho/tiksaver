<?php

use App\classes\menu;


use App\classes\language;
use App\classes\tk_video;

function getLangs(){
  $langs = language::$langs;
  $current = language::getLang();
  $result=[];
  $i_sub = ['en'=>'us','hi'=>'in','ar'=>'arab'];
  $html = '<li class="flex">
  <label class="@selected flex hover:pointer items-center gap-3 w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" onclick="setLanguage(\'@key\')">
  <span class="fi fi-@i rounded fis" title="@value"></span>
  <span>@value</span>    
  </label>
</li>
';
  foreach($langs as $key=>$value){
    $selected = $key==$current?'bg-gray-100 rounded-md dark:bg-gray-700':'';
    $lang = isset(tts[strtolower($value)])?tts[strtolower($value)]:$value;
    $i = $i_sub[$key]??$key;
    $result[] = str_replace(['@key','@value','@i','@selected'],[$key,$lang,$i,$selected],$html);
  }

  return implode("\n",$result);

}

function getHeader(){

    $header = (new menu())->selectMenu("nav_area='header'",null,1,'nav_items');
    if($header){
        $headerItems = [];
        $items = (array)json_decode($header[0]->nav_items);

        foreach($items as $key => $value){
            $headerItems[] = explode('@:',$value);
        }
        return $headerItems;
        
    }else{
        return null;
    }

}

function headerList($class = null, $addoms = null,$aclass = null){
 $items = getHeader();
 $list = '';
 $style = $class ? " class='$class' ":'';
 $astyle = $aclass ? " class='$aclass' ":'';

 
 if($items){    
    foreach($items as $i){
        $list.= '<li '.$style.' '.$addoms.'><a href="'.$i[1].'" '.$astyle.'>'.$i[0].'</a></li>'."\n";
    }
 }

 return $list;
}

function download_Counter(){
  $results = tk_video::find(null,null,null,'COUNT(id) as Results')[0]->Results??0;
  $html = '
 <button style="background:#00000057;" class="text-white dark:text-gray-200 relative px-2 py-1 flex gap-2 items-center rounded-md focus:outline-none focus:shadow-outline-purple" title="Downloads counter">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class=" w-5 h-5" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128l-368 0zm79-167l80 80c9.4 9.4 24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-39 39L344 184c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 134.1-39-39c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9z"/></svg>
    
    <span class="text-xs font-semibold">'.$results.'</span>
    
  </button>';

  return !getOption('show_downloadcounter')?$html:'';
}

function darkmode_toogle(){
    $html = '<li class="flex">
    <button class="rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleTheme" aria-label="Toggle color mode">
      <template x-if="!dark">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
          <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
        </svg>
      </template>
      <template x-if="dark">
        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
        </svg>
      </template>
    </button>
  </li>';

    return !getOption('show_darkmode')?$html:'';
}

function setLangToogle(){
  $i_sub = ['en'=>'us','hi'=>'in','ar'=>'arab'];
  $lang = language::getLang();
  $icone = $i_sub[$lang]??$lang;
  $html = '<li class="relative"  title="'.tts['select_language'].'">
  <button style="background:#00000057;" class="relative px-2 py-1 text-white flex items-center rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleLangMenu"  aria-label="Select-Language" aria-haspopup="true">
  <span class="fi fi-'.$icone.' rounded fis mr-1" title="'.$icone.'"></span> 
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" w-5 h-5">
<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802" />
</svg>
    
    
  </button>
  <template x-if="isLangMenuOpen">
    <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeLangMenu" @keydown.escape="closeLangMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700" aria-label="Set Lang">
'.getLangs().'
      
    </ul>
  </template>
</li>';

return !getOption('show_langToogle')?$html:'';
}

function profilemenu(){
       if(!getOption('userprofilemenu')){return 1;};
    }

function loginButton(){
    $html = '<li class="text-sm md:hidden">|</li><li class="flex gap-3 items-center"><a href="'.URI_NAME.'/login">Login</a><i class="bx bx-log-in"></i></li>';
    return !getOption('loginbutton')?$html:'';
}


function headerlogo($dir){
    
  $site_dir = $dir;
  switch(getOption('nav_header')){
      case 'logo':
          return '<a class=" flex items-center text-lg   dark:text-gray-200" href="'.$site_dir.'">
          <img src="'.getOption('website_logo').'" class="h-8" alt="logo">
           </a>';
      break;
      case 'logo_title':

          return '<a class=" flex items-center text-2xl gap-3  dark:text-gray-200" href="'.$site_dir.'">
          <img src="'.getOption('website_logo').'" class="h-6" alt="logo"><span class="hidden md:block flex ml-1 mt-1 uppercase">'.SITE_TITLE.'</span>
           </a>';
          break;
      case 'title':

          return '<a class=" flex items-center text-2xl   dark:text-gray-200" href="'.$site_dir.'">
          <span class="ml-1 mt-1 uppercase">'.SITE_TITLE.'</span>
           </a>';
      break;
      default:
      return '<a class=" flex items-center gap-3 text-lg   dark:text-gray-200" href="'.$site_dir.'">
          <img src="'.getOption('website_logo').'" class="h-6" alt="logo"><span class="hidden md:block ml-1 mt-1">'.SITE_TITLE.'</span>
           </a>';
      break;
  }
}