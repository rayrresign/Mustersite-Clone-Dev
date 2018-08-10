<?php
/*
* Template Name: Page-Events
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
        'posts_per_page' => '-1',
        'category_name' => 'events',
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
			  
				<a class="btn btn-primary gl-eventhandler" href="#" data-toggle="modal" data-target="#res-Modal" data-id="<?= $post->ID; ?>"><i class="fa fa-file-o"></i>&nbsp;&nbsp; Test </a>
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

  <div class="container">
<?php echo do_shortcode('[res_guestlist]'); ?>
	</div>

	
	 <!-- Modal Guestlist -->
      <div class="modal fade guestlistmodal" id="res-Modal" tabindex="-1" role="dialog" aria-labelledby="res-EventModalLabel" aria-hidden="true">
        <div class="modal-dialog text-left">
          <div class="modal-content">
            <div class="modal-header clearfix">
              <div class="close-modal xClose pull-right" data-dismiss="modal">
                <div class="lr">
                  <div class="rl"></div>
                </div>
              </div>
              <h3 class="modal-title pull-left" id="res-EventModalLabel" style="padding-top: 13px;">Liste</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 res-modalRow">
                  <div id="guestlistPopup">
                    <div class="guestlistBox">
                      <div id="callbackprocess">&nbsp;</div>
						<?php// echo do_shortcode('[res_guestlist]'); ?>
                    </div>
                  </div>
                  <div id="callbacksend">&nbsp;</div>
                </div>
              </div>
            </div>
            <div class="modal-footer"></div>
          </div>
        </div>
      </div>
      <!-- /.modal -->

</main>
<?php get_footer(); ?>
