<?php
use App\classes\notification;

$results = notification::getResult();
?>
<li class="relative">
            <button class="relative align-middle rounded-md focus:outline-none focus:shadow-outline-purple" @click="toggleNotificationsMenu" @keydown.escape="closeNotificationsMenu" aria-label="Notifications" aria-haspopup="true">
              <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
              </svg>
              <!-- Notification badge -->
              <?= notification::getBadget()?>
            </button>
            <template x-if="isNotificationsMenuOpen">
              <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.away="closeNotificationsMenu" @keydown.escape="closeNotificationsMenu" class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:text-gray-300 dark:border-gray-700 dark:bg-gray-700">
                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="<?=URI_NAME?>/panel/comments?status=0">
                    <span><?=tts['comments']?></span>
                    <?= $results['comments'] ?>
                  </a>
                </li>

                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="<?=URI_NAME?>/panel/accounts">
                    <span><?=tts['pending_users']?></span>
                    <?= $results['users'] ?>
                  </a>
                </li>


                <li class="flex">
                  <a class="inline-flex items-center justify-between w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" href="<?=URI_NAME?>/panel/all-posts?state=Unlisted">
                    <span><?=tts['pending_posts']?></span>
                    <?= $results['posts'] ?>
                  </a>
                </li>
              </ul>
            </template>
          </li>