<?php

namespace App\classes;

use App\login\user;

class navlinks
{


protected $templateBody;
protected $hoverText;


public function __construct()
{
  $userTypeVal = user::logged('type');
  $this->templateBody = $userTypeVal>1?"text-white bg-gray-900 dark:text-gray-400 dark:bg-gray-900":"text-gray-500 bg-gray-50 dark:text-gray-400 dark:bg-gray-900";
  $this->hoverText = $userTypeVal>1?"hover:text-gray-200":"hover:text-gray-800";
}


  private function pages()
  {
    $link = [];

    $link[] = [
      'type' => 'link',
      'allowed' => [0, 1],
      'route' => 'dashboard',
      'text' => tts['dashboard'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M264.5 5.2c14.9-6.9 32.1-6.9 47 0l218.6 101c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 149.8C37.4 145.8 32 137.3 32 128s5.4-17.9 13.9-21.8L264.5 5.2zM476.9 209.6l53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 277.8C37.4 273.8 32 265.3 32 256s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0l152-70.2zm-152 198.2l152-70.2 53.2 24.6c8.5 3.9 13.9 12.4 13.9 21.8s-5.4 17.9-13.9 21.8l-218.6 101c-14.9 6.9-32.1 6.9-47 0L45.9 405.8C37.4 401.8 32 393.3 32 384s5.4-17.9 13.9-21.8l53.2-24.6 152 70.2c23.4 10.8 50.4 10.8 73.8 0z"/></svg>'
    ];



    $link[] = [
      'type' => 'link',
      'allowed' => [0, 1],
      'route' => 'download-logs',
      'text' => tts['download_logs'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128l-368 0zm79-167l80 80c9.4 9.4 24.6 9.4 33.9 0l80-80c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-39 39L344 184c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 134.1-39-39c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9z"/></svg>'
    ];

   
    

    $link[] = [
      'type' => 'template',
      'route' => '#',
      'allowed' => [0,1],
      'text' => 'Blog',
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg"  class="w-4 h-4" fill="currentColor"  viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 64C0 46.3 14.3 32 32 32c229.8 0 416 186.2 416 416c0 17.7-14.3 32-32 32s-32-14.3-32-32C384 253.6 226.4 96 32 96C14.3 96 0 81.7 0 64zM0 416a64 64 0 1 1 128 0A64 64 0 1 1 0 416zM32 160c159.1 0 288 128.9 288 288c0 17.7-14.3 32-32 32s-32-14.3-32-32c0-123.7-100.3-224-224-224c-17.7 0-32-14.3-32-32s14.3-32 32-32z"/></svg>',
      'links' => [
        ['route' => 'blogs', 'allowed' => [0, 1], 'text' => tts['all_posts']],
        ['route' => 'new-post', 'allowed' => [0, 1], 'text' => tts['add_new']],
      ]
    ];

    $link[] = [
      'type' => 'template',
      'route' => '#',
      'allowed' => [0, 1],
      'text' => tts['pages'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 464c-8.8 0-16-7.2-16-16L48 64c0-8.8 7.2-16 16-16l160 0 0 80c0 17.7 14.3 32 32 32l80 0 0 288c0 8.8-7.2 16-16 16L64 464zM64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-293.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0L64 0zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24l144 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-144 0z"/></svg>',
      'links' => [
        ['route' => 'pages', 'allowed' => [0, 1], 'text' => tts['all_pages']],
        ['route' => 'new-page', 'allowed' => [0, 1], 'text' => tts['add_new']],
      ]
    ];


    

    


    $link[] = [
      'type' => 'link',
      'route' => 'attachments',
      'allowed' => [0, 1],
      'text' => tts['attachments'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M364.2 83.8c-24.4-24.4-64-24.4-88.4 0l-184 184c-42.1 42.1-42.1 110.3 0 152.4s110.3 42.1 152.4 0l152-152c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-152 152c-64 64-167.6 64-231.6 0s-64-167.6 0-231.6l184-184c46.3-46.3 121.3-46.3 167.6 0s46.3 121.3 0 167.6l-176 176c-28.6 28.6-75 28.6-103.6 0s-28.6-75 0-103.6l144-144c10.9-10.9 28.7-10.9 39.6 0s10.9 28.7 0 39.6l-144 144c-6.7 6.7-6.7 17.7 0 24.4s17.7 6.7 24.4 0l176-176c24.4-24.4 24.4-64 0-88.4z"/></svg>'
    ];

    $link[] = [
      'type' => 'link',
      'route' => 'stats',
      'allowed' => [0],
      'text' => tts['stats'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M64 64c0-17.7-14.3-32-32-32S0 46.3 0 64L0 400c0 44.2 35.8 80 80 80l400 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L80 416c-8.8 0-16-7.2-16-16L64 64zm406.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L320 210.7l-57.4-57.4c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L240 221.3l57.4 57.4c12.5 12.5 32.8 12.5 45.3 0l128-128z"/></svg>'
    ];


    $link[] = [
      'type' => 'link',
      'route' => 'accounts',
      'allowed' => [0],
      'text' => tts['accounts'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM609.3 512l-137.8 0c5.4-9.4 8.6-20.3 8.6-32l0-8c0-60.7-27.1-115.2-69.8-151.8c2.4-.1 4.7-.2 7.1-.2l61.4 0C567.8 320 640 392.2 640 481.3c0 17-13.8 30.7-30.7 30.7zM432 256c-31 0-59-12.6-79.3-32.9C372.4 196.5 384 163.6 384 128c0-26.8-6.6-52.1-18.3-74.3C384.3 40.1 407.2 32 432 32c61.9 0 112 50.1 112 112s-50.1 112-112 112z"/></svg>'
    ];


    $link[] = [
      'type' => 'template',
      'route' => '#',
      'allowed' => [0],
      'text' => tts['appearance'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 64C0 28.7 28.7 0 64 0L352 0c35.3 0 64 28.7 64 64l0 64c0 35.3-28.7 64-64 64L64 192c-35.3 0-64-28.7-64-64L0 64zM160 352c0-17.7 14.3-32 32-32l0-16c0-44.2 35.8-80 80-80l144 0c17.7 0 32-14.3 32-32l0-32 0-90.5c37.3 13.2 64 48.7 64 90.5l0 32c0 53-43 96-96 96l-144 0c-8.8 0-16 7.2-16 16l0 16c17.7 0 32 14.3 32 32l0 128c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-128z"/></svg>',
      'links' => [
        ['route' => 'menu-settings', 'allowed' => [0], 'text' => tts['menu_settings']],
    #  ['route' => 'layout', 'allowed' => [0], 'text' => tts['layout']],
     # ['route' => 'select-template', 'allowed' => [0], 'text' => tts['template']],
        ['route' => 'theme-options', 'allowed' => [0], 'text' => tts['theme_options']],
      ]
    ];


   

    $link[] = [
      'type' => 'template',
      'route' => '#',
      'allowed' => [0, 1, 2, 3],
      'text' => tts['settings'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>',
      'links' => [
        ['route' => 'general-settings', 'allowed' => [0], 'text' => tts['general']],
        ['route' => 'integrations', 'allowed' => [0], 'text' => tts['integrations']],
        ['route' => 'profile', 'allowed' => [0, 1, 2, 3], 'text' => tts['profile']],
        ['route' => 'logs', 'allowed' => [0], 'text' => 'Logs'],
      ]
    ];

    $link[] = [
      'type' => 'link',
      'allowed' => [0,1],
      'route' => 'api-keys',
      'text' => 'API Keys',
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 144l0 48 160 0 0-48c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192l0-48C80 64.5 144.5 0 224 0s144 64.5 144 144l0 48 16 0c35.3 0 64 28.7 64 64l0 192c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 256c0-35.3 28.7-64 64-64l16 0z"/></svg>'];
    

    $link[] = [
      'type' => 'link',
      'route' => 'updates',
      'allowed' => [0],
      'text' =>UPDATE_VERSION? '<div class="flex items-center gap-3">'.tts['updates']."<span class='text-red-600 text-xs '><i class='bx bxs-circle bx-flashing' ></i></span></div>":tts['updates'],
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160 352 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l111.5 0c0 0 0 0 0 0l.4 0c17.7 0 32-14.3 32-32l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1L16 432c0 17.7 14.3 32 32 32s32-14.3 32-32l0-35.1 17.6 17.5c0 0 0 0 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.8c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352l34.4 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48.4 288c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg>
'
    ];

    return $link;
  }

  public function buildMenu($root = URI_NAME . '/panel/')
  {
    $user = intval(user::logged('type'));
    $data =  $this->pages();
    $link = '<li class="relative px-6 py-3">       
        <a href="@dir" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 @selected">
          @icon
          <span class="ml-4">@text</span>
        </a>
      </li>';

    $templateItem = '<li class="px-2 py-1 transition-colors duration-150 @selected">
      <a class="w-full" href="@dir">
      @text
      </a>
    </li>';

    $templateBody = '<li class="relative px-6 py-3" x-data="{open: @selected}">
    <button class="inline-flex items-center focus:outline-none justify-between w-full text-sm font-semibold transition-colors duration-150 '.$this->hoverText.' dark:hover:text-gray-200" @click="open = !open" aria-haspopup="true">
      <span class="inline-flex items-center">
      @icon
        <span class="ml-4">@text</span>
      </span>
      <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
      </svg>

    </button>
    <template x-if="open">
      <ul x-transition:enter="transition-all ease-in-out duration-300" x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl" x-transition:leave="transition-all ease-in-out duration-300" x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium  rounded-md shadow-inner'.$this->templateBody.'" aria-label="submenu">
        @templateitens
      </ul>
    </template>
  </li>
';
    $html = [];
    $dataConvert = $data ? json_encode($data) : "[]";
    $data = json_decode($dataConvert);
    if ($data) {
      foreach ($data as $d) {
        if (in_array($user, $d->allowed)) {
          switch ($d->type) {
            case 'link':
              $newElement = str_replace(['@text', '@dir', '@icon', '@selected'], [$d->text, $root . $d->route, $d->icon, $this->isIn($d->route)], $link);
              $html[] = $newElement;
              break;
            case 'template':
              $linksResult = [];
              $Troutes = [];
              foreach ($d->links as $tLink) {
                if (in_array($user, $tLink->allowed)) {
                  $Troutes[] = $tLink->route;
                  $linksResult[] = str_replace(['@text', '@dir', '@selected'], [$tLink->text, $root . $tLink->route, $this->isIn($tLink->route)], $templateItem);
                }
              }
              $html[] = str_replace(['@text', '@templateitens', '@icon', '@selected'], [$d->text, implode("\n", $linksResult), $d->icon, $this->isMenu($Troutes)], $templateBody);

              break;
            default:
              break;
          }
        }
      }
    }

    return implode("\n", $html);
  }

  private function isIn($page)
  {
    $section = isset($_GET['zone']) ? $_GET['zone'] : $_GET['p'];

    return $page == $section ? 'text-purple-600' : "$this->hoverText dark:hover:text-gray-200";
  }

  private function isMenu($pages = [])
  {
    $section = isset($_GET['zone']) ? $_GET['zone'] : $_GET['p'];
    return in_array($section, $pages) ? 'true' : 'false';
  }
}
