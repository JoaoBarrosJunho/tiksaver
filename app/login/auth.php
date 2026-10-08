<?php 
namespace App\login;
use App\login\user;

class auth{

    private $email;
    private $pass;

    /**
     * Metodo construtor da class auth
     * @var string $email
     * @var string $pass
     */
    public function __construct($email,$pass)
    {
        $this->email = $email;
        $this->pass=$pass;

        $this->sigin();
    }

    /** 
     * Metodo responsavel por verificar se a sessão já foi iniciada.
     */
    public static function inite(){
        if(session_status()!== PHP_SESSION_ACTIVE){session_start();}
            return true;
    }
    /**
     * Metodo responsavel pela autenticação do usuario
     * @return array
     */
    public function sigin(){
          if ($this->email != null || $this->pass != null) {
            //DADOS DO USUARIO
            $pass = md5($this->pass);
            $s = [];

            //EXECUTA A QUERY
            $us = (new user())->getData("email= '$this->email' AND password='$pass'");

            //VERIFICA SE RETORNOU ALGUM DADO
            if ($us) {
                return $this->createLogin($us);
            } else {

                //SE NÃO FOR ENCONTRADO NENHUM USUARIO NO BANCO DE DADOS RETORNA UMA ARRAY COM state false
                $s = ['state' => false];
                return $s;
            }
        }
    }

    public  function createLogin($us)
    {
        $s = [];
        $user = $us[0];
        $s['id'] = $user->id;
        $s['type'] = $user->type;
        $s['hash'] = $user->hash;
        $s['name'] = $user->name;
        $s['picture'] = $user->picture;
        $s['state'] = $user->status;
        $s['personal'] = !empty($user->personal_info) ? (array)json_decode($user->personal_info) : [];



        //VERIFICA SE O USUARIO TEM PERMIÇÃO DE ACESSO
        if ($s['state'] == 1) {

            //VERIFICA SE A SESSÃO JÁ FOI INICIADA

            $this->inite();


            //CRIANDO AS VARIAVEIS DE SESSÃO
            $UserData = [
                'id' => $s['id'],
                'email' => $this->email,
                'name' => $s['name'],
                'picture' => $s['picture'],
                'status' => $s['state'],
                'type' => $s['type']
            ];
            $_SESSION[LOGIN_TOKEN] = array_merge($UserData, $s['personal']);
        }

        //RETORNA A ARRAY COM OS DADOS DO USUARIO
        return $s;
    }

     public function reconectUser()
    {
        $login = (new access_checker())->checkUser();

        if ($login['success']) {
            $account = $login['data']['user'];
            $user = user::getData("id=$account");
            if ($user) {
                $conect = $this->createLogin($user);
                return $conect ? true : false;
            }
        }

        return false;
    }

    public static function vT($data){
        self::inite();
        $response = isset($_SESSION['vToken']["$data"])?$_SESSION['vToken']["$data"]:null;

        return $response;
    }
}