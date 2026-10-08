<?php

use App\classes\leemclasses;

include_once 'modules/genius/configs.php';
require_once 'general-settings/update-integrations.php';

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>

        <form action="" method="POST">
            <div class="flex flex-col px-4 py-3 mb-8 <?=style["bg"]?>">
                <?php if ($_POST) {
                    echo leemclasses::notification($status);
                } ?>



                <!--Menu-->
                <div class="flex gap-3 w-full">
                    <label class="flex gap-3 bg-gray-50 dark:bg-gray-700 py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'email-settings')">Email/SMPT</label>
                    <label class="flex gap-3  py-2 px-4 hover:pointer btn-option" onclick="setPanelTemplate(event,'recaptcha-settings')">Recaptcha</label>
                </div>
                <!--Menu-->

                <!--Genius Template-->
                
                <?php include_once 'modules/integrations/email.php' ?>
                <?php include_once 'modules/integrations/recaptcha.php' ?>

                <!--Genius Template-->
                <div class="w-full ">
                    <button class="<?= style['btn'] ?>"><?= tts['submit'] ?></button>
                </div>
            </div>
        </form>
    </div>
</main>