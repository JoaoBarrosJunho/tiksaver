<?php
use App\login\user;
use App\classes\leemclasses;
use App\classes\pagination;

if (isset($_POST['NumberOfResisters']) && is_numeric($_POST['NumberOfResisters'])) {
  leemclasses::setNumberOfResiter($_POST['NumberOfResisters']);
}

$num_of_registers = leemclasses::getNumberOfResister();
$page = !isset($_GET['page']) ? 1 : $_GET['page'];
$where = isset($_GET['search']) ? "name LIKE '%" . $_GET['search'] . "%' OR email LIKE '%" . $_GET['search'] . "%' " : null;
$searchpage = isset($_GET['search']) ? '&search=' . $_GET['search'] : '';
$offset = (new leemclasses())->getOffset($page, $num_of_registers);
$users = (new user())->getData($where, 'id DESC', $num_of_registers . ' OFFSET ' . $offset);
$table = '';





foreach ($users as $data) {

  $type = user::UserType($data->type);

  switch ($data->status) {
    case 1:
      $status = '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
  >Active</span>';
      break;
    case 2:
      $status = '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-orange-100 rounded-full dark:bg-green-700 dark:text-green-100"
  >Unverified</span>';
      break;
    default:
      $status = '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700"
  >Disabled</span>';
      break;
  }

  $block_action = $data->status == 1?            "<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-orange-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Block $data->name' onclick='blocku($data->id)'>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636' />
 </svg>
  </button>":"<button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-green-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Unlock $data->name' onclick='blocku($data->id,1)'>
  <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-5 h-5'>
  <path stroke-linecap='round' stroke-linejoin='round' d='M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z' />
</svg>

  </button>";


  $table .= "<tr class='text-gray-700 dark:text-gray-400' id='tr_user_$data->id'>
            <td class='px-4 py-3'><div class='flex items-center text-sm font-semibold user_info'>$data->name</div></td>
            <td class='px-4 py-3 text-sm user_info'>$data->email</td>
            <td class='px-4 py-3 text-sm user_info'>$type</td>
            <td class='px-4 py-3 text-xs user_info'>$status</td>
            <td class='px-4 py-3'>
            <div class='flex items-center space-x-4 text-sm'>
            <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' title='Edit $data->name' onclick='editU($data->id)'>
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
            </svg>
            </button> 
           <label class='user_info'> $block_action</label>
            <button class='flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray' data-bs-toggle='modal' title='Remove $data->name' data-bs-target='#deleteAlert' onclick='dlu($data->id)'>
            <svg class='w-5 h-5' aria-hidden='true' fill='currentColor' viewBox='0 0 20 20'>
            <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
            </svg>
            </button></div></td>
            
        </tr>";
  
}

?>
<main class="h-full overflow-y-auto">


  <div class="container px-6 mx-auto grid">

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"><?= $TITLE ?>
      <ul class="flex  items-center flex-shrink-0 space-x-6">
        <!-- Theme toggler -->
        <li class="flex">
          <label class="block mt-4 text-sm">
            <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple "  data-bs-toggle='modal' data-bs-target='#ModalNew'>
              <?= tts['add_new'] ?>
              <span class="ml-2" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                </svg>
              </span>
            </button>
          </label>
        </li>
        <li class="flex">
          <!-- Search input -->
          <label class="block mt-4 text-sm">
            <div class="relative text-gray-500 focus-within:text-purple-600">
              <input class="block w-full pr-20 mt-1 text-sm text-black dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input" placeholder="Search for users: name, email" id="search" value="<?php if (isset($_GET['search'])) {
                                                                                                                                                                                                                                                                                                                    echo $_GET['search'];
                                                                                                                                                                                                                                                                                                                  } ?>" />
              <button class="absolute inset-y-0 right-0 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple" onclick="searchdata()" ;>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

              </button>
            </div>
          </label>
        </li>



        <?php if (isset($_GET['search']) && !empty($_GET['search'])) {
          echo '<li class="flex"><label class="block mt-4 text-sm">
              <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple " onclick="showall()">
              Show All
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            
            </button>  
              </label> </li>';
        } ?>

      </ul>
    </h2>


    <script>
      var search = document.getElementById('search');

      function searchdata() {
        if (search.value == '') {
          alert('Insert name or email');
        } else {

          window.location.href = '<?php echo URI_NAME; ?>/panel/accounts?search=' + search.value + '';
        }
      }

      function showall() {
        window.location.href = '<?php echo URI_NAME; ?>/panel/accounts';
      }
    </script>

    <?php
    if (isset($_GET['success'])) {
      switch ($_GET['success']) {
        case 'true':
          print leemclasses::notification('Action has been succeeded', 5000);
          break;
        case 'false':
          print leemclasses::notification('Error executing action', 5000, 'bg-red-100');
          break;
        default:
          break;
      }
    }
    ?>
    <!-- Users Table -->
    
    <div class="w-full overflow-hidden <?=style["bg"]?>">
      <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 
        uppercase border-b dark:border-gray-700  ">
              <th class="px-4 py-3"><?= tts['name'] ?></th>
              <th class="px-4 py-3">Email</th>
              <th class="px-4 py-3"><?= tts['type'] ?></th>
              <th class="px-4 py-3"><?= tts['status'] ?></th>
              <th class="px-4 py-3"><?= tts['actions'] ?></th>
            </tr>
          </thead>
          <tbody class=" divide-y dark:divide-gray-700 dark:bg-gray-800 table_users">
            <?= $table ?>
          </tbody>
        </table>
      </div>

      <!--Pagination-->
      <?=(new pagination('/panel/accounts',$page,'user',$num_of_registers,$where))->getPagination()?>
      <?php include_once 'modules/number-registers.php'?>


      <?php include_once 'modules/accounts/modal-delete.php' ?>

        <?php include_once 'modules/accounts/modal-management.php' ?>
      <div class="mb-4 mt-4"></div>


</main>