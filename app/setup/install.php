<?php
use App\classes\leemclasses;
use App\classes\metatags;
use App\classes\post;
use App\classes\postmeta;
use App\classes\sitemap;
use App\classes\widget;
use App\controllers\robots;
use App\db\dbinfo;
use App\login\user;

$databasetemplate = SITE_ROOT . "/app/views/database-config.html";
$settingstemplate = SITE_ROOT . "/app/views/site-settings.html";
$finstall = SITE_ROOT . "/app/views/f-install.html";
$databaseInfo = SITE_ROOT."/app/db/mydb.php";



//START DATABASE CONFIG IF CONNECTION STATMENT HAS BEEN SUCCEDEED
if (isset($_POST['dbhost'], $_POST['dbname'], $_POST['dbuser'], $_POST['dbpass'])) {
    $host = $_POST['dbhost'];
    $name = $_POST['dbname'];
    $user = $_POST['dbuser'];
    $pass = $_POST['dbpass'];
    $conection = conectdatabase("$host", "$user", "$name", "$pass");
    if ($conection != false) {
        
        try {
            //JS Conection file
            if(!file_exists($databaseInfo)){
                $f = fopen("$databaseInfo","w");
                if(!fwrite($f,NewDataBaseInfo($host,$user,$pass,$name))){
                    echo 'Error creating database .env file!';
                }
                fclose($f);
            }

            //CREAT TABLES
            foreach(createTable() as $key=>$value){
                $statment = $conection->exec($value);
                if($statment != 0){
                    echo "\n$statment...";
                }
            }

            
        } catch (PDOException $e) {
            print("\nNovo erro" . $e->getMessage());
        }
    }else{
        header('location:'.URI_NAME.'?error');
    }
}



if(!file_exists($databaseInfo)){
    //CONFIG DATABASE
getDatabaseTemplate($databasetemplate);
}else{
    //CONFIG START PAGE
    $db = (new dbinfo())->inite();
    $database = conectdatabase($db['host'],$db['user'],$db['name'],$db['pass']);
    if($database){
        //VERIFY STEP 2 
        $step2 =  leemclasses::option('site_title') && leemclasses::option('site_description') && leemclasses::option('website_address') && user::getData('type=0 AND status=1',null,1)?true:false;
        
        if(isset($_POST['site_title'],$_POST['site_description'],$_POST['website_address'],$_POST['name'],$_POST['email'],$_POST['password'])){
            
            $site_title = !empty($_POST['site_title']) && $_POST['site_title'] != ' '?$_POST['site_title']:"Untitled";
            $site_description = !empty($_POST['site_description'])?$_POST['site_description']:" ";
            $site_adress = !empty($_POST['website_address'])?$_POST['website_address']:URI_NAME;
            $name = !empty($_POST['name'])?$_POST['name']:"Undefined";
            $email = !empty($_POST['email']) && $_POST['email']!=' '?$_POST['email']:null;
            $password = !empty($_POST['password']) && $_POST['password']!=' '?$_POST['password']:null;

            if($email && $password && checkTables($database,'user') && checkTables($database,'options')){
            //START INSERT OPTIONS AND USER ADMIN ACCOUNT
                $options = setOptions($site_title,$site_description,$site_adress);
                $admin = addAdmin($name,$email,$password);
               # $widgets = creatWidgets();
                if($options && $admin /**&& $widgets**/){
                    $step2 = true;
                    creatExamplePost();
                }
            
            }else{
                header("location:".URI_NAME."?error");
            }

        }
       
        if(!$step2){
            getsiteSettingsTemplate($settingstemplate);
        }else{
           
            complete_install();
            (new sitemap())->updateIndex();
            robots::ReseTset();
            
            getFinallTemplate($finstall);
        }
        
    }else{
        unlink($databaseInfo);
        header('location:'.URI_NAME.'?error');
        die();
    }
    
}

function complete_install(){
    $dir_inite_setup = SITE_ROOT.'/app/setup/inite.php';
    $f = fopen("$dir_inite_setup",'w+');
    fwrite($f,'<?php'."\n".'$install_ = true;');
    fclose($f);
    
}

function NewDataBaseInfo($host,$user,$pass,$dbname){
    $string = '<?php $conn_info = ["host"=>"'.$host.'","user"=>"'.$user.'","pass"=>"'.$pass.'","name"=>"'.$dbname.'"];';
    return $string;
}

function getDatabaseTemplate($file){
   /** $file2 = SITE_ROOT."/assets/js/app.js";
    * var_dump(str_replace('@apidir',URI_NAME."/api",file_get_contents($file2)));*/
    if (file_exists($file)) {
        $alert = isset($_GET['error'])?leemclasses::notification("Error connecting database...",3000,'bg-red-100'):'';
        $content = file_get_contents($file);
        $page = str_replace(['@dir', '@inputstyle', '@buttonstyle','@alert'], [URI_NAME, style['input-text'], style['btn-purple-np'],$alert], $content);
        print $page;
        die();
    }
}



function getsiteSettingsTemplate($file){
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $page = str_replace(['@dir', '@inputstyle', '@buttonstyle','@siteaddress'], [URI_NAME, style['input-text'], style['btn-purple-np'],URI_NAME], $content);
        print $page;
        die();
    }
}

function getFinallTemplate($file){
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $page = str_replace(['@dir', '@buttonstyle'], [URI_NAME,  style['btn-purple-np']], $content);
        print $page;
        die();
    }
}




function conectdatabase($host, $user, $name, $pass)
{
    try {
        $conection = new PDO("mysql:host=" . $host . ";dbname=" . $name, $user, $pass);
        $conection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conection;
    } catch (PDOException $e) {
        return false;
    }
}


//TABLE QUERYES!
function createTable()
{
    $query = ["CREATE TABLE IF NOT EXISTS logs (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,token varchar(255) NOT NULL,email varchar(255) NOT NULL,data_validate date NOT NULL)",
    "CREATE TABLE IF NOT EXISTS metatags (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,name varchar(255) NOT NULL,slug varchar(255) NOT NULL,type varchar(255) NOT NULL)",
    "CREATE TABLE IF NOT EXISTS navitems (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,nav_name varchar(255) NOT NULL,nav_items TEXT NOT NULL,nav_area varchar(255) NOT NULL)",
    "CREATE TABLE IF NOT EXISTS options (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,option_name varchar(255) NOT NULL,option_value TEXT NOT NULL, UNIQUE(option_name))",
    "CREATE TABLE IF NOT EXISTS postmeta (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,post_id int NOT NULL,meta_key TEXT NOT NULL,meta_value TEXT NOT NULL)",
    "CREATE TABLE IF NOT EXISTS posts (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,post_author int NOT NULL,post_date DATETIME NOT NULL,post_date_update DATETIME NOT NULL,post_content LONGTEXT NOT NULL,post_title TEXT NOT NULL,post_status varchar(255),post_visibility varchar(255) NOT NULL,comment_status int NOT NULL,post_slug VARCHAR(500) NOT NULL,post_type varchar(255) NOT NULL,post_att_type VARCHAR(255) NOT NULL,post_guid VARCHAR(255) NOT NULL)",
    "CREATE TABLE IF NOT EXISTS user (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,email VARCHAR(255) NOT NULL,password VARCHAR(255) NOT NULL,name VARCHAR(255) NOT NULL,username VARCHAR(255) NOT NULL,type INT NOT NULL,picture VARCHAR(500) NULL,data_joined DATETIME NULL,status INT NOT NULL,hash TEXT NOT NULL, UNIQUE(email))",
    "CREATE TABLE IF NOT EXISTS widgets (id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,widget_name VARCHAR(255) NOT NULL,widget_content TEXT NOT NULL,widget_type VARCHAR(255) NOT NULL,widget_parent INT NULL)",
    "CREATE TABLE IF NOT EXISTS postmetrics (id INT NOT NULL AUTO_INCREMENT , post_id INT NOT NULL , date DATE NOT NULL , ip TEXT NOT NULL , ip_country VARCHAR(255) NOT NULL , agent TEXT NOT NULL , PRIMARY KEY (id))",
    "CREATE TABLE IF NOT EXISTS comments (id INT NOT NULL AUTO_INCREMENT , post_id INT NOT NULL , comment TEXT NOT NULL, author_name VARCHAR(255) NOT NULL , author_email VARCHAR(255) NOT NULL , user_id INT NOT NULL , comment_date DATETIME NOT NULL,parent_id INT NOT NULL,status INT NOT NULL,ip TEXT NOT NULL, PRIMARY KEY (id))",
    "CREATE TABLE IF NOT EXISTS usermeta (`id` INT NOT NULL AUTO_INCREMENT, user_id INT NOT NULL , meta_key VARCHAR(255) NOT NULL , meta_value TEXT NOT NULL , status INT NOT NULL , created DATETIME NOT NULL , updated DATETIME NOT NULL,PRIMARY KEY (id) )",
    "CREATE TABLE IF NOT EXISTS `black_list` (`id` int NOT NULL AUTO_INCREMENT,`ip` text  NOT NULL,`created` datetime NOT NULL,`updated` datetime NOT NULL,PRIMARY KEY (`id`))",
    "CREATE TABLE IF NOT EXISTS `api_logs` (`id` int NOT NULL AUTO_INCREMENT,`api_id` int NOT NULL,`action_key` varchar(255)  NOT NULL,`created` datetime NOT NULL,`updated` datetime NOT NULL,`user_agent` text  NOT NULL,`user_ip` text  NOT NULL,PRIMARY KEY (`id`))",
    "CREATE TABLE IF NOT EXISTS `api_tokens` (`id` int NOT NULL AUTO_INCREMENT,`user_id` int NOT NULL,`api_name` varchar(255)  NOT NULL,`auth_token` text  NOT NULL,`status` int NOT NULL,`created` datetime NOT NULL,`updated` datetime NOT NULL,`asLimited` int NOT NULL,`day_limit` int NOT NULL,PRIMARY KEY (`id`))",
    "CREATE TABLE IF NOT EXISTS `tk_links` (`id` int NOT NULL AUTO_INCREMENT,`video_id` text  NOT NULL,`video_cover` text  NOT NULL,`video_data` text  NOT NULL,`created` datetime NOT NULL,`updated` datetime NOT NULL,`user_ip` text  NOT NULL,PRIMARY KEY (`id`))"];

return $query;
}

function checkTables($database,$table_name){
$query = "SHOW TABLES LIKE '$table_name'";
$statment = $database->prepare($query);
$statment->execute();

$result = $statment->fetchAll(PDO::FETCH_CLASS);
return  $result ? true:false;
}

function setOptions($site_title,$site_description,$site_adress){
    $options = ['site_title'=>"$site_title",
                'site_description'=>"$site_description",
                'website_address'=>"$site_adress",
                'role_subscribers'=>"Subscriber",
                'site_language'=> 'en',
                'time_zone'=> 'Europe/Lisbon',
                'date_format' => 'd/m/Y',
                'time_format'=> 'H:i',
                'user_update_email' => 'NULL',
                'not_allowed_formats' => 'exe,bat,php,html,xml,js',
                'smtp_host' => '',
                'smtp_port' => '',
                'smtp_username' => '',
                'active_theme'=>'modern',
                'smtp_password'=>'',
                'new_user_status' => '2',
                'smtp_from' => 'geral@mysite.com',
                'smtp_noreply' => 'noreply@mysite.com',
                'smtp_secure' => 'ssl',
                'theme_option'=>'{"nav_header":"title","header_color":"#ea284e","header_background":"#ffffff","show_darkmode":"0","show_langToogle":"0","show_footer_nav":"0","footer_color":"","footer_background":"","copy_text":"","show_email_inbox_count":"1","home_modules":"","show_ads_home":"0","show_ads_inbox":"0","show_ads_page":"0","ads_after_header":"","ads_after_generate_section":"","ads_after_email_section":"","ads_before_footer":"","header":"","body_area":"","footer":"","custom_css":"","custom_html":"","custom_script":"","main_text_font":"font-inter","main_text_size":"text-lg","main_text_weight":"font-medium","nav_font":"font-inter","nav_text_size":"text-sm","nav_text_weight":"","heading_font":"","heading_size":"","heading_weight":"","only_darkmode":"0","primary_color":"#ea284e","body_color":"","body_background":"","generate_s_txt":"#ffffff","generate_s_bg":"#18485e","module_color":"","module_background":"","pagination_color":"#ffffff","pagination_background":"#ea284e","copyright_color":"","copyright_background":"","content_color":"","link_color":"","meta_color":"#4c4f52"}',
                'theme-elements'=>'"\/*This stylesheet is updated by php UPDATED: 11-03-2025 05:20 *\/:root{--primary-color:#ea284e;}.text-primary{color: var(--primary-color);}.bg-primary{background-color: var(--primary-color);}.border-primary{border-color: var(--primary-color);}.theme-body{ background-color: #f9fafb;}.header-styling{ background-color: #ffffff; color: #ea284e;}.footer-styling{ background-color: #fff; color: #000;}.module-styling{ background-color: #fff; color: inherit;}.pagination-styling{ background-color: #ea284e; border-color: #ea284e; color:#ffffff;}.copy-area{ background-color: #fff; color: #000;}.content-styling{ color: #000;}a{ color: inherit;}.meta-styling{ color: #4c4f52;}"'

];

try{
    foreach($options as $key=>$value){
        echo leemclasses::setOptions("$key",$value);
      }
      return true;
}catch(Exception $e){
leemclasses::newLog("INSTALL SCRIPT: ".$e->getMessage());
return false;
}
}



function addAdmin($name,$email,$password){

    try{
        $addUser = new user();
        $addUser->SetAllData($name,$email,md5($password),0,1,null);
        $addUser->addUser();
        return true;
    }catch(Exception $e){
        leemclasses::newLog("INSTALL SCRIPT: ".$e->getMessage());
        return false;
    }

}

function creatWidgets(){
    try{
        (new widget())->insertWidget('Sidebar default',' ','sidebar_area');
        (new widget())->insertWidget('Footer 1',' ','footer_area');
        (new widget())->insertWidget('Footer 2',' ','footer_area');
        (new widget())->insertWidget('Footer 3',' ','footer_area');
        (new widget())->insertWidget('Footer 4',' ','footer_area');

        return true;
    }catch(Exception $e){
        leemclasses::newLog("INSTALL SCRIPT: ".$e->getMessage());
        return false;
    }
}



function creatExamplePost(){
   
    $post_date = (new DateTime('now'))->format('Y-m-d h:i:s');


    $page_content = file_get_contents(SITE_ROOT."/app/views/privacy-policy.html");
    $page_content = str_replace(['@siteName','@siteUrl'],[leemclasses::option('site_title'),URI_NAME],$page_content);
    $page_title = 'Privacy Policy';
    $page_slug = leemclasses::genUnicSlug($page_title,null,'posts','post_slug');
    $page_guid = leemclasses::genGuid($page_slug);
    $page = (new post())->postPage($page_title,$page_slug,$page_guid,'Published',$page_content,'public',0,$post_date);

    if($page){
    leemclasses::setOptions('privacy_policy_page',"$page_guid");
    }
}

