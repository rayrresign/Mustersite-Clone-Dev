<?php
/*
Plugin Name: Ultimate Nofollow
Plugin URI: http://5fifty.co.uk
Description: A suite of tools that gives you complete control over the rel=nofollow tag on an individual link basis.
Version: 1.4.7
Author: 5fifty
Author URI: http://5fifty.co.uk
License: GPLv2
	Copyright 2017 5fifty (5fifty.co.uk)

This plugin contains several tools in one to significantly increase your control of the nofollow rel tag on every link on your blog, on both an individual and type basis. It is designed to give you fine-grained control of linking for SEO purposes.

Notice: This plugin changes WordPress functionality in a way that is not modular and may break with WP-Core updates.

*/

/**********************************************
* ADD LINK DIALOGUE NOFOLLOW CHECKBOX SECTION *
***********************************************/
function nofollow_redo_wplink() {
	wp_deregister_script( 'wplink' );
	
	$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
//	' . $suffix . '
	wp_register_script( 'wplink',  get_template_directory_uri().'/functions/nofollow/wplink.js', array( 'jquery', 'wpdialogs' ), false, 1 ); 
	
	wp_localize_script( 'wplink', 'wpLinkL10n', array(
		'title' => __('Insert/edit link'),
		'update' => __('Update'),
		'save' => __('Add Link'),
		'noTitle' => __('(no title)'),
		'noMatchesFound' => __('No matches found.')
	) );
}
add_action( 'admin_enqueue_scripts', 'nofollow_redo_wplink', 999 );


/************************************
* NOFOLLOW ON COMMENT LINKS SECTION *
*************************************/

// add/remove nofollow from all comment links
function ultnofo_comment_links( $comment ) {
	$options = get_option( 'ultnofo_item' );
	if( !$options[ 'nofollow_comments' ] )
		$comment = str_replace( 'rel="nofollow"', '', $comment );
	elseif( !strpos( $comment, 'rel="nofollow"' ) )
		$comment = str_replace( '<a ', '<a rel="nofollow"', $comment ); 
	return $comment;	
}

/* add hooks/filters */
// add/remove nofollow from comment links
add_filter('comment_text', 'ultnofo_comment_links', 10);

?>
