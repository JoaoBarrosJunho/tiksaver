<?php

use App\classes\leemclasses;
use App\classes\post;

include_once THEME_CLASSES.'/grids.php';



function searchFeatureds($page,$num_rows = POSTS_LIMIT_DEFAULT){ 
    $where = null;
    $offset = (new leemclasses())->getOffset($page,$num_rows);
    $cat = getOption('slide_category');
    $articles = $cat?getArticlesByCategory($cat,$where,null,$num_rows.' OFFSET '.$offset):getArticles($where,null,$num_rows.' OFFSET '.$offset);
    
    return $articles;
}
$grid_latest = instanceGrid('featured-a');


function countPfeatures($post_category=null){   
    $count = $post_category ?post::selectPostsByCategory($post_category,"posts.post_type='article' AND posts.post_visibility='public'",null,null,"COUNT(posts.id) as Results"):post::selectPost("post_type='article' AND post_visibility='public'",null,null,"COUNT(id) as Results");
    $total = $count[0]->Results?$count[0]->Results:0;
    $limit = 0;

    if($total > 0 && $total<=5){
        $limit = 1;
    }else if($total > 5 && $total<=15){
        $limit = 2;
    }else if($total >= 15){
        $limit = 3;
    }

    return $limit;
}

//var_dump(countPfeatures());

?>

<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">-->
<link rel="stylesheet" href="<?=URI_NAME?>/assets/css/frameworks/splide-4.1.3/themes/splide-sea-green.min.css">


<style>
    .slider_cover_bg{
        background-size: cover;background-position: center;
    }
    .splide__progress__bar {
  height: 1px;
  margin-top: .5rem;
  background: var(--primary-color);
}
.image-fit{
    object-fit: cover;
}
</style>

    <section class="splide mb-4 bg-gray-50 text-gray-700 dark:bg-gray-700 dark:text-gray-300" aria-label="Splide Basic HTML Example">
    
    <div class="splide__track">
		<ul class="splide__list">
        <?php
            $fResults = countPfeatures(getOption('slide_category'));
            

            if($fResults){
                $Myi=1;
                while($Myi<=$fResults){
                    print '<li  class="splide__slide slider_cover_bg">';
                    print $grid_latest->gridArea(searchFeatureds($Myi,5),null);
                    print '</li>';
                    $Myi++;
                };

            }
            
                
            
        ?>
		</ul>
  </div>
  <!--<div class="grid md:grid-cols-2">
  <div class="splide__progress">
		<div class="splide__progress__bar">
		</div>
  </div>
  </div>-->
  
  
</section>



    

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script> 
  document.addEventListener( 'DOMContentLoaded', function() { 
    var splide = new Splide( '.splide',{type   : 'loop',
  perPage: 1,
arrows:false,//setas
autoplay:true,
rewind:true,
interval:10000,
classes:{
pagination:'splide__pagination focus:outline-none',
page:'splide__pagination__page focus:outline-none',
},
breakpoints: {
			640: {
				perPage: 1,
			},},
} ); 
/**splide.on( 'autoplay:playing', function ( rate ) {
  console.log( rate ); // 0-1
} );**/
    splide.mount(); 
  } ); 
</script>