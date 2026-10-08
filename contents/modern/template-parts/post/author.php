<?php

use App\classes\dashboard;
use App\login\user;

//$totalArticles = dashboard::TotalArticles("post_author=$post->post_author");
$author = user::getData("id=$post->post_author");
$author = $author ? $author[0] : null;
?>
<div class="flex gap-3 mt-2 mb-4 w-full items-center justify-center py-2 px-2">
    <label>
        <img src="<?= user::getAvatar($author->id) ?>" class="w-5 rounded-full hvr-grow" alt="Profile picture of <?= $author->name ?>">
    </label>



    <div class="flex items-center gap-3 text-xs">
        <?= $author->name ?>
        <span>•</span>
        <div class="">
            <?php include_once 'terms.php'; ?>

        </div>
    </div>


</div>