<!-- side-menu  -->
<div class="side-menu-overlayer">
	<section id="side-menu-box">
		<div class="side-menu-inside">

			<nav id="side-menu-navigation">
				<?php
				wp_nav_menu( array(
					'menu' => 'header-menu',
					'theme_location' => 'primary',
					'depth' => 2,
					'container' => 'div',
					'container_id' => 'side-menu-nav',
					'container_class' => 'side-menu-collapse-overlay',
					'menu_class' => 'nav navbar-nav',
					'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
					'walker' => new wp_bootstrap_navwalker() ) );
				?>
			</nav>
			
<!--
			<div class="side-elements sidemenu-animation-start well-top-md ">
                <p style="line-height: 120%;">Informationen und wissenswertes<br> lesen Sie in unserem:</p>
            	<a class="btn btn-default" href="<?php esc_url( home_url( '/' ) ); ?>category/blog" >BLOG</a>
			</div>
-->
			
		</div>
	</section>
</div>