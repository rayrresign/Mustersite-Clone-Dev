<!-- REV-Slider-Homescreen VIDEO from Page-Settings -->
<section id="rev-slider-homescreen-video-mobile" class="rev-slider rev-homescreen"> 
<?php $the_query = new WP_Query(array('post_type' => 'res-custom', 'order' => 'ASC')); ?>
<?php if ($the_query->have_posts()) {
	$the_query->the_post(); 
	$video_res = wp_get_attachment_url(get_option('res_videohome')['video_mobile']);
?>

    <div class="vertical-center rev-slider-text">
        <div class="slogan duration2 topIncoming text-uppercase">
            <div class="container">
                    <h2><?php echo get_option('res_logohome')['titel_homescreen_mobile']; ?></h2>
                    <p><?php echo get_option('res_logohome')['text_homescreen_mobile']; ?></p>
                 <p class="scrollLink"><a class="btn btn-secondary" href="#home">mehr erfahren</a></p>
            </div>
            <div class="scrollSkipper claimSkipp"><a href="#home" class="arrow-down arrowWhite"></a></div>
        </div>
    </div> 

    <div class="rev_slider_wrapper"> 
        <div id="rev_slider_homescreen" data-version="5.4.5" class="rev_slider">
            <ul>
               <li data-transition="fade">

   					 <!-- required for background video, and will serve as the video's "poster/cover" image -->
				   <div class="rs-background-video-layer tp-resizeme tp-videolayer rs-parallaxlevel-5 rev-slidebg" data-bgparallax="8"
 
					 data-frames='[{"delay": 500, "speed": 300, "from": "opacity: 0", "to": "opacity: 1"}, 
								   {"delay": "wait", "speed": 300, "to": "opacity: 0"}]' 

					 data-type="video" 
					 data-videomp4="<?php echo $video_res; ?>" 
					 data-videowidth="2600" 
					 data-videoheight="1460" 
					 data-autoplay="on" 
					 data-videocontrols="none" 
					 data-forcerewind="on" 
					 data-videoloop="loop" 
					 data-allowfullscreenvideo="true" 
					 data-videopreload="false" 

					 data-x="center" 
					 data-y="center" >
						</div> 
                </li>
            </ul> 
    </div>         
<?php wp_reset_postdata(); ?>
<?php } ?>
</section>
<?php    
function revslider_slider_homescreen_video_mobile(){
?>
		<script type="text/javascript">
			var tpj=jQuery;								
			var revapi490;
			tpj(document).ready(function() {
				if(tpj("#rev_slider_homescreen").revolution == undefined){
					revslider_showDoubleJqueryError("#rev_slider_homescreen");
				}else{
					revapi490 = tpj("#rev_slider_homescreen").show().revolution({
                        sliderType:"standard",
                        sliderLayout:"fullscreen",
						spinner:"off",
                        dottedOverlay:"none",
                        responsiveLevels:[1240,1024,900,778,480],
                        visibilityLevels:[1240,1024,900,778,480],
                        gridwidth:[1200,1024,900,778,480],
                        gridheight:[675,576,900,480,480],
						parallax: {
							type:"scroll",
							origo:"slidercenter",
							levels:[10,20,30,40,50,60,70,80,90],							
							disable_onmobile: 'on'
						}
					});
				}
			});	/*ready*/
		</script>
<?php
}
add_action('wp_footer', 'revslider_slider_homescreen_video_mobile');
