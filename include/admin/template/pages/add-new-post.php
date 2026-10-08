
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>
        <div class="w-full flex-col gap-3 status-area mb-4">
        </div>
        <?php 
        $post_type = 'article';
        include_once "modules/post-editor.php";
        ?>
       
    </div>
</main>