<?php 
use App\login\user;
use App\classes\leemclasses;

$data = $_POST;
$data['file'] = $_FILES;

$update_response = user::saveProfile($data);

?>
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200 "><?= $TITLE ?></h2>
        <?php if(isset($update_response['data_saved'])){ print $update_response['data_saved'];}?>
        <?php if(isset($update_response['password_saved']) && $update_response['password_saved']!=null){ print $update_response['password_saved'];}?>
        <?php if(isset($update_response['picture_saved']) && $update_response['picture_saved']!=null){ print $update_response['picture_saved'];}?>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="grid gap-6 px-4 py-3 mb-8 md:grid-cols-4 <?=style["bg"]?>">
        
            <!--Usuario Info-->
            <div class="w-full h-full px-5 py-4 bg-gray-100 rounded-lg  dark:bg-gray-700  ">
                <div id="picture" >
                <div class="flex items-center justify-center ">
                <img src="<?=user::getLoggedAvatar()?>" class="rounded-full w-25 h-25 shadow" alt="profile picture">
                </div>

                <label for="file" class="flex items-center justify-center text-gray-700">
                    
                            <span class="flex py-2 px-3 text-center text-md mt-2 bg-white rounded-md text-gray" style="cursor: pointer;">Upload <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
                </svg>
                </span>
                    
                <input id="file" type="file" name="picture" onchange="newimage('picture')" accept="image/jpeg,image/png,image/gif" class="hidden">
                </label>
                
                </div>
                <div class="text-center mt-2">
                  <span class="font-semibold text-gray-700 dark:text-gray-200"><?= user::logged('name')?></span><br>
                  <span class="text-gray-500 text-sm"><?= user::LoggedtypeString()?></span><br>
                  <span class="text-gray-500 text-sm"><?=tts['joined']?> <?php $u = user::getData('id='.user::logged('id'));
                                                                    foreach($u as $ur){
                                                                        print leemclasses::dateFormat($ur->data_joined) ;
                                                                    }?></span>
                  

                </div>
            </div>
            <!--Usuario infor-->

            <!--Form with data -->
            
            <div class="grid gap-6 md:grid-cols-2 w-full h-full px-5 py-4 rounded-lg bg-gray-50  dark:bg-gray-700 md:col-span-3">
            <?php if(isset($response)){ print '<div class="md:col-span-2">'.$response.'</div>';}?>
            
            <label class="block mt-4 text-sm" >
                <span class="text-gray-700 dark:text-gray-400"><?=tts['name']?></span>
                <input type="text" autocomplete="name" value="<?=user::logged('name')?>" name="name" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Name" />
            </label>

            <label class="block mt-4 text-sm" aria-disabled="true">
                <span class="text-gray-700 dark:text-gray-400"><?=tts['email']?></span>
                <input type="text" autocomplete="off" value="<?=user::logged('email')?>" name="email" class="block w-full mt-1 <?php if(leemclasses::option('user_update_email')!=1){echo 'bg-gray-50';}?> text-gray-500 text-sm  dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Email" <?php if(leemclasses::option('user_update_email')!=1){echo 'readonly';}?>  />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400"><?=tts['new_password']?></span>
                <input type="password" autocomplete="new-password" name="password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="********" />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400"><?=tts['repeat_password']?></span>
                <input type="password" autocomplete="new-password" name="password_repeat" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="********" />
            </label>

            <button class="md:col-span-2 flex mt-4 items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Save</button>
            </div>
            
            
            <!--Form with data -->
                                                                
        </div>
        </form>
        

    </div>
</main>