<?php

use App\classes\api_logs;
use App\classes\api_tokens;
use App\classes\leemclasses;
use App\http\webhooks\webhooks;
use App\login\user;


if (isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])) {
    leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page']) ? 1 : $_GET['page'];

$user = user::logged('id');
/**FILTER TABLE START*/
$where = "user_id=$user";

/**FILTER TABLE START*/
$offset = (new leemclasses())->getOffset($page, $num_of_registers);

$posts = api_tokens::select("$where", 'id DESC', $num_of_registers . ' OFFSET ' . $offset);



$table = '';



//START -> CREAT LINES OF DATA TABLE 
foreach ($posts as $data) {

    $id = $data->id;


    $icone = '<span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M336 352c97.2 0 176-78.8 176-176S433.2 0 336 0S160 78.8 160 176c0 18.7 2.9 36.8 8.3 53.7L7 391c-4.5 4.5-7 10.6-7 17l0 80c0 13.3 10.7 24 24 24l80 0c13.3 0 24-10.7 24-24l0-40 40 0c13.3 0 24-10.7 24-24l0-40 40 0c6.4 0 12.5-2.5 17-7l33.3-33.3c16.9 5.4 35 8.3 53.7 8.3zM376 96a40 40 0 1 1 0 80 40 40 0 1 1 0-80z"/></svg>
    </span>';

    $edit_icone = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>';
    $regenerate_icone = '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M105.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L386.3 160 352 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l111.5 0c0 0 0 0 0 0l.4 0c17.7 0 32-14.3 32-32l0-112c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 35.2L414.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C73.2 122 55.6 150.7 44.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM39 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1L16 432c0 17.7 14.3 32 32 32s32-14.3 32-32l0-35.1 17.6 17.5c0 0 0 0 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.8c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L125.6 352l34.4 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L48.4 288c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/></svg>';

    switch ($data->asLimited) {
        case 1:
          $status = '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
      >Active</span>';
          break;
        default:
          $status = '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"
      >Disabled</span>';
          break;
      }

    $requestsToday = api_logs::requestsToday($data->id);

    $token = substr($data->auth_token,0,20)."...";

    $table .= "<tr class='text-gray-700 dark:text-gray-400'  id='tr_$data->id'>
    <td class='px-4 py-3 text-sm'>$icone</td>
            <td class='px-4 py-3 text-sm'>$data->api_name</td>
            <td class='px-4 py-3 text-sm hover:pointer' id='token_$data->id' data-token='$data->auth_token' onclick='copyPemalink($(\"#token_$data->id\").attr(\"data-token\"))' >$token</td>
            <td class='px-4 py-3 text-sm'>$requestsToday/$data->day_limit</td>
            <td class='px-4 py-3 text-sm'>$status</td>
            <td class='px-4 py-3 text-sm flex items-center gap-3' >
            <button  onclick='editAPI($data->id)' title='Edit $data->api_name' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            $edit_icone
            </button>

            <button  onclick='regenerateKey($data->id)' title='Regenerate key' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            $regenerate_icone
            </button>

            <button  onclick='removeAPI($data->id)' title='Remove $data->api_name' class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 hover:pointer rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray'>
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
            </svg>
            </button>
            </td>
            <td class='px-4 py-3'>
            </td>
           
        </tr>
        <tr  class='text-gray-700 dark:text-gray-400 hidden shadow-inner' id='tr_detais_$data->id'>
            <td  colspan='6' class='px-4 py-3 text-sm'></td>
        </tr>";
}
//END -> CREAT LINES OF DATA TABLE





