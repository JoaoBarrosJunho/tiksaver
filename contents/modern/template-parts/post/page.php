<?php
include_once THEME_CLASSES.'/post.php';
?>

<div class="flex flex-col <?=bodyStyle()?>">
<!-- Breadcrumbs -->
<?php !getOption('show-breadcrumbs')?include_once THEME_ROOT.'/template-parts/post/breadcrumbs-page.php' : null; ?>
<!-- Breadcrumbs -->

<!-- Post Title area -->
<div class="flex items-center  mt-6 mb-4">
<h1 class="text-gray-800 font-semibold text-2xl dark:text-gray-100 <?=getOption('h1_font')?>"><?=$post->post_title?></h1>
</div>
<!-- Post Title area -->

<!--Post content area-->
<article class="content-styling dark:text-gray-200 content-area">
<?= $post->post_content?htmlspecialchars_decode($post->post_content):$post->post_content; ?>
</article>
<!--Post content area-->

</div>


<?php !getOption('view-count')?addView($post->id):null ?>