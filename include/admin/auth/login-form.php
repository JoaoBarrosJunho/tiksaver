<?php

use App\api\recaptcha;
use App\classes\leemclasses;
?>
<div class="w-full h-screen flex py-4 px-4 flex-col items-center justify-center gap-6">



<div class="w-full flex md:col-span-2  max-w-2xl max-h-xl bg-white rounded-md shadow-md">
  <div style="width: 20rem;" class="hidden md:flex  h-full bg-purple-600 rounded-l-md">

  </div>

  <form class=" w-full rounded-l-md px-4 py-4  " id="Formlogin">
  <p class="flex justify-center text-sm"><?=tts['log_in_to_your_account']?></p>
  <div class="input-container">
    <input placeholder="<?= tts['email']?>" required type="email" name="email" id="email" autocomplete="email">
    <span>
      <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
      </svg>
    </span>
  </div>
  <div class="input-container">
    <input placeholder="<?= tts['password']?>" required type="password" name="password" id="password" autocomplete="current-password">

    <span>
      
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144l0 48-16 0c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l320 0c35.3 0 64-28.7 64-64l0-192c0-35.3-28.7-64-64-64l-240 0 0-48z"/></svg>
    </span>
  </div>
<?=recaptcha::getRecaptcha('rcp_login')?>
    <label class="flex px-2 gap-3 items-center hover:pointer">
    <input type="checkbox" name="remember_me" value="1">
    <span class="text-sm signup-link">Remember me</span>
  </label>
  
    <button class="btnsub mt-2" id="BtnLogin" type="submit">
  <?= tts['sign_in']?>
  </button>
  <p class="signup-link mb-4">
  <a href="<?= URI_NAME?>/recovery"><?= tts['forgot_password']?></a>
  </p>
  </form>

</div>



  </div>