<div class="timeline-horizontal well-top-md">
  <?php $args = array(
	'posts_per_page' => '4',
	'post_type' => 'demo',
	'order'=> 'ASC'		 
	);
	$i = 0;
	$the_query = new WP_Query($args); ?>
  <?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-quadrat-thumbnail'); ?>
  <div class="timeline-item" data-index="<?php echo $i; ?>">
		<div class="item-img">
			<div class="item-img-box">
<!--					<img class="img-responsive" alt="" src="<?php echo $image_res_crop_thumbnail[0]; ?>">-->
					<i class="fa fa-circle-o" aria-hidden="true"></i>
			</div>
		</div>
		<span class="items_toolbar_progress">
			<span class="items_toolbar_progress_line"></span>
			<span class="items_toolbar_progress_dot"></span>
		</span>

	</div>		  
	<?php $i++; endwhile; endif; ?>
  <?php wp_reset_postdata(); ?>
</div>

<div class="timeline-horizontal-text">
	<div class="timelineContent">
  <?php $args = array(
	'posts_per_page' => '4',
	'post_type' => 'demo',
	'order'=> 'ASC'		 
	);
	$i = 0;
	$the_query = new WP_Query($args); ?>
	<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
	<div class="timeline-text postContent text-center" data-index="<?php echo $i; ?>">
		<div class="textbox">
			<div class="headline">
				<h4><strong><?php echo title(12); ?></strong></h4>
			</div>
			<div class="text">
				<?php echo the_content(); ?>
			</div>
		</div>
	</div>
	<?php $i++; endwhile; endif; ?>
  <?php wp_reset_postdata(); ?>
	</div>
</div>