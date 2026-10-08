<?php

use App\activities\activity;
use App\login\user;

//Verifica se o usuario está logado
if ($loged->isLoged() && user::isAdmin()) {
    $success = false;
    $message = '';
    $user_data = '';
    $data['password'] = !empty($data['user_selected']) && is_numeric($data['user_selected']) && empty($data['password']) ?' ':$data['password'];
    //Verifica se os dados foram devidamente inseridos
    $datavalidate =  isset($data['name'], $data['email'], $data['password'])
        && !empty($data['name'])
        && !empty($data['email'])
        && !empty($data['password']) ? true : false;

    $datavalidate = !empty($data['password']) && strlen($data['password'])<8?null:$datavalidate;
    if ($datavalidate) {

        $type = isset($data['type'])
            && is_numeric($data['type']) ? $data['type'] : 3;

        $status = isset($data['status'])
            && is_numeric($data['status'])
            ? $data['status'] : 2;

        if(empty($data['user_selected']) && !is_numeric($data['user_selected'])){
        $day = date('Y-d-m H:i:s');
        $u = new user();
        $u->SetAllData($data['name'], $data['email'], md5($data['password']), $type, $status);
        
        $u->addUser();
        
        if ($u->getId() > 0) { 
            
                $success = true;
                $message = 'User has been added';
                $user_data = ['action'=>'add','id'=> $u->getId(),'html_code'=>createTableElement((new user())->getData("id=".$u->getId()))];
                activity::insert('Account Management',user::logged('name')." created account of ".$data['name'],user::logged('id'));   
        } else {
           
                $message = 'Error: Error to add new user!';
        }}else{
            
            $selected_user = $data['user_selected'];
            $old_pass = user::getData("id=$selected_user",null,1,'password');
            $up_password = !empty($data['password']) && $data['password'] != ' '?md5($data['password']):$old_pass[0]->password;
            $update = user::update("id=$selected_user",['name'=>$data['name'],'email'=>$data['email'],'password'=>"$up_password",'type'=>$type,'status'=>$status]);
            if($update){
                $success = true;
                $message = 'User data has been updated!';
                $user_data = ['action'=>'update','id'=>$selected_user,'name'=>$data['name'],'email'=>$data['email'],'type'=>user::UserType($type),'status'=>$status];
                activity::insert('Account Management',user::logged('name')." updated the data of ".$data['name'],user::logged('id'));
            }else{
                $message = 'Error to update user data!';
            }
        }
    } else {
       
            $message = $datavalidate === null? 'Very short password, needs 8 characters!':'Error: invalid data.';
        
    }
} else {
    
    $message = 'No Autorized';
    
}

function createTableElement($data){
    $data = $data[0];
    $type = user::UserType($data->type);
    $table = '';

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


  $table .= "
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
            
        ";
  
return $table;
}



$response = [ 'success' => $success,'message'=>$message, 'data'=>$user_data];
//FIM CASO SEJA ADD USUARIO
?>