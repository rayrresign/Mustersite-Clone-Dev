<?php
/**
 * The Template for displaying default single posts.
 *
 * 
 */
get_header(); 
?>

<main class="res-content">

<!-- single-impressum page -->
<section class="impressum">
    <div class="container">
    	<div class="singleContent">
			
			<div class="row">
				<div class="col-xs-12 col-sm-6">
						
					<h3 class="well-bottom">Inhaber</h3>
					<p><?= get_option('res_kontaktdaten')['firma'];?><br>
						<?= get_option('res_kontaktdaten')['strasse'];?><br>
						<?= get_option('res_kontaktdaten')['adresszusatz']; ?>
						<?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?>
					</p>
		
					<p>
						<a href="<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a><br>
						<a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?> </a>				    
					</p>
				</div>
				<div class="col-xs-12 col-sm-6">
					<h3 class="well-bottom">Design, Konzept + Code</h3>
						<p>RESIGN. Grafikstudio<br>
						Technoparkstrasse 3<br>
						8406 Winterthur<br>
					</p>
					<p><a title="Grafik- und Webdesign" href="http://www.resign.ch" target="_blank" rel="nofollow noopener">www.resign.ch</a></p>
				</div>
			 
			</div>
			
			<div class="row"> <hr> </div>
			
                <?php while ( have_posts() ) : the_post(); ?>
                                  
                <?php $image_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large'); ?>
                <?php $image_res_crop_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'res-crop-thumbnail'); ?>
                    <article class="postBox"> 
                         <?php if( !has_shortcode( get_the_content(), 'gallery' ) && $image_res_crop_thumbnail ){ ?>  
                                <div class="postImg well-bottom">                    
                                    <a href="<?php echo $image_large[0]; ?>"><img class="img-responsive" src="<?php echo $image_res_crop_thumbnail[0]; ?>"></a> 
                                </div>                   
                             <?php } ?>
                            <div class="postContent">
                				<h2 class="well-bottom"><?php the_title(); ?></h2>
                                <?php the_content(); ?>
                            </div>          

                    </article>
                <?php get_template_part( 'content', 'single' ); ?>
			
            <div class="row"> <hr> </div>

			<a class="btn btn-primary" href="<? echo esc_url( home_url( '/' ) ); ?>">zur Startseite</a>
			
            <?php endwhile; // end of the loop. ?>
			
           </div>
		</div>
 </section>


</main>
<?php get_footer(); ?>