<?php

use App\api\recaptcha;
use App\classes\leemclasses;
?>

<div class="w-full h-screen flex py-4 flex-col items-center justify-center gap-6">

<div class="flex w-full justify-center">
<span class="text-xl font-inter uppercase"> <?=leemclasses::option('site_title')?></span>
</div>


<form class="Myform w-full" id="frmSignup">
<p class="flex justify-center text-sm"><?=tts['create_new_account']?></p>
 <div class="input-container">
   <input placeholder="<?=tts['name']?>" type="text" class="md-nw-content"  name="name" id="name">
</div>
<div class="input-container">
   <input placeholder="<?=tts['email']?>" type="email" class="md-nw-content" name="email" id="email">
</div>
<div class="input-container">
   <input placeholder="<?=tts['password']?>" type="password" class="md-nw-content" name="password" id="password">
 </div>
 <?=recaptcha::getRecaptcha('rcp_signup')?>
  <button class="btnsub"  type="submit">
 <?=tts['submit']?>
</button>

<p class="signup-link">
<?= tts['already_have_acount']?>
 <a href="<?= URI_NAME?>/login"><?= tts['sign_in']?></a>
</p>
<div class="flex mt-6 text-sm">
                <label class="flex items-center dark:text-gray-400">
                  <span class="ml-2">
                  <?= tts['by_proceeding_agree_to_our']?>
                    <a href="<?=leemclasses::option('privacy_policy_page')?>" class="underline"><?=tts['privacy_policy']?></a>
                  </span>
                </label>
              </div>
</form>

</div>