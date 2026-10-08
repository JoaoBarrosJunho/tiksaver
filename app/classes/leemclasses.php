<?php
namespace App\classes;

use App\db\database;
use DateTimeImmutable;
use \PDO;
use DateTimeZone;
use App\classes\post;
use App\login\auth;
use App\login\user;
use DateTime;
use Intervention\Image\ImageManager;
use App\classes\sitemap;

class leemclasses{
    
    /**
     * Metodo responsavel pela paginação da lista de ususario
     * @param int $page
     * @param int $quant
     * @return int $offset
     */
    public function getOffset($page,$quant){
        if(is_numeric($page) && is_numeric($quant)){
            $offset = ($page - 1)*$quant;
            return $offset;
        }
        

    }

    public static function checkQueryes(){
        $listQueryes = $_GET;
        unset($listQueryes['zone'],$listQueryes['p'],$listQueryes['page']);
        $queries = '';
        $queries .= http_build_query($listQueryes);
        return $queries?"&$queries":'';
        }

    /**
     * Metodo responsavel por fazer o calculo e trazer a quantidade de paginas
     * @param string $table
     * @param int $rows
     * @return int
     */
    public function pagination($table,$rows,$where=null,$results=false){
        if($results===false){
            $totaldata =  (new database($table))->select($where,null,null,"COUNT(id) as results")->fetchAll(PDO::FETCH_CLASS);
            $result = $totaldata[0]->results?$totaldata[0]->results:0;
        }else{
            $result = $results;
        }
        
        
        $arr = ($result/$rows);
        
        return ceil($arr);
        
    }

    
/**
     * Metodo responsavel por fazer o calculo e trazer a quantidade de paginas
     * @param int $table
     * @param int $rows
     * @return int
     */
    public function Calc_pagination($articles_quant,$rows_perpage){
        $result =  $articles_quant;
        $arr = ($result/$rows_perpage);
        return ceil($arr);        
    }

    /**
 * Metodo responsavel pelo cadastramento de novos usuarios no banco de dados.
 */
public static function AddOption($option,$value){
    $obDataBase = new database('options');
    return $obDataBase->insert(["option_name"=>"$option","option_value"=>"$value"]);
}

public static function UpdateOption($option,$value,$where){
    $obDataBase = new database('options');
    return $obDataBase->update(["$option"=>"$value"],$where);
}

public static function SelectOption($where=null,$order=null,$limit=null,$fiels='*'){
    return (new database('options'))->select($where,$order,$limit,$fiels)
                                                        ->fetchAll(PDO::FETCH_CLASS);
}

/**
 * Metodos responsavel por cadastrar as configurações do sistema no banco dedados
 * @param string $option Nome da configuração
 * @param string value Valor a ser inserido na configuração
 * 
 * @return mixed
 */
public static function setOptions($option,$value=null){
    if(!self::SelectOption("option_name = '$option'")){
        
        $add = self::AddOption($option,$value);

        if($add>0){
            return null;
        }else{
            return "<span style='color:red;font-weight:800;'>Error</span> to save $option: $value.<br>";
        }

    }else{

        $update = self::UpdateOption("option_value",$value,"option_name = '$option'");
        if($update){
            return null;
        }else{
            return "<span style='color:red;font-weight:800;'>Error</span> to update $option: $value.<br>";
        }

    }
}

public static function getTimeZoneList(){   
    return DateTimeZone::listIdentifiers();
}

public static function themeName(){


    return 'modern';

    $theme = self::option("active_theme");
    $templates = ['classic','modern'];
    if($theme){
        return in_array($theme,$templates)?$theme:'modern';
    }

    return 'default';
}

public static function GetTimeZone(){
    $getTime =  leemclasses::SelectOption("option_name='time_zone'",null,null,'option_value');
    if($getTime) {
        foreach($getTime as $Tz){
            $Tzone = $Tz->option_value;
        };
    }else{
        $Tzone = 'UTC';
    }
    return $Tzone;
}

/**
 * Metodo responsavel por consultar uma determinada função no banco de dados
 * @param string
 * @return string
 */
public static function option($option_name){
    $option =  leemclasses::SelectOption("option_name='$option_name'",null,null,'option_value');
    if($option) {
        foreach($option as $option_value){
            $Voption = $option_value->option_value;
        };
        return $Voption;
    }else{
        return null;
    }
    
}
/**
 * Metodo para exibir uma notificação após realizar uma operação
 * @param string $message texto a ser exibido
 * @param int $time tempo de exibição
 * @param string $bgcolor cor do backgroung
 * @return string
 */
public static function notification($message=null,$time=3000,$bgcolor='bg-green-100'){
    $n = rand(0000,9999);
    return '<div id="nt_'.$n.'" class="px-4 py-3 mt-2 mb-4 rounded-lg text-gray-700 '.$bgcolor.' shadow-md">'.$message.'</div>
    <script>
    setTimeout(()=>{
        document.getElementById("nt_'.$n.'").style.display="none";
    },'.$time.');
    </script>';
}

public static function headerlogo($dir){
    
    $site_dir = $dir;
    switch(self::option('nav_header')){
        case 'logo':
            return '<a class="ml-6 flex text-lg font-bold  dark:text-gray-200" href="'.$site_dir.'/panel">
            <img src="'.$site_dir.'/assets/media/'.self::option('website_logo').'" class="w-8 h-8" alt="logo">
             </a>';
        break;
        case 'logo_title':

            return '<a class="ml-6 flex text-lg font-bold  dark:text-gray-200" href="'.$site_dir.'/panel">
            <img src="'.$site_dir.'/assets/media/'.self::option('website_logo').'" class="w-8 h-8" alt="logo"><span class="ml-1 mt-1">'.self::option('site_title').'</span>
             </a>';
            break;
        case 'title':

            return '<a class="ml-6 flex text-lg font-bold  dark:text-gray-200" href="'.$site_dir.'/panel">
            <span class="ml-1 mt-1">'.self::option('site_title').'</span>
             </a>';
        break;
        default:
        return '<a class="ml-6 flex text-lg font-bold  dark:text-gray-200" href="'.$site_dir.'/panel">
            <img src="'.$site_dir.'/assets/media/'.self::option('website_logo').'" class="w-8 h-8" alt="logo"><span class="ml-1 mt-1">'.self::option('site_title').'</span>
             </a>';
        break;
    }
}

/**
 * Metodo responsavel por realizar o upload dos icones e banner do website
 * @param string $option titulo da opção a ser manipulada
 * @param string $name nome do ficheiro
 * @param string $tmp url temporaria da imagem
 * @param mixed $size 
 * @return string
 */
public static function uploadPic($option,$name,$tmp,$size=null){
    
    
    

    $format = self::getExtension($name);
    if(self::isImage($format)){

    if(!self::verify_format($format)){
        $filename='';
        switch($option){
            case 'website_logo':
                $filename = 'logo.'.$format;
            break;
            case 'fav_icon':
                $filename = 'favicon.'.$format;
            break;
            case 'mobile_logo':
                $filename = 'mobilelogo.'.$format;
            break;
            default:
                return "<span style='color:red;font-weight:800;'>Error</span> to upload image<br>";
                die();
            break;
        }
            $dir = SITE_ROOT."/assets/media/$filename";
    
            if($filename){
                if(move_uploaded_file($tmp,"$dir")){
                   return  self::setOptions($option,$filename);
                }
            }else{
                return "<span style='color:red;font-weight:800;'>Error</span> to upload image<br>";
            }
            
    }else{
        return "<span style='color:red;font-weight:800;'>Error</span> to upload image, ficheiro 
        entre os formatos não permitidos<br>";
    }
    

    }else{
        return "<span style='color:red;font-weight:800;'>Error:</span> este tipo de ficheiro não corresponde aos formatos de imagem permitido.<br>";
    }


}

/**
 * Retorna a data com o formato definido pelo administrador
 * @param date 
 * @param string data format
 * @return date
 */
public static function dateFormat($d, $f=null){
    $format= !$f ?self::option('date_format'):$f;
    $date = new DateTimeImmutable($d);
    return $date->format($format);
}

public static function getDateFormat(){
   return self::option('date_format')." ".self::option('time_format');
}

/**
 * Retorna o formato ficheiro que está a aser carregado
 * @param string $filename
 * @return string
 */
public static function getExtension($filename){
    return pathinfo($filename,PATHINFO_EXTENSION);
}

/**
 * Verifica se o formato do ficheiro consta na lista de não perfmitidos
 * @param string $format
 * @return bool
 */
public static function verify_format($format){
$not_allowed_list = explode(',',self::option('not_allowed_formats'));
$response = in_array($format,$not_allowed_list)?true:false;
return $response;
}

/**
 * Metodo que valida se a o ficheiro a ser carregado é uma imagem ou não
 * @param string $extension
 */
public static function isImage($extension){
    $response = in_array($extension,['jpeg','jpg','png','gif'])?true:false;
    return $response;
}

/**
 * Metodo responsavel por carregamento de arquivos
 * @param string $att attachment
 * @param string $extension estensão do ficheiro
 * @return array
 */
public static function uPloadAttachment($att,$extension,$name,$type){
    
    
    $dir = SITE_ROOT.'/uploads';

    $newname = post::genFilename($name,$dir);

    if(move_uploaded_file($att,"$dir/"."$newname.$extension")){
        $attachment_guid = URI_NAME."/uploads/$newname.$extension";

        $post = (new post())->postAttachment("$newname.$extension","$newname","$type","$attachment_guid");
        
        if($post['success']){
            $response = ["success"=>true,"attachment"=>"$attachment_guid", "file_name"=>"$newname.$extension"];
        }else{
            $response = ["success"=>false,"attachment"=>"$attachment_guid","message"=>"Error to save file in database"];
        }
        
        return $response; 
    } else{
        $response = ["success"=>false,"message"=>'Error tu upload'.$name];
        return $response;
    }
}

/**
 * Upload Image Generated
 * @param string $dir
 * @param string $name
 * @param int $dirType (1 URL, 0 HOST_DIR) 
 */

 public static function uploadImage($dir,$name,$dirType = 1,$isProfile = false){
    //ini_set('display_errors',0);
    $success = false;
    $message = '';
    $data = [];
    $mimeType = '';
    $file = $dirType == 1? file_get_contents($dir):$dir;

    if($file){
    
    $slug = self::genUnicSlug(explode('.',$name)[0],null,'posts','post_slug','post_type = "attachment"');
    $manage = ImageManager::gd();
    if($image = $manage->read($file)){
        $extension = leemclasses::getExtension($name);
        if($extension == 'png'){
            $isProfile?$image->scaleDown('300'):null;
            $Encoded = $image->toPng();
            $mimeType = $Encoded->mimetype();        
        }else{
            $extension = "jpg";
            $isProfile?$image->scaleDown('300'):null;
            $Encoded = $image->toJpeg();
            $mimeType = $Encoded->mimetype();
        }
        

        if($Encoded->save(SITE_ROOT."/uploads/$slug.$extension") == null){
            $guid = self::genGuid("uploads/$slug.$extension");
            $post = (new post())->postAttachment($name,$slug,$mimeType,$guid);
            
            if($post['success']){
                $success = true;
                $message = 'Attachemnt has been uploaded';
                $data['id'] = $post['attachment_id'];
                $data['guid'] = $guid;
                $data['slug'] = "$slug.$extension";
            }else{
                $message = 'Error to save attachment in Data Base!';
            }
        }


    }else{
        $message='Error to read image!';
    }
}else{
    $message = 'Invalid file!';
}
    


return ['success'=>$success,'message'=>$message,'data'=>$data];

}

public static function setNumberOfResiter($value){
    auth::inite();
    $_SESSION['numberOfResisters'] = $value;
}

public static function getNumberOfResister(){
    $n = isset($_SESSION['numberOfResisters']) 
    && is_numeric($_SESSION['numberOfResisters']) ? $_SESSION['numberOfResisters']:10;

    return $n;
}

/**
 * Metodo responsavel por gerar um slug unico para um determinado elemento no banco de dados
 * @param string $value gera um slug automaticamente quando slug personalizado é null
 * @param string $ModifiedSlug slug personalizado
 * @param string $tableToCheck nome da tabela no banco de daos
 * @param string $colName nome da colunada a verificar o slug
 * @return string
 */
public static function genUnicSlug($value,$ModifiedSlug = null,$tableToCheck = null,$colName = 'slug',$where = null){
    $where = $where != null ? " AND $where":"";
    $slug = $ModifiedSlug != null ? urilize::text($ModifiedSlug) : urilize::text($value);

    $initial_slug = $slug;
    $i=0;
    
    while((new database("$tableToCheck"))->select("$colName = '$slug' $where ")->fetchAll(PDO::FETCH_CLASS)){
        $i++;
        $slug = $initial_slug.'-'.$i;
    }

    return $slug;
}

public static function genGuid($slug,$query = null){
    $query = $query != null? "/$query/$slug":"/$slug";
    return URI_NAME.$query;
}


    
public static function newLog($message){
    $file = SITE_ROOT."/logs.txt";
    $date = (new DateTime('now'))->format('d-m-Y H:i:s');
    $f = fopen($file,"a+");
    fwrite($f,"\n [$date] $message");
    fclose($f);
}

public static function onlyAdmins(){
    if(!user::isAdmin()){
        print "<label class='py-4 px-4 font-semibold'></label>
        <script>window.location='".URI_NAME."/panel/404'</script>";
        die();
    }
}

public static function noSubs(){
    if(user::logged('type')>1){
        print "<label class='py-4 px-4 font-semibold'><script>window.location='".URI_NAME."/panel/404'</script></label>";
        die();
    }
}



public static function getAuthorName($id){
    $data = (new user())->getData("id='$id'",null,null,'name,username');
   
    return $data ? ['name'=>$data[0]->name,'username'=>$data[0]->username,'profile_url'=>URI_NAME."/author/".$data[0]->username]:['name'=>'','username'=>'','profile_url'=>''];
}

public static function getFeaturedImage($post_id){
    $picture = postmeta::selectPostMeta("post_id = '$post_id' AND meta_key = 'featured_img'");
   return $picture? $picture[0]->meta_value:URI_NAME.'/assets/media/noimage.png';
}

public static function text_prepare($text,$mode='set'){
    switch($mode){
        case 'set':
            return htmlspecialchars($text);
        break;
        case 'get':
            return html_entity_decode($text);
        break;
        default:
        return ' ';
        break;
    }
}

public static function text_encode($text,$mode){
    $chars = ['"',"'","<",">"];
     //#v2a@(2 high commas)
    //#v1a@(1 high comma)
    $code = ['#v2a@','#v1a@','&lt;','&gt;'];
   
    switch($mode){
        case 'set':
            return str_replace($chars,$code,$text);
        break;
        case 'get':
            return str_replace($code,$chars,$text);
        break;
        default:
        return str_replace($code,$chars,$text);
        break;
    }

}

public static function setFont($font){
    return in_array("$font",fonts)? $font:null;
}

public static function checkInvalidString($text){
$invalid_string = '<>:,;+*?}=])[({/&%$#"@!\|';
$l = str_split("$invalid_string");
$t = str_split("$text");
$i=0;

for($i;$i<count($t);$i++){
    if(in_array($t[$i],$l)){
        return ['success'=>true,'line'=>$i,'char'=>$t[$i]];
    }
}

return ['success'=>false];

}


public static function apiAccessBlock($userType = 0){
    $user = user::logged('type');
     if($user>$userType){
        print json_encode(['success'=>false,'message'=>'Not found!']);
        die();
     }
}



public static function geniusLang(){
    $langs = self::option('genius_languages');

    return $langs? explode(',',$langs):[];

}



public static function geniusCategories(){
    $categories = self::option('genius_categories');
    return $categories?explode(',',$categories):[];
}



public static function SetThemeOpition($data,$files){
    $status ='<p>'.tts['action_succedd'].'</p>';
    //UPLOAD IMAGES
    if($files){
        foreach($files as $key => &$fl){
            if($fl['tmp_name']){
            $name = md5(date("Y-m-d H:i:s").$fl['name']); 
            $image = self::uploadImage($fl['tmp_name'],$name.".".self::getExtension($fl['name']));
            if($image['success']){
                $data[$key]=$image['data']['guid'];
            }
            }
        }
    }

    $options_code = self::customCodesVars();
    //UPDATE SETTINGS
    if($data){
        $theme_Option = self::option("theme_option");
        $t = $theme_Option?(array)json_decode($theme_Option):[];
        foreach($data as $key=>$value){
            $t[$key] = in_array($key,$options_code)?htmlspecialchars($value):$value;
        }
        self::setOptions("theme_option",json_encode($t)); 
        (new sitemap())->updateIndex();
    }
    return $status;
}

public static function customCodesVars(){
    return ['custom_script','custom_css','custom_html','header','body_area','footer','ads_after_header','ads_after_email_section','ads_after_generate_section','ads_before_footer'];
}

public static function getThemeOptions(){
    $data = self::option("theme_option");
    return $data?json_decode($data):[];
}

public static function getThemeElements(){
    $data = self::option("theme-elements");
    return $data?json_decode($data):'';
}

public static function setGeneralSettings($data){
    $status ='<p>'.tts['action_succedd'].'</p>';
    
    //UPDATE SETTINGS
    if($data){
        foreach($data as $key => &$dt){
              $status.=  self::setOptions($key,$dt); 
        };
        (new sitemap())->updateIndex();
    }
    return $status;
}

public static function nextprev($results){
    $results = count($results);
    $resisters = self::getNumberOfResister();
    $btnDisabled = style['btn-disabled'];
    $btnEnabled = style['btn-purple'];
    $page = isset($_GET['page']) && is_numeric($_GET['page'])?$_GET['page']:1;
    $prevButtonStyle = $page>1?$btnEnabled:$btnDisabled;
    $prevButtonDisabled = $page>1?'':'disabled';
    $prevPage = $page>1?$page-1:1;

    $btnNextStyle = $results>=$resisters?$btnEnabled:$btnDisabled;
    $nextPage = $results>=$resisters?$page+1:1;
    $nextButtonDisabled = $results>=$resisters?'':'disabled';

    $visibility = $page==1 && $results<$resisters?'hidden':'';
    $html = "<div class='$visibility px-4 flex gap-6 items-center'>
    <div class='w-8'><button onclick='window.location=\"".URI_NAME."/panel/".$_GET['zone']."?page=".$prevPage."\"' $prevButtonDisabled class='$prevButtonStyle'>«</button></div>
    <div class='w-8'><button onclick='window.location=\"".URI_NAME."/panel/".$_GET['zone']."?page=".$nextPage."\"' $nextButtonDisabled class='$btnNextStyle'>»</button></div>
    </div>";
    return $html;
}

public static function cronLog($message){
    $file = SITE_ROOT."/cron/logs.txt";
    $date = (new DateTime('now'))->format('d-m-Y H:i:s');
    $f = fopen($file,"a+");
    fwrite($f,"\n [$date] $message");
    fclose($f);
}


}