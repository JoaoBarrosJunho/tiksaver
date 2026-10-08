<?php

use App\classes\leemclasses;
use App\classes\pagination;
use App\classes\post;
use App\login\user;

if (isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])) {
  leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page']) ? 1 : $_GET['page'];

/**FILTER TABLE START*/
$state = isset($_GET['state']) && !empty($_GET['state']) ? " AND post_visibility='" . $_GET['state'] . "'" : "";
$date = isset($_GET['datePublished']) && !empty($_GET['datePublished']) ? " AND post_date LIKE '%" . (new DateTime($_GET['datePublished']))->format('Y-m-d') . "%' " : '';
$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '';
$whereSearch = is_numeric($search) ? " AND id LIKE '%$search%' " : " AND post_title LIKE '%$search%' AND post_slug LIKE '%$search%' ";


$where = "post_type = 'page' $state $date $whereSearch";

/**FILTER TABLE START*/

$searchpage = isset($_GET['search']) ? '&search=' . $_GET['search'] : '';
$offset = (new leemclasses())->getOffset($page, $num_of_registers);
$posts = post::selectPost("$where", $num_of_registers . ' OFFSET ' . $offset, 'id DESC', 'id,post_title,post_date,post_date_update,post_visibility,post_guid');


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
  $edit_dir = URI_NAME . "/panel/new-page?edit=$id";

  $post_visibility = isset(tts[strtolower($data->post_visibility)]) ? tts[strtolower($data->post_visibility)] : $data->post_visibility;
  $date = (new DateTime("$data->post_date"))->format(leemclasses::getDateFormat());
  $update_date = (new DateTime("$data->post_date_update"))->format(leemclasses::getDateFormat());
  $table .= "<tr class='text-gray-700 dark:text-gray-400' id='tr_$data->id'>
            <td class='px-4 py-3 text-sm w-64'><a href='$edit_dir' class='text-ellipsis hover:pointer'>$data->post_title</a></td>
            <td class='px-4 py-3 text-sm'>$post_visibility</td>
            <td class='px-4 py-3 text-xs'>$date</td>
            <td class='px-4 py-3 text-xs'>$update_date</td>
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
            
            " . delecteAction($data->id) . "</td>
            </div>
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE


?>

<main class="h-full overflow-y-auto">
  <div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 flex gap-3 items-center"><?= $TITLE . " (" . post::countPosts('post_type="page"') . ")" ?><a href="<?= URI_NAME ?>/panel/new-page" class="<?= style['btn-purple-outline'] ?>"><?= tts['add_new'] ?></a></h2>

    <div class="grid  items-center gap-6 mb-6" x-data="{showFilter:false}">
      <div class="flex items-center gap-3">
        <form action="" class="flex items-center gap-3">
          <input type="search" name="search" class="<?= style["input-text"] ?>" value="<?= $_GET['search'] ?? null ?>" placeholder="Search here...">
          <label>
            <button id="add-server" class="<?= style['btn-purple-np'] ?>">Search</button>
          </label>
        </form>

        <label>
          <button id="add-server" @click="showFilter = !showFilter" class="<?= style['btn-purple-np'] ?>">
            <span x-show="!showFilter" class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
              </svg>

              Filter</span>
            <span x-show="showFilter" class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
              </svg>
              Close</span>
          </button>
        </label>


      </div>

      <form x-show="showFilter" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="grid xl:grid-cols-4 items-center gap-3 md:col-span-2">
        <select name="state" id="state" class="<?= style['select'] ?>">
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

          <option value="Private"
            <?php if (isset($_GET['state']) && $_GET['state'] == 'Private') {
              echo 'selected';
            } ?>>
            <?= tts['private'] ?>
          </option>
        </select>
        <input type="date" title="Published" name="datePublished" id="datePublished" class="<?= style['input-text'] ?>"
          value="<?php if (isset($_GET['datePublished']) && !empty($_GET['datePublished'])) {
                    print (new DateTime($_GET['datePublished']))->format('Y-m-d');
                  } ?>">
        <label>
          <button id="add-server" class="<?= style['btn-purple-np'] ?>">Apply</button>
        </label>
      </form>


    </div>



    <!--Table Posts-->
    <div class="w-full mb-4 overflow-hidden <?= style["bg"] ?>">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left  
        uppercase border-b dark:border-gray-700  ">
              <th class="px-4 py-3"><?= tts['title'] ?></th>
              <th class="px-4 py-3"><?= tts['visibility'] ?></th>
              <th class="px-4 py-3"><?= tts['published'] ?></th>
              <th class="px-4 py-3"><?= tts['updated'] ?></th>
              <th class="px-4 py-3"><?= tts['actions'] ?></th>
            </tr>
          </thead>
          <tbody class=" divide-y dark:divide-gray-700 ">
            <?= $table ?>
          </tbody>
        </table>
      </div>

      <!--Pagination START-->
      <?= (new pagination('/panel/pages', $page, 'posts', $num_of_registers, $where))->getPagination() ?>
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
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete page</h1>
        <button type="button" class="btn-close dark:text-gray-400" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id-post-delete" id="id-post-delete">
        <p class="text-sm text-gray-700 dark:text-gray-400">
          Are you sure you want to delete this Page?
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?= tts['cancel'] ?></button>
        <button id="Okdelete" aria-label="Yes" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple"><?= tts['yes'] ?></button>
      </div>
    </div>
  </div>
</div>