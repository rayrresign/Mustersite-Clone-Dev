<?php 

	function musterpage_v9_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'musterpage-v8' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h1 class="widget-title">',
			'after_title'   => '</h1>',
		) );
	}
	add_action( 'widgets_init', 'musterpage_v9_widgets_init' );
	
	
	function wpc_url_login(){
		return "http://www.resign.ch"; // your URL here
	}
	add_filter('login_headerurl', 'wpc_url_login');
	
	
	function login_css() {
		wp_enqueue_style( 'login_css', get_template_directory_uri() . '/admin-theme/res-login.css' );
	}
	add_action('login_head', 'login_css');
	
	
	function remove_footer_admin () {
		echo '&copy; '.date('Y').' Content Drive by RESIGN. Webagentur';
	}
	add_filter('admin_footer_text', 'remove_footer_admin');
	
	
	add_action('wp_dashboard_setup', 'wpc_dashboard_widgets');
	function wpc_dashboard_widgets() {
		global $wp_meta_boxes;
		// Today widget
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		// Last comments
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		// Incoming links
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		// Plugins
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	}
	
	
	function admin_css() {
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin-theme/res-backend.css' );
	}
	add_action('admin_print_styles', 'admin_css' );



if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {

	// thumbnails im backend for post and page
	add_theme_support('post-thumbnails', array( 'post', 'page' ) );

	function fb_AddThumbColumn($cols) {

		$cols['thumbnail'] = __('Thumbnail');

		return $cols;
	}

	function fb_AddThumbValue($column_name, $post_id) {

			$width = (int) 35;
			$height = (int) 35;

			if ( 'thumbnail' == $column_name ) {
				// thumbnail of WP 2.9
				$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
				// image from gallery
				$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
				if ($thumbnail_id)
					$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
				elseif ($attachments) {
					foreach ( $attachments as $attachment_id => $attachment ) {
						$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
					}
				}
					if ( isset($thumb) && $thumb ) {
						echo $thumb;
					} else {
						echo __('None');
					}
			}
	}

	add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
	add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
}


 // CMS User Backend Setting Color Bar
function set_user_defaults($user_id) {
    $args = array(
        'ID' => $user_id,
        'admin_color' => 'light',
		'show_admin_bar_front' => 'false'
    );
    wp_update_user( $args );
}
add_action('user_register', 'set_user_defaults');


// backend Editor Style
add_editor_style( '/admin-theme/res-backend-editor.css' );


// Res Dashboard
add_filter( 'admin_title', 'admin_title', 10, 2 );
add_action( 'admin_menu', 'admin_menu' );
add_action( 'current_screen', 'current_screen' );

function admin_title( $admin_title, $title ) {
    global $pagenow;
	if( 'admin.php' == $pagenow && isset( $_GET['page'] ) && 'custom-page' == $_GET['page'] ) {
		$admin_title = $this->title . $admin_title;
	}
	return $admin_title;
}

function admin_menu() {
	add_menu_page( "CMS Help", '', 'read', 'cms-help', 'custom_dashboard_content' );
	remove_menu_page('cms-help');
	global $parent_file, $submenu_file;
	$parent_file = 'index.php';
	$submenu_file = 'index.php';
	global $menu;
	$menu[2][0] = "CMS Help";
	global $submenu;
	$submenu['index.php'][0][0] = "CMS Home";
}

function current_screen( $screen ) {
	if( 'dashboard' == $screen->id ) {
		wp_safe_redirect( admin_url('admin.php?page=cms-help') );
		exit;
	}
}

function custom_dashboard_content(){
	?>
    <div class="wrap"> 
        <h2>ContentDrive</h2>
        <div id="DashboardResign">
            <iframe scrolling="no"  width="95%" height="700" frameborder="0" src="//code.resign.ch/CMS/tutorial"></iframe>
        </div>
    </div>
    <?php
}
?>