<?php
include_once THEME_CLASSES.'/grids.php';
include_once THEME_CLASSES.'/post.php';




/**START SEARCHARTICLES */
function searchArticles($where,$num_rows = 6){ 
    $where = isset($_GET['s'])?" post_title LIKE '%".$_GET['s']."%' ":null;
    $articles = getArticles($where,null,$num_rows.' OFFSET 0');
    
    return $articles;
}
/**END SEARCHARTICLES */


/** SERCH FOR CATEGORY**/
function searchByCategory($meta_id,$order=null,$limit=6){ 
    $order = $order?$order:'post_id DESC';
    $num_rows = $limit;
    $articles = postsByCategory($meta_id,$order,$num_rows);
    
    return $articles;
}



function show_list($title = null,$where = null,$num_rows = 6, $grid_style = null,$category_id=null){

$grid_template = $grid_style?$grid_style:'default-grid';
$grid_list = instanceGrid($grid_template);
$title = $title?"$title":'';

if(!$category_id){
    print $grid_list->gridArea(searchArticles($where,$num_rows),$title);
}else{
    print $grid_list->gridArea(searchByCategory($category_id,null,$num_rows),$title);
}

}

