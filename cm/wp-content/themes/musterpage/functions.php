<?php

// Styles
function theme_styles() {
	global $wp_styles;
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap-res-theme-custom.min.css', '', '3.3.6');
	wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', '', '4.7.0');
	
	wp_enqueue_style('font-awesome5.1', 'https://pro.fontawesome.com/releases/v5.1.0/css/all.css' ,'', '5.1.0');
	
	wp_enqueue_style('roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,700', '', '1.0.0');
	wp_enqueue_style('imagelightbox', get_template_directory_uri() . '/css/imagelightbox.css', '', '1.0.0');
	
	wp_enqueue_style('aos', get_template_directory_uri() . '/css/aos-animation/aos.css', '', '1.0.0');

	wp_enqueue_style('res-animation', get_template_directory_uri() . '/css/res-animations.css', '', '1.2.0'); 
	
	wp_enqueue_style('side-menu', get_template_directory_uri() . '/module/side-menu/side-menu.css', '', '1.0.0');
	wp_enqueue_style('page-overlayer', get_template_directory_uri() . '/module/page-overlayer/res-page-overlayer.css', '', '1.1.0');
	wp_enqueue_style('cta-overlayer', get_template_directory_uri() . '/module/cta-overlayer/res-cta-overlayer.css', '', '1.1.0');
	wp_enqueue_style('pointer-nav', get_template_directory_uri() . '/module/pointer-nav/pointer-nav.css', '', '1.1.0');
	wp_enqueue_style('content-slider', get_template_directory_uri() . '/module/content-slider/content-slider.css', '', '2.0.0');
	wp_enqueue_style('partner-slider', get_template_directory_uri() . '/module/partner-slider/partner-slider.css', '', '1.0.0');
	wp_enqueue_style('testimonials-slider', get_template_directory_uri() . '/module/testimonials/testimonials-slider.css', '', '1.0.0');
	wp_enqueue_style('timeline-slider', get_template_directory_uri() . '/module/timeline-slider/timeline-slider.css', '', '1.1.0');
	wp_enqueue_style('revolution-slider-settting', get_template_directory_uri() . '/module/revolution-slider/rev-slider-5v4/css/settings.css', '', '1.0.0');
	 
	wp_enqueue_style('main_css', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_styles'); 
//add_action('get_footer', 'theme_styles');

add_filter('style_loader_tag', 'add_attrs_to_fontawsome');
function add_attrs_to_fontawsome($tag, $id = 'font-awesome5.1'){
    $tag = preg_replace("/id='".$id."-css'/", "id='".$id."-css' integrity=\'sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs\' crossorigin=\'anonymous\'", $tag);
    return $tag;
}

// Scripts
function theme_js() {
	
	global $wp_scripts;

	wp_register_script('html5_shiv', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', '', '', false);
	wp_register_script('respond_js', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', '', '', false);
	
	$wp_scripts->add_data('html5_shiv', 'conditional', 'lt IE 9');
	$wp_scripts->add_data('respond_js', 'conditional', 'lt IE 9');
	
	wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', '', '3.3.7', true);
    wp_enqueue_script('nicescroll', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.0/jquery.nicescroll.min.js', '', '3.7.4', true);
	wp_enqueue_script('validate_js', get_template_directory_uri() . '/js/formValidation/formValidation.min.js', '', null, true);	
	wp_enqueue_script('validate_bootstrap_js', get_template_directory_uri() . '/js/formValidation/validator_framework/bootstrap.js', array( 'validate_js'), null, true);	
	wp_enqueue_script('imagelightbox_js', get_template_directory_uri() . '/js/image-lightbox/imagelightbox.min.js', '', null, true);
	wp_enqueue_script('imagelightbox_js-settings', get_template_directory_uri() . '/js/image-lightbox/imagelightbox-settings.js', '', null, true);
	wp_enqueue_script('side-menu-js', get_template_directory_uri() . '/module/side-menu/side-menu.js', '', '1.0.0');
	wp_enqueue_script('modernizer_js', get_template_directory_uri() . '/js/theme-basic/modernizr-3.5-respond-1.1.0.min.js', '', null, true);
	
	wp_enqueue_script('aos_js', get_template_directory_uri() . '/js/aos-animation/aos.js', '', null, true);
	
	wp_enqueue_script('jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js',  '', null, true);
	wp_enqueue_script('jquery-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js',  '', null, true);
	wp_enqueue_script('mailing-nl-tool', get_template_directory_uri() . '/module/footer-mailing/footer-modal-mailing-form.js', '', null, true); 
	wp_enqueue_script('revolution-slider', get_template_directory_uri() . '/module/revolution-slider/rev-slider-5v4/js/jquery.themepunch.revolution.min.js', '', null, true);
	wp_enqueue_script('revolution-slider-plugins', get_template_directory_uri() . '/module/revolution-slider/rev-slider-5v4/js/jquery.themepunch.tools.min.js', '', null, true);
	wp_enqueue_script('timeline-slider_js', get_template_directory_uri() . '/module/timeline-slider/timeline-slider.js', '', null, true);
	wp_enqueue_script('res-animation_js', get_template_directory_uri() . '/js/res-animation.js', array('bootstrap_js'), null, true);

	wp_enqueue_script('res-script_js', get_template_directory_uri() . '/js/res-script.js', array('bootstrap_js'), null, true);
	
	
}
add_action('wp_enqueue_scripts', 'theme_js');

// Primary Menu
register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'Musterpage v10' ),
) );

// Include the Post Types
require_once('functions-post-types.php');

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'res-large-thumbnail', 800, 800, false );
	add_image_size( 'res-crop-thumbnail', 440, 270, array( 'center', 'center' ) );
	add_image_size( 'res-quadrat-thumbnail', 600, 600, array( 'center', 'center' ) );
	add_image_size( 'gallery-size', 300, 184, array( 'center', 'center' ) );
	add_image_size( 'res-crop-slider', 1920, 1080, array( 'center', 'center' ) );
	add_image_size( 'res-widescreen-slider', 1280, 520, array( 'center', 'center' ) );
	add_image_size( 'res-crop-large-thumbnail', 840, 480, array( 'center', 'center' ) );
	
}	
// Gallery html5
add_theme_support( 'html5', array(
	'search-form',
	'comment-form',
	'comment-list',
	'gallery',
	'caption',
) );
// WP Gallerie Image size & Verlinkung	
function force_image_size($out, $pairs, $atts) {
  $out['size'] = 'gallery-size'; 
  $out['link'] = 'file';
  return $out;
}
define( 'UPLOADS', 'wp-content/uploads' );

add_filter('shortcode_atts_gallery','force_image_size',10,3);

// Thumbnails
add_theme_support('post-thumbnails');

// Bootstrap  Navigation
require_once('functions/wp_bootstrap_navwalker.php');

// Include admin stylings & settings
require_once('admin-theme/admin-theme.php');

// Include head SEO PageTitle
require_once('functions/res-seo-head.php');
require_once('functions/res-design-customizer.php');
require_once('functions/res-page-settings.php');

// kontakte
require_once('functions/res-kontakte.php');

// RES-Chache Minifier und JS async
require_once('functions/res-minifier/function-res-minifier.php');
require_once('functions/res-minifier/function-res-js-async.php');

// Include limits for excerpt, content & title
require_once('functions/limit-post-text.php');

// Remove unwanted WP Actions
require_once('functions/remove-action.php');

// Thumbnail upscale & correct crop in Wordpress
require_once('functions/upscale.php');

// Modalbox Content-Slider Carousel
require_once('module/content-slider/function-content-slider.php');

// Partner-Slider Carousel
require_once('module/partner-slider/function-partner-slider.php');

// Testimonials-Slider Carousel
require_once('module/testimonials/function-testimonials-slider.php');

// Footer BigFormular
require_once('module/footer-big-formular/footerBig-mail-function.php');


// Custom Category Fields
require_once('functions/custom-filter-category-field.php');

// Custom Category Fields
require_once('functions/breadcrumbs-singlepage.php');

//nofollow auf der Seite aktivieren
require_once('functions/nofollow/nofollow.php');




?>