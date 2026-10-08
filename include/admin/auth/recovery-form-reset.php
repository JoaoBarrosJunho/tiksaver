<?php
use App\classes\leemclasses;
?>

<div class="w-full h-screen flex py-4 flex-col items-center justify-center gap-6">

    <div class="flex w-full justify-center">
        <span class="text-xl font-inter uppercase"> <?= leemclasses::option('site_title') ?></span>
    </div>

<form class="Myform" id="formRecovery">
  <p class="flex justify-center text-lg font-semibold"><?=tts['reset_password']?></p><br>
  <p class="flex justify-center text-sm"><?=tts['changing_account__email']?> <span class="font-semibold"><?=$TokenVerify['data']?></span></p>
  <div class="input-container">
    <input placeholder="<?= tts['new_password']?>" required autocomplete="new-password" type="password" name="password">
  </div>
  <div class="input-container">
    <input placeholder="<?=tts['repeat_password']?>" required autocomplete="off" type="password" name="password-repeat">
  </div>
  <input type="hidden" name="t" value="<?=$token?>">
    <button class="btnsub" id="BtnLogin" type="submit">
  <?=tts['submit']?>
  </button>



  
  </form>

</div>