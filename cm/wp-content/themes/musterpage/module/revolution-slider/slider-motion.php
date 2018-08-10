<!-- REV-Slider-Motion-->
<section class="rev-slider fullwidthbanner-container rev-slider-motion"> 
	<div class="rev_slider_wrapper"> 
        <div id="slider-motion-01" data-version="5.4.5" class="rev_slider fullwidthabanner ">
            <ul><?php 
				// WP_Query arguments
					$args = array(
						'post_type' => 'slider-motion',
						'order' => 'ASC',
					);
				// The Query
					$slider = new WP_Query( $args );
				// The Loop
				$count = 0;
					if ( $slider->have_posts() ) {
							while ( $slider->have_posts() ) {
							
							$slider->the_post();
							$image_res_crop_large_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-slider-thumbnail'); ?>		
			   <li data-transition="fade"> <!-- fade , fadethroughdark, fadethroughlight, random-premium -->
				   <img src="<?php echo $image_res_crop_large_thumbnail[0]; ?>" 
						data-bgposition="center center" 
						data-kenburns="on" 
						data-duration="4000"  
						data-ease="Power3.easeInOut" 
						data-scalestart="<?php echo $count % 2 == 0 ? '160' : '160'; ?>" 
						data-scaleend="<?php echo $count % 2 == 0 ? '100' : '100'; ?>" 
						data-bgparallax="8" 
						class="img-responsive rev-slidebg"> <!-- ZoomSkale Animation data-duration + duration-scale -->
				   <div class="rev-slider-motion-text hidden-xs" data-transition="fade">
						<div class="tp-caption" data-frames='[{
 											"delay": 500, 
											"speed": 500, 
											"from": "opacity: 0", 
											"to": "opacity: 1"

										}, {
											"delay": "wait", 
											"speed": 300, 
											"to": "opacity: 0"
										}]'>
							<p><?php echo title(8); ?></p>
						</div>
					</div>
				</li>
				<?php 
				$count ++;}
				} else {
			// no posts found
				}
		// Restore original Post Data
		wp_reset_postdata(); ?>
            </ul> 
        </div> 
    </div>
</section>
<?php
function revslider_slider_motion(){
?>
		<script type="text/javascript">
			var tpj=jQuery;								
			var revapi490;
			tpj(document).ready(function() {
				if(tpj("#slider-motion-01").revolution == undefined){
					revslider_showDoubleJqueryError("#slider-motion-01");
				}else{
					revapi490 = tpj("#slider-motion-01").revolution({
						sliderLayout:'fullwidth', /* 'auto', 'fullwidth','fullscreen' */
						autoHeight: "off", //autohöhe skalliert, wenn sliderLayout auf auto ist automatisch 100vh nur bei Desktop
						spinner: "off", //Preloader zeichen off/on
						delay: 1000,  // bildwechsel
						dottedOverlay:"none",
						disableProgressBar: "on",
						responsiveLevels: [ 1690, 1390, 1100, 970, 480 ],
						gridwidth: [ 1690, 1390, 1100, 970, 480 ],
						gridheight:[ 600,500,400,400,200],
						parallax: {
							type: "scroll",
							origo: "slidercenter",
							levels: [ 10, 20, 30, 40, 50, 60, 70, 80, 90 ],
						},
						navigation: {
							onHoverStop: 'off',
							arrows: {
								enable: true,
								style: 'uranus',
								tmp: '',
								rtl: false,
								hide_onleave: false,
								hide_onmobile: true,
								hide_under: 0,
								hide_over: 9999,
								hide_delay: 200,
								hide_delay_mobile: 1200,
								left: {
									container: 'slider',
									h_align: 'left',
									v_align: 'center',
									h_offset: 20,
									v_offset: 0
								},
								right: {
									container: 'slider',
									h_align: 'right',
									v_align: 'center',
									h_offset: 20,
									v_offset: 0
								}
							},
							bullets: {
								enable: true,
								style: 'hermes',
								tmp: '',
								direction: 'horizontal',
								rtl: false,
								container: 'slider',
								h_align: 'center',
								v_align: 'bottom',
								h_offset: 0,
								v_offset: 20,
								space: 5,
								hide_onleave: false,
								hide_onmobile: false,
								hide_under: 0,
								hide_over: 9999,
								hide_delay: 200,
								hide_delay_mobile: 1200
							}
						}
						
                        							
					});
				}
				
				
	});	/*ready*/
			
			/*
			Zuerst Bilder Grösse ändern in Zeile 19 z.B. 'res-crop-large-thumbnail'
			
			Optionen für Content-Slider:
			sliderType:'hero', für nur 1 Bild
			- Fullscreen:
				- Zeile 2 Container Klasse löschen
				- sliderLayout auf fullscreen ändern
			- Fullwidth:
				- Zeile 2 Container Klasse mit container-fluid ersetzen
				- sliderLayout auf fullwidth ändern
			- Slider im Container:
				- sliderLayout auf auto ändern
			*/
			
		</script>
<?php
}
add_action('wp_footer', 'revslider_slider_motion');
?>
