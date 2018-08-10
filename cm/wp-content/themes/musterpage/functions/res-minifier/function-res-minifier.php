<?php
require('res-minifier.php');
require('HTML-res-caching.php');

/*
* FILE LISTE in Datei:  res-minifier.php   ------------------------------------------------------------------
*/

/*
* CMS BACKEND MENÜ ------------------------------------------------------------------
*/

// create custom plugin settings menu
add_action('admin_menu', 'res_minifier_menu');
function res_minifier_menu() {
	//create new top-level menu   
	$hook = add_menu_page('Page komprimieren', 'Ladezeit', 'edit_pages', __FILE__, 'res_minifier_page', 'dashicons-editor-code');

	//call register settings function
	add_action( 'admin_init', 'res_minifier_settings' );
	
	add_action('load-'.$hook,'on_update_res_minifier_settings');
	function on_update_res_minifier_settings(){
		if(isset($_GET['settings-updated']) && $_GET['settings-updated']){
			// CSS & JS Minifier
			if(!get_option('res_minifier_checkbox')){
				// false => clears all min.css and min.js
				clear_min_css_files();	// => res-minifier.php
				clear_min_js_files();	// => res-minifier.php
			}else{
				create_min_css_files();	// => res-minifier.php
				create_min_js_files();	// => res-minifier.php
				// update res_minifier_timestamp
				update_option('res_minifier_timestamp', current_time('timestamp'));
			}

			// HTML Cacher 
			if(!get_option('res_html_cacher_checkbox')){
				// false => clears _cache Folder
				clear_cached_pages();
			}
		}
	}
}

function res_minifier_settings() {
	//register our settings
	register_setting( 'res-minifer-setting', 'res_minifier_checkbox' );
	register_setting( 'res-minifer-setting', 'res_minifier_timestamp' );
	register_setting( 'res-minifer-setting', 'res_html_cacher_checkbox' );
	register_setting( 'res-minifer-setting', 'res_html_timestamp' );
}

// HTML Page
function res_minifier_page() {
?>
<div class="wrap">
	<?php
	if(get_option('res_minifier_checkbox'))
		$state = '[Aktiviert]';
	else
		$state = '[Deaktiviert]';
	?>
	<h1>Webseite komprimieren SEO</h1>
	<form method="post" action="options.php">
		<?php settings_fields( 'res-minifer-setting' ); ?>
		<?php do_settings_sections( 'res-minifer-setting' ); ?>
		<table class="form-table">       
			<p>MINIFY - Das komprimieren der Website verbessert die Ladezeit und Performance einer Webseite. <br>
				Die Dateien werden komprimiert über den Server an den Browser übertragen und erfüllen damit die Google-Anforderungen (JavaScript reduzieren / CSS reduzieren) 
                 für optimalen Page Speed (Ladezeit). <br></p>
                 <p>Mit der HTML Cache Aktivierung wir die Seite zwischengespeichert und kann somit schneller geladen werden.<br>
                 Gemäss Google wird daher die Seite vorallem bei der mobilen Suche besser gelistet SEO-Ranking.<br>
                 Der Cache-Zwischenspeichert wird erst wieder erneuert, wenn im CMS ein Beitrag aktualisiert wird.</p>
			<p>Status Komprimierung: <b> <?php echo $state; ?> </b> </p>
			<tr valign="top">
				<th scope="row">
					Minify CSS & JS Files
				</th>
				<td>
					<input type="checkbox" name="res_minifier_checkbox" value="1" <?php checked(1, get_option('res_minifier_checkbox'), true);?> />
				</td>
			</tr>
			
			<?php 
			if(get_option('res_minifier_timestamp')):
			?>
			<tr>
				<th>
					Letzer Minify:
				</th>
				<td>
					<?php echo date_i18n('F j, Y H:i', get_option('res_minifier_timestamp')); ?>
				</td>
			</tr>
			<?php
			endif;		  
			?>
			<tr>
				<th>
					HTML Cache
				</th>
				<td>
					<input type="checkbox" name="res_html_cacher_checkbox" value="1" <?php checked(1, get_option('res_html_cacher_checkbox'), true);?> />
					<?php
					if(get_option('res_html_cacher_checkbox')){
						echo '<a href="#" class="button button-secondary clear_cached_pages_btn">HTML Caches löschen</a>';						
					}?>
				</td>
			</tr>
				<th>
				
				</th>
				<td>
					<div class="success-empty hidden">Der Cache wurde erfolgreich gelöscht und wird jetzt neu angelegt</div>
				</td>
			<?php
			//endif;		  
			?>
			
		</table>
        <p>Aktualisieren und speichern:</p>
		<?php submit_button();
//		$current_user = wp_get_current_user();	
//		echo '<pre>' . print_r( $current_user, true ) . '</pre>';
		?>
	</form>
</div>
<?php
}

/*
*	calls functions from res-minifier.php when settings are updated
*/
//$hook = add_menu_page('Page komprimieren', 'Page komprimieren', 'edit_pages', __FILE__, 'res_minifier_page', 'dashicons-editor-code');


// AJAX Request für leeren des HTML caches
add_action('admin_head', 'clear_cached_pages_script');
function clear_cached_pages_script() {
	?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		$('.clear_cached_pages_btn').click(function(){
			var data = {
				action: 'clear_cached_pages_action'
			};
			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(ajaxurl, data, function(response){});
			$('.success-empty').removeClass('hidden');
		});
	});
	</script>
	<?php
}
add_action('wp_ajax_clear_cached_pages_action', 'clear_cached_pages');


/*
*	REDAKTEUR (EDITOR) BERECHTIGUNGEN ------------------------------------------------------
*/

// Editor (Redakteur) darf Einstellungen (options) bearbeiten
function add_theme_caps() {
    // gets the author role
    $role = get_role( 'editor' );
    $role->add_cap( 'manage_options' ); 
}
add_action( 'admin_init', 'add_theme_caps');

// Versteckt Einstellung im Menü vor dem Redakteur
function remove_menus(){
    $user = wp_get_current_user();
	if ( in_array( 'editor', (array) $user->roles ) ) {
  		remove_menu_page( 'options-general.php' );        //Settings
	}
}
add_action( 'admin_menu', 'remove_menus' );

// Verhindert dem Redakteur diese Seiten aufzurufen
add_action( 'load-options-general.php', 'prevent_access' );
add_action( 'load-options-writing.php', 'prevent_access' );
add_action( 'load-options-reading.php', 'prevent_access' );
add_action( 'load-options-discussion.php', 'prevent_access' );
add_action( 'load-options-media.php', 'prevent_access' );
add_action( 'load-options-permalink.php', 'prevent_access' );
function prevent_access(){
    $user = wp_get_current_user();
	if ( in_array( 'editor', (array) $user->roles ) ) {
		echo 'Sie sind leider nicht berechtigt diese Seite aufzurufen.';
		exit();
	}
}
