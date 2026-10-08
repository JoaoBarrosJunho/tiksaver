<?php

use App\api\onesignal;

$onsignal = (new onesignal())->getData();
?>
<!--Notify area-->
<div class="w-full mt-4 bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800 ">
<div class="mb-4 w-full rounded-lg " id="title-label"><b><?= tts['notification']?></b></div>
    <div class="flex flex-col">
        <div class="cl-toggle-switch flex gap-3 py-2 items-center">
            <label class="cl-switch hover:pointer">
                <input type="checkbox"  onclick="setToogleValue('notify_subs')" <?= ($onsignal->options->status ?? null) ? 'checked' : 'disabled' ?>>
                <span></span>
            </label>
            <span class="text-sm font-semibold"><?= tts['notify_subs'] ?></span>
            <input type="hidden" name="notify_subs" id="notify_subs" value="<?= $onsignal->options->status ?? 0 ?>">
        </div>

        <a href="<?=URI_NAME?>/panel/onesignal-settings" class="text-xs text-purple-600 underline"><?=tts["onesignal_settings"]?></a>
    </div>
</div>
<!--Notify area-->