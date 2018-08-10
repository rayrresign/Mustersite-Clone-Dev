<?php
/*
* Template Name: Page-Template
*/
get_header(); ?>


<?php 
// Menunamen mitgeben 
$menu_name = 'subnav';
 require_once("module/sub-nav/sub-nav-01.php"); 
?>

<main class="res-content">   
	

<!-- ............ Artikel-Post  ............  -->
<section class="post well-top-md">
  <div class="container">
    <div class="page-header">
      <h1>Artikel</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '1',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
    <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
      <div class="row postBox">
        <div class="col-xs-12 <?php if( $image_res_crop_thumbnail ){ ?>col-sm-10<?php } ?>">
          <div class="postContent ">
            <h2><?php echo title(15); ?></h2>
            <?php echo content(999); ?>
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
 
<!-- ............ Post Mag ............  -->
<section class="postMag">
  <div class="container">
    <div class="page-header">
      <h1>PostMag</h1>
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
            <h2><?php echo title(12); ?></h2>
          </div>
          <div class="postShowMore"><a href="<?php the_permalink(); ?>">mehr erfahren</a> </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <?php wp_reset_postdata(); ?>
  </div>
</section>



<!-- ............ Post Mag Modal ............  -->
<section class="postMagModal">
  <div class="container">
    <div class="page-header">
      <h1>Post Mag Modal</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '4',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <div class="row">
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
      <div class="col-xs-12 col-sm-3 postBox">
          <a href="#" class="load-content" data-target="ModalBox" data-id="<?php echo get_the_ID(); ?>" data-thumb="true">
          <div class="<?php if( $image_res_crop_thumbnail ){ ?>postImg<?php } ?>">
            <?php if( $image_res_crop_thumbnail ){ ?>
               <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>">
            <?php } ?>
          </div>
          <div class="postContent">
            <h4><?php echo title(8); ?></h4>
          </div>
          <div class="postShowMore"><p>mehr erfahren</p></div>
          </a>
      </div>
      <?php wp_reset_postdata(); ?>
      <?php endwhile; endif; ?>
    </div>
    
    <!-- Modal Box Overlayer -->
    <div class="modal fade" id="ModalBox" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header clearfix">
            <div class="close-modal xClose pull-right" data-dismiss="modal">
              <div class="lr">
                <div class="rl"></div>
              </div>
            </div>
          </div>
          <div class="modal-body"> </div>
        </div>
      </div>
    </div>
    
  </div>
</section>


<!-- ............ Intro Box ............  -->
 <section class="post well-md intro-box text-center wow downIncoming" data-wow-duration="2s">
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
          <div class="postContent">
            <h2 class="title-line"><?php echo title(15); ?></h2>
            <?php echo content(26); ?>
            <a class="btn btn-default" href="#">mehr erfahren</a>
          </div>
        </div>
      </div>
    <?php endwhile; endif; ?>
    <?php wp_reset_postdata(); ?>
  </div>
</section>


<!-- ............ REV Parallax Bar ............  -->
 <section id="parallax01" class="">
 	<div class="container-fluid"> 
		<?php require_once("module/revolution-slider/slider-parallax-bar-01.php"); ?>
	</div>
</section>
	
	
	
<!-- ............ Video - autoplay loop preload muted playsinline ............  -->
 <section class="intro-box text-center well-lg video">
 	<div class="container"> 

		<h2 class="well-bottom-sm">Video</h2>
		<div class="html-video">
			<video preload controls poster="<?=get_template_directory_uri(); ?>/img/video/video_hg.jpg">
			<source src="<?=get_template_directory_uri(); ?>/img/video/video_hg.mp4" type='video/mp4'>
			</video>
		</div>	
	
	</div>
</section>

<!-- ............ Features2 Storytelling ............  -->
<section class="storytell well-md well-bottom-sm">
    <?php $args = array(
        'posts_per_page' => '4',
        'post_type' => 'demo', 
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-large-thumbnail'); ?>
<div class="storytell-row">
  <div class="container-fluid">
     <div class="row postBox well-bottom-lg well-md">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="postContent">
			  <small class="text-uppercase"><strong>Subtitle</strong></small>
            <h2 class="well"><?php echo title(20); ?></h2>
            <?php echo content(60); ?>
           </div>
        </div>
        <?php if( $image_res_crop_thumbnail ){ ?>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
          <div class="postImg" style="background-image: url(<?php echo $image_res_crop_thumbnail[0]; ?>);">
            <div class="img-spacer"></div>
          </div>
        </div>
        <?php } ?>
      </div>
  </div>
  </div>
  <?php endwhile; endif; ?>
  <?php wp_reset_postdata(); ?>
</section>

	
<!-- ............ Focus Modal ............  -->
<section class="focusModal">
  <div class="container">
    <div class="page-header">
      <h1>Focus Teaser</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '3',
        'post_type' => 'demo', 
		'order'=> 'DESC'		 
        );
        $the_query = new WP_Query($args); ?>
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
     <div class="row">
      <a href="#" class="load-content" data-target="focusModalBox" data-id="<?php echo get_the_ID(); ?>" data-thumb="false" >
        <div class="col-xs-12 col-sm-7 postBox">
          <div class="postContent">
            <h2><?php echo title(5); ?></h2>
            <?php echo excerpt(20); ?>
            <div class="postShowMore">
              <p>mehr erfahren</p>
            </div>
          </div>
        </div>
        <?php if( $image_res_crop_thumbnail ){ ?>
        <div class="col-xs-12 col-sm-5">
          <div class="postImg imageZoomer"> 
           <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"> 
          </div>
        </div>
        <?php } ?>
      </a>
      </div>
      <?php endwhile; endif; ?>
      <?php wp_reset_postdata(); ?>

  </div>
</section>
<div class="modal fade" id="focusModalBox" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header clearfix">
        <div class="close-modal xClose pull-right" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
      </div>
      <div class="modal-body"> </div>
    </div>
  </div>
</div>


<!-- ............ Testimonials Slider ............  --> 
<section class="testimonialsSlider well-lg">
  <div id="testimonialsSliderPlacer">
    <div class="container">
    <div class="page-header text-center">
      <h1>Was Kunden sagen</h1>
    </div>
    </div>
        <div id="testimonialsSliderBox" class=""> 
              <!-- id, category_name, columns, mode, interval, width --> 
              <?php echo resign_testimonials_slider('testimonials', 'demo', 1, '', '0', ''); ?> 
        </div>
   </div>
</section> 
  
 
<!-- ............  Timeline Slider ............  -->
  <section style="background-color:red;" id="res-timeline-slider" class="well-bottom-lg">
    <div class="container">
<?php require_once("module/timeline-slider/timeline-slider.php"); ?> 
    </div>
  </section>

	
	
	
<!-- ............ Collapse Post  ............  -->
<section class="collapse-section">
  <div class="container">
    <div class="page-header">
      <h1>Collapse</h1>
    </div>
   <div class="panel-group" id="accordion">
    <?php $args = array(
            'posts_per_page' => '4',
            'post_type' => 'demo',
            'order'=> 'ASC'		 
            );
            $the_query = new WP_Query($args); ?>
    <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
    <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="heading-<?php the_ID(); ?>"> 
      	<a  class="<?php echo ($the_query->current_post == -1 ? '' : 'collapsed'); ?> accordionTitel" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php the_ID(); ?>" aria-expanded="true" aria-controls="collapse-<?php the_ID(); ?>">
        	<h3><?php echo title(8); ?></h3>
        	<div class="collapse-icon" id="arrow-collapse"> <i id="angleCross" class="fa fa-angle-down rotate-icon"></i> </div>
        </a> 
      </div> 
      <div id="collapse-<?php the_ID(); ?>" class="panel-collapse collapse<?php echo ($the_query->current_post == -1 ? ' in' : ''); ?>" role="tabpanel" aria-labelledby="heading-<?php the_ID(); ?>">
            <div class="row">
            <div class="panel-body col-sm-9">
              <?php the_content(); ?>
            </div>
            <?php if( $image_res_crop_thumbnail ){ ?>
          <div class="col-xs-12 col-sm-3">
            <div class="postImg well-top"><img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></div>
          </div>
          <?php } ?>
          </div>
    	</div>
     </div>
    <?php endwhile; endif; ?>
    <?php wp_reset_postdata(); ?>
	</div>
  </div>
</section>


 <div class="nextSection container well-md"> 
 	<div class="scrollLink arrowDown text-center">     
     <a href="#"><i class="fa fa-angle-down"></i></a>
    </div>
 </div>
  
	
	
<!-- ............ Parallax CSS ............  -->    
<?php $the_query = new WP_Query(array('post_type' => 'res-custom', 'order' => 'ASC')); ?>
<?php if ($the_query->have_posts()) {
	$the_query->the_post(); 
	$slider_crop = get_field('parallax01-image');
?>
<section class="container-fluid parallaxCSS" style="background-image: url(<?php echo $slider_crop['sizes']['res-crop-slider']; ?>">
  <div class="vertical-center slogan">
  		<div class="container text-center">
   		  <h3><?php the_field('parallax01-title'); ?></h3>
  		  <p><?php the_field('parallax01-text'); ?></p>
  	  </div>
  </div>
</section>  
<?php wp_reset_postdata(); ?>
<?php } ?>



 
<!-- ............ Team Modal ............  -->
<section class="team well-lg text-center">
  <div class="container">
    <div class="page-header">
      <h1>Team</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '2',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <div class="row">
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-quadrat-thumbnail'); ?>
      <div class="col-xs-12 col-sm-4 col-center postBox">
          <!--<a href="#" class="load-content" data-target="ModalBoxTeam" data-id="<?php echo get_the_ID(); ?>" data-thumb="true">-->
          <div class="<?php if( $image_res_crop_thumbnail ){ ?>postImg<?php } ?>">
            <?php if( $image_res_crop_thumbnail ){ ?>
               <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>">
            <?php } ?>
          </div>
          <div class="postContent well-bottom">
            <h4><?php echo title(4); ?></h4>
            <?php echo content(8); ?>
          </div>
          <!--</a>-->
      </div>
      <?php wp_reset_postdata(); ?>
      <?php endwhile; endif; ?>
    </div>
    
    <!-- Modal Box TEAM Overlayer 
    <div class="modal fade" id="ModalBoxTeam" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header clearfix">
            <div class="close-modal xClose pull-right" data-dismiss="modal">
              <div class="lr">
                <div class="rl"></div>
              </div>
            </div>
          </div>
          <div class="modal-body"> </div>
        </div>
      </div>
    </div>
    -->
  </div>
</section>




<!-- ............ Features ............  -->
<section class="features well-lg">
  <div class="container-fluid">
    <div class="page-header text-center well-bottom-sm">
      <h1>Features</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '4',
        'post_type' => 'demo', 
		'order'=> 'DESC'		 
        );
        $the_query = new WP_Query($args); ?>
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-quadrat-thumbnail'); ?>
     <div class="row postBox">
        <div class="col-xs-12 col-sm-6">
          <div class="postContent">
            <h2><?php echo title(6); ?></h2>
            <?php echo content(30); ?>
			<a class="btn btn-primary" href="#">mehr erfahren</a>
           </div>
        </div>
        <?php if( $image_res_crop_thumbnail ){ ?>
        <div class="col-xs-12 col-sm-6">
          <div class="postImg"> 
           <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"> 
          </div>
        </div>
        <?php } ?>
      </div>

      <?php endwhile; endif; ?>
      <?php wp_reset_postdata(); ?>

  </div>
</section>





<div class="well-top-lg text-center">
	<h1><strong>Plugins & Module</strong></h1>
</div>


<!-- ............ Content Slider ............  --> 
<section class="contentSlider well-lg">
  <div id="contentSliderPlacer">
    <div class="container">
		<div class="page-header text-center">
		  <h1 class="title-line">Content Slider</h1>
		</div>
    </div>
     <!-- Desktop Carousel Slide Modalbox -->
    <div id="contentSliderBox" class="container-fluid hidden-xs hidden-sm"> 
      <!-- category_name, columns, mode, interval, width --> 
      <?php echo resign_post_slider('content-slider-desktop','demo', 4, '', '0', ''); ?> 
    </div>
      
     <!-- Mobile No-Carousel-Output -->
    <div id="carousel-news-mobile" class="visible-xs visible-sm container">

      <div class="row">
        <?php $args = array(
                'posts_per_page' => '2',
                'post_type' => 'demo',
				'order'=> 'ASC'		 
                );
                $the_query = new WP_Query($args); ?>
        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
        <div class="col-sm-6 col-xs-12">
          <div class="contentBox popupLink postBox"> <a href="#" class="load-content" data-target="contentModalBox" data-id="<?php echo get_the_ID(); ?>" data-thumb="true">
            <div class="contentBoxslide">
              <?php if( $image_res_crop_thumbnail ){ ?>
              <div class="postImg"> <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"> </div>
              <?php } ?>
              <div class="overlay">
                <div class="tablePlacer">
                  <div class="overlayerBox postContent">
                    <h2><?php the_title(); ?></h2>
                    <div class="postShowMore">
                      <p>mehr erfahren</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </a> </div>
        </div>
        <?php endwhile; endif; ?>
        <?php wp_reset_postdata(); ?>
      </div>
      
    </div>
  </div>
  
  <!-- Modalbx Content Carousel -->
  <div class="modal fade" id="contentModalBox" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="close-modal xClose pull-right" data-dismiss="modal">
            <div class="lr">
              <div class="rl"></div>
            </div>
          </div>
        </div>
        <div class="modal-body"> </div>
      </div>
    </div>
  </div>
</section> 


<!-- ............ Partner Slider ............  --> 
<section class="partnerSlider well-lg">
  <div id="partnerSliderPlacer">
	  
    <div class="page-header text-center"><h1 class="title-line">Partners</h1></div> 
	  
     <div id="partnerSliderBox" class="container"> 
       <div class="hidden-xs">
          <!-- id, category_name, columns, mode, interval, width --> 
          <?php echo resign_partner_slider('partner-desktop', 'demo', 4, '', '0', ''); ?> 
	   </div>
     </div>
	  
      <div class="visible-xs">
          <?php echo resign_partner_slider('partner-mobile', 'demo', 1, 'fade', '0', ''); ?> 
	  </div>
	  
   </div>
</section>
	
 
 <!-- ............ REV Content-Slider ............  -->
 <section id="sliderContent" class="">
		<?php require_once("module/revolution-slider/slider-content.php"); ?>
 	<div class="container"> 
	</div>
</section>

  
  
  
<!-- Plugin Gallery-slider  --> 
<section id="gallerySlider" class="well-lg">
        <div class="container">
      <div class="page-header text-center"><h2>Gallery-Slider</h2></div>         
      <div class="hidden-xs text-center">
     <!-- columns, mode, interval, width --> 
    <?php //echo resign_gallery_slider(3, '', '0', 'full'); ?>
      </div>
      <div class="visible-xs">
        <?php //echo resign_gallery_slider(1, '', '3000', 'full'); ?>
      </div>

        </div>
</section> 


	
<!-- ............ Tabs Register ............  -->
<section class="tabs">
  <div class="container">
    <div class="page-header">
      <h1>Register</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '3',
        'post_type' => 'demo',
		'order'=> 'ASC'	 
        );
        $the_query = new WP_Query($args); ?>
    <div class="tabsNav">
      <ul class="nav nav-tabs nav-justified" role="tablist">
        <?php $i = 1; ?>
        <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <li role="presentation" class="">
          <a href="#tabsnav<?php echo $i;?>" aria-controls="tabsnav<?php echo $i;?>" role="tab" data-toggle="tab">
            <?php echo title(3); ?>
          </a>
         </li>
        <?php $i++; ?>
        <?php endwhile; endif; ?>
      </ul>
      
      <!-- Tab panes -->
      <div class="row">
        <div class="tab-content">
          <?php $i = 1; ?>
          <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
          <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
          <div role="tabpanel" class="tab-pane postBox" id="tabsnav<?php echo $i;?>">
            <div class="col-xs-12  <?php if( $image_res_crop_thumbnail ){ ?>col-sm-7<?php } ?>">
              <div class="postContent">
                <?php the_content(); ?>
              </div>
            </div>
            <?php if( $image_res_crop_thumbnail ){ ?>
            <div class="col-xs-12 col-sm-5">
              <div class="postImg"> <a href="<?= $image_large[0] ?>"> <img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"> </a> </div>
            </div>
            <?php } ?>
          </div>
          <?php $i++; ?>
          <?php endwhile; endif; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ............ Tabs Side - Second-Nav  ............  -->
<section class="secondNav">
  <div class="container">
    <div class="page-header">
      <h1>Second Nav</h1>
    </div>
    <?php $args = array(
        'posts_per_page' => '5',
        'post_type' => 'demo', 
		'order'=> 'ASC'	 
        );
        $the_query = new WP_Query($args); ?>
    <div class="row">
      <div class="secondNavList">
        <div class="col-xs-12 col-sm-3 tab-title">
          <ul class="nav nav-tabs" role="tablist">
            <?php $i = 1; ?>
            <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <li role="presentation" class="">
              <a href="#secondnav<?php echo $i;?>" aria-controls="secondnav<?php echo $i;?>" role="tab" data-toggle="tab">
                 <?php echo title(4); ?>
              </a></li>
            <?php $i++; ?>
            <?php endwhile; endif; ?>
          </ul>
        </div>
        <!-- Tab panes -->
        <div class="col-xs-12 col-sm-9 tab-content">
          <?php $i = 1; ?>
          <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
          <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
          <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
          <div role="tabpanel" class="tab-pane postBox" id="secondnav<?php echo $i;?>">
            <div class="col-xs-12  <?php if( $image_res_crop_thumbnail ){ ?>col-sm-10<?php } ?>">
              <div class="postContent">
                <h3><?php the_title(); ?></h3>
                <?php the_content(); ?>
              </div>
            </div>
            <?php if( $image_res_crop_thumbnail ){ ?>
            <div class="col-xs-12 col-sm-2">
              <div class="postImg"> <a href="<?= $image_large[0] ?>"><img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a> </div>
            </div>
            <?php } ?>
          </div>
          <?php $i++; ?>
          <?php endwhile; endif; ?>
          <?php wp_reset_postdata(); ?>
        </div>
      </div>
    </div>
  </div>
</section>


<!--  Socials -->
<section id="social-icons">
  <div class="container">
    <div class="page-header text-center">
      <h1 class="title-line">Socials</h1>
    </div>
    <div class="row">
      <div class="socials text-center">
          <div class="col-xs-1 col-center"><a href="https://www.facebook.com" target="_blank"><i class="fa fa-facebook fa-2x"></i></a></div>
          <div class="col-xs-1 col-center"><a href="https://instagram.com" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></div>
          <div class="col-xs-1 col-center"><a href="https://twitter.com" target="_blank"><i class="fa fa-twitter fa-2x"></i></a></div>
          <div class="col-xs-1 col-center"><a href="#" target="_blank"><i class="fa fa-envelope fa-2x"></i></a></div>
      </div>
    </div>
  </div>
</section>
       


<!-- ............ Filter v10  ............  -->
<section class="postMag Filterbox">
  <div class="container">
    <div class="page-header">
      <h1>Filter </h1>
    </div>
    <!-- Filter Navigation Desktop -->
	 <section id="tab-nav" class="container well hidden-xs"> 
  		  <div class="row">
   		  <div id="fixedDropdown" class="btn-group">
            <button type="button" class="btn-default btn-dropdown-custom btn-nav-dropdown visible-xs" data-toggle="dropdown" id="dropdown-menu-title">Thema wählen...</button>
            <button type="button" class="btn-default dropdown-toggle btn-nav-dropdown-toggle visible-xs" data-toggle="dropdown">
                <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span>
            </button>   
            <div class="filter-nav" role="tabpanel">
				<?php $terms = get_terms( 'Filter' );
				// Custom Category Meta Field in Post Array einfügen
//				var_dump($terms);
				if( !empty($terms) ){
					foreach($terms as $term){
						$term->cat_order = get_option("cat_order_" .$term->term_id)['cat_order']; // einfügen 
					}
					function cmp($a, $b){return strcmp($a->cat_order, $b->cat_order);} // string compare function nach cat_order
					usort($terms, "cmp"); // sortierung des Arrays

					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						echo '<ul id="dropdown-menu" class="nav nav-tabs" role="tablist">';
						foreach ( $terms as $term ) {
								$tax_class = strtolower(str_replace(' ','_',$term->name));
								echo '<li class="filter-btn" data-tax="'.$tax_class.'">
												<a href="javascript:void(0);" title="">
													<i class="fa fa-circle-thin" aria-hidden="true"></i><span> ' . $term->name . ' </span>
												</a>
											</li>';
						}
						echo '</ul>';
					}
				}
				?>
            </div>
         </div>    
         </div>    
     </section>
     
    <!-- Filter Navigation Mobile -->
     <section id="filter-nav-mobile" class="top-nav well visible-xs ">
     			<div class="dropdown">
					<button class="btn btn-primary filter-nav-btn dropdown-toggle" type="button" data-toggle="dropdown">
						<span class="choice"><?php $terms = get_terms( 'Filter' );
							echo $terms[0]->name; 
							?></span>
						<span class="caret"></span>
					</button>
					<div id="filter-mobile-dropdown" class="dropdown-menu">
						<?php 
						if( !empty($terms)){
							// Custom Category Meta Field in Post Array einfügen
							foreach($terms as $term){
								$term->cat_order = get_option("cat_order_" .$term->term_id)['cat_order']; // einfügen
							}
							usort($terms, "cmp"); // sortierung des Arrays 

							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
									echo '<ul id="dropdown-menu" class="nav navbar-nav">';
									foreach ( $terms as $term ) {
										$tax_class = strtolower(str_replace(' ','_',$term->name));
										echo '<li class="filter-btn" data-tax="'.$tax_class.'">
														<a href="javascript:void(0);" title="">
															<span> ' . $term->name . ' </span>
														</a>
												</li>';
									}
									echo '</ul>';
								}
						}?>
					</div>
				</div>
		</section>
        
    <!-- Filter Artikel -->
    <?php 
	   
	  $args = array(
        'posts_per_page' => '-1',
        'post_type' => 'demo',
		'order'=> 'ASC'		 
        );
        $the_query = new WP_Query($args); ?>
    <div class="row">
      <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>      
		<?php 
		$term_list = wp_get_post_terms($post->ID, 'Filter', array("fields" => "names"));
			$tax_class = '';
			foreach ($term_list as $term){
				$tax_class = $tax_class.' '.strtolower(str_replace(' ','_',$term));
			}
		?>
        <div class="col-xs-12 col-sm-4 postBox taxonomy-filter<?php echo $tax_class; ?>">        
          <div class="<?php if( $image_res_crop_thumbnail ){ ?>postImg<?php } ?>">
            <?php if( $image_res_crop_thumbnail ){ ?>
            <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a>
            <?php } ?>
          </div>
          <div class="postContent">
            <h2><?php echo title(12); ?></h2>
          </div>
          <div class="postShowMore"><a href="<?php the_permalink(); ?>">mehr erfahren</a> </div>
        </div>
      <?php endwhile; endif; ?>
    </div>
    <?php wp_reset_postdata(); ?>
  </div>
</section>





</main>
<?php get_footer(); ?>
