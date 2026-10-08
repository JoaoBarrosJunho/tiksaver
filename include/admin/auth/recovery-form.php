<?php
use App\classes\leemclasses;
?>
<div class="w-full h-screen flex py-4 flex-col items-center justify-center gap-6">

    <div class="flex w-full justify-center">
        <span class="text-xl font-inter uppercase"> <?= leemclasses::option('site_title') ?></span>
    </div>

    <form class="Myform w-full" id="formEmailRecoverCheck">
        <p class="flex justify-center text-sm"><?= tts['enter_your_account_email'] ?></p>
        <div class="input-container">
            <input placeholder="<?= tts['email'] ?>" required type="email" name="email">
            <span>
                <svg stroke="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                </svg>
            </span>
        </div>

        <button class="btnsub" id="BtnLogin" type="submit">
            <?= tts['submit'] ?>
        </button>

        <p class="signup-link">
            <?= tts['already_have_acount'] ?>
            <a href="<?= URI_NAME ?>/login"><?= tts['sign_in'] ?></a>
        </p>


    </form>

</div>