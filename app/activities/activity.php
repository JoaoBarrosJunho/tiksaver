<?php
namespace App\activities;
use App\login\user;
use DateTime;
use Exception;

class activity{
    private static $file = SITE_ROOT."/app/activities/logs.txt";

    public static function insert($title,$message,$userId = null){
        $user = $userId != null ? '"user":"'.$userId.'",':'';
        $file = self::$file;
        $v = '';
        $date = (new DateTime('now'))->format('Y-m-d h:i');

        if(file_exists($file)){
            $c = str_word_count(file_get_contents($file));
            if($c>0){
                $v = ",\n";
            }
        }
        
        $f = fopen($file,"a+");


        
        if(fwrite($f,$v.'{'.$user.'"title":"'.$title.'","message":"'.$message.'","date":"'.$date.'"}')){
            fclose($f);
            return true;
        }else{
            fclose($f);
            return false;
        }
    }

    public static function get(){
        $file = self::$file;
        $content = null;
        try{
            if(file_exists($file)){
                $filecontent = file_get_contents($file);
                if($filecontent){
                    $content = "[".$filecontent."]";
                    $activities = (array) json_decode($content);
                    return $activities;
                }else{
                    return null;
                }
                
            }
        }catch(Exception $e){
            return null;
        }

    }

    
public static function clean(){
    $orinal_f = self::$file;
    $new_file = SITE_ROOT."/app/activities/olds/log-cleaned-".(new DateTime('now'))->format('d-m-Y-h-i').".txt";
    $contents = file_get_contents($orinal_f);

    if(count(str_split($contents))>1 && user::isAdmin()){
        $f = fopen($new_file,'a+');
        fwrite($f,$contents);
        fclose($f);
        self::reset();
    }
    
}

public static function reset(){
   
   if(unlink(self::$file)){
    $f = fopen(self::$file,'a+');
    fwrite($f,'');
    fclose($f);
    }
   }
    
   

}
