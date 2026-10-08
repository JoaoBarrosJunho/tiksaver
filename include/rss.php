<?php

use App\classes\language;
use App\classes\leemclasses;
use App\classes\post;
use App\login\user;

header('Content-Type: application/rss+xml; charset=utf-8');
$posts = post::selectPost("post_type='article' AND post_status='published' AND post_visibility='public'",null,'id DESC');
$created = user::getData("type=0 AND status=1",'id ASC',1)[0]->data_joined??null;
$date = $created?(new DateTime($created))->format("D, d M Y H:i:s"):(new DateTime('now'))->format("D, d M Y H:i:s");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>


<rss version="2.0">
  <channel>
    <title><?=$pagename?></title>
    <link><?=URI_NAME?></link>
    <description><?=leemclasses::option('site_description')?></description>
    <language><?=language::getLang()?></language>
    <pubDate><?=date(DATE_RSS,strtotime($date))?></pubDate>


    <?php
    if($posts){
        foreach($posts as $post){
            print '<item>
      <title>'.$post->post_title.'</title>
      <link>'.$post->post_guid.'</link>
      <description><![CDATA[
        '.$post->post_content.'
      ]]></description>
      <pubDate>'.date(DATE_RSS,strtotime($post->post_date)).'</pubDate>
      <guid>'.$post->post_guid.'</guid>
    </item>';
        }
    }

    ?>
    

    

  </channel>
</rss>
