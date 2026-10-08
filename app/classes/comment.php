<?php
namespace App\classes;

use App\db\database;
use App\login\user;
use DateTime;
use PDO;

class comment{
    
    public static function insert($post_id,$comment,$author_name,$author_email,$parent_id = 0,$user_id = 0){
        $date = (new DateTime('Now'))->format('Y-m-d H:i:s');
        $user_id = user::logged('id') ? user::logged('id'):$user_id;
        $ip = $_SERVER['REMOTE_ADDR']?$_SERVER['REMOTE_ADDR']:0;
        $author_email = user::logged('email')?user::logged('email'):$author_email;
        $author_name = user::logged('name')?user::logged('name'):$author_name;
        $status = leemclasses::option('comment_initial_status')?leemclasses::option('comment_initial_status'):0;
        $status = user::isAdmin()?1:$status;
        $comment = htmlspecialchars($comment);

        return (new database('comments'))->insert(['post_id'=>$post_id,
                                                    'comment'=>"$comment",
                                                    'author_name'=>"$author_name",
                                                    'author_email'=>"$author_email",
                                                    'parent_id'=>$parent_id, 
                                                    'comment_date'=>"$date",
                                                    'user_id'=>$user_id,
                                                     'status'=>$status,
                                                    'ip'=>"$ip"]);

    }

    public static function update($VALUES,$WHERE){
        return (new database('comments'))->update($VALUES,$WHERE);
    }

    public static function delete($WHERE){
        return (new database('comments'))->delete($WHERE);
    }

    public static function select($WHERE = null,$ORDER=null,$LIMIT=null,$FIELDS = '*'){
        return (new database('comments'))->select($WHERE,$ORDER,$LIMIT,$FIELDS)->fetchAll(PDO::FETCH_CLASS);
    }

    public static function approve($id){
      return  self::update(['status'=>1],"id='$id'");
    }

    public static function approveAll(){
        return  self::update(['status'=>1],'status = 0');
      }

    public static function occult($id){
        return  self::update(['status'=>0],"id='$id'");
    }

    public static function reject($id){
        return self::delete("id='$id'");
    }

    public static function count($where = null){
        $response = self::select($where,null,null,'COUNT(id) as Total_comments');
        return $response[0] ? $response[0]->Total_comments:0;
    }



}