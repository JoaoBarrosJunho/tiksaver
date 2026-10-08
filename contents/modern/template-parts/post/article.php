<?php

use App\login\user;

include_once THEME_CLASSES . '/post.php';
?>

 <!-- Breadcrumbs -->
 <?php !getOption('show_breadcrumbs')?include_once THEME_ROOT.'/template-parts/post/breadcrumbs-article.php' : null; ?>
<!-- Breadcrumbs -->
    


<div class="w-full max-w-4xl mx-auto grid  gap-6">

<div class="w-full grid">
<!-- Post Title area -->
<div class="flex justify-center gap-2  px-2">
        <h1 class="<?= theme_t['heading']?> uppercase text-gray-800  dark:text-gray-100 "><?= $post->post_title ?> </h1>
        <?php if(user::logged('id') && user::logged('id')==$post->post_author){include_once 'edit-button.php';}?>
    </div>
    <!-- Post Title area -->

    

    <?php include_once 'author.php'?>
</div>

   

<div class="w-full ">
    <!-- Post Featured Image -->
    <?php $featuredImage = ArticlefeaturedImage($post->id); $featuredImage? include_once 'featured-image.php' :null ?>
    <!-- Post Featured Image -->

   
<div class="flex flex-col <?= bodyStyle()?>">
    

    

    <!--Post content area-->
    <article class="w-full mt-4 content-styling dark:text-gray-200 content-area">
        <?= $post->post_content?htmlspecialchars_decode($post->post_content):$post->post_content; ?>
    </article>
    <!--Post content area-->

    

    <!--Post tags area-->
   <?php !getOption('show_posttags')?include_once 'tags.php' :null ?>
    <!--Post tags area-->

    <?php  !getOption('show_sharebuttons')?include_once 'share-buttons.php' :null ?>
</div>


<!--Related articles-->
<?php !getOption('show_relatedcontents')?include_once THEME_ROOT.'/template-parts/post/related-content.php' :null ?>
<!--Related articles-->


</div>


</div>

<?php addView($post->id) ?>