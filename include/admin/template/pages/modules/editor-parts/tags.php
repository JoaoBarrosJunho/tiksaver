<!--Tags area-->
<div class="w-full mt-4 bg-gray-100 rounded-lg px-4 py-4 dark:bg-gray-800 ">
    <div class="mb-4 w-full rounded-lg " id="title-label"><b><?= tts['tags']?></b></div>
    <div class="w-full mt-4 py-5">
        <input type="text" value="<?= data($data, 'tags') ?>" id="post_tags" name="post_tags" class="<?= style['input-text'] ?>" placeholder="<?= tts['separate_with_commas']?>">
    </div>
</div>
<!--Tags area-->