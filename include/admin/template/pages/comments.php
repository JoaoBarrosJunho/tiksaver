<?php
use App\classes\comment;
use App\classes\leemclasses;
use App\classes\pagination;
use App\classes\post;
use App\login\user;



function countComments($status = null){
  $status = is_numeric($status)?"status=$status":null;
  $response = comment::select($status,null,null," COUNT(id) AS Total ");
  return $response[0]? $response[0]->Total:0;
}

if(isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])){
leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}


$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page'])?1:$_GET['page'];

/**FILTER TABLE START*/
$withID = isset($_GET['search']) && is_numeric($_GET['search']) ? " id LIKE '%".$_GET['search']."%'":'';
$WithName = isset($_GET['search']) && !empty($_GET['search'])?" author_name LIKE '%".$_GET['search']."%' OR author_email LIKE '%".$_GET['search']."%' ":'';
$search = isset($_GET['search'])  && !is_numeric($_GET['search'])? $WithName: $withID;

$where = $search;
$status = isset($_GET['status'])?"status = '".$_GET['status']."'":'';
/**FILTER TABLE START*/

$searchpage = isset($_GET['search'])?'&search='.$_GET['search']:'';
$statushpage = isset($_GET['status'])?'&status='.$_GET['status']:'';
$offset =(new leemclasses())->getOffset($page,$num_of_registers);
$comments = comment::select($where.$status,'id DESC',$num_of_registers.' OFFSET '.$offset);


$table ='';
$imputs='';
$date_format = leemclasses::getDateFormat();

function delecteAction($id){
    $html="<a  title='delete'  onclick='deletecomment($id)' class='flex items-center justify-between px-2 py-2  leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
    <i class='bx bxs-trash'></i>
    </a>";
    
    return user::isAdmin()?$html:'';
  }
//START -> CREAT LINES OF DATA TABLE 
foreach($comments as $data){
    
$id = $data->id;
$post = post::selectPost("id='$data->post_id'",null,null,'post_title,post_guid');

$post = $post?"<a href='".$post[0]->post_guid."' class=' flex gap-3 items-center' target='_blank'><span class='underline' title='".$post[0]->post_title."'></span><i class='bx bx-link-external'></i></a>":'Not found';
$datastatus = $data->status != 1?"<span class='bg-orange-100 dark:text-gray-100 dark:bg-orange-500 py-2 px-2 rounded-full' id='status_$data->id'>Pending</span>":"<span class='bg-green-100 dark:text-gray-100 dark:bg-green-500 py-2 px-2 rounded-full' id='status_$data->id'>Approved</span>";

$actions = $data->status !=1?"<a onclick='approvecomment($data->id)' title='Approve' class='flex items-center justify-between hover:pointer px-2 py-2   leading-5 text-green-500 rounded-lg dark:text-green-400 focus:outline-none focus:shadow-outline-gray' >
<i class='bx bxs-message-check'></i>
</a> 

".delecteAction($data->id)."":
"
<a  title='Occult'  onclick='occultcomment($data->id)' class='flex items-center justify-between px-2 py-2   leading-5 text-orange-500 hover:pointer rounded-lg dark:text-orange-100 focus:outline-none focus:shadow-outline-gray'>
<i class='bx bxs-message-minus'></i>
</a>

".delecteAction($data->id)."

";
$date = (new DateTime("$data->comment_date"))->format($date_format);
$table.="<tr class='text-gray-700 dark:text-gray-400' id='tr_$data->id'>
            <td class='px-4 py-3 text-sm' id='td_author_$data->id'><div class='flex flex-col'><span class='font-semibold'>$data->author_name</span><span class='text-gray-400 text-xs'>$data->author_email</span></div></td>
            <td class='px-4 py-3 text-sm w-64 word-wrap whitespace-wrap' >$data->comment</td>
            <td class='px-4 py-3 text-sm'>$date</td>
            <td class='px-4 py-3 text-sm' id='td_post_$data->id'>$post</td>
            <td class='px-4 py-3 text-sm'>$datastatus</td>
            <td class='px-4 py-3'>

            <div class='flex items-center space-x-4 text-lg' id='actions_$data->id'>
            $actions</div></td>
            
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE


?>

<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-100 "><?= $TITLE ?></h2>

    <div class="flex gap-3">
        <label class="w-56 whitespace-no-wrap">
            <a class="<?= style['btn-purple-np']?>" href="<?= URI_NAME."/panel/comments"?>"  ><?= tts['all_comments']?>(<?= countComments()?>)</a>
        </label>
        <label class="w-64 whitespace-no-wrap">
            <a class="<?= style['btn-red-outline']?> " href="<?= URI_NAME."/panel/comments?status=0"?>"  ><?= tts['need_approval']?>(<?= countComments("0")?>)</a>
        </label>
        <label class="w-64">
            <button class="<?= style['btn-purple-outline']?>" onclick="approveAll()"  ><?= tts['approval_all']?></button>
        </label>

        <label class="w-full">
            <!-- Start search-->
            <form action="" method="GET" class="flex gap-3 mb-4 justify-end">
            <label>
                <input type="search" name="search" id="search" class="<?= style['input-text']?>" value="<?php if(isset($_GET['search']) && !empty($_GET['search'])){echo $_GET['search'];}?>" placeholder="Enter id, name">
                
            </label>
            <label>
            <button type="submit" class="<?= style['btn-purple-np']?>"><?= tts['search']?></button>
            </label>
            </form>
            <!-- End search--> 

    </label>
    </div>
        
<!--Table Posts-->
<div class="w-full mb-4 overflow-hidden rounded-lg shadow-md">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 
        uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3"><?= tts['author']?></th>
                        <th class="px-4 py-3" ><?= tts['comment']?></th>
                        <th class="px-4 py-3"><?= tts['date']?></th>
                        <th class="px-4 py-3"><?= tts['link']?></th>
                        <th class="px-4 py-3"><?= tts['status']?></th>
                        <th class="px-4 py-3"><?= tts['actions']?></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <?= $table ?>
                </tbody>
            </table>
        </div>

<!--Pagination START-->
<?=(new pagination('/panel/comments',$page,'comments',$num_of_registers,$where))->getPagination()?>

<?php include_once 'modules/number-registers.php'?>
</div>
<!--Table Posts-->
    
    </div>
</main>
<script src="<?=URI_NAME?>/assets/js/functions/comments.js" defer></script>