<?php
require('HTMLMinify.php');
define('RES_HTML_CACHER_ENABLED', get_option('res_html_cacher_checkbox'));

// get cache files
function cache_function(){
    global $post;
	if(is_admin()) return false; // exit if in backend

    if (!RES_MINIFIER_ENABLED) return;
	
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		
		
		$url = $_SERVER['REQUEST_URI'];
		
		if(!strpos($url,'en') || !strpos($url,'?lang=') ){
			if(empty($post->ID))return;
			define("RES_CACHE_ID", "page_" . $post->ID);
			
		} elseif(strpos($url,'en')){
			// Sprachen, wenn URL/en ist
			$extracted = array_filter(explode("/",parse_url($url,PHP_URL_PATH)));
			$lang = current($extracted);

			//define english or german cache page
			if($lang !== 'en') define("RES_CACHE_ID", "page_de_" . $post->ID);
			else  define("RES_CACHE_ID", "page_en_" . $post->ID);	
		} elseif(strpos($url,'?lang=')){
			// Sprachen, wenn URL/?lang=en ist // get uri
			$url = $_SERVER['REQUEST_URI'];
			$lang = substr($url,7);

			// define english or german cache page
			if($lang !== 'en') define("RES_CACHE_ID", "page_de_" . $post->ID);
			else  define("RES_CACHE_ID", "page_en_" . $post->ID);
		}		
//        define("RES_CACHE_ID", "page_" . $post->ID);
        $cache = get_cached_page(RES_CACHE_ID);

        if ($cache !== false) {
            if ($_SERVER['SERVER_PORT'] == 443) {
                $cache = str_replace("http://", "https://", $cache);
            }
            echo $cache;
            exit();
        }
    }
    ob_start();
}
add_action('wp', 'cache_function');

function get_cached_page($id){
	if(is_admin()) return false; // exit if in backend
    $cache_file_path = get_stylesheet_directory() . '/_cache/' . $id;
    if (file_exists($cache_file_path) && (time() - filemtime($cache_file_path)) < 12 * 3600) {
        return file_get_contents($cache_file_path);
    } else {
        return false;
    }
}


// save cache files
function res_cache(){
    //global $start;
    if (!RES_HTML_CACHER_ENABLED || !defined("RES_CACHE_ID")) {
        return;
    }
    $html = ob_get_clean();
    $html_minified = HTMLMinify::minify($html);
    put_cached_page(RES_CACHE_ID, $html_minified);
    echo $html_minified;

    //$end = (float)array_sum(explode(' ', microtime()));
    //print "Processing time (new-cached): " . sprintf("%.4f", ($end - $start)) . " seconds.";
    exit();
}
function put_cached_page($id, $html){
	// verhindert, dass page-dateien ohne id erstellt werden
	if($id != 'page_'){
		$cache_file_path = get_stylesheet_directory() . '/_cache/' . $id;
		file_put_contents($cache_file_path, $html);	
	}else{
		return;
	}
	
}

// clear cache files
function clear_cached_pages(){
    $cache_file_path = get_stylesheet_directory() . '/_cache/';
    if (is_dir($cache_file_path)) {
        $dir_handle = opendir($cache_file_path);
        if (!$dir_handle)
            return false;
        while ($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($cache_file_path . "/" . $file))
                    unlink($cache_file_path . "/" . $file);
            }
        }
        closedir($dir_handle);
    }
}

add_action('save_post', 'clear_cached_pages');
?>