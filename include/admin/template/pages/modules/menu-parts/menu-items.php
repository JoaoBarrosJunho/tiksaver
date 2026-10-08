<?php
use App\classes\menu;

function creatMenuItem($title,$url,$id){
$elementHTML = '<label id="item_'.$id.'" class="block px-2 py-3 bg-gray-100 border-sm border-gray-300 dark:bg-gray-800 item" draggable="true" x-data="{open: false}">';
$elementHTML .='<label class="inline-flex items-center hover:pointer justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" @click="open = !open" aria-haspopup="true">';
$elementHTML .='<span class="inline-flex items-center"> <span class="ml-4" id="pageName_'.$id.'">'.$title.'</span></span> <i class="bx bx-chevron-down"></i> </label>';
$elementHTML .=' <template x-if="open">';
$elementHTML .=' <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900" aria-label="submenu">';
$elementHTML .='<li class="flex flex-col gap-3">';
$elementHTML .='<input type="text"  value="'.$title.'"  onchange="updateTitle('.$id.',event)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Page tile">';
$elementHTML .='<input type="text"  value="'.$url.'" onchange="updateLink('.$id.',event)" class="block w-full  text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Page URL">';
$elementHTML .='<label class="text-sm underline text-red-600 hover:pointer " onclick="deleteItem('.$id.')">Remove item</label>';
$elementHTML .='</li></ul></template>';
$elementHTML .='<input type="hidden" name="titlemenu[]" value="'.$title.'" id="menuTitle_'.$id.'" >';
$elementHTML .='<input type="hidden" name="linkmenu[]" value="'.$url.'" id="menuLink_'.$id.'">';
$elementHTML .='</label>';

return $elementHTML;
}

if(isset($_GET['menu']) && is_numeric($_GET['menu'])){
  $result = menu::getItems($_GET['menu']);
  if($result){
    $items = $result;
    foreach($items as $item => $value){
      $result = explode('@:',$value);
      print creatMenuItem($result[0],$result[1],$item);
    }
    }
}

?>
<script src="<?= URI_NAME?>/assets/js/functions/menu-construtor.js"> </script>

