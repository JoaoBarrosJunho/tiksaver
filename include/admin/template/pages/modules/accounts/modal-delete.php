<!-- Modal Delete-->
<div class="modal fade" id="deleteAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
            <div class="modal-header">
              <h5 class="modal-title fs-5" id="staticBackdropLabel"><?=tts['delete_user_account']?></h5>
              <button type="button" class="text-xl dark:text-gray-100 dark:border-gray-600 dark:bg-gray-700" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-x'></i></button>
            </div>
            <div class="modal-body">
              <p class="text-sm text-gray-700 dark:text-gray-400">
                <?=tts['delete_account_alert']?>
              </p>
              <input type="hidden" id="user_to_delete">
            </div>
            <div class="modal-footer">
              <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?=tts['cancel']?></button>
              <button id="deletebutton" aria-label="<?=tts['continue']?>" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple"><?=tts['continue']?></button>
            </div>
          </div>
        </div>
      </div>