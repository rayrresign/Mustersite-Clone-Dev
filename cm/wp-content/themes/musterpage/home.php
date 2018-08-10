<?php
/*
* Template Name: Home
*/
get_header(); ?>

<?php //require_once("module/home-video/res-video.php"); ?>
<?php require_once("module/revolution-slider/slider-homescreen.php"); ?>


<main class="res-content">

<section id="home" class="post well-top-lg intro-box text-center wow downIncoming" data-wow-duration="2s">
  <div class="container"> 
    <?php $args = array(
        'posts_per_page' => '1',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
      <div class="row postBox">
        <div class="col-xs-12">
          <div class="postContent ">
            <h2 class="title-line"><?php echo title(15); ?></h2>
            <?php echo content(36); ?>
          </div>
        </div>
      </div>
    <?php endwhile; endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section> 
	
	
	<section class="well-lg">
		<div class="container">
			
			<h2>icon v5 - <i class="fab fa-amazon-pay"></i>  </h2>

			
			<div class="postContent">
						<h2 class="title-line">FontAwsome Testings CHRIS</h2>
						<div class="">
							
							<h3><strong>After Elemente:</strong></h3>
							<ul>
								<li class="light">light After Elemente</li>
								<li class="regular">regular After Elemente</li>
								<li class="solid">solid After Elemente</li>
								<li class="brand">brand After Elemente</li>
							</ul>
							
							<h3><strong>Normale Icons:</strong></h3>
							Light: <i class="fal fa-arrow-right"></i><br>
							Regular: <i class="far fa-arrow-right"></i><br>
							Solid: <i class="fas fa-arrow-right"></i><br>
							Brand: <i class="fab fa-amazon-pay"></i><br>
							
							<hr>
							<h3><strong>OLD Icons:</strong></h3>
							<ul>
								<li>OLD After</li>
							</ul>
							OLD: <i class="fa fa-facebook"></i>
						</div>
						
					</div>		
			
			
						
			<div class="postContentOLD">

						<hr>
							<h3><strong>OLD Icons:</strong></h3>
							<ul>
								<li>OLD After</li>
							</ul>
							OLD: <i class="fa fa-facebook"></i>
				
			</div>
			
			 
		
		</div>
	</section>
	

	

	<!-- ............ html5 Video - PlayBtn via JS auf Home ............  -->
 <section class="home-video text-center well-lg video">
 	<div class="container">
		
		<h2 class="well-bottom-sm">Btn klick startet video - auf jeder seite unabhängi class "home"</h2>

		<div class="res-vid-playBtn html-video">
			<video preload controls poster="<?=get_template_directory_uri(); ?>/img/video/video_hg.jpg" 
				   onclick="gtag('event', 'homescreen', {event_category: 'video-play', event_action: 'Video Play auf Homescreen'});" >
				<source src="<?=get_template_directory_uri(); ?>/img/video/video_hg.mp4" type='video/mp4'>
			</video>
		</div>
		
		<div class="res-vid-playBtn html-video">
			<video preload controls poster="<?=get_template_directory_uri(); ?>/img/video/video_hg.jpg" 
				   onclick="gtag('event', 'homescreen', {event_category: 'video-play', event_action: 'Video Play auf Homescreen'});" >
				<source src="<?=get_template_directory_uri(); ?>/img/video/video_hg.mp4" type='video/mp4'>
			</video>
		 </div>	
		
	</div>
</section>

	


</main>
<?php get_footer(); ?>
