<?php

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Musterpage
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */


// RES Seo Version 2.3 - 2018 mit Kategorien-SEO-Title, normalem Fallback, noindex Option, Search No-Found Fix, Res-Large-Thumb-FB

// überprüft ob die Klasse acf existiert
add_action('customize_register', 'res_customize_register');
add_filter('wp_title', 'musterpage_wp_title', 10, 2);


if (!class_exists('acf')) return;


function musterpage_wp_title($title, $sep)
{
    global $paged, $page;
	
	// in Blog holt Kategorie
	$term_id = res_get_cat_id();	
	$blogTitle = get_field('seiten_titel',$term_id); // in Blog holt den geschriebenen Titel -> sonst leer
	$wpTitle_custom = get_field('seiten_titel'); // settings -> title
	
	// Falls Blog und ein Titel geschrieben wurde.
	if(is_blog() && !empty($blogTitle)){
		$title .= $blogTitle;
		return $blogTitle;			
	} 
	
    if (is_feed())
        return $title;
	
    // Add the site description for the home/front page.
	if(empty($wpTitle_custom)){		
    	$title .= get_bloginfo('name');
	} else {
		if(is_blog() && !empty($wpTitle_custom)){
			$title .= get_bloginfo('name');
		} else {			
        	return $wpTitle_custom;
		}
	}

    // Add a page number if necessary.
    if ($paged >= 2 || $page >= 2) {	
        $title = "$blogTitle $sep " . sprintf(__('Page %s', 'musterpage'), max($paged, $page));
	} 
	
    return $title;
}
/**
*	Info:	holt den aktuellen Category , NUR AUF BLOG SEITE 
*	return	Gibt den Taxonomy mit Id zurück
*/
function res_get_cat_id(){
	global $post, $cat;
	
	if(is_category()){
		$terms = get_the_terms( $post->ID, 'category' );
		$this_category = get_category($cat);     
		
		if($this_category->category_parent > 0){
			$cat_id = $this_category->term_id;
			return 'category_'.$cat_id;	
		} else {			
			foreach ($terms as $term) {
				$cat_id = $term->taxonomy.'_'.$term->term_taxonomy_id; 
				$name = $term->name;
				$id = $term->term_taxonomy_id;
				return $cat_id;
				}
		}
	} 	
}

function getUrl(){
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	return $url;
}

// check if site is Blog
function is_blog () {
	global  $post;
	$posttype = get_post_type($post );
	return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
}

function res_write_page_infos()
{	
	if(!is_blog()){
    	$description = get_field('seiten_beschreibung');
    	$socialTitel = get_field('social_titel');		 
    	$socialBeschreibung = get_field('social_beschreibung');
		$socialUrl = get_permalink();
		$socialImageField = get_field('social_image');
		$res_meta_tags = (array) get_field('res_meta_tags');
		$res_canonical = get_field('res_canonical');
	} else {		
		$cat_id = res_get_cat_id();	
    	$description = get_field('seiten_beschreibung', $cat_id);
    	$socialTitel = get_field('social_titel', $cat_id);		 
    	$socialBeschreibung = get_field('social_beschreibung', $cat_id);
		$socialUrl = getUrl();
		$socialImageField = get_field('social_image', $cat_id);
		$res_meta_tags = (array) get_field('res_meta_tags', $cat_id);
		$res_canonical = get_field('res_canonical', $cat_id);		
	}	
	 	
	// falls keine Google Beschreibung
	if(empty($description)) {
		$titlefalse = wp_title('|', false, 'right');
		$titlecut = get_bloginfo( 'name' );
		$correct_desc = str_replace( $titlecut, '' ,$titlefalse );
		$description = $correct_desc .get_bloginfo( 'description' );
	}
	
	
    $socialImage = null;
    if ($socialImageField ) {
		if(!is_blog()){
			$socialImage_arr = get_field('social_image');
			$socialImage = $socialImage_arr["sizes"]["res-large-thumbnail"];
		} else {
			$socialImage_arr = get_field('social_image', $cat_id);
			$socialImage = $socialImage_arr["sizes"]["res-large-thumbnail"];
		}
    } 	
	
	
	if ($description) echo '<meta name="description" content="' . $description . '">';
    if ($socialTitel) echo '<meta property="og:title" content="' . $socialTitel . '">';
    if ($socialBeschreibung) echo '<meta property="og:description" content="' . $socialBeschreibung . '">';
    if ($socialTitel) echo '<meta property="og:url" content="' . $socialUrl . '">';
    if ($socialImage) echo '<meta property="og:image" content="' . $socialImage . '">';
	
	// Robot
	$index = 'index';
	$follow = 'follow';
	if(in_array('noindex', $res_meta_tags)) $index = 'noindex';
	if(in_array('nofollow', $res_meta_tags)) $follow = 'nofollow';
	echo '<meta name="robots" content="'.$index.', '.$follow.'" />';
		
	// Canonical
	
	if(is_blog()){
		$singleId = str_replace('category_','',$cat_id);
		if($singleId) $res_canonical = get_category_link($singleId);
	} 
	
	
	if($res_canonical) echo '<link rel="canonical" href="'.$res_canonical.'" />';
	else echo '<link rel="canonical" href="'.$res_canonical.'" />';
	
    ?>
    <link rel="shortcut icon" href="<?php echo esc_url( get_theme_mod( 'res_favicon' ) ); ?>" />
    <link rel="icon" sizes="192x192" href="<?php echo esc_url( get_theme_mod( 'res_favicon' ) ); ?>">
    <meta name="theme-color" content="<?php echo esc_url( get_theme_mod( 'res_browser_color_bar' ) ); ?>">
    <meta name="Designer" content="RESIGN. Grafikstudio Winterthur">
    <?php
}

add_action('wp_head', 'res_write_page_infos');


function res_customize_register($wp_customize)
{
//    $wp_customize->add_section( 'res_head_section' , array(
//        'title'       => __( 'Head Settings', 'themeslug' ),
//        'priority'    => 30,
//        'description' => 'Mobile Header Bar Color und Favicon',
//    ) );
    $wp_customize->add_setting( 'res_browser_color_bar', array(
        'default' => '#000',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

//    $wp_customize->add_setting( 'res_favicon' );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'res_browser_color_bar', array(
        'label' => __( 'Mobile Header Bar Color', 'theme_textdomain' ),
        'section'  => 'title_tagline'
    ) ) );

//    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'res_favicon', array(
//        'label'    => __( 'Favicon', 'favicon' ),
//        'section'  => 'res_head_section'
//    ) ) );
}

if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'acf_seo',
        'title' => 'SEO',
        'fields' => array (
            array (
                'key' => 'field_58ab15d0e82a4',
                'label' => 'Google Seiten Titel',
                'name' => 'seiten_titel',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => 'max. 65 Zeichen',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => 70,
            ),
            array (
                'key' => 'field_58ab15f2e82a5',
                'label' => 'Google Seiten Beschreibung',
                'name' => 'seiten_beschreibung',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => 'max. 156 Zeichen',
                'maxlength' => 160,
                'rows' => 2,
                'formatting' => 'none',
            ),
			array (
                'key' => 'field_hxsuq4wrnywrk',
                'label' => 'Indexierung',
                'name' => 'res_meta_tags',
                'type' => 'checkbox',
				'choices' => array(
					'noindex'	=> 'Keine Indexierung dieser Seite (noindex)',
					'nofollow'	=> 'Keine Linkverfolgung ab dieser Seite (nofollow)',
				),
                'default_value' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
            ),
            array (
                'key' => 'field_1zxha7xz8ukk3',
                'label' => 'Canonical URL',
                'name' => 'res_canonical',
                'type' => 'text',
                'default_value' => '',
                'maxlength' => 100,
                'formatting' => 'none',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
            array (
                array (
                    'param' => 'ef_taxonomy',
                    'operator' => '==',
                    'value' => 'category',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
            array (
                array (
                    'param' => 'ef_media',
                    'operator' => '!=',
                    'value' => 'all',
                    'order_no' => 0,
                    'group_no' => 1,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 98,
    ));
    register_field_group(array (
        'id' => 'acf_social-media',
        'title' => 'Social Media',
        'fields' => array (
            array (
                'key' => 'field_58ab20e06c0fe',
                'label' => 'Titel',
                'name' => 'social_titel',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => 'Facebook Titel',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => 70,
            ),
            array (
                'key' => 'field_58ab20f76c0ff',
                'label' => 'Beschreibung',
                'name' => 'social_beschreibung',
                'type' => 'textarea',
                'default_value' => '',
                'placeholder' => 'Facebook Link Beschreib',
                'maxlength' => 150,
                'rows' => 2,
                'formatting' => 'none',
            ),
            array (
                'key' => 'field_58ab215a6c101',
                'label' => 'Image',
                'name' => 'social_image',
                'type' => 'image',
                'save_format' => 'object',
                'preview_size' => 'res-crop-thumbnail',
                'library' => 'all',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
            array (
                array (
                    'param' => 'ef_taxonomy',
                    'operator' => '==',
                    'value' => 'category',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
            array (
                array (
                    'param' => 'ef_media',
                    'operator' => '!=',
                    'value' => 'all',
                    'order_no' => 0,
                    'group_no' => 1,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 99,
    ));
}
//add_action('acf/input/admin_head', 'hide_seo_and_social_group_boxes');
function hide_seo_and_social_group_boxes() {
    ?>
    <script type="text/javascript">
        jQuery(function(){
            jQuery('#acf_acf_seo').addClass('closed');
            jQuery('#acf_acf_social-media').addClass('closed');
        });
    </script>
    <?php
}


