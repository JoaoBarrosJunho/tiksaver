<?php
use App\classes\language;

function getLangs(){
  $langs = language::$langs;
  $result=[];
  $current = language::getLang();

  $html = '<li class="flex">
  <label class="inline-flex @current hover:pointer items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" onclick="setLanguage(\'@key\')">
    <span>@value</span>    
  </label>
</li>
';
  foreach($langs as $key=>$value){
    $lang = isset(tts[strtolower($value)])?tts[strtolower($value)]:$value;
    $isCurrent = $key==$current?'bg-gray-100 dark:bg-gray-800':'';
    $result[] = str_replace(['@key','@value','@current'],[$key,$lang,$isCurrent],$html);
  }

  return implode("\n",$result);

}
?>

<li class="relative"  title="<?=tts['select_language']?>">
            <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleLangMenu"  aria-label="Select-Language" aria-haspopup="true">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
			  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 21l5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 016-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 01-3.827-5.802" />
			</svg>
              <!-- Lang badge -->
              
            </button>
            <template x-if="isLangMenuOpen">
              <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeLangMenu" @keydown.escape="closeLangMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700" aria-label="Set Lang">
<?=getLangs()?>
                
              </ul>
            </template>
</li>


