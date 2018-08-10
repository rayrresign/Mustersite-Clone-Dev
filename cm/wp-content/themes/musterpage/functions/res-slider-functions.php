<?php 

function wp_get_slider_function() {
	require_once("module/revolution-slider/slider-homescreen-video.php");
    wp_die();
}
add_action( 'wp_ajax_wp_get_slider_function', 'wp_get_slider_function' );
add_action( 'wp_ajax_nopriv_wp_get_slider_function', 'wp_get_slider_function' );

function wp_get_slider_function_mobile() {
	require_once("module/revolution-slider/slider-homescreen-video-mobile.php");
    wp_die();
}
add_action( 'wp_ajax_wp_get_slider_function_mobile', 'wp_get_slider_function_mobile' );
add_action( 'wp_ajax_nopriv_wp_get_slider_function_mobile', 'wp_get_slider_function_mobile' ); 

?>