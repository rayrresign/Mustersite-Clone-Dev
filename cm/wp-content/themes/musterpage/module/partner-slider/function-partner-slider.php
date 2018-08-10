<?php

// Partner Slider - Carousel

function resign_partner_slider($id, $post_slider_customposttype, $post_slider_columns, $post_slider_mode, $post_slider_interval, $post_slider_width)
{

    // Verarbeitung der Funktions-Parameter
    $fade = ($post_slider_mode == 'fade') ? ' carousel-fade' : '';
    $post_slider_interval = ($post_slider_interval != '') ? ' data-interval="' . $post_slider_interval . '"' : '';

    if ($post_slider_columns != 1 && $post_slider_columns != 2 && $post_slider_columns != 3 && $post_slider_columns != 4 && $post_slider_columns != 6) {
        $post_slider_columns = 3;
    }

    $size = ($post_slider_width == 'full') ? '-fluid' : '';

    global $post;

    $args = array(
        'post_type' => $post_slider_customposttype,
    );

    $the_query = new WP_Query($args);
    $post_count = $the_query->post_count;

    if ($the_query->have_posts()):

        $gallery_slider_start = '<div id="' . $id . '" class="carousel slide' . $fade . '" data-ride="carousel"' . $post_slider_interval . '><div class="carousel-inner" role="listbox">';
        $gallery_slider_end = '</div>';

        $gallery_slider_controls = '<div class="controls">
			<a class="left" href="#' . $id . '" role="button" data-slide="prev">
        	<div class="arrow-left" aria-hidden="true"></div>
        	<span class="sr-only">Previous</span>
      		</a>
			  <a class="right" href="#' . $id . '" role="button" data-slide="next">
				<div class="arrow-right" aria-hidden="true"></div>
				<span class="sr-only">Next</span>
			  </a></div>';

        $i = 0; // Anzahl Slides
        $j = 0; // Anzahl Gruppierung
        $indicator = '';
        $slides_output = '';

        while ($the_query->have_posts()) : $the_query->the_post();

            $thumbnail_id = get_post_thumbnail_id($post->ID);

            if ($post_slider_width == 'full') {
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'res-crop-large-thumbnail', true);
            } else {
                $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'res-crop-thumbnail', true);
            }

            $large_url = wp_get_attachment_image_src($thumbnail_id, 'large');
            $thumbnail_meta = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

            $start_tag = '';
            $end_tag = '';
            $active = '';

            $i = $i + 1;

            if ($i == 1) { // erster Durchgang
                $start_tag = '<div class="item active"><div class="container' . $size . '"><div class="row">';
            }

            if ($i % $post_slider_columns == 0) {  // Wenn durch Anzahl Spalten teilbar

                $indicator_active = '';

                if ($j == 0) { // Wenn in erster Gruppe
                    $indicator_active = ' class="active"';
                }

                $end_tag = '</div></div></div><div class="item"><div class="container' . $size . '"><div class="row">';
                $indicator .= '<li data-target="#' . $id . '" data-slide-to="' . $j . '"' . $indicator_active . '></li>';

                $j = $j + 1;
            }

            if ($post_count == $i) { // Wenn letzter Slide
                $end_tag = '</div></div></div>';

                if ($post_count % $post_slider_columns != 0) { // Wenn Anzahl Slides nicht teilbar durch Anzahl Spalten
                    $indicator .= '<li data-target="#' . $id . '" data-slide-to="' . $j . '"></li>';
                    $j = $j + 1;
                }
            }
				
				// Generiere Slide-Output
				$slides_output .= '<div class="col-xs-' . (12 / intval($post_slider_columns)) . '">';
				$slides_output .= '<div class="post-carousel-item partnerBox">';
				$slides_output .= '<a href="#" target="_blank">';
				$slides_output .= '<img src="' . $thumbnail_url[0] . '" alt="" class="img-responsive center-block" />';
				$slides_output .= '</a>';
				$slides_output .= '</div>';
				$slides_output .= '</div>';
				
				$slides_output = $start_tag . $slides_output . $end_tag;
		
		endwhile; 
			$slides_output .= '</div>';
			$indicator = '<ol class="carousel-indicators">' . $indicator . '</ol>';
			// Und hier alles zusammenfassend
			$gallery_slider = $gallery_slider_start . $slides_output . $gallery_slider_controls . $indicator . $gallery_slider_end;
			return $gallery_slider;
		
		else:
			return '<div class="text-center">...</div>';
		endif;
		
}

?>
