<!-- REV-Slider-Homescreen VIDEO from Page-Settings DESKTOP -->
<section id="rev-slider-homescreen-video-desktop" class="rev-slider rev-homescreen"> 
<?php $the_query = new WP_Query(array('post_type' => 'res-custom', 'order' => 'ASC')); ?>
<?php if ($the_query->have_posts()) {
	$the_query->the_post(); 
	$video_res = wp_get_attachment_url(get_option('res_videohome')['video_desktop']);
?>

    <div class="vertical-center rev-slider-text">
        <div class="slogan duration2 topIncoming text-uppercase">
            <div class="container">
                    <h2><?php echo get_option('res_logohome')['titel_homescreen']; ?></h2>
                    <p><?php echo get_option('res_logohome')['text_homescreen']; ?></p>
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
	
<!-- REV-Slider-Homescreen VIDEO from Page-Settings MOBILE -->
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
        <div id="rev_slider_homescreen_mobile" data-version="5.4.5" class="rev_slider">
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