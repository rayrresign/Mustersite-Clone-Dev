<!-- side-menu  or  side-mobile-classy -->
<div class="side-menu-overlayer side-mobile-classy">
	<section id="side-menu-box">
		<div class="side-menu-inside">
			
			<!-- Mobile Side-Nav -->
			<div class="side-mobile-res-nav">
				<div class="side-elements sidemenu-animation-start">
					<p class="well-top-md"><?= get_option('res_kontaktdaten')['firma'];?></p>
					
				</div>

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
			</div>
			
			<!-- Blog Desktop -->
<!--
			<div class="side-blog-overlayer hidden-xs">
				<div class="side-elements sidemenu-animation-start">
					
					<div class="side-adress text-center">
							<h2 class="well-bottom">Kontakt</h2>
							<p><?= get_option('res_kontaktdaten')['firma'];?></p>
							<p><?= get_option('res_kontaktdaten')['strasse'];?></p>
							<p><?= get_option('res_kontaktdaten')['adresszusatz']; ?></p>
							<p><?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?><br><br></p>
							<p><a href="<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a></p>
							<p><a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?> </a></p>
					</div>
					
					<div class="side-blog text-center well-top-md">
						<h3>Unser Blog</h3>
						<p>Lesen Sie interessante Beiträge aus unserem Blog</p>
						<p class="well">
							<a class="btn btn-default" href="<?php esc_url( home_url( '/' ) ); ?>category/blog"><i class="fa fa-comment" style="padding-right: 8px;" aria-hidden="true"></i> Beiträge ansehen</a>
						</p>
					</div>
					
				</div>

			</div>
-->
			
        </div>	
	</section>
</div>