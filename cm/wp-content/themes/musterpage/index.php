<?php
get_header();
?>
<main class="res-content">

<section class="page-default">
    <div class="container">
    	<div class="singleContent">
			<?php while ( have_posts() ) : the_post(); ?>                    
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            <?php endwhile; ?>
          </div>
    </div>
</section>

</main>

<?php
get_footer();
?>