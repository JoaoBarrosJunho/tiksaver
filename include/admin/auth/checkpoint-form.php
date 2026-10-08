<?php
use App\login\auth;
use App\classes\leemclasses;
?>
<div class="w-full h-screen flex py-4 flex-col items-center justify-center gap-6">

<div class="flex w-full justify-center">
<span class="text-xl font-inter uppercase"> <?=leemclasses::option('site_title')?></span>
</div>

<form class="Myform w-full" id="FormCheckPoint">
  <p class="text-sm"> <?=tts['we_send_a_code_to_email']?> <span class="font-semibold"><?=auth::vT('email')?></span></p>
  
    <input placeholder="****" class="block w-full mt-2 text-md dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" style="text-align:center;" required type="text" name="code" id="code">
    
  
    <button class="btnsub" id="BtnCheckpoint" type="submit">
  <?=tts['submit']?>
  </button>

  <p class="signup-link" id="newcode" style="cursor:pointer;display:none">
<?= tts['generate_new_code']?>
  </p>
  </form>

</div>