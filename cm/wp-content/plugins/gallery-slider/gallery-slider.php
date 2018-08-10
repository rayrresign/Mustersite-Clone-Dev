<?php
/*
Plugin Name: Resign Gallery-Slider Carousel v10
Version: 1.3
Description: Musterpage - Dieses Plugin generiert ein verwaltbares Bootstrap 3.0 -Carousel mithilfe der Wordpress-Mediathek. 
Author: RESIGN. Phillip Schmanau
Author URI: http://www.resign.ch 
*/
/*  Copyright 2015 Phillip Schmanau (phillip@resign.ch)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.

*/


// Füge Scripts und Styles im Admin-Bereich hinzu
function admin_enqueue()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');

    wp_register_script('gallery-slider-js', plugins_url('js/script.js', __FILE__), array('jquery-ui-core', 'jquery-ui-sortable'));
    $translation_array = array('ajax_url' => plugins_url('ajax.php', __FILE__));
    wp_localize_script('gallery-slider-js', 'object', $translation_array);
    wp_enqueue_script('gallery-slider-js');

    wp_enqueue_style('gallery-slider-css', plugins_url('css/style.css', __FILE__));
    wp_enqueue_style('fontawesome-css', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css');

}

add_action('admin_enqueue_scripts', 'admin_enqueue');

// Füge Scripts und Styles im Output-Bereich hinzu
function output_enqueue()
{
    wp_enqueue_style('gallery-slider-css', plugins_url('css/style.css', __FILE__));

}

//  für pageSpeed das CSS im Footer laden
//add_action('wp_enqueue_scripts', 'output_enqueue');
add_action('get_footer', 'output_enqueue'); 

// Bildgrössen, die wir benötigen (erspart uns die functions.php bei Nachtrag)
function add_new_image_size()
{
    add_image_size('res-slider-thumbnail', 440, 270, array('center', 'center'));
    add_image_size('res-slider-thumbnail-big', 880, 540, array('center', 'center'));
}

add_action('init', 'add_new_image_size');

// Generiere Gallery-Slider Table in Datenbank
function register_gallery_slider_table()
{
    global $wpdb;
    $wpdb->gallery_slider = "{$wpdb->prefix}gallery_slider";
}

add_action('init', 'register_gallery_slider_table', 1);
add_action('switch_blog', 'register_gallery_slider_table');

function create_gallery_slider_table()
{
    global $wpdb;
    global $charset_collate;

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    register_gallery_slider_table();

    $sql_create_table = "CREATE TABLE {$wpdb->gallery_slider} (
		gallery_slide_id int(9) NOT NULL AUTO_INCREMENT,
		gallery_slide_media_id int(9) NOT NULL,
		gallery_slide_place int(9) NOT NULL,
		UNIQUE KEY id (gallery_slide_id)
		); $charset_collate;";

    dbDelta($sql_create_table);

}

register_activation_hook(__FILE__, 'create_gallery_slider_table');

// Füge die Admin-Seite hinzu
function gallery_slider_pages()
{
    add_menu_page('Gallery-Slider', 'Gallery-Slider', 'edit_posts', 'gallery-slider', 'display_gallery_slider_page', 'dashicons-align-center', 4);
}

add_action('admin_menu', 'gallery_slider_pages');

// Generiere Gallery-Slider Page im Admin-Bereich
function display_gallery_slider_page()
{

    wp_enqueue_media();

    ?>

    <div class="wrap">
        <h2>Resign Gallery-Slider</h2>
        <form method="POST" action="">
            <input type="hidden" name="update_resign_royalslider" value="true"/>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"> Bild hinzufügen</th>
                    <td><a class="button button-primary" id="upload_logo" href="">Bild hinzufügen</a>
                        <input style="width:400px;" id="logo_image_id" type="hidden" value=""/>
                        <br/>
                        <br/>
                        <div style="display:none;" id="logo_image_holder"></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <div class="clear"></div>
    </div>
    <div class="wrap">
        <div id="slides-panel">
            <?php

            global $wpdb;
            $slides = $wpdb->get_results(
                "SELECT * FROM {$wpdb->gallery_slider} ORDER BY gallery_slide_place ASC"
            );

            if ($slides) {

                echo '<div role="alert" class="alert alert-info">Du kannst die Bilder per <strong>Drag & Drop</strong> sortieren, die Änderungen werden direkt gespeichert.</div>';
                echo '<ol class="slides">';

                foreach ($slides as $slide) {

                    $slide_thumb = wp_get_attachment_image($slide->gallery_slide_media_id, 'res-thumbnail');
                    ?>
                    <li id="page_<?php echo $slide->gallery_slide_media_id; ?>">
                        <div class="panel panel-default">
                            <div class="panel-body"><a href="#" class="delete-link"
                                                       slide-id="<?php echo $slide->gallery_slide_id; ?>"><i
                                        class="fa fa-times fa-1x"></i> entfernen</a> <?php echo $slide_thumb; ?> </div>
                        </div>
                    </li>
                    <?php
                }
                echo '</ol>';

            } else {
                echo '<div role="alert" class="alert alert-info">Keine Einträge vorhanden, bitte zuerst <strong>Bild hinzufügen</strong>.</div>';
            }

            ?>
        </div>
    </div>
    <?php
}

// Ausgabe im Front-End
function resign_gallery_slider($columns, $mode, $interval, $width)
{

    // Verarbeitung der Funktions-Parameter
    $fade = ($mode == 'fade') ? ' carousel-fade' : '';
    $interval = ($interval != '') ? ' data-interval="' . $interval . '"' : '';

    if (!wp_is_mobile()) {
        if ($columns != 1 && $columns != 2 && $columns != 3 && $columns != 4 && $columns != 6) {
            $columns = 3;
        }
    } else {
        if (select_device() == 'iPad' || select_device() == 'Android Tablet') {
            $columns = 2;
        } else {
            $columns = 1;
        }
    }


    $size = ($width == 'full' || wp_is_mobile()) ? '-fluid' : '';

    global $wpdb;

    $slides_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->gallery_slider}");
    $slides = $wpdb->get_results(
        "SELECT * FROM {$wpdb->gallery_slider} ORDER BY gallery_slide_place ASC"
    );

    if ($slides) {

        $gallery_slider_start = '<div id="carousel-generic" class="carousel slide' . $fade . '" data-ride="carousel"' . $interval . '><div class="carousel-inner" role="listbox">';
        $gallery_slider_end = '</div>';

        $gallery_slider_controls = '<div class="controls">
			<a class="left" href="#carousel-generic" role="button" data-slide="prev">
        	<div class="arrow-left" aria-hidden="true"></div>
        	<span class="sr-only">Previous</span>
      		</a>
			  <a class="right" href="#carousel-generic" role="button" data-slide="next">
				<div class="arrow-right" aria-hidden="true"></div>
				<span class="sr-only">Next</span>
			  </a></div>';

        $i = 0; // Anzahl Slides
        $j = 0; // Anzahl Gruppierung
        $indicator = '';
        $slides_output = '';

        // Generiere die einzelnen Slides
        foreach ($slides as $slide) {

            $thumbnail_id = $slide->gallery_slide_media_id;

            if ($width == 'full' || wp_is_mobile()) {
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'res-slider-thumbnail-big', true);
            } else {
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'res-slider-thumbnail', true);
            }

            $large_url = wp_get_attachment_image_src($thumbnail_id, 'large', true);
            $thumbnail_meta = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

            $start_tag = '';
            $end_tag = '';
            $active = '';

            $i = $i + 1;

            if ($i == 1) { // erster Durchgang
                $start_tag = '<div class="item active"><div class="container' . $size . '"><div class="row">';
            }

            if ($i % $columns == 0) {  // Wenn durch Anzahl Spalten teilbar

                $indicator_active = '';

                if ($j == 0) { // Wenn in erster Gruppe
                    $indicator_active = ' class="active"';
                }

                $end_tag = '</div></div></div><div class="item"><div class="container' . $size . '"><div class="row">';
                $indicator .= '<li data-target="#carousel-generic" data-slide-to="' . $j . '"' . $indicator_active . '></li>';

                $j = $j + 1;
            }

            if ($slides_count == $i) { // Wenn letzter Slide
                $end_tag = '</div></div></div>';

                if ($slides_count % $columns != 0) { // Wenn Anzahl Slides nicht teilbar durch Anzahl Spalten
                    $indicator .= '<li data-target="#carousel-generic" data-slide-to="' . $j . '"></li>';
                    $j = $j + 1;
                }
            }

            // Generiere Slide-Output
            $slides_output .= '<div class="col-xs-' . (12 / intval($columns)) . '">';
            $slides_output .= '<div class="carousel-item">';
            $slides_output .= '<a href="' . $large_url[0] . '" class="">';
            $slides_output .= '<img src="' . $thumbnail_url[0] . '" alt="' . $thumbnail_meta . '" class="img-responsive center-block imageZoomer" />';
            $slides_output .= '<div class="overlayer"><span class="magnifier"><i class="fa fa-search fa-1x"></i></span></div>';
            $slides_output .= '</a>';
            $slides_output .= '</div>';
            $slides_output .= '</div>';

            $slides_output = $start_tag . $slides_output . $end_tag;

        }

        $slides_output .= '</div>';

        $indicator = '<ol class="carousel-indicators">' . $indicator . '</ol>';

        // Und hier alles zusammenfassend
        $gallery_slider = $gallery_slider_start . $slides_output . $gallery_slider_controls . $indicator . $gallery_slider_end;

        return $gallery_slider;

    } else {

        return '<div role="alert" class="alert alert-info">Keine Einträge vorhanden, bitte zuerst <a href="wp-admin/admin.php?page=gallery-slider">hinzufügen</a>.</div>';

    }

}

function select_device()
{

    if (!empty($_SERVER['HTTP_USER_AGENT'])) {

        if (strstr($_SERVER['HTTP_USER_AGENT'], 'Android') && stripos($_SERVER['HTTP_USER_AGENT'], "mobile")) {
            $device = 'Android Phone';
        } elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'Android')) {
            $device = 'Android Tablet';
        }
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'webOS')) $device = 'webOS';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'BlackBerry')) $device = 'BlackBerry';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPhone')) $device = 'iPhone';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPod')) $device = 'iPod';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) $device = 'iPad';
        if (strstr($_SERVER['HTTP_USER_AGENT'], 'RIM Tablet')) $device = 'RIM Tablet';


    } else {
        $device = false;
    }

    return $device;

}

?>
