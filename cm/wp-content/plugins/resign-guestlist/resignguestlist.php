<?php
/*
Plugin Name: Resign Guestlist Plugin
Plugin URI: http://www.musterpage.ch/plugins/guestlist/
Version: 1.0
Description: Guestlist Plugin Stable Version 2015 (with EXEL) in Musterpage Theme v8
Author: RESIGN. Webagentur
Author URI: http://www.resign.ch
*/
/*  Copyright 2015 Rene Grob (info@resign.ch)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

*/

/* --------------------------- BACKEND --------------------------- */ 

add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
	add_menu_page('Guestlist Manager', 'Guestlist', 'edit_plugins', 'resignguestlist', 'pluginAdminScreen', 'dashicons-groups', 9);
}


function pluginAdminScreen() {	
global $wpdb;
	
	if (!current_user_can('edit_plugins'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	} else {
		require_once(plugin_dir_path( __FILE__ ) .'admin/guestlist-settings.php' );		
	}
	
	
}
function event_guestlist_init()
{
	function event_guestlist_ajax($atts = [], $content = null)
	{
		$content = include(plugin_dir_path( __FILE__ ) .'public/eventsGuestlistAjax.php');
		return $content;
	}
	add_shortcode('event_guestlist', 'event_guestlist_ajax');
}
add_action('init', 'event_guestlist_init');

function event_send_init()
{
	function event_send_ajax($atts = [], $content = null)
	{
		$content = include(plugin_dir_path( __FILE__ ) .'public/eventsSendAjax.php');
		return $content;
	}
	add_shortcode('event_send', 'event_send_ajax');
}
add_action('init', 'event_send_init');

add_action( 'wp_ajax_resign_write_db', 'resign_write_db' );
add_action( 'wp_ajax_nopriv_resign_write_db', 'resign_write_db' );

function resign_write_db(){	
//	 print_r('dataString: ');
//	 print_r($_POST['id']);
	include(plugin_dir_path( __FILE__ ) .'public/eventsSendAjax.php');
	
}

function guestlist_shortcode() {
	ob_start();
	// läd das File, wo die gesamte Strukur abhängt
	require(plugin_dir_path( __FILE__ ) .'public/eventsGuestlistAjax.php');
	
	// holt den abgefüllten Buffer und löscht den Aktuelle.
	$content = ob_get_clean(); 
	
	return $content;
	
};
add_shortcode( 'res_guestlist', 'guestlist_shortcode') ;

?>
