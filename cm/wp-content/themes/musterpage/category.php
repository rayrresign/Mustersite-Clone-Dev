<?php
/**
 * The Template for displaying default single posts.
 *
 * 
 */
get_header(); ?>

<main class="res-content">

<!-- category page  -->
 <div class="container"> 
 
    <?php //breadcrumbz($post); ?>
  
    <div class="col-xs-12 col-sm-8">
	<?php 
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
        $source = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
    <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
      <div class="row postBox">
        <div class="col-xs-12 <?php if( $image_res_crop_thumbnail ){ ?>col-sm-9<?php } ?>">
          <div class="row postContent">
            <h3><?php echo title(15); ?></h3>
            <p><?php echo get_the_date(); ?> - <?php the_category(' '); ?></p>
            <p><?php echo excerpt(30); ?></p>
             <p><a class="btn btn-primary" href="<?php the_permalink(); ?>">ansehen</a></p>
          </div>
        </div>
        <?php if( $image_res_crop_thumbnail ){ ?>
    <div class="col-xs-12 col-sm-3">
      <div class="postImg"> <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a> </div>
    </div>
        <?php } ?>
      </div>

				<?php 
					}
				} else {
				?><p>...</p>
                <?php
			} ?>
     </div> 
     
     <!-- sidebar -->
    <div class="col-xs-12 col-sm-3 col-sm-offset-1">
        	<?php get_sidebar( 'blog' );?>
    </div>
    
     </div>

</main>
<?php get_footer(); ?>