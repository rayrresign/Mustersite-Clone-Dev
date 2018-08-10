<?php 
// checking if there is an nav with specific name
if(wp_get_nav_menu_object( $menu_name )){
?>
 <!-- ............ Desktop Sub-nav  ............  --> 
 <section class="res-sub-nav hidden-xs">
    <div id="subnav-container" class="container">
    	<?php
			$nav_id = str_replace(' ', '_', strtolower($menu_name));
		
			wp_nav_menu( array(
				'menu' => $menu_name,
				'depth' => 1,
				'container' => 'div',
				//'container_id' => 'subnavbar',
				'container_id' => $nav_id,
				'container_class' => 'subnavbar',
				'menu_class' => 'nav nav-justified',
				'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
				'walker' => new wp_bootstrap_navwalker())
			);    
         ?>
   </div>
 </section> 
 
  <!-- ..... MOBILE Sub-nav ............... -->
 <section id="mobile-sub-nav">
 	<?php
	$menu_items = wp_get_nav_menu_items($menu_name);
	if(is_object(current( wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) ) ))){
		$this_item = current( wp_filter_object_list( $menu_items, array( 'object_id' => get_queried_object_id() ) ) )->title;
	}else{
		$this_item = 'Bitte wählen... ';
	}	 
	 ?>	 
	 <div class="top-nav visible-xs">
		 <div class="container">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle subnav-btn" type="button" data-toggle="dropdown"><?php echo $this_item; ?>
					<span class="caret"></span>
				</button>
				<?php
					$subnav_id = $nav_id . '_mobile';
					  wp_nav_menu( array( 
						'menu' => $menu_name,
						'depth' => 2,
						'container' => 'div',
						//'container_id' => 'subnavbar-mobile',
						'container_id' => $subnav_id,
						'container_class' => 'dropdown-menu',
						//'container_class' => 'subnav-menu',
						'menu_class' => 'nav navbar-nav',
						'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
						'walker' => new wp_bootstrap_navwalker())
					  );    
					?>
			</div>
		</div>
	</div>         	
</section>
<?php
}
?>