<!-- Homescreen-->
<?php 
	$image_res_crop = wp_get_attachment_image_src(get_option('res_logohome')['homescreen_bild'], get_option('res_logohome')['homescreen_bild_crop']);
?>

<div class="headerScreen container-fluid text-center" style="background-image: url(<?php echo $image_res_crop[0]; ?>);">	

<!-- sticker CMS  -->
<?php $the_query = new WP_Query(array('post_type' => 'res-custom', 'order' => 'ASC')); ?>
<?php if ($the_query->have_posts()) {
	$the_query->the_post(); 
?>
        <div class="sticker"> 
    	<a class="scrollLink" href="#home">
            <div class="circle">
                <div class="circleTxt text-center">
                    <h4>«<?php the_field('stickerTitel'); ?>»</h4>
                    <p><?php the_field('stickerTxt'); ?></p>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                </div> 
            </div>
         </a>
     </div>
<?php wp_reset_postdata(); ?>
<?php } ?>
	
  <div class="vertical-center slogan text-uppercase">
  	  <div class="container wow downIncoming" data-wow-duration="1.5s">	
                    <h2><?php echo get_option('res_logohome')['titel_homescreen']; ?></h2>
                    <p><?php echo get_option('res_logohome')['text_homescreen']; ?></p>
            <p class="scrollLink animated infinite pulseSoft"><a class="btn btn-primary" href="#postMag">mehr erfahren</a></p>
    	</div> 
    </div>
	
</div> 