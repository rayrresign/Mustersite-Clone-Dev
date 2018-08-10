<?php
/**
 * The Template for displaying default single posts.
 *
 * 
 */
get_header(); 
?>

<main class="res-content">

<!-- single page -->
<section class="">
    <div class="container">
    	<div class="singleContent">
                <?php while ( have_posts() ) : the_post(); ?>
                
                <?php //breadcrumbz($post); ?> 
                  
                <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
                <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
                    <article class="postBox"> 
                         <?php if( !has_shortcode( get_the_content(), 'gallery' ) && $image_res_crop_thumbnail ){ ?>  
                                <div class="postImg well-bottom">                    
                                    <a href="<?php echo $image_large[0]; ?>"><img class="img-responsive" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a> 
                                </div>                   
                             <?php } ?>
                            <div class="postContent">
                				<h2><?php the_title(); ?></h2>
                                <?php the_content(); ?>
                            </div>          

                    </article>
                <?php get_template_part( 'content', 'single' ); ?>
            <ul class="breadcrumb breadcrumb-light breadcrumb-divider-middot">
              <li><a href="javascript:history.back()">zurück</a> </li>
            </ul> 
            <?php endwhile; // end of the loop. ?>
           </div>
		</div>
 </section>


</main>
<?php get_footer(); ?>