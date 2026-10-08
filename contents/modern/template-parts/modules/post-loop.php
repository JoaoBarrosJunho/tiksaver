<?php
include_once THEME_CLASSES.'/post.php';

/**START SEARCHARTICLES */
function showArticles($where,$num_rows = 6,$order=null){ 
    $where = $where? $where:null;
    $articles = getArticles($where,$order,$num_rows);
    return $articles;
}
/**END SEARCHARTICLES */