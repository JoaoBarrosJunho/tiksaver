<?php
use App\login\user;
?>
<!-- Modal Add New -->
<div class="modal right" id="ModalNew" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="rightModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md w-100 ">
          <div class="modal-content dark:bg-gray-800 dark:text-gray-400">
            <div id="await-modal" class="hidden absolute flex items-center justify-center w-full h-full" style="z-index: 999; background:rgb(0, 0, 0,0.4);">
            <span class="text-sm text-white font-semibold"><i class='bx bx-loader-circle bx-spin' ></i> Wait...</span>
            </div>
            <div class="modal-header">
              <h5 class="my-4 text-xl font-semibold text-gray-700 dark:text-gray-200" id="rightModalLabel"><?= tts['manage_account'] ?> (<span id="manage_action">Add</span>)</h5>
              <button type="button" class="text-xl dark:text-gray-100 dark:border-gray-600 dark:bg-gray-700" onclick="CleanDataU()" data-bs-dismiss="modal" aria-label="Close"><i class='bx bx-x'></i></button>
            </div>

            <div class="modal-body">
              <form action="" id="FrmaddUser">
                <p class="w-full  text-lg font-semibold"><?= tts['user_info'] ?>:</p>
                <div class="input-container">
                  <input placeholder="Name" type="text" name="name" id="name" required class="md-nw-content text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div class="input-container">
                  <input placeholder="Email" type="email" name="email" id="email" required class="md-nw-content text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700">
                </div>
                <div class="input-container">
                  <input placeholder="Password" type="password" id="password" class="md-nw-content text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" name="password">
                </div>
                <br>



                <p class="w-full mt-2 text-lg font-semibold border-t"><?= tts['account_type'] ?>:</p>
                <div class="flex gap-3">
                  <label class="radio-button text-sm">
                    <input value="0" name="type" id="type" type="radio">
                    <span class="radio"></span>
                    <?= user::UserType(0) ?>
                  </label>

                  <label class="radio-button text-sm">
                    <input value="1" name="type" id="type" type="radio">
                    <span class="radio"></span>
                    <?= user::UserType(1) ?>
                  </label>

                  <label class="radio-button text-sm">
                    <input value="2" name="type" id="type" type="radio">
                    <span class="radio"></span>
                    <?= user::UserType(2) ?>
                  </label>
                </div>

                <p class="w-full mt-2 text-lg font-semibold border-t"><?= tts['account_status'] ?>:</p>

                <div class="flex gap-3">
                  <label class="radio-button text-sm">
                    <input value="1" name="status" id="status" type="radio">
                    <span class="radio"></span>
                    <?= tts['active'] ?>
                  </label>


                  <label class="radio-button text-sm">
                    <input value="0" name="status" id="status" type="radio">
                    <span class="radio"></span>
                    <?= tts['inactive'] ?>
                  </label>
                  <label class="radio-button text-sm">
                    <input value="2" name="status" id="status" type="radio">
                    <span class="radio"></span>
                    <?= tts['unverified'] ?>
                  </label>
                </div>
                <br>
                <input type="hidden" name="user_selected" id="user_selected">

                <div class="modal-footer">
                  <button class="btnsub" type="submit" id='BtnAddModal'>
                    <?= tts['submit'] ?>
                  </button>
                </div>

                
              </form>
            </div>


          </div>
        </div>
      </div>


      <!-- End Right Modal -->


