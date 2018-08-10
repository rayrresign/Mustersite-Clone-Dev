<?php
/**
*	get latest jquery
*/
function load_jquery_head(){
	if(!is_admin()){ // only in frontend
		wp_deregister_script('jquery');
		wp_deregister_script('jquery-core');
//		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js','',true);
//		wp_enqueue_script('jquery');	
	}
}
add_filter('wp_enqueue_scripts', 'load_jquery_head');
/**
 * Add async attributes to enqueued scripts where needed.
 * The ability to filter script tags was added in WordPress 4.1 for this purpose.
 */
function set_async_scripts( $tag, $handle, $src ) {
    // the handles of the enqueued scripts we want to async
//    $async_scripts = array('jquery');
	$async_scripts = array('jquery-core');
	if(!in_array( $handle, $async_scripts )){
		return '<script type="text/javascript" src="' . $src . '" defer></script>' . "\n";
	}else{
//		return '<script type="text/javascript" src="' . $src . '" ></script>' . "\n";
//		return '<script type="text/javascript" src="' . $src . '" async></script>' . "\n";
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'set_async_scripts', 10, 3 );
?>