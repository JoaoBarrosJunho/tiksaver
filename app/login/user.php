<?php

namespace App\login;

use App\db\database;
use \PDO;
use App\classes\leemclasses;
use App\controllers\emailgen;
use DateInterval;
use DateTime;
use App\classes\urilize;

class user{

    private $id;
    private $name;
    private $email;
    private $password;
    private $type;
    private $status;
    private $hash;
    private $data_joined;
    private $picture;

//GETTERS E SETTERS

public function getId() {
    return $this->id;
}

public function getName() {
    return $this->name;
}

public function getEmail() {
    return $this->email;
}

public function getPassword() {
    return $this->password;
}

public function getType() {
    return $this->type;
}

public function getStatus() {
    return $this->status;
}

public function getHash() {
    return $this->hash;
}

public function getData_joined() {
    return $this->data_joined;
}

public function getPicture() {
    return $this->picture;
}


public function setId($id): void {
    $this->id = $id;
}

public function setName($name): void {
    $this->name = $name;
}

public function setEmail($email): void {
    $this->email = $email;
}

public function setPassword($password): void {
    $this->password = $password;
}

public function setType($type): void {
    $this->type = $type;
}

public function setStatus($status): void {
    $this->status = $status;
}

public function setHash($hash): void {
    $this->hash = $hash;
}

public function setData_Joined($data_joined): void {
    $this->data_joined = $data_joined;
}

public function setPicture($picture): void {
    $this->picture = $picture;
}
/**
 * Metodo responsavel por gerar um codigo Hash para o novo usuario
 * @return String 
 */
public function creatUserHash(){
  
    //GERANDO UMA NOVA HASH
    $UserHash = md5($this->email);
    return $UserHash;
}

// FIM GETTERS E SETTERS

/**
 * Metodo responsavel pelo cadastramento de novos usuarios no banco de dados.
 */
    public function addUser(){
        $obDataBase = new database('user');
        $this->setHash($this->creatUserHash());

        $this->data_joined = date('Y-m-d H:i:s');
        $this->picture = "avatar.jpg";
        $username = $this->genUsername($this->name);

        $this->id = $obDataBase->insert(['email'=>$this->email,
                                'password'=>$this->password,
                                'name'=>$this->name,
                                'username'=> $username,
                                'type'=>$this->type,
                                'status'=>$this->status,
                                'data_joined'=>$this->data_joined,
                                'picture'=>$this->picture,
                                'hash'=>$this->hash
                                
                            ]);
    
        
    }
    public static function reConect(){
        if(!(new logout())->isLoged() && isset($_COOKIE['uAuth_'])){
            $reconect = (new auth(null,null))->reconectUser();
            return true;
        }
    }

    private function genUsername($name){
        $user = urilize::text($name);

        $newname = $user;
        while($this->getData("username='$newname'")){
            $newname = strtolower(uniqid($user.'_'));
        }
    
    return $newname;
    }


    /**
     * Metodo responsavel por obter os dados do usuarios no banco
     * @param string $where 
     * @param string $order
     * @param string $limite
     * @return array
    */
    
    public static function getData($where=null,$order=null,$limit=null,$fields='*'){
        return (new database('user'))->select($where,$order,$limit,$fields)
                                                        ->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Metodo responsavel por excluir  dados do usuario no banco
     * @param Statement $where
     */

    public function deleteUser($where=null){
        return (new database('user'))->delete($where);
    }

    /**
     * Metodo responsavel pela actualização dos dados do usuario no banco de dados.
     * @param string $where
     */
    public function updateUser($where){
        $obDataBase = new database('user');
       
        $update = $obDataBase->update(['name'=>$this->name,
                                'email'=>$this->email,
                                'type'=>$this->type,
                                'status'=>$this->status
                            ],$where);
    return $update;
        
    }

    public static function update($where,$data){
        return (new database('user'))->update($data,$where);
    }
    
    /**
     * Metodo responsavel pela actualização dos dados do usuario no banco de dados.
     * @param string $where
     */
    public function updateStatus($status,$where){
        $obDataBase = new database('user');
       
        $update = $obDataBase->update([
                                'status'=>$status
                            ],$where);
    return $update;
        
    }

    public function SetAllData($name,$email,$password,$type,$status,$id=null){
        $this->id=$id; $this->name=$name; $this->email=$email; $this->password = $password; $this->type=$type;
        $this->status=$status;
    }

    /**
     * Metodo responsavel por retornar os dados do usuario logado no sistema.
     * @param string $data 
     * @return string 
     */
    
    public static function logged($data){
        auth::inite();
        if(isset($_SESSION[LOGIN_TOKEN]["$data"])){
        return $_SESSION[LOGIN_TOKEN]["$data"];
    }else{
        return null;
    }
    }

    /**
     * Metodo responsavel por verificar o tipo de usuario logado
     * @return string
     */
    public static function LoggedtypeString(){
    
        switch(self::logged('type')){
            case 0:
                $type = 'Admin';
                break;
                case 1:
                    $type = 'Editor';
                    break;
                    default:
                    $type = leemclasses::option('role_subscribers');
                    break;
        }
      return  $type;
    }

    /**
     * Metodo responsavel por verificar o tipo de usuario
     * @return string
     */
    public static function UserType($user_type){
    
        switch($user_type){
            case 0:
                $type = tts['admin'];
                break;
                case 1:
                    $type = tts['editor'];
                    break;
                    default:
                    $type = leemclasses::option('role_subscribers');
                    break;
        }
      return  $type;
    }

    /**
     * Metodo responsavel por atualizar email e nome do usuario
     * @param $array $data
     * @return bool
     */
    private static function profileUpdate($data){
        $where = 'id='.self::logged('id');
        $obDataBase = new database('user');
        $email = leemclasses::option('user_update_email')==1?$data['email']:self::logged('email');
        $update = $obDataBase->update(['name'=>$data['name'],'email'=>$email],$where);
        if($update){
            $_SESSION[LOGIN_TOKEN]['name']=$data['name'];
            $_SESSION[LOGIN_TOKEN]['email']=$email;
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo responsavel pelo apdate da senha do usuario logado
     * 
     * @param array
     * @return string
     */
    private static function updatePassword($data){
        if(isset($data['password'],$data['password_repeat']) && $data['password']!=''){
            if($data['password']==$data['password_repeat']){
                 $savePassword = (new database('user'))->update(['password'=>md5($data['password'])],
                 'id='.self::logged('id'));
                 if($savePassword){
                    return leemclasses::notification('Password actualizada');
                 }else{
                    return leemclasses::notification('Erro ao actualizar password',5000,'bg-red-100');
                 }
            }else{
                return leemclasses::notification('Verifica se a senha inserida coencidem',5000,'bg-red-100');
            }
        }else{
            return null;
        }
    }

    /**
     * Metodo responsavel por realizar o update da foto do perfil do usuario
     * @param array 
     * @return mixed
     */
    private static function uPictureProfile($data)
    {
        $response = null;
        if (isset($data['file']['picture']) && !empty($data['file']['picture']['name']) && !empty($data['file']['picture']['tmp_name'])) {
            $data = $data['file']['picture'];
            $name = $data['name'];
            $file_tmp = $data['tmp_name'];
            $format = leemclasses::getExtension($name);

            if (leemclasses::isImage($format)) {
                $unicName = uniqid('picture_') . md5(self::logged('email'));
                if (leemclasses::verify_format($format)) {
                    $response = leemclasses::notification('file .' . $format . ' cannot be uploaded.', 5000, 'bg-red-100');
                } else {
                    $upload = leemclasses::uploadImage($file_tmp,$unicName,1,true);
                    if ($upload['success']) {
                        $slug = $upload['data']['slug'];
                        $execute = (new database('user'))->update(['picture' => $slug], 'id=' . self::logged('id'));
                        $_SESSION[LOGIN_TOKEN]['picture'] = $slug;
                        $response = leemclasses::notification($upload["message"]);
                    } else {
                        $response = leemclasses::notification($upload["message"], 5000, 'bg-red-100');
                    }
                }
            } else {
                $response = leemclasses::notification("Invalid file!", 5000, 'bg-red-100');
            }
        }
        return $response;
    }

    /**
     * Metodo responsavel por actualizar os dados de perfil do usuario
     * @param array $data
     * @return array $update_response
     */
    public static function saveProfile($data){
        $update_response = [];
        if(isset($data['name'],$data['email'])){
            $data_verify = $data['name']!='' && $data['email']!=''?true:false;
            if($data_verify){
                if(self::profileUpdate($data)){
                  $update_response["data_saved"] = leemclasses::notification('Dados actualizados');
                }else{
                  $update_response["data_saved"] = leemclasses::notification('Erro ao actualizar dados',5000,'bg-red-100');
                }
            }
        }
        $update_response['password_saved'] = self::updatePassword($data);
        $update_response['picture_saved']= self::uPictureProfile($data);

         return $update_response;
    }

    public static function getLoggedAvatar(){
         $uploads_ = URI_NAME."/uploads/";
        $media_ = URI_NAME.'/assets/media/';
        if(file_exists(SITE_ROOT.'/uploads/'.self::logged('picture'))){
            return $uploads_.self::logged('picture');
        }else{
            return $media_.'nopicture.png';
        }
    }

    public static function getAvatar($id){
        $uploads_ = URI_NAME."/uploads/";
        $media_ = URI_NAME.'/assets/media/';
        $picture = (new user())->getData("id='$id'",null,null,'picture');
        return $picture && file_exists(SITE_ROOT."/uploads/".$picture[0]->picture)? $uploads_.$picture[0]->picture:$media_.'nopicture.png';
        
        
    }

    /**
     * Check if the logged in user is admin.
     * @return bool
     */
    public static function isAdmin(){
        $response = false;
        if(self::logged('id')){
            $userType = self::getData("id='".self::logged('id')."'",null,null,'type');
            if($userType){
                $response = $userType[0]->type == 0?true:false;
            }
        }
        
        return $response;
    }

    //ACCOUNT RECOVER METHODS
    private static function generateToken($email){

       if(self::getData("email = '$email'")){
        $date_validate = self::DataExpire();
        $token = uniqid().md5($email);
        if((new database('logs'))->insert(['token'=>"$token",'email'=>"$email",'data_validate'=>"$date_validate"])){
          $response = ['success'=>true,'message'=>"$token"];
        }else{
            $response = ['success'=>false,'message'=>"Erros"];
        }

       }else{
        $response = ['success'=>false,'message'=>"Account not exist."];
       }
        
        return $response;
        }

    private static function DataExpire($add = 3){
        $data = new DateTime("now");
        $data->add(new DateInterval("P".$add."D"));
        return $data->format('Y-m-d');
    }

    public static function sendRecoveryLink($email,$baseuri){
        $token = self::generateToken("$email");
        if($token['success']){
            $recoverlink = $baseuri."?t=".$token['message'];
          if(emailgen::SendRecoveryMail($email,$recoverlink,$email)){
            $response = ['success'=>true,'message'=>'Reset URL has been sent to your email.','data'=>"$recoverlink"];
          }else{
            $response = ['success'=>false,'message'=>'An unexpected error occurred.'];
          }
            
        }else{
            $response = ['success'=>false,'message'=>$token['message']];
        }

        return $response;
        
    }

    public static function tokenCheck($token){
        $token_response = (new database('logs'))->select('token='."'$token'")->fetchAll(PDO::FETCH_CLASS);
        
        if($token_response){

           $TokenDate = new DateTime($token_response[0]->data_validate);
           $now = (new DateTime(date('Y-m-d')))->format('Y-m-d');

           if($TokenDate->format('Y-m-d') >= $now){
            $response = ['success'=>true,'message'=>'Valid Token','data'=>$token_response[0]->email];
           }else{
            self::destroyToken($token);
           $response = ['success'=>false,'message'=>'Invalid token'];
           }

        }else{
            $response = ['success'=>false,'message'=>'Invalid token'];
        }
        return $response;
    }

    public static function resetPassword($pass,$email){
        
        if((new database('user'))->update(['password'=>md5($pass)],
        "email='$email'")){
            return true;
        }else{
            return false;
        }
    }
    public static function destroyToken($token){
        if((new database('logs'))->delete("token='$token'")){
         return true;   
        }else{
        return false;
        }
    }
}