<?php

use App\classes\leemclasses;

$def_theme_options = '{"nav_header":"title","header_color":"#ea284e","header_background":"#ffffff","show_darkmode":"0","show_langToogle":"0","show_footer_nav":"0","footer_color":"","footer_background":"","copy_text":"","show_email_inbox_count":"1","home_modules":"","show_ads_home":"0","show_ads_inbox":"0","show_ads_page":"0","ads_after_header":"","ads_after_generate_section":"","ads_after_email_section":"","ads_before_footer":"","header":"","body_area":"","footer":"","custom_css":"","custom_html":"","custom_script":"","main_text_font":"font-inter","main_text_size":"text-lg","main_text_weight":"font-medium","nav_font":"font-inter","nav_text_size":"text-sm","nav_text_weight":"","heading_font":"","heading_size":"","heading_weight":"","only_darkmode":"0","primary_color":"#ea284e","body_color":"","body_background":"","generate_s_txt":"#ffffff","generate_s_bg":"#18485e","module_color":"","module_background":"","pagination_color":"#ffffff","pagination_background":"#ea284e","copyright_color":"","copyright_background":"","content_color":"","link_color":"","meta_color":"#4c4f52"}';
$def_theme_style = '"\/*This stylesheet is updated by php UPDATED: 11-03-2025 05:20 *\/:root{--primary-color:#ea284e;}.text-primary{color: var(--primary-color);}.bg-primary{background-color: var(--primary-color);}.border-primary{border-color: var(--primary-color);}.theme-body{ background-color: #f9fafb;}.header-styling{ background-color: #ffffff; color: #ea284e;}.footer-styling{ background-color: #fff; color: #000;}.module-styling{ background-color: #fff; color: inherit;}.pagination-styling{ background-color: #ea284e; border-color: #ea284e; color:#ffffff;}.copy-area{ background-color: #fff; color: #000;}.content-styling{ color: #000;}a{ color: inherit;}.meta-styling{ color: #4c4f52;}"';

leemclasses::setOptions("theme_option",$def_theme_options);
leemclasses::setOptions("theme-elements",$def_theme_style);

header("location:".URI_NAME."/panel/theme-options");



