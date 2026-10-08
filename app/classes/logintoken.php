<?php
namespace App\classes;
class logintoken{
protected $token;
protected $dir_token = SITE_ROOT."/app/login/logintoken.php";

public function createAppToken(){
  $this->token =  uniqid("app_");
    $f = fopen($this->dir_token,"w");
    if(fwrite($f,'<?php $appID = "'.$this->token.'";')){
        fclose($f);
        return $this->token;
    }else{
        fclose($f);
        return "user_login";
    }
}

public function getappID(){
if(file_exists($this->dir_token)){
    include_once $this->dir_token;
    return isset($appID) ? $appID:$this->createAppToken();
}else{
    return $this->createAppToken();
}
}

}