<?php
namespace App\login;
use App\login\auth;

class logout{

public function __construct()
{
    auth::inite();
}
public function Logout(){
    if(isset($_SESSION[LOGIN_TOKEN])){
        unset($_SESSION[LOGIN_TOKEN]);
        $remove = (new access_checker())->remove();
        return true;
    }else{
        return false;
    }
}

/**
 * Metodo que verifica se o usuario já está logado no sistema;
 * @return bool 
 */

public function isLoged(){

    if(isset($_SESSION[LOGIN_TOKEN]) && user::logged('status')==1){
        $user = (new user())->getData("id=".user::logged('id'));

        $user = $user?$user[0]:$this->Logout().$this->loginCheck();
        
        $_SESSION[LOGIN_TOKEN]['name']=$user->name;
        $_SESSION[LOGIN_TOKEN]['email']=$user->email;
        $_SESSION[LOGIN_TOKEN]['picture']=$user->picture;
        $_SESSION[LOGIN_TOKEN]['status']=$user->status;
        $_SESSION[LOGIN_TOKEN]['type']=$user->type;
        
        return true;
    }else{
        $remove_login = isset($_SESSION[LOGIN_TOKEN])?$this->Logout():null;
        return false;
    }
}

/**
 * Metodo responsavel por verificar se o usuario está logado no sistema
 */
public function loginCheck(){
    if(!$this->isLoged()){
        header("location:".URI_NAME."/login");
        $reconect = (new auth(null,null))->reconectUser();
        die();
    }
}

}
