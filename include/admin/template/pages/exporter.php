<?php

use App\login\user;

?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="flex gap-3 items-center my-6  text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>






        <!--Menu management area-->
        <div class="grid  gap-6 px-4 py-3 mb-8 bg-white shadow-md rounded-lg   dark:bg-gray-800 dark:text-gray-200">



            <div class="flex flex-col xl:col-span-3  gap-6 w-full h-full px-5 py-4 items-center  ">

                <form id="export" method="POST" class="flex flex-col items-center justify-center gap-3 w-full max-w-xl mx-auto text-xs">

                <div class="flex items-center gap-3 w-full">
                <label class="w-full">
                        <span class="text-sm"><?= tts['date_start'] ?></span>
                        <input type="datetime-local"  id="datei" class="<?=style['input-text']?>">
                    </label>
                    <label class="w-full">
                        <span class="text-sm"><?= tts['date_end'] ?></span>
                        <input type="datetime-local"  id="datef" class="<?=style['input-text']?>">
                    </label>
                </div>
                    

                    <label class="w-full">
                        <span class="text-sm"><?= tts['type'] ?></span>

                        <select  id="type" class="w-full <?= style['select'] ?>">
                            <option value="all">All</option>
                            <option value="article"><?=tts['articles']?></option>
                            <option value="page"><?=tts['pages']?></option>
                            <option value="attachment"><?=tts['attachments']?></option>
                        </select>
                    </label>

                    <label class="w-full">
                        <span class="text-sm"><?= tts['visibility'] ?></span>

                        <select name="status" id="status" class="w-full <?= style['select'] ?>">
                        <option value="">All</option>
                            <option value="public"><?= tts['public'] ?></option>
                            <option value="private"><?= tts['private'] ?></option>
                            <option value="unlisted"><?= tts['unlisted'] ?></option>
                        </select>
                    </label>

                    

                    <label class="w-full">
                        <button  data-label="<?= tts['export'] ?>" class="uppercase <?= style['btn-purple'] ?>"><?= tts['export'] ?></button>
                    </label>

                    <div class="w-full flex-col gap-3 status-area">
                </div>
                </form>
                

            </div>

        </div>
        <!--Menu management area-->
    </div>
</main>


<script>
    const export_form = document.getElementById("export");
    const myDir ='<?=URI_NAME?>';
    export_form.addEventListener("submit",(e)=>{
        e.preventDefault();
        window.location = myDir+`/export.json?type=${$("#type").val()}&status=${$("#status").val()}&datei=${$("#datei").val()}&datef=${$("#datef").val()}`
    });
</script>