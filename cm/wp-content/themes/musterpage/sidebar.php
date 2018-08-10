
<div class="row res-sidebar">
<?php if ( is_active_sidebar( 'sidebar-1' )  ) : ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
<?php endif; ?>

 <div class="share-tools well-top-sm">
   <h2>Share</h2>
    	<ul class="list-unstyled">
			<li><a href="http://www.facebook.com/sharer.php?url=<?php the_permalink(); ?>" data-social="facebook" target="_blank" class="popup facebook"><i class="fa fa-facebook"></i>Facebook</a></li>
            <li><a href="https://twitter.com/home?status=<?php the_permalink(); ?>" data-social="twitter" target="_blank" class="popup twitter"><i class="fa fa-twitter"></i>Twitter</a></li>
			<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" data-social="linkedin" target="_blank" class="popup linkedin"><i class="fa fa-linkedin"></i>Linkedin</a></li>
            <li><a href="https://www.xing.com/social_plugins/share?url=<?php the_permalink(); ?>" data-social="xing" target="_blank" class="popup xing"><i class="fa fa-xing"></i>XING</a></li>
            <li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-social="google-plus" target="_blank" class="popup google-plus"><i class="fa fa-google-plus"></i>Google+</a></li>
        </ul>
  </div>

  </div>
