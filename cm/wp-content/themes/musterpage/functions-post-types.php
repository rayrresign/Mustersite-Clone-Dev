<?php 

    function resign_register_post_type($id, $menu, $menu_position, $menu_icon = 'dashicons-admin-page', $post_name = null, $post_name_plural = null){
        if($post_name == null){
            $post_name = $menu;
        }
        
        if($post_name_plural == null){
            $post_name_plural = $menu;
        }
        
        $labels = array(
            'name'                => _x( $post_name, 'Post Type General Name', 'text_domain' ),
            'singular_name'       => _x( $post_name, 'Post Type Singular Name', 'text_domain' ),
            'menu_name'           => __( $menu, 'text_domain' ),
            'name_admin_bar'      => __( 'Post Type', 'text_domain' ),
            'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
            'all_items'           => __( 'Alle '.$post_name_plural, 'text_domain' ),
            'add_new_item'        => __( 'Neuen Beitrag hinzufügen', 'text_domain' ),
            'add_new'             => __( 'Neuen Beitrag hinzufügen', 'text_domain' ),
            'new_item'            => __( 'Neuer Beitrag', 'text_domain' ),
            'edit_item'           => __( 'Beitrag bearbeiten', 'text_domain' ),
            'update_item'         => __( 'Update Item', 'text_domain' ),
            'view_item'           => __( 'Seite anschauen', 'text_domain' ),
            'search_items'        => __( 'Beitrag suchen', 'text_domain' ),
            'not_found'           => __( 'Nicht gefunden', 'text_domain' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
        );
        $args = array(
            'label'               => __( $id, 'text_domain' ),
            'description'         => __( 'Post shown at Homepage', 'text_domain' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'thumbnail', ),
            'taxonomies'          => array( ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => $menu_position,
            'menu_icon'           => $menu_icon,
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => false,     
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        );
        register_post_type( $id, $args );
    }
	
	function resign_register_taxonomy($name, $post_name){
			$labels = array(
				'name'                       => _x( $name, 'Taxonomy General Name', 'text_domain' ),
				'singular_name'              => _x( $name, 'Taxonomy Singular Name', 'text_domain' ),
				'menu_name'                  => __( $name, 'text_domain' ),
				'all_items'                  => __( 'Alle Rubriken', 'text_domain' ),
				'parent_item'                => __( 'Eltern Rubrik', 'text_domain' ),
				'parent_item_colon'          => __( 'Eltern Rubrik:', 'text_domain' ),
				'new_item_name'              => __( 'New Item Name', 'text_domain' ),
				'add_new_item'               => __( 'Neue Rubrik hinzufügen', 'text_domain' ),
				'edit_item'                  => __( 'Beitrag bearbeiten', 'text_domain' ),
				'update_item'                => __( 'Update Item', 'text_domain' ),
				'view_item'                  => __( 'View Item', 'text_domain' ),
				'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
				'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
				'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
				'popular_items'              => __( 'Popular Items', 'text_domain' ),
				'search_items'               => __( 'Search Items', 'text_domain' ),
				'not_found'                  => __( 'Not Found', 'text_domain' ),
			);
			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
			);
		register_taxonomy( $name, array( strtolower($post_name)), $args );	
	}

	// Register Custom Post Type
	function custom_post_type() {


		resign_register_post_type('res-custom', 'Texte & Bilder', 2.2, 'dashicons-schedule');

		resign_register_post_type( 'home', 'Home', 4.0 );

		
		resign_register_post_type( 'impressum', 'Impressum', 60, 'dashicons-edit');
        resign_register_post_type('demo', 'Demo-Inhalt', 60, 'dashicons-media-text');
		
		resign_register_taxonomy("Filter", 'demo');

	}
	
	// Hook into the 'init' action
	add_action( 'init', 'custom_post_type', 0 );
	

	// Hide Submenu at Post Type Impressum
	function hide_add_new_custom_type()
	{
		global $submenu;
		unset($submenu['edit.php?post_type=impressum'][10]);
	}
	add_action('admin_menu', 'hide_add_new_custom_type');
	
	// Hide Add New Button and TableNav from Post Type Impressum 
	function hide_that_stuff() {
		if('impressum' == get_post_type())
			echo '<style type="text/css">
				#favorite-actions {display:none;}
				.add-new-h2{display:none;}
				.tablenav{display:none;}
			</style>';
	}
	add_action('admin_head', 'hide_that_stuff');	
	

?>