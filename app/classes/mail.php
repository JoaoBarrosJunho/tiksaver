<?php 
namespace App\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\classes\leemclasses;

class mail{

private $phpmailer;

public function __construct()
{
    $this->phpmailer = new PHPMailer(true);
}

public function Maildebug(){
    $this->phpmailer->SMTPDebug = SMTP::DEBUG_SERVER;
}
/**
 * Inicia o PHPMailer 
 * @return bool
 */
public function init(){

    $host = leemclasses::option('smtp_host');
    $Username = leemclasses::option('smtp_username');
    $password = leemclasses::option('smtp_password');
    $port = leemclasses::option('smtp_port');

    $host = $host?$host:'smtp.gmail.com';
    $password = $password?$password:'yvrl wmab xydq qvcy';
    $Username = $Username?$Username:'appgeniusblog@gmail.com';
    $port = $port?$port:'465';
    
    $this->phpmailer->isSMTP();
    $this->phpmailer->Host = "$host";
    $this->phpmailer->SMTPAuth = true;
    $this->phpmailer->Username = "$Username";
    $this->phpmailer->Password = "$password";
    
    switch(leemclasses::option('smtp_secure')){
        case'ssl':
            $this->phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        break;
        case'tls':
            $this->phpmailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        break;
        default:

        break;
    }
    
    
    
    $this->phpmailer->Port = "$port";
    return true;

}

/**
 * Metodo que recebe os dados do recipiente
 * @param string $from
 * @param string $fromName
 * @param string $toAdress
 * @param string $toName
 * @param string $replyTo
 * @param string $cc
 * @param string $bcc
 */
public function recipients($from,$fromName='',$toAdress='',$toName='',$replyTo='',$cc='',$bcc=''){
    //$this->init();
    $this->phpmailer->setFrom($from,$fromName);
    $this->phpmailer->addAddress($toAdress,$toName);
    $this->phpmailer->addReplyTo($replyTo);
    $this->phpmailer->addCC($cc);
    $this->phpmailer->addBCC($bcc);
}

/**
 * Adiciona ficheiro no email que se presente enviar
 * @param string $url
 * @param string $nameOptional
 */
public function attachment($url,$nameOptional=''){
    $this->phpmailer->addAttachment("$url",$nameOptional);
}

public function content($subject,$body,$altbody,$isHTML=true){
$this->phpmailer->isHTML($isHTML);
$this->phpmailer->CharSet = 'UTF-8';
$this->phpmailer->Subject = "$subject";
$this->phpmailer->Body = $body!=false?"$body":$altbody;
$this->phpmailer->AltBody = "$altbody";

}

/**
 * Metodo responsavel por enviar o email 
 * @return array
 */
public function send(){
    try{
    $this->phpmailer->send();
    $response = ['ok'=>true,'message'=>'Email has been sended'];
    
    return $response;

    }catch(Exception $e){
        $response = ['ok'=>false,'message'=>"{$this->phpmailer->ErrorInfo}"];
        return $response;
    }
}

}

?>