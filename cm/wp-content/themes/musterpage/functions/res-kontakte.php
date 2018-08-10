<?php
/*
Plugin Name: Resign Kontakte
Version: 1.0
Description: Dieses Plugin speichert Kontakte.
Author: RESIGN. Don Kodiyan
Author URI: http://www.resign.ch
*/

add_action('init', 'resign_kontakte_register_custom_post');
function resign_kontakte_register_custom_post() {
    $labels = array(
        'name' => _x('Kontakt', 'post type general name'),
        'singular_name' => _x('Kontakt', 'post type singular name'),
        'menu_name' => __('Kontakte E-Mails'),
        'add_new' => _x('Kontakt hinzufügen', 'portfolio item'),
        'add_new_item' => __('Kontakt hinzufügen'),
        'edit_item' => __('Kontakt bearbeiten'),
        'new_item' => __('Neuer Kontakt'),
        'view_item' => __('Kontakt ansehen'),
        'search_items' => __('Kontakt suchen'),
        'not_found' =>  __('Keine Kontakt vorhanden'),
        'not_found_in_trash' => __('Keine Kontakt im Papierkorb vorhanden'),
        'parent_item_colon' => ''
    );
 
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-groups',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_menu' => true,
        'menu_position' => 9,
        'capability_type' => 'post',
        'supports' => array('title'),
        'exclude_from_search' => true,
        'show_in_nav_menus' => true,
        'has_archive' => false,
        'rewrite' => false,
      ); 
 
    register_post_type( 'res-kontakt' , $args );
}

add_action( 'add_meta_boxes', 'kontakt_meta_boxes' );

function kontakt_meta_boxes() {
    add_meta_box('kontakt_name', 'Name', 'kontakt_name_callback', 'res-kontakt', 'normal', 'high');
    add_meta_box('kontakt_vorname', 'Vorname', 'kontakt_vorname_callback', 'res-kontakt', 'normal', 'high');
    add_meta_box('kontakt_email', 'E-Mail', 'kontakt_email_callback', 'res-kontakt', 'normal', 'high');
    add_meta_box('kontakt_mobile', 'Mobile', 'kontakt_mobile_callback', 'res-kontakt', 'normal', 'high');
}

function kontakt_name_callback() {
    global $post;
    
    $kontakt_name = get_post_meta($post->ID, 'kontakt_name', true);
    echo '<input name="kontakt_name" class="large-text" value="'.$kontakt_name.'" />';
}

function kontakt_vorname_callback() {
    global $post;
    
    $kontakt_vorname = get_post_meta($post->ID, 'kontakt_vorname', true);
    echo '<input name="kontakt_vorname" class="large-text" value="'.$kontakt_vorname.'" />';
}

function kontakt_email_callback() {
    global $post;
    
    $kontakt_email = get_post_meta($post->ID, 'kontakt_email', true);
    echo '<input name="kontakt_email" class="large-text" value="'.$kontakt_email.'" />';
}

function kontakt_mobile_callback() {
    global $post;
    
    $kontakt_mobile = get_post_meta($post->ID, 'kontakt_mobile', true);
    echo '<input name="kontakt_mobile" class="large-text" value="'.$kontakt_mobile.'" />';
}

add_action('admin_head-edit.php','resign_kontakte_add_export_button');
function resign_kontakte_add_export_button(){
    global $current_screen;

    if (strcmp('res-kontakt', $current_screen->post_type) == 0) {
        $delimiter = ';';
        $csv = 'Name'.$delimiter.'Vorname'.$delimiter.'E-Mail'.$delimiter.'Mobile'."\n";
        $args = array('post_type' => array('res-kontakt'));
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                $csv .= get_field('kontakt_name').$delimiter.get_field('kontakt_vorname').$delimiter.get_field('kontakt_email').$delimiter.get_field('kontakt_mobile')."\n";
            }
            
            wp_reset_postdata();
        }
    ?>
        <script type="text/javascript">
            jQuery(document).ready( function($) {
                $($(".wrap h1")[0]).append('<a id="kontakt_export" download="export.csv" href="data:application/octet-stream,<?= urlencode($csv); ?>" class="button button-primary" style="margin-left: 10px;">Adressen exportieren</a>');
            });
        </script>
    <?php
    }
}


add_action( 'save_post', 'resign_kontakte_custom_fields_save' );

function resign_kontakte_custom_fields_save(){
    global $post;

    if( $_POST ) {
        if ( isset( $_POST['kontakt_name'] ) ) {
            update_post_meta( $post->ID, 'kontakt_name', sanitize_text_field( $_POST['kontakt_name'] ) );
        }
        
        if ( isset( $_POST['kontakt_vorname'] ) ) {
            update_post_meta( $post->ID, 'kontakt_vorname', sanitize_text_field( $_POST['kontakt_vorname'] ) );
        }
        
        if ( isset( $_POST['kontakt_email'] ) ) {
            update_post_meta( $post->ID, 'kontakt_email', sanitize_text_field( $_POST['kontakt_email'] ) );
        }
        
        if ( isset( $_POST['kontakt_mobile'] ) ) {
            update_post_meta( $post->ID, 'kontakt_mobile', sanitize_text_field( $_POST['kontakt_mobile'] ) );
        }
    }
}

function kontakt_save_data() {
    if ($_POST && !empty($_POST['nachname']) && !empty($_POST['email'])) {
        $nachname = sanitize_text_field( $_POST['nachname'] );
        $vorname = sanitize_text_field( $_POST['vorname'] );
        $email = sanitize_text_field( $_POST['email'] );
        $mobile = sanitize_text_field( $_POST['mobile'] );
        
        $post_id = wp_insert_post(
            array('post_type' => 'res-kontakt', 
            'post_title' => $vorname.' '.$nachname.', '.$email.', '.$mobile, 
            'post_content' => '', 
            'post_status' => 'publish', 
            'comment_status' => 'closed',
            'ping_status' => 'closed',
            ));
        
        if ($post_id) {
            add_post_meta($post_id, 'kontakt_name', $nachname);
            add_post_meta($post_id, 'kontakt_vorname', $vorname);
            add_post_meta($post_id, 'kontakt_email', $email);
            add_post_meta($post_id, 'kontakt_mobile', $mobile);
            }
    }
}
add_action( 'admin_post_nopriv_subscribe', 'kontakt_save_data' );
add_action( 'admin_post_subscribe', 'kontakt_save_data' );

?>
