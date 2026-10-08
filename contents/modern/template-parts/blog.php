<?php

use App\classes\postmeta;

use App\classes\blog_pagination;
use App\classes\leemclasses;


include_once THEME_CLASSES . '/post.php';

?>




<main class="container mt-12 p-4">


    <section class="mb-24">

        <div class="w-full mx-auto max-w-6xl flex flex-col gap-3 mt-4 mb-4 ">



            <label class="flex gap-3 items-center justify-center mt-10">
                <h2 class="text-6xl font-bold  mb-4">Blog</h2>
            </label>


            <div class="w-full grid md:grid-cols-2 gap-6  text-white rounded-md  py-4  px-2">




                <?php
                $results = 10;
                $page = $_GET['page'] ?? 1;
                $offset = (new leemclasses())->getOffset($page, $results);
                $OFFSET = $results . " OFFSET " . $offset;

                $all_posts = getArticles(null, "post_date DESC", $OFFSET);
                foreach ($all_posts as $post) {

                    $banner = postmeta::selectPostMeta("post_id=$post->id AND meta_key='featured_img'")[0]->meta_value ?? URI_NAME . "/assets/media/noimage.png";


                    $post_date = (new DateTime($post->post_date))->format('M d, Y');

                    print '<div class="w-full text-gray-700 dark:text-gray-100 rounded-md flex flex-col gap-3 py-2 px-2">
                <a href="' . $post->post_guid . '" style="max-height: 300px;" class="w-full h-full  border overflow-hidden rounded-md">
                    <img src="' . $banner . '" alt="' . $post->post_title . '" class="w-full h-full object-cover">
                </a>

                <a href="' . $post->post_guid . '" class="text-lg font-semibold">
                    ' . $post->post_title . '
                </a>

                <div class="flex gap-3  items-center text-xs">
                    <span>
                        ' . $post_date . '
                    </span>
                </div>

            </div>';
                }

                ?>
            </div>

            <div class="mt-8">
                <?= (new blog_pagination($_GET['page'] ?? 1, 'posts', $results, 'post_visibility="public" AND post_type="article"'))->getPagination() ?>
            </div>


        </div>
    </section>
    <script>

    </script>


</main>

<?php addView(0) ?>