<?php
/*
* Template Name: Home
*/
get_header(); ?>

<?php //require_once("module/home-video/res-video.php"); ?>
<?php //require_once("module/revolution-slider/slider-homescreen-video.php"); ?>
<?php //require_once("module/revolution-slider/slider-homescreen.php"); ?>


<div id="sliderChange">
	<?php //require_once("module/revolution-slider/slider-homescreen-video.php"); ?>
</div>
<div class="visible-xs-off">
	<?php //require_once("module/revolution-slider/slider-homescreen.php"); ?>
</div>



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
	
	
	
	
	<!-- ............ Wochenplan ............  -->
<!--	<section id="wochenplan">-->
		<?php //require_once("module/wochenplan/wochenplan.php"); ?>
<!--	</section>-->
	
	
	
	
	
	<!-- ............ Post Mag ............  -->
<section class="postMag well-top-lg">
  <div class="container">
    <div class="page-header text-center well">
      <h2>Angebote</h2>
    </div>
    <?php $args = array(
        'posts_per_page' => '3',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <div class="row">
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
        <div class="col-xs-12 col-sm-4 postBox">
          <div class="<?php if( $image_res_crop_thumbnail ){ ?>postImg<?php } ?>">
            <?php if( $image_res_crop_thumbnail ){ ?>
            <a href="<?php the_permalink(); ?>"><img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a>
            <?php } ?>
          </div>
          <div class="postContent">
            <h2><?php echo title(7); ?></h2>
            <?php echo excerpt(9); ?>
          </div>
          <div class="postShowMore"><a href="<?php the_permalink(); ?>">mehr erfahren</a> <img class="arrowSVG" src="<?=get_template_directory_uri(); ?>/img/site/arrow.svg" alt="Logo"/> </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <?php wp_reset_postdata(); ?>
  </div>
</section>



<!-- ............ Video - autoplay loop preload muted playsinline ............  -->
 <section class="intro-box text-center well-lg video">
 	<div class="container"> 

		<h2 class="title-line">Video Title</h2>
		<div class="html-video">
			<video preload controls poster="<?=get_template_directory_uri(); ?>/img/video/video_hg.jpg">
			<source src="<?=get_template_directory_uri(); ?>/img/video/video_hg.mp4" type='video/mp4'>
			</video>
		</div>	
	
	</div>
</section>

	
	
 <div class="nextSection container well-bottom-md"> 
 	<div class="scrollLink arrowDown text-center">     
     <a href="#parallax01"><i class="fa fa-angle-down"></i></a>
    </div>
 </div>
          	
	
<!-- ............ REV Parallax Bar ............  -->
 <section id="parallax01" class="well">
 	<div class="container-fluid"> 
		<?php require_once("module/revolution-slider/slider-parallax-bar-01.php"); ?>
	</div>
</section>

	
	
<!-- ............ Artikel-Post  ............  -->
<section class="post well-top-md">
  <div class="container">
    <div class="page-header">
      <h2>Aktuelles</h2>
    </div>
    <?php $args = array(
        'posts_per_page' => '3',
        'post_type' => 'demo',
		'order'=> 'DESC'		 
        );
        $the_query = new WP_Query($args); ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
    <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
      <div class="row postBox">
        <div class="col-xs-12 <?php if( $image_res_crop_thumbnail ){ ?>col-sm-10<?php } ?>">
          <div class="postContent ">
            <h2><?php echo title(15); ?></h2>
            <?php echo content(30); ?>
            <?php // echo excerpt(24); ?>
          </div>
        </div>
        <?php if( $image_res_crop_thumbnail ){ ?>
            <div class="col-xs-12 col-sm-2">
              <div class="postImg"> <a href="<?= $image_large[0] ?>"><img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a> </div>
            </div>
        <?php } ?>
      </div>
    <?php endwhile; endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>
	
	
	

	


</main>
<?php get_footer(); ?>
