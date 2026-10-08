<?php
namespace App\classes;

use App\login\user;

class flash_messages{
   protected $flash_status = SITE_ROOT."/app/classes/flash_status.php";

    public function getMessage(){
      $flash_ = $this->check_flashstatus();
       

       

        



       /**if(!isset($flash_['flash_star'])){
            $message = '<div class="w-full flex flex-col gap-3 py-4 px-4 flash_body">
            <a
            class="flex items-center justify-between p-4 mb-8 text-sm  font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
            onclick="closeAlert(\'flash_star\')" href="https://www.codester.com/items/comments/53289/quick-inbox-temporary-email-generator" target="_blank"
          >
            <div class="flex items-center">
              <svg
                class="w-5 h-5 mr-2"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <span>Did you like this script? Please support my work, star this project on Codester</span>
            </div>
            <span>Star now&RightArrow;</span>
          </a></div>';

          return user::isAdmin()? $message:null;
        }*/

        return null;
    }

    public function closeMessage($message){
         $message?$this->hide_message($message):null;
        return true;
    }

    public function hide_message($message){
        if(file_exists($this->flash_status)){
            include_once $this->flash_status;
        }
        $newData = isset($flash_data)?(array)json_decode($flash_data):[];
        $newData[$message] = 1;
        $newData_ = json_encode($newData);
        $file = fopen($this->flash_status,"w");
        fwrite($file,'<?php $flash_data = \''.$newData_.'\';');
        fclose($file);
    }

    public function check_flashstatus(){
        
        if(file_exists($this->flash_status)){
            include_once $this->flash_status;
        }
        $newData = isset($flash_data)?(array)json_decode($flash_data):[];
        return $newData;
    }

    

}