
<div class="modal right" id="inboxModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="rightModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg w-100 ">
          <div class="modal-content dark:bg-gray-800 dark:text-gray-400">
            <div id="await-modal" class="hidden absolute flex items-center justify-center w-full h-full" style="z-index: 999; background:rgb(0, 0, 0,0.4);">
            <span class="text-sm text-white font-semibold"><i class='bx bx-loader-circle bx-spin' ></i> Wait...</span>
            </div>
            <div class="modal-header">
              <h5 class="my-4 text-xl font-semibold text-gray-700 dark:text-gray-200" id="rightModalLabel"><?= tts['inbox'] ?> (<span id="email_label">mail@g.com</span>)</h5>
              <button type="button" class="text-xl dark:text-gray-100 dark:border-gray-600 dark:bg-gray-700"  data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-x'></i></button>
            </div>

            <div class="modal-body" id="inbox-section">
                
            </div>


          </div>
        </div>
      </div>




