<div class="w-full mt-4 mb-4 <?= bodyStyle()?>">
    <?php
    
                                use App\classes\postmeta;

    include_once THEME_CLASSES . '/post-module.php';
    $related_grid = 'grid-c';
    $related_num_rows = getOption('related_rows')?getOption('related_rows'):4;
    
    $category = (new postmeta())->selectPostMeta("meta_key='post_category' AND post_id = $post->id");
    $category = $category? $category[0]->meta_value:null;
    show_list(tts_t['related_contents'],null,$related_num_rows,$related_grid,$category);
    ?>
</div>