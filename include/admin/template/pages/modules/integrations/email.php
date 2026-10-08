<?php
use App\classes\leemclasses;
?>

<div class="grid gap-6 md:grid-cols-2 w-full px-5 py-4 rounded-lg bg-gray-50  dark:bg-gray-700 md:col-span-2 panel-template" id="email-settings">              


<label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">SMTP Host</span>
                <input type="text" value="<?=leemclasses::option('smtp_host')?>" name="smtp_host" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </label>

        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Port</span>
                <input type="text" value="<?=leemclasses::option('smtp_port')?>" name="smtp_port" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="2525" />
        </label>
        
        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">User name</span>
                <input type="text" value="<?=leemclasses::option('smtp_username')?>" name="smtp_username" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </label>   
        
        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400">Password</span>
                <input type="password" autocomplete="off" value="<?=leemclasses::option('smtp_password')?>" name="smtp_password" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </label>

        <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">
                SMTP Secure
                </span>
                <select name="smtp_secure" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                <option value="NULL">none</option>
                <option <?php $smtp_secure = leemclasses::option('smtp_secure'); if($smtp_secure == 'ssl'){echo'selected';} ?>  value="ssl">SSL</option>
                <option <?php if($smtp_secure == 'tls'){echo'selected';} ?> value="tls">TLS</option>
                    
                </select>
            </label>

        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400"><?=tts['email_where_users_must_reply']?></span>
                <input type="email" value="<?=leemclasses::option('smtp_from')?>" name="smtp_from" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </label>

        <label class="block mt-4 text-sm ">
                <span class="text-gray-700 dark:text-gray-400"><?=tts['no_reply_email']?></span>
                <input type="email" value="<?=leemclasses::option('smtp_noreply')?>" name="smtp_noreply" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" />
        </label>   
        <label class="block mt-4 text-sm ">
        <span class="text-gray-700 dark:text-gray-400">Test if is work</span>
        <a href="<?=URI_NAME?>/panel/testmail?true" class="<?=style['btn-purple-outline']?>" target="_blank">Test Mail</a>                
        </label>
</div>