<?php
/*
Plugin Name: Resign Newsletter-Tool v10
Version: 1.0
Description: Dieses Plugin erstellt 2017ner-Newsletter Templates für MvA ContentLetter Tool.
Author: RESIGN. Don Kodiyan
Author URI: http://www.resign.ch
*/

add_action( 'admin_menu', 'register_newsletter_menu' );
function register_newsletter_menu() {
	add_submenu_page(
        'edit.php?post_type=newsletter',
        'Newsletter',
        'manage_options',
		'',
		'res-newsletter'
	);	
}

function newsletter_admin_scripts(){
    wp_enqueue_script('media-upload'); 
	wp_enqueue_media();
	
	wp_enqueue_script( 'newsletter-entry-img-uploader', plugins_url( 'js/newsletter-entry-img-uploader.js', __FILE__), "", false, true );
	wp_enqueue_script( 'clipboard.min', plugins_url( 'js/clipboard.min.js', __FILE__), "", false, true );
}
add_action('admin_enqueue_scripts','newsletter_admin_scripts');


add_action('init', 'register_custom_post');
function register_custom_post() {
	$labels = array(
		'name' => _x('Newsletter', 'post type general name'),
		'singular_name' => _x('Newsletter', 'post type singular name'),
		'menu_name' => __('Newsletter'),
		'add_new' => _x('Neuen Newsletter hinzufügen', 'portfolio item'),
		'add_new_item' => __('Neuen Newsletter hinzufügen'),
		'edit_item' => __('Newsletter bearbeiten'),
		'new_item' => __('Neuer Newsletter'),
		'view_item' => __('Newsletter ansehen'),
		'search_items' => __('Newsletter suchen'),
		'not_found' =>  __('Keine Newsletter vorhanden'),
		'not_found_in_trash' => __('Keine Newsletter im Papierkorb vorhanden'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-media-code',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_menu' => true,
		'menu_position' => 2,
		'capability_type' => 'post',
		'supports' => array('title'),
		'public' => false,
		'publicly_queriable' => true,
		'show_ui' => true,
		'exclude_from_search' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'rewrite' => false,
	  ); 
 
	register_post_type( 'newsletter' , $args );
	
	$labels = array(
		'name' => _x('Newsletter Eintrag', 'post type general name'),
		'singular_name' => _x('Newsletter Eintrag', 'post type singular name'),
		'menu_name' => __('Newsletter Eintrag'),
		'add_new' => _x('Neuen Eintrag hinzufügen', 'portfolio item'),
		'add_new_item' => __('Neuen Eintrag hinzufügen'),
		'edit_item' => __('Eintrag bearbeiten'),
		'new_item' => __('Neuer Eintrag'),
		'view_item' => __('Einträge ansehen'),
		'search_items' => __('Einträge suchen'),
		'not_found' =>  __('Keine Einträge vorhanden'),
		'not_found_in_trash' => __('Keine Einträge im Papierkorb vorhanden'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => 'dashicons-media-code',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'show_in_menu' => false,
		'menu_position' => 2,
		'capability_type' => 'post',
		'supports' => array('title'),
		'public' => false,
		'publicly_queriable' => true,
		'show_ui' => true,
		'exclude_from_search' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'rewrite' => false,
	  ); 
 
	register_post_type( 'newsletter-entry' , $args );
	
    add_image_size('res-newsletter-big', 520, 276, true);  // bigImg = 1
    add_image_size('res-newsletter-small', 120, 141, true); // bigImg = 0
    //add_image_size('res-newsletter-small-square', 120, 120, true); 
}

function res_newsletter_image_size( $response, $attachment, $meta ){
	$size_array = array( 'res-newsletter-big', 'res-newsletter-small') ;

	foreach ( $size_array as $size ){

		if ( isset( $meta['sizes'][ $size ] ) ) {
			$attachment_url = wp_get_attachment_url( $attachment->ID );
			$base_url = str_replace( wp_basename( $attachment_url ), '', $attachment_url );
			$size_meta = $meta['sizes'][ $size ];

			$response['sizes'][ $size ] = array(
				'height'        => $size_meta['height'],
				'width'         => $size_meta['width'],
				'url'           => $base_url . $size_meta['file'],
				'orientation'   => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape',
			);
		}

	}

	return $response;
}
add_filter ( 'wp_prepare_attachment_for_js',  'res_newsletter_image_size' , 10, 3  );

/** NEWSLETTER CUSTOM POSTS **/
//http://wordpress.stackexchange.com/questions/128622/creating-a-relationship-between-two-post-types

add_action( 'add_meta_boxes', 'newsletter_meta_boxes' );

function newsletter_meta_boxes() {
	add_meta_box('newsletter_entries', 'Newsletter Inhalt', 'newsletter_entries_callback', 'newsletter', 'normal', 'high');
	add_meta_box('newsletter_options', 'Vorschau und Export', 'newsletter_options_callback', 'newsletter', 'normal', 'high');
}

function newsletter_entries_callback(){
	global $post;
	$newsletter_id = $_GET['post'];
	
    query_posts(array( 
        'posts_per_page' => '-1',
        'post_type' => 'newsletter-entry',
		'order'     => 'ASC',
		'meta_key' => 'order',
		'orderby'   => 'meta_value_num',
		'meta_query' => array(
        	array(
				'key' => 'newsletter_id',
				'value' => $newsletter_id,
				'compare' => 'LIKE'
			)
		)
    ));  
	if($_GET['action'] == 'edit'){
	?>
    
    <style>
	  /*  CSS Back-End Style */
	  @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?ver=4.7.0");

	  .btn-neuer-beitrag{
		  position: relative;
	  }
	  .btn-neuer-beitrag:before {
		content: "\f040";
		font-family: FontAwesome;
		font-style: normal;
		font-weight: normal;
		text-decoration: inherit;
		margin-right: 10px;
		}
		.column-title{
			position: relative;
		}
		.row-title{
			padding-left: 10px;	
		}
		.btn-drag-drop{
		  position: relative;
		  width: 10px;
		  background-color: red;
		  margin: 30px;
		}

		.drag-indicator{
			background:#eee;
			color: #ccc;
			padding: 5px 3px 0 3px;
			position:absolute;
			top: 0;
			bottom: 0;
			left: 0;
			width: 10px;
			cursor: move; /* fallback if grab cursor is unsupported */
			cursor: grab;
			cursor: -moz-grab;
			cursor: -webkit-grab;
		}
		.drag-indicator:active{
			cursor: grabbing;
			cursor: -moz-grabbing;
			cursor: -webkit-grabbing;
		}
	  
	 	</style>
    

     <div style="margin: 20px 0;display:block;">
             <a href="<?=site_url(); ?>/wp-admin/post-new.php?post_type=newsletter-entry&newsletter=<?= $newsletter_id; ?>" class="button button-primary btn-neuer-beitrag">Neuer Beitrag hinzufügen</a></div>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <th scope="col" id="title" class="manage-column column-title column-primary"><span style="pad">Title</span></th>
                    <th scope="col" id="date" class="manage-column column-date"><span>Date</span></th>
                </tr>
                </thead>
            
                <tbody id="the-list">
                	<?php 
					$i = 0;
					while (have_posts()) : the_post(); 
						$i++;
						?>
                            <tr id="post-<?php the_ID(); ?>" post-id="<?php the_ID(); ?>" class="iedit author-self level-0 post-<?php the_ID(); ?> type-newsletter status-publish hentry">
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                        <div class="drag-indicator"><i class="fa fa-sort" aria-hidden="true"></i> </div>
                        <strong><a class="row-title" href="<?=site_url(); ?>/wp-admin/post.php?post=<?php the_ID(); ?>&amp;action=edit&amp;newsletter=<?= $newsletter_id ?>" aria-label="“<?php the_title(); ?>” (Edit)"> &nbsp;
							<?= !get_the_title() ? '--- Leer' : the_title(); ?></a></strong>
                        </td>
                        <td class="date column-date" data-colname="Date"><?php the_date(); ?></td>		
                        </tr>
                    <?php endwhile; 
					wp_reset_query();
					if($i==0){
						?>
                        <tr class="iedit author-self level-0  type-newsletter status-publish hentry">
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                        Keine Einträge vorhanden
                        </td>	
                        </tr>
                        <?
					}else{ ?>
                        
						<script>
							jQuery( function($) {
								$( "#the-list" ).sortable({
									axis: 'y',
								 	update: function( event, ui ) {
										$("#html-export").val("Wird aktualisiert...");
									  	var data = {
											action: 'newsletter_entry_update_order',
											newsletter_entries: []
										};
										$( "#the-list tr" ).each(function( index ) {
										  data.newsletter_entries.push({id: parseInt($( this ).attr("post-id")), order: index});
										});
										
										$.post("<?= admin_url( 'admin-ajax.php' ); ?>", data, function(response) {
											$.get("<?= get_permalink($newsletter_id); ?>", function(response){
												$("#html-export").val(response);
											});
										});
									  }
								});
							  } );
						</script>
					<? } ?>
                </tbody>
            </table>
	<?php
	
	}else{
		?>
        <style>
			#newsletter_entries{
				display:none;	
			}
		</style>
        <?
	}
}

function newsletter_options_callback(){
	
	if($_GET['action'] == 'edit'){
	global $post;
	$newsletter_id = $_GET['post'];
	$result = file_get_contents(get_permalink(	$newsletter_id));
		
//	ob_start(); 
//	include 'single-newsletter.php';
//	$result = ob_get_clean();
	
	?>
    <div style="margin: 20px 0;">
    <a target="_blank" href="<?= get_permalink($newsletter_id); ?>" class="page-title-action button button-primary"><i class="fa fa-envelope-o" aria-hidden="true"></i>  Newsletter Vorschau</a>
    <a href="#" data-clipboard-target="#html-export" class="copy page-title-action button"><i class="fa fa-code" aria-hidden="true"></i>  HTML Code kopieren</a>
    <a target="_blank" href="http://nl.contentdrive.ch/" class="page-title-action button"> <i class="fa fa-envelope" aria-hidden="true"></i>  Zum Versand</a>
    </div>
    <textarea id="html-export" cols="100" rows="4" readonly onclick="this.focus();this.select()"><?= $result ?></textarea>
    <script>
		jQuery( document ).ready(function() {
			new Clipboard('a.copy');
		});
	</script>
<?
}else{
		?>
        <style>
			#newsletter_options{
				display:none;	
			}
		</style>
        <?
	}
}


/** NEWSLETTER-ENTRY CUSTOM POSTS **/
add_action( 'add_meta_boxes', 'newsletter_entry_meta_boxes' );
add_action( 'save_post', 'custom_fields_save' );

function newsletter_entry_meta_boxes() {
	add_meta_box('newsletter_entry_bild', 'Bild', 'newsletter_entry_bild_callback', 'newsletter-entry', 'normal', 'high');
	add_meta_box('newsletter_entry_text', 'Text', 'newsletter_entry_text_callback', 'newsletter-entry', 'normal', 'high');
	add_meta_box('newsletter_entry_link', 'Link', 'newsletter_entry_link_callback', 'newsletter-entry', 'normal', 'high');
	add_meta_box('newsletter_entry_link_text', 'Link Text', 'newsletter_entry_link_text_callback', 'newsletter-entry', 'normal', 'high');
	add_meta_box('newsletter_id', 'Newsletter ID', 'newsletter_id_callback', 'newsletter-entry', 'normal', 'high');
}

function newsletter_entry_bild_callback() {
	global $post;
	global $_wp_additional_image_sizes;
	
	$newsletter_entry_bild = get_post_meta($post->ID, 'newsletter_entry_bild', true);
	$imgBig = get_post_meta($post->ID, 'newsletter_entry_bild_imgBig', true);

//	if(!empty($newsletter_entry_bild)){
//		print_r(get_post_meta($post->ID));	
////		$imgBig =  get_post_meta($post->ID, '', true);
////		$matches = array();
////		preg_match("/([0-9]+)x([0-9]+).[a-zA-Z]+$/", $newsletter_entry_bild, $matches);
////		$imgBig = strcmp($_wp_additional_image_sizes['res-newsletter-big']['width'], $matches[1])==0;
//	
//	}
	?>
    <input type="hidden" name="newsletter_entry_bild" id="newsletter_entry_bild_input" value="<?= $newsletter_entry_bild; ?>" />
	<select name="newsletter_entry_bild_imgBig" id="img-size"><option value="1">Gross</option> <option <?= !$imgBig?'selected':''; ?> value="0">Klein</option></select>
    <?
	if ($newsletter_entry_bild == '') {
		echo '<div id="newsletterImg"></div><a href="#" id="upload_newsletter_entry_bild" class="button button-primary">Bild hinzufügen</a>';
	} else {
		echo '<div id="newsletterImg" style="display: block;">
			<img style="max-width:500px;" src="'.$newsletter_entry_bild.'" class="croppedImg"></div>
			<a href="#" id="upload_newsletter_entry_bild" class="button button-primary imgRemove">Bild ersetzen</a>';
	}
}

function newsletter_entry_text_callback() {
	global $post;
	
	$newsletter_entry_text = get_post_meta($post->ID, 'newsletter_entry_text', true);	
	echo '<textarea name="newsletter_entry_text" rows="10" class="large-text" rows="3">'.$newsletter_entry_text.'</textarea>';
}

function newsletter_entry_link_callback() {
	global $post;
	
	$newsletter_entry_link = get_post_meta($post->ID, 'newsletter_entry_link', true);	
	?>
    <script>
		function onLinkKeyUp(){
			var $link = jQuery("input[name='newsletter_entry_link']");
			if($link.val().length > 4 && !$link.val().startsWith("http")){
				$link.val("http://"+$link.val());
			}
		}
	</script>
	<input name="newsletter_entry_link" onkeyup="onLinkKeyUp()"  class="large-text" placeholder="http://" value="<?= $newsletter_entry_link; ?>" />
    <?
}

function newsletter_entry_link_text_callback() {
	global $post;
	
	$newsletter_entry_link_text = get_post_meta($post->ID, 'newsletter_entry_link_text', true);
	echo '<input name="newsletter_entry_link_text" class="large-text" value="'.$newsletter_entry_link_text.'" />';
}

function newsletter_id_callback() {
	global $post;
	
	$newsletter_id = get_post_meta($post->ID, 'newsletter_id', true);
	$order = get_post_meta($post->ID, 'order', true);
	
	if(!isset($newsletter_id) || empty($newsletter_id)){
		$newsletter_id = $_GET['newsletter'];	
	}
	
	if(!isset($order) || empty($order)){
		$order = 999;	
	}
	
	?>
	<style>
		#newsletter_id, #minor-publishing{display:none;}
		.page-title-action{
			display:none;	
		}
    </style>
    <script>
    	var backToNewsletterBtn = document.getElementsByClassName("page-title-action")[0];
		if (typeof backToNewsletterBtn !== 'undefined') {
			backToNewsletterBtn.setAttribute("href", "<?=admin_url( 'post.php?post='.$newsletter_id.'&action=edit' ); ?>");
			backToNewsletterBtn.setAttribute("style", "display:inline");
			backToNewsletterBtn.innerHTML = "Zurück zum Newsletter";
		}
    </script>
	<input type="hidden" name="newsletter_id" value="<?= $newsletter_id; ?>" />
	<input type="hidden" name="order" value="<?= $order; ?>" />
    <?
}


function custom_fields_save(){
	global $post;

	if( $_POST ) {
		if ( isset( $_POST['newsletter_entry_bild'] ) ) {
			update_post_meta( $post->ID, 'newsletter_entry_bild', sanitize_text_field( $_POST['newsletter_entry_bild'] ));
		}
		
		if ( isset( $_POST['newsletter_entry_bild_imgBig'] ) ) {
			update_post_meta( $post->ID, 'newsletter_entry_bild_imgBig', $_POST['newsletter_entry_bild_imgBig']);
		}
		
		if ( isset( $_POST['newsletter_entry_text'] ) ) {
			$data = htmlspecialchars($_POST['newsletter_entry_text']);
			update_post_meta( $post->ID, 'newsletter_entry_text', $data );
		}
		
		if ( isset( $_POST['newsletter_entry_link'] ) ) {
			$data = htmlspecialchars($_POST['newsletter_entry_link']);
			update_post_meta( $post->ID, 'newsletter_entry_link', $data );
		}
		
		if ( isset( $_POST['newsletter_entry_link_text'] ) ) {
			$data = htmlspecialchars($_POST['newsletter_entry_link_text']);
			update_post_meta( $post->ID, 'newsletter_entry_link_text', $data );
		}
		
		if ( isset( $_POST['newsletter_id']) && !empty($_POST['newsletter_id']) ) {
			$data = htmlspecialchars($_POST['newsletter_id']);
			update_post_meta( $post->ID, 'newsletter_id', $data );
		}
		
		if ( isset( $_POST['order']) && !empty($_POST['order']) ) {
			$data = htmlspecialchars($_POST['order']);
			update_post_meta( $post->ID, 'order', $data );
		}
	}
}

function newsletter_entry_update_order(){
	$newsletter_entries = $_POST['newsletter_entries'];
	foreach ($newsletter_entries as $entry) {
		update_post_meta($entry['id'], 'order', htmlspecialchars($entry['order']));
	}
	echo "ok";
}
add_action('wp_ajax_newsletter_entry_update_order', 'newsletter_entry_update_order');
add_action('wp_ajax_nopriv_newsletter_entry_update_order', 'newsletter_entry_update_order');

function newsletter_entry_redirect( $location, $post_id ) {
	if ( 'newsletter-entry' == get_post_type( $post_id ) ) {
		$newsletter_id = get_post_meta($post_id, 'newsletter_id', true);
		$location = admin_url( 'post.php?post='.$newsletter_id.'&action=edit' );
	}
	return $location;
}
add_filter( 'redirect_post_location', 'newsletter_entry_redirect', 10, 2 );
add_action( 'trashed_post', 'newsletter_entry_redirect_on_delete');

function newsletter_entry_redirect_on_delete($post_id) {
	$location = newsletter_entry_redirect( NULL, $post_id );
	if(!empty($location)){
		wp_redirect($location);
		exit();
	}
}

/* FRONTEND */

function get_newsletter_template($single_template) {
     global $post;

     if ($post->post_type == 'newsletter') {
          $single_template = dirname( __FILE__ ) . '/single-newsletter.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_newsletter_template' );