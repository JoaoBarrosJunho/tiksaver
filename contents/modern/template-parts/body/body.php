<?php

include_once THEME_CLASSES.'/router.php';


$router_response = getContent();
$adsEnable = isset($router_response['show_ads'])?$router_response['show_ads']:true;
$SEO = isset($router_response['seo'])?$router_response['seo']:[];
siteHeader($router_response['page_title'],printAds('ads_after_header',$adsEnable),$SEO);

function bodyStyle(){
    //Return the style of Modules
    return 'w-full module-styling theme-module dark:bg-gray-800';
}

?>
<!--Content area-->
<div class="<?= theme_t['text']?> min-h-screen-sm md:mx-12 mt-6 mb-6 px-4 py-3 dark:text-gray-200">
    <?php 
    include_once 'main.php'; 
    ?>
</div>
<!--Content area-->

<?= printAds('ads_before_footer',$adsEnable)?>
<!--Fotter area -->
<footer class="flex flex-col w-full dark:text-gray-200">


<div class="<?= theme_t['text']?> w-full flex justify-center py-4 px-4  footer-styling  dark:bg-gray-800 dark:text-gray-100" id="widgets_footer">
<?php !getOption('show_footer_nav') ? include_once 'footer-menu.php' : null; ?>
<!-- Footer menu -->
</div>


<div class="text-sm w-full copy-area px-4 py-4 flex justify-center items-center dark:bg-gray-700 dark:text-gray-100" id="copy_right">
<?= getOption('copy_text')?str_replace(['@site_title','@site_url','@site_description','@this_year'],[SITE_TITLE,URI_NAME,SITE_DESCRIPTION,date('Y')],getOption('copy_text')):"Copyright &copy; ".date('Y')." ".SITE_TITLE.", All rights reserved."?> 
</div> 

</footer>
<!--Fotter area -->