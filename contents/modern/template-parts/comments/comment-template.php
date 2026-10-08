<?php

use App\api\recaptcha;

include_once THEME_CLASSES.'/grids.php';
include_once THEME_CLASSES.'/comments.php';

?>


<!-- Comments -->

<?php include_once THEME_ROOT.'/template-parts/comments/comments.php'?>


<!--New comment area-->
<?=newTitle(tts_t['write_a_comment'],'h3')?>
<form class="flex flex-col gap-6 py-2 px-2" id="commentForm" method="POST">
<?= userInfo()?>
<label class="w-full">
    <textarea name="comment" class="<?=style['input-text']?>" id="comment-area" cols="30" rows="4" placeholder="<?=tts_t['comment']?>..."></textarea>
</label>
<?=recaptcha::getRecaptcha('rcp_comment')?>
<label class="w-35">
    <button type="input" class="<?= theme_t['btn-primary']?>" aria-label="<?=tts_t['post_comment']?>" id="submit-comment"><?=tts_t['post_comment']?></button>
</label>
<span class="px-4" id="comment-alert"></span>
<input type="hidden" name="reply" value="0" id="reply">
<input type="hidden" name="comment-ref" value="<?=$post->id?>">

</form>
<script src="<?= THEME_URI?>/assets/js/functions/comments.js" defer></script>
