<?php


include_once THEME_CLASSES . '/post.php';


include_once 'home/downloader_section.php';
?>



<div class="w-full grid  gap-6">


    
    

    <?php if (!isset($_GET['s']) && !isset($router_response['page'])) {
        include_once 'modules/home.php';
    } ?>




</div>


<script src="<?= THEME_URI ?>/assets/js/video-actions.js"></script>

<?php addView(0)?>
