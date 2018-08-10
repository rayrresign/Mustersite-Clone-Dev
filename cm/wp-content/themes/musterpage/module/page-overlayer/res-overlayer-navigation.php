


<!--  Overlayer Navigation -->
<section id="page-overlayer">
  <div class="page-overlayer-inside">
          <div class="page-overlayer-content text-center">
             
			<div class="page-overlayer-nav">
				<?php
                      wp_nav_menu( array(
                        'menu' => 'header-menu',
                        'theme_location' => 'primary',
                        'depth' => 2,
                        'container' => 'div',
                        'container_id' => 'navbar',
                        'container_class' => 'collapse navbar-collapse',
                        'menu_class' => 'nav navbar-nav',
                        'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
                        'walker' => new wp_bootstrap_navwalker())
                      );    
                 ?>
             </div>

         </div>
  </div>
</section>





