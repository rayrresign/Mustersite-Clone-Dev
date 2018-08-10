<?php

require('../../../wp-blog-header.php');

global $wpdb;

// Image Upload
if(isset($_POST['resign_image_ajax'])){
	$gallery_slider_id	= $_POST['resign_image_ajax'];
	// Re-Order Places
	$wpdb->query("UPDATE {$wpdb->prefix}gallery_slider SET gallery_slide_place = gallery_slide_place +1");		
	// Add New Image/s to Album
	$wpdb->query("INSERT into {$wpdb->prefix}gallery_slider (gallery_slide_media_id, gallery_slide_place) values ('$gallery_slider_id', 0)");
}

// Sortable Update
if(isset($_POST['pages'])){
	parse_str($_POST['pages'], $orderSlides);
	foreach ($orderSlides['page'] as $key => $value) {
		$wpdb->query("UPDATE {$wpdb->prefix}gallery_slider SET gallery_slide_place = '$key' WHERE gallery_slide_media_id = '$value'");
	}
}

// Delete Slide
if(isset($_POST['type']) && $_POST['type'] == 'deleteSlide'){
	$slide_id = intval($_POST['id']);
	$wpdb->query("DELETE FROM {$wpdb->prefix}gallery_slider WHERE gallery_slide_id = '$slide_id'");
}
	
?>