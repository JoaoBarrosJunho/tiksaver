<?php
use App\classes\leemclasses;
use App\classes\pagination;
use App\classes\post;
use App\classes\previews;
use App\login\user;

if(isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])){
leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page'])?1:$_GET['page'];

/**FILTER TABLE START*/

$date = isset($_GET['datePublished']) && !empty($_GET['datePublished'])?" AND post_date LIKE '%".(new DateTime($_GET['datePublished']))->format('Y-m-d')."%' ":'';
$search = isset($_GET['search']) && !empty($_GET['search'])?$_GET['search']:'';
$whereSearch = is_numeric($search) ? " AND id LIKE '%$search%' ": " AND post_title LIKE '%$search%' AND post_slug LIKE '%$search%' ";

$type = isset($_GET['type']) ? $_GET['type']:'';
$attachment_type = !empty($type)?" AND post_att_type LIKE '%$type%' ":' ';


$where = "post_type = 'attachment' $date $whereSearch $attachment_type";

/**FILTER TABLE START*/

$offset =(new leemclasses())->getOffset($page,$num_of_registers);
$posts = post::selectPost("$where",$num_of_registers.' OFFSET '.$offset,'id DESC','id,post_title,post_date,post_guid,post_att_type');


$table ='';
$imputs='';

//START -> CREAT LINES OF DATA TABLE 
foreach($posts as $data){
    
$id = $data->id;
$edit_dir = URI_NAME."/panel/new-post?edit=$id";


//ATTACHMENT THUMB


$type_attachment = explode('/',$data->post_att_type);
switch($type_attachment[0]){
    case 'image':
        if(!$data->post_guid){
            $postThumb = previews::get($type_attachment[0]);
        }else{
            $postThumb = $data->post_guid;
        }   
    break;
    default:
    $postThumb = previews::get($type_attachment[0]);
    break;

}





$date = (new DateTime("$data->post_date"))->format(leemclasses::getDateFormat());
$delete_button = user::isAdmin()?" <a data-bs-toggle='modal' data-bs-target='#deleteAlert' onclick='dlPost($data->id)' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
            </svg>
            </a>":null;

$table.="<tr class='text-gray-700 dark:text-gray-400' id='tr_$data->id'>
            <td class='px-4 py-3'><div class='flex items-center text-sm w-12 h-12'><img src='$postThumb' class='w-full h-full rounded-md'/>
            </div></td>
            <td class='px-4 py-3 text-sm'>$data->post_title</td>
            <td class='px-4 py-3 text-sm'>$data->post_att_type</td>
            <td class='px-4 py-3 text-xs'>$date</td>
            <td class='px-4 py-3'>

            <div class='flex items-center space-x-4 text-sm'>
            <a  onclick='copyPemalink(\"$data->post_guid\")'  class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            
            <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
            <path stroke-linecap='round' stroke-linejoin='round' d='M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244' />
            </svg>


            </a>

            <a onclick='editAttachment($data->id)' data-bs-toggle='modal' data-bs-target='#EditAttachment' class='flex items-center justify-between hover:pointer px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' >
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
            </svg>
            </a> 
            
           $delete_button</td>
            </div>
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE


?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE." (".post::countPosts('post_type="attachment"').")" ?></h2>

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
<!--Apply filter END-->

<!--Table Posts-->
<div class="w-full mb-4 overflow-hidden <?=style["bg"]?>">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left  
        uppercase border-b dark:border-gray-700 ">
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3"><?=tts['title']?></th>
                        <th class="px-4 py-3"><?=tts['type']?></th>
                        <th class="px-4 py-3"><?=tts['uploaded']?></th>
                        <th class="px-4 py-3"><?=tts['actions']?></th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700 dark:bg-gray-800">
                <?= $table ?>
                </tbody>
            </table>
        </div>

<!--Pagination START-->
<!--Pagination HTML Result-->

<?=(new pagination('/panel/attachments',$page,'posts',$num_of_registers,$where))->getPagination()?>

<?php include_once 'modules/number-registers.php'?>
</div>
<!--Table Posts-->
    
    </div>
</main>

<!-- Modal Delete-->
<div class="modal fade" id="deleteAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAlert" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-lg dark:bg-gray-800 dark:text-gray-400">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel"><?=tts['delete_attachment']?></h1>
        <button type="button" class="btn-close dark:text-gray-400" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id-post-delete" id="id-post-delete">
      <p class="text-sm text-gray-700 dark:text-gray-400">
      <?=tts['delete_attachment_alert']?>
          </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?=tts['cancel']?></button>
        <button id="Okdelete" aria-label="Yes" class="w-full px-5 text-center py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple" ><?=tts['yes']?></button>
      </div>
    </div>
  </div>
</div>

<!-- EditAttachment Modal -->
<div class="modal right" class="text-sm" id="EditAttachment" tabindex="-1"  data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="rightModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md w-100">
                <div class="modal-content dark:bg-gray-800 dark:text-gray-400">
                    <div class="modal-header">
                    <h5 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200" id="rightModalLabel"><?=tts['edit_attachment']?></h5>
                    <button type="button" class="btn-close dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                        <div class="modal-body">
                        
                        <form id='formAttachment'>
                        
                        <label class="block">
                           <span><?=tts['title']?></span>
                           <input type="text" name="titleAttachment" id="titleAttachment" class="<?= style['input-text']?>">
                        </label>
                        <label class="block my-6">
                        <span><?=tts['description']?></span> 
                        <textarea name="descriptionAttachment" id="descriptionAttachment" cols="30" rows="10" class="<?= style['input-text']?>"></textarea>   
                        </label>
                        
                        <input type="hidden" name="idAttachment" id="idAttachment">
                        <input type="submit" id="sendForm" class="hidden">
                        </form>
                        
                        <label class="block">
                           <span><?=tts['permalink']?></span>
                           <span class="flex gap-3">
                           <input type="text" readonly  id="permalinkAttachment" class="<?= style['input-text']?> bg-gray-50">
                          <label> 
                        <button class="<?= style['btn-purple-np']?>"  id="copy-permalink">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184" />
                        </svg>

                        </button></label>
                           </span>
                           
                        </label>
                        </div>
                    
                    <div class="modal-footer">
                        <label>
                        <button type="button" class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray" data-bs-dismiss="modal"><?=tts['cancel']?></button>
                        </label>   
                    
                        <label>
                        <button id="saveAttachment" type="submit" aria-label="Submit" class="<?= style['btn-purple-np']?>" ><?=tts['submit']?></button>    
                        </label>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- End Right Modal -->


