<?php

use App\classes\black_list;
use App\classes\leemclasses;
use App\classes\tk_video;
use App\login\user;




if (isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])) {
    leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page']) ? 1 : $_GET['page'];

/**FILTER TABLE START*/
$colletions = null;

if (isset($_GET['s'])) {
    $colletions[] = 'video_data LIKE "%' . $_GET['s'] . '%"';
}

if (isset($_GET['date_in'], $_GET['date_fin']) && !empty($_GET['date_fin'])  && !empty($_GET['date_in'])) {
    $date_in = (new DateTime($_GET['date_in']))->format('Y-m-d H:i:s');
    $date_fin = (new DateTime($_GET['date_fin']))->format('Y-m-d H:i:s');
    $colletions[] = 'created BETWEEN "' . $date_in . '" AND "' . $date_fin . '"';
}




$where = $colletions ? implode(" AND ", $colletions) : null;
/**FILTER TABLE START*/
$offset = (new leemclasses())->getOffset($page, $num_of_registers);
$posts = tk_video::find($where, 'id DESC', $num_of_registers . ' OFFSET ' . $offset);
$table = '';
$imputs = '';





function delecteAction($id)
{
    $html = "<a onclick='deleteVideoLog($id,event)' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
    <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
    <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
    </svg>
    </a>";

    return user::isAdmin() ? $html : '';
}

//START -> CREAT LINES OF DATA TABLE 
foreach ($posts as $data) {

    $video_data = json_decode($data->video_data);


    $title = substr($video_data->title, 0, 35);

    $created = leemclasses::dateFormat($data->created, leemclasses::getDateFormat());
    
    $ip_shorten = strlen($data->user_ip) > 20 ? substr($data->user_ip, 0, 20) . "..." : $data->user_ip;

    $block_action = !black_list::check($data->user_ip) ?            "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Block $data->user_ip' onclick='blockIP(`$data->user_ip`)'>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' />
 </svg>
  </button>" : "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Unlock $data->user_ip' onclick='unblockIP(`$data->user_ip`)'>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' />
</svg>

  </button>";

    $table .= "<tr class='text-gray-700 dark:text-gray-400' id='tr_$data->id'>
    <td class='px-4 py-3 text-sm font-semibold'><img src='$data->video_cover' class='w-8 h-8 object-cover rounded-md'></td>
<td class='px-4 py-3 text-sm font-semibold'><a href='$video_data->url' target='blank'>$title</a></td>
    <td class='px-4 py-3 text-sm hover:pointer user_ip' data-short='$ip_shorten' data-show='0' data-ip='$data->user_ip' title='$data->user_ip'>$ip_shorten</td>
            
            <td class='px-4 py-3 text-sm created'>$created</td>
            <td class='px-4 py-3'>

            
            <div class='flex items-center space-x-4 text-sm'>
            $block_action
            " . delecteAction($data->id) . "
            </span>
            </div>
            </td>
           
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE