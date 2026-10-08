<?php
namespace App\classes;
use App\db\database;
use App\login\user;
use DateTime;
use Exception;
use PDO;

class post{
    private $id;
    private $post_autor;
    private $post_date;
    private $post_date_updated;
    private $post_content;
    private $post_title;
    private $post_status; //1 public, 0 private ,2 rascunho(draft)
    private $post_comment_status; //1 enabled, 0 disabled
    private $post_slug;
    private $post_type; //post,page, attachment,oters
    private $post_att_type; // format
    private $guid; // format

    public function getId() {
        return $this->id;
    }

    public function getGuid() {
        return $this->guid;
    }

    public function getPost_autor() {
        return $this->post_autor;
    }

    public function getPost_date() {
        return $this->post_date;
    }

    public function getPost_date_updated() {
        return $this->post_date_updated;
    }

    public function getPost_content() {
        return $this->post_content;
    }

    public function getPost_title() {
        return $this->post_title;
    }

    public function getPost_status() {
        return $this->post_status;
    }

    public function getPost_comment_status() {
        return $this->post_comment_status;
    }

    public function getPost_slug() {
        return $this->post_slug;
    }

    public function getPost_type() {
        return $this->post_type;
    }

    public function getPost_att_type() {
        return $this->post_att_type;
    }

    
    public function setId($id): void {
        $this->id = $id;
    }
    public function setGuid($guid): void {
        $this->guid = $guid;
    }

    public function setPost_autor($post_autor): void {
        $this->post_autor = $post_autor;
    }

    public function setPost_date($post_date): void {
        $this->post_date = $post_date;
    }

    public function setPost_date_updated($post_date_updated): void {
        $this->post_date_updated = $post_date_updated;
    }

    public function setPost_content($post_content): void {
        $this->post_content = $post_content;
    }

    public function setPost_title($post_title): void {
        $this->post_title = $post_title;
    }

    public function setPost_status($post_status): void {
        $this->post_status = $post_status;
    }

    public function setPost_comment_status($post_comment_status): void {
        $this->post_comment_status = $post_comment_status;
    }

    public function setPost_slug($post_slug): void {
        $this->post_slug = $post_slug;
    }

    public function setPost_type($post_type): void {
        $this->post_type = $post_type;
    }

    public function setPost_att_type($post_att_type): void {
        $this->post_att_type = $post_att_type;
    }

    


/**
 * Metodo responsavel pelo cadastramento de ficheiros no banco de dados
 * @param string $title
 * @param string $slug
 * @param string $att_type
 * @param string $guid
 * @return array
 */
public function postAttachment($title,$slug,$att_type,$guid, $status='inherit', $content=''){
    $post = $this->InsertPost(['content'=>"$content",'title'=>"$title",'status'=>"$status",'visibility'=>'inherit','comment_status'=>0,'slug'=>$slug,'type'=>'attachment','att_type'=>"$att_type",'guid'=>"$guid"]);
    if($post>0){
        $response = ['success'=>true,'attachment_id'=>"$post"];
        return $response;
    }else{
        $response = ['success'=>false];
        return $response;
    }
}



/**
 * Metodo responsavel por gerar slug das postagens
 * @param string
 * @return string
 */
public static function getSlug($string){
try{

return urilize::text($string);
}catch(Exception $e){
    leemclasses::newLog("Error slug: ".$e->getMessage());
}
}

public static function genFilename($filename,$dir){
    $extension = leemclasses::getExtension($filename);
    $name = pathinfo($filename,PATHINFO_FILENAME);
    $name = self::getSlug($name);

    $oldname = $name;
    $i=0;
    while(file_exists("$dir/"."$name.$extension")){
        $i++;
        $name = $oldname.'-'.$i;
    }

    return $name;
}

public function InsertPost($data = ['content'=>'','title'=>'','status'=>'','visibility'=>'inherit','comment_status'=>'','slug'=>'','type'=>'','att_type'=>'','guid'=>'','date'=> '']){
    $post_date = isset($data['date']) && $data['date']!= ''? $data['date']: date('Y-m-d H:i:s');

    $author = user::logged('id')!=null?user::logged('id'):'1';
    $author = $this->post_autor ? $this->post_autor:$author;
    $add = (new database('posts'))->insert(
        ['post_author'=>"$author",
        'post_date'=>"$post_date",
        'post_date_update'=>"$post_date",
        'post_content'=> $data['content'],
        'post_title'=>$data['title'],
        'comment_status'=>$data['comment_status'],
        'post_status'=> strtolower($data['status']),
        'post_visibility'=> strtolower($data['visibility']),
        'post_slug'=>$data['slug'],
        'post_type'=>$data['type'],
        'post_att_type'=>$data['att_type'],
        'post_guid'=>$data['guid']]);

    
    if(strtolower($data['visibility'])=='public'){
        $type_ = strtolower($data['type']);
        $sitemap = new sitemap();
        $sitemap->update(strtolower($type_));
        if($type_=='article'){
            $sitemap->update('tag');
            $sitemap->update('category');
        }

    }

    return $add;
}


public static function selectPost($where=null,$limit=null, $order=null,$fields='*'){
    
     $post = (new database('posts'))->select($where,$order,$limit,$fields)
    ->fetchAll(PDO::FETCH_CLASS);

     return $post;
}

public function updatePost($VALUES,$WHERE){
    if(isset($VALUES['post_status'])){
        $VALUES['post_status'] = strtolower($VALUES['post_status']);
    }

    if(isset($VALUES['post_visibility'])){
        $VALUES['post_visibility'] = strtolower($VALUES['post_visibility']);
    }

    $VALUES['post_date_update'] = (new DateTime('now'))->format("Y-m-d H:i:s");

    if((new database('posts'))->update($VALUES,$WHERE)){
        return true;
    }
    return false;
}

public static function update($VALUES,$WHERE){
    if(isset($VALUES['post_status'])){
        $VALUES['post_status'] = strtolower($VALUES['post_status']);
    }

    if(isset($VALUES['post_visibility'])){
        $VALUES['post_visibility'] = strtolower($VALUES['post_visibility']);
    }

    $VALUES['post_date_update'] = (new DateTime('now'))->format("Y-m-d H:i:s");

    if((new database('posts'))->update($VALUES,$WHERE)){
        return true;
    }
    return false;
}


public static function deletePost($WHERE){
    if((new database('posts'))->delete($WHERE)){
        return true;
    }
    return false;
}

public static function selectPostInnerMeta($where=null,$order = null,$limit = null,$fields = '*'){
$inner = 'posts ON postmeta.post_id = posts.id';
$result = (new database('postmeta'))->selectINNERJOIN($where,$inner,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS);
return $result;
}

public static function selectPostsByCategory($category,$where=null,$order = null,$limit = null,$fields = '*'){
    $inner = 'posts ON postmeta.post_id = posts.id AND postmeta.meta_key="post_category" AND postmeta.meta_value="'.$category.'"';
    $result = (new database('postmeta'))->selectINNERJOIN($where,$inner,$order,$limit,$fields)->fetchAll(PDO::FETCH_CLASS);
    return $result;
    }

public static function countPosts($where=null){
    $posts = post::selectPost($where,null,null,'COUNT(id) as Total_posts');
    return $posts[0]->Total_posts;
}

/**
 * Metodo responsavel por consulturar arquivos no banco de dados
 * @param int $page 
 * @param string $where
 * @param string $fields
 * @param int $limit
 * @param string $order
 * @return array
 */
public static function getAttachemnt($page = 1,$where = null,$fields=null,$limit=10,$order=null){
   
    $offset = ($page-1)*$limit;
    $WHERE = $where!=null?$where:"post_type='attachment'";
    $FIELDS = $fields!=null?$fields:'*';
    $ORDER = $order!=null?$order:'id DESC';
    $LIMIT = "$limit OFFSET $offset";

    return self::selectPost($WHERE,$LIMIT,$ORDER,$FIELDS);
}


//CREATE ARTICLE 

/**
 * Metodo responsavel pelo cadastramento de ficheiros no banco de dados
 * @param string $title
 * @param string $slug
 * @param string $att_type
 * @param string $guid
 * @return array
 */
public function postArticle($title,$slug,$guid, $status='inherit', $content='',$visibility='inherit',$comment_status=0,$date = ''){
    $post = $this->InsertPost(['content'=>$content?htmlspecialchars($content):$content,'title'=>"$title",'status'=>"$status",'visibility'=>"$visibility",'comment_status'=>$comment_status,'slug'=>$slug,'type'=>'article','att_type'=>" ",'guid'=>"$guid",'date'=>"$date"]);
    if($post>0){
        $response = ['success'=>true,'article_id'=>$post];
        return $response;
    }else{
        $response = ['success'=>false];
        return $response;
    }
}

public function updateArticle($id,$title,$slug,$guid, $status='inherit', $content='',$visibility='inherit',$comment_status=0,$date=''){
   $updateTime = date('Y-m-d H:i:s');
    $post = $this->updatePost(['post_content'=>$content?htmlspecialchars($content):$content,'post_date'=>$date,'post_date_update'=>"$updateTime",'post_title'=>"$title",'post_status'=>"$status",'post_visibility'=>"$visibility",'comment_status'=>$comment_status,'post_slug'=>$slug,'post_type'=>'article','post_att_type'=>" ",'post_guid'=>"$guid"],"id='$id'");
    
    if($post>0){
        $response = ['success'=>true,'article_id'=>"$id"];
        return $response;
    }else{
        $response = ['success'=>false];
        return $response;
    }
}

public static function genPostSlug($post_title){
    $slug = self::getSlug($post_title);

    $initial_slug = $slug;
    $i=0;
    while(self::selectPost("post_slug='$slug'")){
        $i++;
        $slug = $initial_slug.'-'.$i;
    }

    return $slug;
}

public function postPage($title,$slug,$guid, $status='inherit', $content='',$visibility='inherit',$comment_status=0,$date = ''){
    $post = $this->InsertPost(['content'=>"$content",'title'=>"$title",'status'=>"$status",'visibility'=>"$visibility",'comment_status'=>$comment_status,'slug'=>$slug,'type'=>'page','att_type'=>" ",'guid'=>"$guid",'date'=>"$date"]);
    if($post>0){
        $response = ['success'=>true,'post_id'=>"$post"];
        return $response;
    }else{
        $response = ['success'=>false];
        return $response;
    }
}

/**
 * Metodo responsavel por excluir um arquivo do banco de dados e do diretorio
 * @param int $id post id
 * @param string $path Path to the file
 * @return array 
 */
public static function deleteAttachment($id,$path = 'uploads'){
    $success = false;
    $message = '';
    $searchAttachment = (new post())->selectPost("id = '$id' AND post_type = 'attachment'");

    if($searchAttachment){

        $guid = !empty($searchAttachment[0]->post_guid)?$searchAttachment[0]->post_guid: '404-notfile.null';
        $filename = "/$path/".pathinfo($guid,PATHINFO_BASENAME);
        $file_dir = SITE_ROOT."".$filename;
        
        if((new post)->deletePost("id='$id'")){
            $success = true;
            $message = 'Attachment has been deleted! ';
            if(file_exists($file_dir)){
                if(!unlink($file_dir)){
                    $message .= "But attachment not exist in directory especified ($file_dir)";
                }
            }else{
                $message .= "But attachment not exist in ($file_dir)";
            }
        }else{
            $message = 'Error to delete this attachment!';
        }

          
    
    }else{
        $message = 'Attachment not found';
    }

    $response = ['success'=>$success, 'message'=>$message];
    return $response;

}

public function updatePage($id,$title,$slug,$guid, $status='inherit', $content='',$visibility='inherit',$comment_status=0,$date = ''){
    $updateTime = date('Y-m-d H:i:s');
     $post = (new post())->updatePost(['post_content'=>"$content",'post_date'=>$date,'post_date_update'=>"$updateTime",'post_title'=>"$title",'post_status'=>"$status",'post_visibility'=>"$visibility",'comment_status'=>$comment_status,'post_slug'=>$slug,'post_type'=>'page','post_att_type'=>" ",'post_guid'=>"$guid"],"id='$id'");
     
     if($post>0){
         $response = ['success'=>true,'article_id'=>"$id"];
         return $response;
     }else{
         $response = ['success'=>false];
         return $response;
     }
 }


 public static function check_schedule(){
    $dateNow = (new DateTime('now'))->format("Y-m-d H:i:s");
    $dateOld = (new DateTime('2000-01-01 00:00:00'))->format("Y-m-d H:i:s");
    $schedules = self::selectPost("post_type='article' AND post_visibility='schedule' AND post_date <='$dateNow'",null,null,'id');
    $response = false;
    if($schedules){
        foreach($schedules as $post){
            self::update(['post_visibility'=>'public','post_status'=>'published'],"id=$post->id");
        }
        $response=true;
    }
    

    return $response;
 }
}
