<?php

add_action( 'add_meta_boxes', 'elementy_custom_field_1' );

add_action( 'save_post', 'custom_fields_save' );

function elementy_custom_field_1() {
	add_meta_box('elementy_custom_field_1', 'Field 1', 'elementy_custom_field_1_callback', 'newsletter-entry', 'normal', 'high');
}

function elementy_custom_field_1_callback() {
	global $post;
	
	$elementy_custom_field_1 = get_post_meta($post->ID, 'elementy_custom_field_1', true);	
	echo '<input id="" name="elementy_custom_field_1" class="large-text" rows="3" value="'.$elementy_custom_field_1.'" />';
}



function custom_fields_save(){
	global $post;
	
	if( $_POST ) :
		if ( isset( $_POST['elementy_custom_field_1'] ) ) {
			$data = htmlspecialchars($_POST['elementy_custom_field_1']);
			update_post_meta( $post->ID, 'elementy_custom_field_1', $data );
		}
	endif;
 
 }
?>