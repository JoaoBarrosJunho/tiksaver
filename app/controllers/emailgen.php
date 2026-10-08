<?php 
namespace App\controllers;

use App\classes\leemclasses;
use App\classes\mail;
class emailgen{

    private static $from;
    private static $noReply;

    private static function inite(){
        self::$from = leemclasses::option('smtp_from')!=null?leemclasses::option('smtp_from'):'undefined@leembytes.com';
        self::$noReply = leemclasses::option('smtp_noreply')!=null?leemclasses::option('smtp_noreply'):'no-reply@leembytes.com';
    }

    private static function getFrom(){
        return self::$from;
    }

    private static function getnoReply(){
        return self::$noReply;
    }

    private static function getTemplate($templatename){
        
        switch($templatename){
            case 'mail-verification':
                $file = SITE_ROOT.'/app/views/emailtemplates/verifyaccount.html';
                if(file_exists($file)){
                    $template = file_get_contents($file);
                    return $template;
                }else{
                    return false;
                }
                break;
            case 'mail-recovery':
                $file = SITE_ROOT.'/app/views/emailtemplates/reset-password.html';
                if(file_exists($file)){
                    $template = file_get_contents($file);
                    return $template;
                }else{
                    return false;
                }
                break;
            default:
                return false;
                break;

        }

    }

    /**
     * Password recovery function
     * @param string $toMail
     * @param string $toName
     * @param string $urlrecovery
     * @return bool
     */
    public static function SendRecoveryMail($toEmail,$urlrecovery,$toName=''){
       self::inite();
        $mail = new mail();
        if($mail->init()){
            if($urlrecovery){
                $url = $urlrecovery;
                $template = self::getTemplate('mail-recovery');

                $mailbody = str_replace(['@toMail','@url'],["$toEmail","$url"],$template);
                $mail->recipients(self::getnoReply(),SITE_TITLE,"$toEmail","$toName",self::getnoReply(),self::getnoReply(),self::getFrom());
                $mail->content('Password reset',"$mailbody",'Click this link to change your password:'.$url);
                $execute = $mail->send();
                if($execute['ok']){
                    return true;
                }else{
                    return false;
                }
            }
        }

    }

    public static function sendVerificationMail($toEmail,$toName=''){
        self::inite();
        $mail = new mail();
        if($mail->init()){

            $code = self::genCode();
            $site = SITE_TITLE;
            $template = self::getTemplate('mail-verification');

            $mailbody = str_replace(['@sitename','@Tomail','@code'],["$site","$toEmail","$code"],$template);
            $mail->recipients(self::getnoReply(),$site,"$toEmail","$toName",self::getnoReply(),self::getnoReply(),self::getFrom());
            $mail->content('Account verification',"$mailbody",'Verify your account using code:'.$code);
            $execute = $mail->send();
            if($execute['ok']){
                self::creatToken($code,$toEmail);
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    private static function genCode(){
        $code = [rand(1,9),rand(1,9),rand(1,9),rand(1,9),rand(1,9),rand(1,9)];
        return implode('',$code);
    }

    private static function creatToken($code,$email){

        
        $_SESSION['vToken']=['email'=>"$email",
                        'code'=>md5($code)];

        return true;
    }
    
 
    

}

