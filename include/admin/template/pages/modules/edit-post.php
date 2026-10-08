<?php 
use App\classes\post;
use App\classes\metatags;
use App\classes\postmeta;

$data = [];

if(isset($_GET['edit']) && is_numeric($_GET['edit'])){
$id = $_GET['edit'];

$post_data = post::selectPost("id='$id' AND post_type = '$post_type'");

if($post_data){
	$post = $post_data[0];

	//SEARCH POST FEATURED IMG
	$featuredMeta = postmeta::selectPostMeta("post_id='$post->id' AND meta_key='featured_img'");
	$featuredImg = $featuredMeta ? $featuredMeta[0]->meta_value:null;

	//SEARCH CATEGORYES
	$catResult = postmeta::selectPostMeta("post_id='$post->id' AND meta_key='post_category'",'meta_value');
	$categoryes = [];
	foreach($catResult as $c){
	$categoryes[] = $c->meta_value;
	}

	//SEARCH TAGS
	$tagsResult = postmeta::selectPostMeta("post_id='$post->id' AND meta_key='post_tag'",'meta_value');
	$tags = [];

	foreach($tagsResult as $t){
		$tagValue = metatags::selectMetaTags("id='$t->meta_value' AND type='tag'",'name');
		$tags[] = $tagValue[0]->name;
	}

	//POST INFORMATION
	$data = ['id'=>$id,
	'title'=>$post->post_title,
	'data'=>$post->post_date,
	'data_update'=>$post->post_date_update,
	'content'=> $post->post_content?htmlspecialchars_decode($post->post_content):$post->post_content,
	'status'=>$post->post_status,
	'visibility'=>$post->post_visibility,
	'comment_status'=>$post->comment_status,
	'slug'=>$post->post_slug,
	'guid'=>$post->post_guid,
	'featured'=>$featuredImg,
	'categoryes'=>$categoryes,
	'tags'=>implode(",",$tags)];
}else{
	$home = URI_NAME."/panel";
	echo "<script>
	window.location = '$home';
	</script>";
	die();
}
}



function data($data,$name){
$value = isset($data[$name]) ? $data[$name]:'';
return $value;
}