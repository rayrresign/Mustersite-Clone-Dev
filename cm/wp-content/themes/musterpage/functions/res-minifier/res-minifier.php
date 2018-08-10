<?php
/*
*	RESIGN Minifier 1.0 - Okt 2017
*/

// JS und CSS Files, welche minified werden ------
/**
	'bootstrap', 
	'font-awesome', 
*/
$CSS_INCLUDE = [
	'imagelightbox', 
	'res-animation', 
	'page-overlayer', 
	'pointer-nav',
	'content-slider',
	'partner-slider',
	'testimonials-slider',
	'revolution-slider-setting',
	'revolution-slider-layers',
	'revolution-slider-nav',
	'timeline-slider',
	'main_css'
];
$JS_INCLUDE = [ 
	'res-script_js', 
	'validate_bootstrap_js', 
	'imagelightbox_js-settings',
	'timeline-slider_js'
];
// --------------------------------------------------

$ADMIN_STYLES = [];
$ADMIN_SCRIPTS = [];

define('RES_MINIFIER_ENABLED', get_option('res_minifier_checkbox'));
require_once('minifier.php');

/*
*	gets the min.css file, which are included in $CSS_INCLUDE on request of the webpage
*/
function get_min_css_files(){
	global $wp_styles, $CSS_INCLUDE;
	
	if(!RES_MINIFIER_ENABLED) return;
	
	foreach ($wp_styles->queue as $css_name) { 
		// überspringt den nicht inkludierte CSS
        if(!in_array( $css_name, $CSS_INCLUDE, true)) continue;
		
		$css_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_styles->registered[$css_name]->src);	// /css/res-animations.css
		$css_filename = substr($css_uri, strrpos($css_uri, '/') + 1); // res-animations.css
		$css_path = str_replace($css_filename, '', $css_uri); // /css/
		$css_dir_path = get_stylesheet_directory() . $css_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$css_cache_file = str_replace('.css','', $css_filename) .'.min.css'; // res-animations.min.css
		
		// speichert die Zeit seit der letzten Modifizierung des Files in $cacheLastUpdated
		if(file_exists($css_dir_path . $css_cache_file)){
    		$cacheLastUpdated = filemtime($css_dir_path . $css_cache_file);
		}else{
			$cacheLastUpdated = 0;
		}	
		
		// dequeue current .css 
		wp_dequeue_style($css_name); 
		// enqueue min.css
		wp_enqueue_style($css_name.'_min',get_template_directory_uri() . $css_path . $css_cache_file, ''); 		
	}
}
add_action('wp_footer','get_min_css_files', 7);
//add_action('wp_head','get_min_css_files', 7);
/*
*	gets the min.js file, which are included in $JS_INCLUDE on request of the webpage
*/
function get_min_js_files(){
	global $wp_scripts, $JS_INCLUDE;
		
	if(!RES_MINIFIER_ENABLED) return;
	foreach ($wp_scripts->queue as $js_name) {
		if(!in_array( $js_name, $JS_INCLUDE, true)) continue;
		
		$js_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_scripts->registered[$js_name]->src);	// /js/res-animations.js
		$js_filename = substr($js_uri, strrpos($js_uri, '/') + 1); // res-animations.js
		$js_path = str_replace($js_filename, '', $js_uri); // /js/
		$js_dir_path = get_stylesheet_directory() . $js_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$js_cache_file = str_replace('.js','', $js_filename) .'.min.js'; // res-animations.min.js
		
		if(file_exists($js_dir_path . $js_cache_file)){
    		$cacheLastUpdated = filemtime($js_dir_path . $js_cache_file);
		}else{
			$cacheLastUpdated = 0;
		}
		
		// dequeue script
		wp_dequeue_script($js_name);
		// enqueue min.jss file
		wp_enqueue_script($js_name.'_min', get_template_directory_uri() . $js_path .$js_cache_file, '', $cacheLastUpdated);
	}	
}
add_action('wp_footer', 'get_min_js_files', 7);

/*
*	Creates for every enqueued style in array $JS_INCLUDE a min.js file in the same directory, 
*	which is then queued instead
*	min.js files are only created if RESIGN Minifier is active in the backend
*/
function create_min_css_files(){
	global $wp_styles, $CSS_INCLUDE;
	
    if (!RES_MINIFIER_ENABLED) return;
		
    $css = '';
    $updateCache = false;
	
	add_action('wp_head', 'theme_styles'); // registers => theme_styles() from functionts.php
	do_action('wp_head', 'theme_styles');	//executes

    foreach ($wp_styles->queue as $css_name) { 
		// überspringt den nicht inkludierte CSS
        if(!in_array( $css_name, $CSS_INCLUDE, true)) {
            continue;
        }
		
		$css_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_styles->registered[$css_name]->src);	// /css/res-animations.css
		$css_filename = substr($css_uri, strrpos($css_uri, '/') + 1); // res-animations.css
		$css_path = str_replace($css_filename, '', $css_uri); // /css/
		$css_dir_path = get_stylesheet_directory() . $css_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$css_cache_file = str_replace('.css','', $css_filename) .'.min.css'; // res-animations.min.css
		
		// speichert die Zeit seit der letzten Modifizierung des Files in $cacheLastUpdated
		if(file_exists($css_dir_path . $css_cache_file)){
    		$cacheLastUpdated = filemtime($css_dir_path . $css_cache_file);
		}else{
			$cacheLastUpdated = 0;
		}				
		
		if (strpos($wp_styles->registered[$css_name]->src, get_template_directory_uri()) !== false) {
			$path_css = str_replace(get_template_directory_uri(), get_stylesheet_directory(), $wp_styles->registered[$css_name]->src);
			$css = file_get_contents($path_css);
			if (filemtime($path_css) > $cacheLastUpdated || !file_exists($css_dir_path . $css_cache_file)) {
				$updateCache = true;
			}
			
			if ($updateCache) {
				// if not exist create new min.css file
				$compressed_cache_css = fopen($css_dir_path . $css_cache_file, "w") or die("Unable to open file!");
				fwrite($compressed_cache_css, minify_css($css));
				$cacheLastUpdated = filemtime($css_dir_path . $css_cache_file);
			}
		}	
	}
	add_action('admin_init ','dequeue_styles');
	do_action('admin_init ','dequeue_styles');
}

/*
*	Creates for every enqueued script in array $JS_INCLUDE a min.js file in the same directory, 
*	which is then queued instead
*	min.js files are only created if RESIGN Minifier is active in the backend
*/
function create_min_js_files(){
	global $wp_scripts, $JS_INCLUDE;

    if (!RES_MINIFIER_ENABLED) return;

    $js = '';
    $updateCache = false;
	
	add_action('wp_footer', 'theme_js'); // registers => theme_js() from functions.php
	do_action('wp_footer', 'theme_js');	//executes

    foreach ($wp_scripts->queue as $js_name) {
		if(!in_array( $js_name, $JS_INCLUDE, true)) {
			continue;
		}		
		$js_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_scripts->registered[$js_name]->src);	// /js/res-animations.js
		$js_filename = substr($js_uri, strrpos($js_uri, '/') + 1); // res-animations.js
		$js_path = str_replace($js_filename, '', $js_uri); // /js/
		$js_dir_path = get_stylesheet_directory() . $js_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$js_cache_file = str_replace('.js','', $js_filename) .'.min.js'; // res-animations.min.js
		
		if(file_exists($js_dir_path . $js_cache_file)){
    		$cacheLastUpdated = filemtime($js_dir_path . $js_cache_file);
		}else{
			$cacheLastUpdated = 0;
		}
		
		if (strpos($wp_scripts->registered[$js_name]->src, get_template_directory_uri()) !== false) {
			$path_js = str_replace(get_template_directory_uri(), get_stylesheet_directory(), $wp_scripts->registered[$js_name]->src);
			$js = file_get_contents($path_js);
			if (filemtime($path_js) > $cacheLastUpdated || !file_exists($js_dir_path . $js_cache_file)) {
				$updateCache = true;
			}
			
			if ($updateCache) {
				$compressed_cache_js = fopen($js_dir_path . $js_cache_file, "w") or die("Unable to open file!");
				fwrite($compressed_cache_js,  minify_js($js));
//				fwrite($compressed_cache_js,  minify_js_union($js));
				fclose($compressed_cache_js);
				$cacheLastUpdated = filemtime($js_dir_path . $js_cache_file);
			}
		}		
    }  
	add_action('admin_init', 'dequeue_scripts');
	do_action('admin_init', 'dequeue_scripts');
}

/*
*	clears all min.css files which are listed in the array $CSS_INCLUDE &&
*	if RESIGN Minifier is disabled in the Backend
*/
function clear_min_css_files(){
	global $wp_styles, $CSS_INCLUDE, $ADMIN_STYLES;
	
	if (RES_MINIFIER_ENABLED) return;
	
	$ADMIN_STYLES = $wp_styles->queue;	// get admin styles
	add_action('wp_head', 'theme_styles'); // registers => theme_styles() from functionts.php
	do_action('wp_head', 'theme_styles');	//executes

	// get all enqueued styles, which are in $CSS_INCLUDE
	foreach ($wp_styles->queue as $css_name) {
		// checks if enqueued style is in $CSS_INCLUDE; continues directly to the next if not
		if(!in_array( $css_name, $CSS_INCLUDE, true)) {
			continue;
		}	
		// get path of style			
		$css_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_styles->registered[$css_name]->src);	// /css/res-animations.css
		$css_filename = substr($css_uri, strrpos($css_uri, '/') + 1); // res-animations.css
		$css_path = str_replace($css_filename, '', $css_uri); // /css/
		$css_dir_path = get_stylesheet_directory() . $css_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$css_cache_file = str_replace('.css','', $css_filename) .'.min.css'; // res-animations.min.css

		// delete min.css-files
		if(file_exists($css_dir_path . $css_cache_file)){
			unlink($css_dir_path . $css_cache_file);
		}
	}	
	add_action('admin_init ','dequeue_styles');
	do_action('admin_init ','dequeue_styles');
}

/*
*	clears all min.js files which are listed in the array $JS_INCLUDE &&
*	if RESIGN Minifier is disabled in the Backend
*/
function clear_min_js_files(){
	global $wp_scripts, $JS_INCLUDE, $ADMIN_SCRIPTS;
	
	if (RES_MINIFIER_ENABLED) return;

	$ADMIN_SCRIPTS = $wp_scripts->queue;
	
	add_action('wp_footer', 'theme_js'); // registers => theme_js() from functions.php
	do_action('wp_footer', 'theme_js');	//executes
	
	// get all enqueued styles, which are in $CSS_INCLUDE
	foreach ($wp_scripts->queue as $js_name) {
		// checks if enqueued style is in $CSS_INCLUDE; continues directly to the next if not
		if(!in_array( $js_name, $JS_INCLUDE, true)) {
			continue;
		}	
		
		// get path of style			
		$js_uri = str_replace(get_stylesheet_directory_uri(), '', $wp_scripts->registered[$js_name]->src);	// /js/res-animations.js
		$js_filename = substr($js_uri, strrpos($js_uri, '/') + 1); // res-animations.js
		$js_path = str_replace($js_filename, '', $js_uri); // /js/
		$js_dir_path = get_stylesheet_directory() . $js_path;	// /var/www/vhosts/musterpage.ch/httpdocs/homepage-maker/cm/wp-content/themes/musterpage_Ver_02.05.17/css/	
		$js_cache_file = str_replace('.js','', $js_filename) .'.min.js'; // res-animations.min.js
		
		// delete min.css-files
		if(file_exists($js_dir_path . $js_cache_file)){
			unlink($js_dir_path . $js_cache_file);
		}
	}
	add_action('admin_init', 'dequeue_scripts');
	do_action('admin_init', 'dequeue_scripts');
}

/*
*	Dequeues CSS-Styles from frontend
*/
function dequeue_styles(){
	global $wp_styles, $ADMIN_STYLES;

	foreach ($wp_styles->queue as $css_name) {
		if(!in_array($css_name, $ADMIN_STYLES)){
//			echo $css_name.'<br>';
			wp_dequeue_style($css_name);
		}
	}
}

/*
*	Dequeues JS-Scripts from frontend
*/
function dequeue_scripts(){
	global $wp_scripts, $ADMIN_SCRIPTS;
	
	foreach ($wp_scripts->queue as $js_name) {
		wp_dequeue_script($js_name);
	}
}