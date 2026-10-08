<?php

use App\activities\views;
use App\classes\leemclasses;
use App\classes\metatags;
use App\classes\pagination;
use App\classes\post;
use App\classes\postmeta;
use App\login\user;


post::check_schedule();

if (isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])) {
    leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page']) ? 1 : $_GET['page'];

/**FILTER TABLE START*/
$state = isset($_GET['state']) && !empty($_GET['state']) ? " AND posts.post_visibility='" . $_GET['state'] . "'" : "";
$date = isset($_GET['datePublished']) && !empty($_GET['datePublished']) ? " AND posts.post_date BETWEEN '" . (new DateTime($_GET['datePublished']." 00:00:00"))->format('Y-m-d H:i:s') . "' AND '" . (new DateTime($_GET['datePublished']." 23:59:59"))->format('Y-m-d H:i:s') . "' " : '';
$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '';
$whereSearch = is_numeric($search) ? " AND posts.id LIKE '%$search%' " : " AND posts.post_title LIKE '%$search%' AND posts.post_slug LIKE '%$search%' ";

$categoryFilter = isset($_GET['categorie']) && !empty($_GET['categorie']) && is_numeric($_GET['categorie'])?$_GET['categorie']: null;



$where = "posts.post_type = 'article' $state $date $whereSearch";

/**FILTER TABLE START*/


$offset = (new leemclasses())->getOffset($page, $num_of_registers);
$fields =  'posts.id ,posts.post_title,posts.post_date,posts.post_guid,posts.post_author,posts.post_status';
$posts = $categoryFilter?post::selectPostsByCategory($categoryFilter,$where,'posts.id DESC',$num_of_registers . ' OFFSET ' . $offset,$fields): post::selectPost("$where", $num_of_registers . ' OFFSET ' . $offset,'posts.id DESC', $fields);
$results = $categoryFilter?post::selectPostsByCategory($categoryFilter,$where,null,null, "COUNT(posts.id) as results"): post::selectPost("$where", null,null, "COUNT(posts.id) as results");

$table = '';
$imputs = '';



function delecteAction($id)
{
    $html = "<a data-bs-toggle='modal' data-bs-target='#deleteAlert' onclick='dlPost($id)' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
    <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
    <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
    </svg>
    </a>";
    return user::isAdmin() ? $html : '';
}

//START -> CREAT LINES OF DATA TABLE 
foreach ($posts as $data) {

    $id = $data->id;
    $edit_dir = URI_NAME . "/panel/new-post?edit=$id";
    $delete_dir = URI_NAME . "/panel/new-post?delete=$id";

    $isAI = postmeta::AIchecker($id) ? '<span class="flex items-center text-sm" title="Generated with ai"><span class="text-purple-600"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
</svg></span>Ai</span>' : '';


    //THUMB DOS POSTS
    $postThumb = postmeta::selectPostMeta("post_id='$id' AND meta_key='featured_img'", 'meta_value');
    if ($postThumb) {
        $postThumb = $postThumb[0]->meta_value;
    } else {
        $postThumb = URI_NAME . "/assets/media/no-image.png";
    }

    //CATEGORIA DOS POSTS
    $categoryes = postmeta::selectPostMeta("post_id='$id' AND meta_key='post_category'");
    $categoryesList = [];


    foreach ($categoryes as $c) {
        $catResult = metatags::selectMetaTags("id = '$c->meta_value'", 'name');
        $categoryesList[] = $catResult[0]->name;
    }



    $categoryes = implode(', ', $categoryesList);
    $views = views::get($id);
    $date = (new DateTime("$data->post_date"))->format(leemclasses::getDateFormat());
    $author = user::getData("id = $data->post_author", null, 1, 'name');
    $author = $author ? $author[0]->name : 'Null';
    $titlePost = substr($data->post_title, 0, 60);
    $titlePost = strlen($data->post_title) > 60 ? $titlePost . '...' : $titlePost;
    $post_status = isset(tts[strtolower($data->post_status)]) ? tts[strtolower($data->post_status)] : $data->post_status;
    $table .= "<tr class='text-gray-700 dark:text-gray-400' id='tr_$data->id'>
            <td class='px-4 py-3'><div class='flex items-center text-sm w-12 h-12'><img src='$postThumb' class='w-full h-full rounded-md'/> </div></td>
            <td class='px-4 py-3 text-sm'><div class='flex flex-col w-64'><a href='$edit_dir' class='font-semibold text-ellipsis hover:pointer'  title='$data->post_title'>$titlePost</a><span class='flex gap-3 items-center text-gray-500'> $isAI" . tts['status'] . ":$post_status, " . tts['author'] . ": $author</span></div></td>
            <td class='px-4 py-3 text-sm'>$categoryes</td>
            <td class='px-4 py-3 text-xs'>$date</td>
            <td class='px-4 py-3 text-xs'>$views</td>
            <td class='px-4 py-3'>

            <div class='flex items-center space-x-4 text-sm'>
            <a href='$data->post_guid' target='_blank'  class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 25 25' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418' />
            </svg>

            </a>

            <a href='$edit_dir' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' >
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
            </svg>
            </a> 
            " . delecteAction($data->id) . "
            </td>
            </div>
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE


?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 flex gap-3 items-center"><?= $TITLE . " (" . post::countPosts('post_type="article"') . ")" ?> <a href="<?= URI_NAME ?>/panel/new-post" class="<?= style['btn-purple-outline'] ?>"><?= tts['add_new'] ?></a></h2>

        <!-- Start search-->
        <form action="" method="GET" class="flex gap-3 mb-4 justify-end">
            <label>
                <input type="search" name="search" id="search" class="<?= style['input-text'] ?>" value="<?php if (isset($_GET['search']) && !empty($_GET['search'])) {
                                                                                                            echo $_GET['search'];
                                                                                                        } ?>" placeholder="Id, Title, Excerpt...">

            </label>
            <label>
                <button type="submit" class="<?= style['btn-purple-np'] ?>"><?= tts['search'] ?></button>
            </label>
        </form>
        <!-- End search-->

        <!--Apply filter-->
        <form action="" method="GET">
            <div class="flex flex-wrap gap-3 w-full bg-white py-4 px-2 rounded-lg shadow-md mb-4 text-sm dark:text-gray-400 dark:bg-gray-800">
                <span>
                    <select name="categorie" id="category-filter" class="<?= style['input-text'] ?> form-select hover:pointer">
                        <option value=""><?= tts['all_categoryes'] ?></option>

                        <?php
                        //filtro por categoria
                        $getCategoryes = metatags::selectMetaTags("type='category'", 'id,name');


                        foreach ($getCategoryes as $c) {
                            $selected = isset($_GET['categorie']) && $_GET['categorie'] == $c->id ? 'selected' : '';
                            echo "<option value='$c->id' $selected>$c->name</option>";
                        }
                        ?>
                    </select>
                </span>

                <span>
                    <select name="state" id="state" class="<?= style['input-text'] ?> form-select hover:pointer">
                        <option value=""><?= tts['all_states'] ?></option>

                        <option value="Public" <?php if (isset($_GET['state']) && $_GET['state'] == 'Public') {
                                                    echo 'selected';
                                                } ?>>
                            <?= tts['public'] ?>
                        </option>

                        <option value="Unlisted" <?php if (isset($_GET['state']) && $_GET['state'] == 'Unlisted') {
                                                        echo 'selected';
                                                    } ?>>
                            <?= tts['unlisted'] ?>
                        </option>

                        <option value="Private" <?php if (isset($_GET['state']) && $_GET['state'] == 'Private') {
                                                    echo 'selected';
                                                } ?>>
                            <?= tts['private'] ?>
                        </option>
                    </select>
                </span>

                <span>
                    <input type="date" name="datePublished" id="datePublished" class="<?= style['input-text'] ?>" value="<?php if (isset($_GET['datePublished']) && !empty($_GET['datePublished'])) {
                                                                                                                            print (new DateTime($_GET['datePublished']))->format('Y-m-d');
                                                                                                                        } ?>">
                </span>

                <span>
                    <button type="submit" class="<?= style['btn-purple-np'] ?>"><?= tts['apply_filter'] ?></button>
                </span>
            </div>
        </form>
        <!--Apply filter END-->

        <!--Table Posts-->
        <div class="w-full mb-4 overflow-hidden <?=style["bg"]?>">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 
        uppercase border-b dark:border-gray-700 ">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3"><?= tts['title'] ?></th>
                            <th class="px-4 py-3"><?= tts['categories'] ?></th>
                            <th class="px-4 py-3"><?= tts['date'] ?></th>
                            <th class="px-4 py-3"><?= tts['views'] ?></th>
                            <th class="px-4 py-3"><?= tts['actions'] ?></th>
                        </tr>
                    </thead>
                    <tbody class=" divide-y dark:divide-gray-700 ">
                        <?= $table ?>
                    </tbody>
                </table>
            </div>

            <!--Pagination START-->
            
            <!--Pagination HTML Result-->

            <?= (new pagination('/panel/all-posts',$page,null,$num_of_registers,$where,$results[0]->results))->getPagination() ?>

            <?php include_once 'modules/number-registers.php' ?>
        </div>
        <!--Table Posts-->

    </div>
</main>

<!-- Modal Delete-->
<div class="modal fade" id="deleteAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete post</h1>
                <button type="button" class="btn-close dark:text-gray-400" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id-post-delete" id="id-post-delete">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Are you sure you want to delete this post?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['cancel'] ?></button>
                <button id="Okdelete" aria-label="Yes" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple"><?= tts['yes'] ?></button>
            </div>
        </div>
    </div>
</div>