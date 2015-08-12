<?php
/*
Plugin Name: DoctorLogic
Plugin URI: http://doctorlogic.com/wordpress-plugins
Description: Easily add DoctorLogic Reviews or Galleries to your website.
Version: 2.1.3
Author: DoctorLogic
Author URI: https://doctorlogic.com
License: GPLv2

Copyright 2015 DoctorLogic(tm)

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/


/*Uninstall*/
register_uninstall_hook(__FILE__,"dl_uninstall");

function dl_uninstall() {
delete_option('dl_site_key');
delete_option('dl_review_path');
delete_option('dl_gallery_path');
delete_option('dl_environment');
delete_option('dl_api');
delete_option('dl_css');

}

/*Includes*/
include_once (plugin_dir_path(__FILE__) . 'inc/palette.php');
include_once (plugin_dir_path(__FILE__) . 'inc/options-page.php');
include_once (plugin_dir_path(__FILE__) . 'inc/review.php');
include_once (plugin_dir_path(__FILE__) . 'inc/review-summary.php');
include_once (plugin_dir_path(__FILE__) . 'inc/gallery.php');
include_once (plugin_dir_path(__FILE__) . 'inc/gallery-summary.php');
include_once (plugin_dir_path(__FILE__) . 'inc/gallery-functions.php');

/*Enqueue scripts and styles*/

function dl_scripts() {
    /*Styles*/
    wp_register_style( 'dl-layout',  plugin_dir_url( __FILE__ ) . '/css/layout.css' );
    wp_register_style( 'dl-palette',  plugin_dir_url( __FILE__ ) . '/css/palette.css' );

    wp_enqueue_style( 'dl-layout' );
    wp_enqueue_style( 'dl-palette' );
    wp_enqueue_style ('dashicons');


    /*Scripts*/
    wp_register_style( 'dl-script',  plugin_dir_url( __FILE__ ) . '/scripts/scripts.js' );
	wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'dl-script' );
}

add_action( 'wp_enqueue_scripts', 'dl_scripts' );




/*Shortcodes*/
add_shortcode('DoctorLogicReviews', 'DoctorLogicReviews');
add_shortcode('DoctorLogicReviewSummary', 'DoctorLogicReviewSummary');
add_shortcode('DoctorLogicGallery', 'DoctorLogicGallery');
add_shortcode('DoctorLogicGallerySummary', 'DoctorLogicGallerySummary');

//That's all, folks!
?>