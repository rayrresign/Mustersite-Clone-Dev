<?php
if (is_admin()) $my_settings_page = new ResPageSettings();


/**  version 1.1 mit Mobile-Homscreen-Texten 2018 */

class ResPageSettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    private $page_id = 'res_page_settings';
    private $sections = array();
    private $fields = array();

    /**
     * Start up
     */
    public function __construct()
    {
        $this->init_structure();	
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_menu_page('Page-Settings', 'Page-Settings', 'edit_pages', $this->page_id, array(&$this, 'create_admin_page'), '', 2);
    }
	
    /**
     * Options page callback
     */
    public function create_admin_page()
    {
		wp_enqueue_media();
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : current(array_keys($this->sections));
        $this->options = get_option('res_' . $active_tab);
        ?>
        <div class="wrap">
            <h1>Page-Settings</h1>
            <?php settings_errors(); ?>
            <h2 class="nav-tab-wrapper">
                <? foreach ($this->sections as $section_id => $section_name) {
                    ?><a href="?page=<?= $this->page_id ?>&tab=<?= $section_id ?>"
                         class="nav-tab <?php echo $active_tab == $section_id ? 'nav-tab-active' : ''; ?>"><?= $section_name ?></a><?
                } ?>
            </h2>
			
            <form method="post" action="options.php">
                <?php
                settings_fields('res_' . $active_tab); // Output nonce, action, and option_page fields for a settings page.     
                do_settings_sections('res_' . $active_tab); // Prints out all settings sections added to a particular settings page.
                submit_button();
                ?>
            </form>
        </div>
        <?php		
    }
    /**
     * Struktur der Sections und Felder
     */
    public function init_structure()
    {
			
		// 1) Section Kontaktdaten
        $this->sections["kontaktdaten"] = "Kontaktdaten";
		$this->fields["kontaktdaten"]["titel_adresse"] = array('type' => 'seperator', 'label' => '<h2 style="margin:0;">Adresse</h2>');
        $this->fields["kontaktdaten"]["firma"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Firma');
        $this->fields["kontaktdaten"]["strasse"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Strasse');
        $this->fields["kontaktdaten"]["adresszusatz"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Adresszusatz');
        $this->fields["kontaktdaten"]["plz"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp;&nbsp; PLZ');
        $this->fields["kontaktdaten"]["ort"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Ort');
        $this->fields["kontaktdaten"]["land"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Land');
		$this->fields["kontaktdaten"]["adresse"] = array('type' => 'textarea', 'label' => '&nbsp;&nbsp;&nbsp; Adresse', 'max_length' => 180);
		
		$this->fields["kontaktdaten"]["titel_kontakt"] = array('type' => 'seperator', 'label' => '<h2 style="margin:0;">Kontakt</h2>');		
        $this->fields["kontaktdaten"]["website"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Webseite');
		$this->fields["kontaktdaten"]["mail_text"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; E-Mail Text');
        $this->fields["kontaktdaten"]["mail"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; E-Mail');
        $this->fields["kontaktdaten"]["phone_text"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Phone Text');
        $this->fields["kontaktdaten"]["phone"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Phone');
        $this->fields["kontaktdaten"]["mobile_text"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Mobile Text');
        $this->fields["kontaktdaten"]["mobile"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Mobile');
		
		$this->fields["kontaktdaten"]["titel_formular"] = array('type' => 'seperator', 'label' => '<h2 style="margin:0;">Formular</h2>');
        $this->fields["kontaktdaten"]["form_adress_reciever"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; E-Mail Adresse Empfänger');
        $this->fields["kontaktdaten"]["form_adress_sender"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; E-Mail Adresse Absender');
        $this->fields["kontaktdaten"]["kontakt_slogan"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Kontakt Slogan');
		
		$this->fields["kontaktdaten"]["titel_lageplan"] = array('type' => 'seperator', 'label' => '<h2 style="margin:0;">Lageplan</h2>');
        $this->fields["kontaktdaten"]["koord_laenge"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Koordinaten Länge');
        $this->fields["kontaktdaten"]["koord_breite"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Koordinaten Breite');
		$this->fields["kontaktdaten"]["maps_url"] = array('type' => 'text', 'label' => '&nbsp;&nbsp;&nbsp; Standort URL');
		$this->fields["kontaktdaten"]["maps_icon"] = array('type' => 'file', 'label' => '&nbsp;&nbsp;&nbsp; Google Maps Icon');
		
		// 2) Section Social Media
        $this->sections["social_media"] = "Social Media";
        $this->fields["social_media"]["facebook"] = array('type' => 'text', 'label' => 'Facebook');
        $this->fields["social_media"]["google"] = array('type' => 'text', 'label' => 'Google Plus');
        $this->fields["social_media"]["twitter"] = array('type' => 'text', 'label' => 'Twitter');
        $this->fields["social_media"]["linkedin"] = array('type' => 'text', 'label' => 'LinkedIn');
        $this->fields["social_media"]["xing"] = array('type' => 'text', 'label' => 'Xing');
        $this->fields["social_media"]["instagram"] = array('type' => 'text', 'label' => 'Instagram');
        $this->fields["social_media"]["youtube"] = array('type' => 'text', 'label' => 'Youtube');
		$this->fields["social_media"]["social_text"] = array('type' => 'text', 'label' => 'Social Text');
        $this->fields["social_media"]["custom"] = array('type' => 'text', 'label' => 'Eigene');
        $this->fields["social_media"]["custom_2"] = array('type' => 'text', 'label' => 'Eigene 2');
		
        // Sample Logo & Homescreen
        $this->sections["logohome"] = "Logo & Homescreen";
        $this->fields["logohome"]["logo"] = array('type' => 'file', 'label' => 'Logo');
        $this->fields["logohome"]["logo_mobile"] = array('type' => 'file', 'label' => 'Logo Mobile');
//		$this->fields["logohome"]["logo_fixed_nav"] = array('type' => 'file', 'label' => 'Logo Fixed Navigation');
		
		// Desktop
		$this->fields["logohome"]["homescreen_page_titel"] = array('type' => 'seperator', 'label' => '<h1 style="margin:0;">DESKTOP</h1>');	
		$this->fields["logohome"]["titel_homescreen"] = array('type' => 'text', 'label' => 'Titel Homescreen<br> (max. 70 Zeichen)', 'max_length' => 70);
        $this->fields["logohome"]["text_homescreen"] = array('type' => 'textarea', 'label' => 'Text Homescreen<br> (max. 160 Zeichen)', 'max_length' => 160);
        $this->fields["logohome"]["homescreen_bild"] = array('type' => 'file', 'label' => 'Homescreen Bild'); 
		$this->fields["logohome"]["homescreen_bild_crop"] = array('type' => 'crop_select', 'label' => 'Homescreen Bild Format'); 
		
		// Mobile		
		$this->fields["logohome"]["homescreen_mobile_page_titel"] = array('type' => 'seperator', 'label' => '<h1 style="margin:0;">MOBILE</h1>');
		$this->fields["logohome"]["titel_homescreen_mobile"] = array('type' => 'text', 'label' => 'Titel Homescreen<br> (max. 50 Zeichen)', 'max_length' => 50);
        $this->fields["logohome"]["text_homescreen_mobile"] = array('type' => 'textarea', 'label' => 'Text Homescreen<br> (max. 80 Zeichen)', 'max_length' => 80);
        $this->fields["logohome"]["homescreen_bild_mobile"] = array('type' => 'file', 'label' => 'Homescreen Bild'); 		
		
        // Sample Video Homescreen
        $this->sections["videohome"] = "Video Homescreen";
		$this->fields["videohome"]["section_info"] = array('type' => 'section-info', 'content' => 'Optimales Video-Format wäre HD720 oder HD1080, Mobile 490x720 Hochformat .mp4-Datei mit h264-Codex komprimiert und einer max. Bitrate von 2000-4000 kbit');
        $this->fields["videohome"]["video_desktop"] = array('type' => 'video', 'label' => 'Video Desktop');
        $this->fields["videohome"]["video_desktop_standbild"] = array('type' => 'file', 'label' => 'Video Desktop Standbild');
        $this->fields["videohome"]["video_mobile"] = array('type' => 'video', 'label' => 'Video Mobile');
        $this->fields["videohome"]["video_mobile_standbild"] = array('type' => 'file', 'label' => 'Video Mobile Standbild');

    }

    /**
     * 	Register and add settings
	 *	
     */
    public function page_init()
    {
        foreach ($this->sections as $section_id => $section_label) {
			// Register a setting and its data.
            register_setting(
                'res_' . $section_id, // Option group
                'res_' . $section_id // Option name
			);			
			// Add a new section to a settings page.
            add_settings_section(
                $section_id, // ID
                $section_label, // Title
                array($this, 'print_section_info'), // Callback
                'res_' . $section_id // Page
            );
			// Add fields to the section
            foreach ($this->fields[$section_id] as $field_id => $field) {
                if ($field['type'] == 'text') {
                    $this->add_text_settings_field($field_id, $field['label'], $section_id);
                } elseif ($field['type'] == 'textarea') {
                    $this->add_textarea_settings_field($field_id, $field['label'], $section_id, $field['max_length']);
                } elseif ($field['type'] == 'checkbox') {
                    $this->add_checkbox_settings_field($field_id, $field['label'], $section_id);
                } elseif ($field['type'] == 'radio') {
                    $this->add_radio_settings_field($field_id, $field['label'], $field['values'], $section_id);
                }elseif ($field['type'] == 'file') {
                    $this->add_image_settings_field($field_id, $field['label'], $section_id);
                }elseif ($field['type'] == 'seperator') {
                    $this->add_seperator_settings_field($field_id, $field['label'], $section_id);
                }elseif ($field['type'] == 'video') {
                    $this->add_video_settings_field($field_id, $field['label'], $section_id);
                }elseif ($field['type'] == 'crop_select') {
                    $this->add_crop_select_settings_field($field_id, $field['label'], $section_id);
                }
            }
        }
    }
	
   /** 
     * Print the Section text
     */
    public function print_section_info()
    {
		$current_tab = isset($_GET['tab']) ? $_GET['tab'] : current(array_keys($this->sections));
         foreach ($this->sections as $section_id => $section_label) {
			 foreach ($this->fields[$section_id] as $field_id => $field) {
				 if ($field['type'] == 'section-info' && $section_id == $current_tab) print $field['content'];
			 }
		 }		
    }

    public function add_text_settings_field($id, $label, $section_id)
    {
        add_settings_field($id, $label, array($this, 'text_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
    }

    public function add_textarea_settings_field($id, $label, $section_id, $max_length)
    {
        add_settings_field($id, $label, array($this, 'textarea_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id, 'max_length' => $max_length)
        );
    }

    public function add_checkbox_settings_field($id, $label, $section_id)
    {
        add_settings_field($id, $label, array($this, 'checkbox_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
    }

    public function add_radio_settings_field($id, $label, $values, $section_id)
    {
        add_settings_field($id, $label, array($this, 'radio_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'values' => $values, 'section_id' => $section_id)
        );
    }

    public function add_image_settings_field($id, $label, $section_id)
    {
        add_settings_field($id, $label, array($this, 'image_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
    }
	
	public function add_seperator_settings_field($id, $label, $section_id)
    {
        add_settings_field($id, $label, array($this, 'seperator_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
    }
	
	public function add_video_settings_field($id, $label, $section_id)
	{
		add_settings_field($id, $label, array($this, 'video_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
	}
	
	public function add_crop_select_settings_field($id, $label, $section_id)
	{
		add_settings_field($id, $label, array($this, 'crop_select_callback'),
            'res_' . $section_id,
            $section_id,
            array('id' => $id, 'section_id' => $section_id)
        );
	}
	
	/*
	*	CALLBACK FUNCTIONS --------------------------------------------------------------------------------------------
	*/
	
	public function crop_select_callback($args)
    {
        $image_sizes = get_intermediate_image_sizes();
		print('<select id="' . $args['id'] . '" name="res_' . $args['section_id'] . '[' . $args['id'] . ']">');
			$selected = ($this->options[$args['id']] == 0) ? 'selected' : '';
			printf('<option value="0" %s>Keine Formattierung verwenden</option>', $selected);
			foreach ($image_sizes as $size_name):
				$selected = ($size_name == $this->options[$args['id']]) ? 'selected' : '';
				printf('<option value="'.$size_name.'" %s>'.$size_name.'</option>', $selected);
			endforeach;
		print('</select>'); 
    }

    public function text_callback($args)
    {
        printf(
            '<input type="text" id="' . $args['id'] . '" name="res_' . $args['section_id'] . '[' . $args['id'] . ']" value="%s" style="width:500px;"/>',
            isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : ''
        );
		
    }

    public function textarea_callback($args)
    {
        printf(
            '<textarea style="resize:both;width:500px;" rows="4" maxlength="'.$args['max_length'].'" id="' . $args['id'] . '" name="res_' . $args['section_id'] . '[' . $args['id'] . ']" >%s</textarea>',
            isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : ''
        );
    }

    public function checkbox_callback($args)
    {
        if (!$this->options || !array_key_exists($args['id'], $this->options)) {
            $this->options[$args['id']] = 0;
        }
        echo '<input type="checkbox" id="' . $args['id'] . '" name="res_' . $args['section_id'] . '[' . $args['id'] . ']" value="1"' .
            checked(1 == $this->options[$args['id']], true, false) . ' />';
    }

    public function radio_callback($args)
    {
        $id = $args['id'];
        $values = $args['values'];
        if (!$this->options || !array_key_exists($id, $this->options)) {
            $this->options[$id] = current(array_keys($values));
        }
        foreach ($values as $k => $v) {
            echo '<input type="radio" id="' . $id . $k . '" name="res_' . $args['section_id'] . '[' . $id . ']" value="' . $k . '" ' .
                checked($k == $this->options[$id], true, false) . ' /><label for="' . $id . $k . '">' . $v . '</label><br>';
			
        }
    }
	
	    public function seperator_callback($args)
    {
        $id = $args['id'];
        if (!$this->options || !array_key_exists($args['id'], $this->options)) {
            $this->options[$args['id']] = 0;
        }
		echo '<hr>';
    }
	
	
    public function image_callback($args)
    {
	    $id = $args['id'];
		$attachement_id = $attachement_url =	$display = '';
		$section_label = 'res_'.$args['section_id'];
		if (!$this->options || !array_key_exists($args['id'], $this->options)) {
            $this->options[$args['id']] = 0;
        }
		if(empty($id))$id = 1;
		$option = get_option($section_label);
		if(empty($option))$option = array();
		if(array_key_exists($id,$option)){
			$attachement_url = wp_get_attachment_url(get_option($section_label)[$id]);
			$attachement_id = get_option($section_label)[$id];
		}	
		if(!$attachement_id) $display = 'display:none;'; 
		
		// Image preview
		echo "<div id='image-preview-wrapper-".$id."' class='image-preview-wrapper'>";
		if(!$attachement_id)
			echo '<span>Kein Bild ausgewählt.</span>';
		else
			echo '<span></span>';
			echo "<img id='image-preview-".$id."' src='".$attachement_url."' width='200' style='".$display."border: 1px solid lightgrey;margin-bottom:10px;'>";
		echo "</div>";
		echo '<input id="upload_image_button_'.$id.'" type="button" class="button" value="Bild auswählen" />';
		
		// Buttons
		echo '<input id="delete_image_button_'.$id.'" type="button" class="button" value="Bild enfernen" style="'.$display.' margin-left:10px;"/>';
		echo "<input id='". $id . "'  name='res_" . $args['section_id'] . "[" . $args['id'] . "]' type='hidden' value='".$attachement_id."'>";
		?>
		<script type='text/javascript'>
			jQuery( document ).ready( function( $ ) {
				var file_frame;
				var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
				var set_to_post_id = '<?php echo $attachement_id; ?>'; // set 
				// Bild auswählen
				$('#upload_image_button_<?php echo $id; ?>').on('click', function(e){
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						// Set the post ID to what we want
//						file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
						// Open frame
						file_frame.open();
						return;
					} else {
						// Set the wp.media post id so the uploader grabs the ID we want when initialised
//						wp.media.model.settings.post.id = set_to_post_id;
					}
					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						button: { text: 'Bild auswählen'},
						multiple: false	// Set to true to allow multiple files to be selected
					});
					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var image_types = ['image/jpeg','image/png','image/jpg']; 
						attachment = file_frame.state().get('selection').first().toJSON();
						if($.inArray(attachment['mime'], image_types) !== -1 ){
							// Do something with attachment.id and/or attachment.url here					
							$('#image-preview-wrapper-<?php echo $id; ?> > span').text('');		
							$('#image-preview-<?php echo $id; ?>' ).attr( 'src', attachment.url ).css( 'width', '200' );
							$('#image-preview-<?php echo $id; ?>').css('display','block');
							$('#<?php echo $id; ?> ').val( attachment.id );
							$('#delete_image_button_<?php echo $id; ?>').show();
							// Restore the main post ID
							wp.media.model.settings.post.id = wp_media_post_id;		
						}else{
							alert('Bitte wählen Sie eine Bilddatei aus.');
						}
								
					});
					file_frame.open();
				});
				// Bild entfernen
				$('#delete_image_button_<?php echo $id; ?>').on('click', function(e){
					$('#image-preview-<?php echo $id; ?>').attr('src', '').css( 'width', '200' );
					$('#image-preview-<?php echo $id; ?>').attr('src', '').hide();
					$('#image-preview-wrapper-<?php echo $id; ?> > span').text('Kein Bild ausgewählt.');
					$('#<?php echo $id; ?>').val('');
					$('#delete_image_button_<?php echo $id; ?>').hide();
				});
			});
		</script>   
		<?php		
    }
	

	public function video_callback($args)
	{
		$id = $args['id'];
		$attachement_id = $attachement_url =	$display = '';
		$section_label = 'res_'.$args['section_id'];
		if (!$this->options || !array_key_exists($args['id'], $this->options)) {
            $this->options[$args['id']] = 0;
        }
		$option = get_option($section_label);
		if(empty($option))$option = array();
		if(array_key_exists($id,$option)){
			$attachement_url = wp_get_attachment_url(get_option($section_label)[$id]);
			$attachement_id = get_option($section_label)[$id];
		}	
		if(!$attachement_id) $display = 'display:none;'; 
		
		// Video preview
		echo "<div id='video-preview-wrapper-".$id."' class='video-preview-wrapper' style='margin-bottom:10px;'>";
		if(!$attachement_id)
			echo '<span>Kein Video ausgewählt.</span>';
		else
			echo '<span></span>';
			echo '<video id="video-preview-'.$id.'" style="'.$display.'" width="400"  controls>';
				echo '<source id="video-preview-source-'.$id.'" src="'.$attachement_url.'" type="'.$attachement_mime.'">';
			echo '</video>';
		echo "</div>";
		echo '<input id="upload_video_button_'.$id.'" type="button" class="button" value="Video auswählen" />';
		
		// Buttons
		echo '<input id="delete_video_button_'.$id.'" type="button" class="button" value="Video enfernen" style="'.$display.' margin-left:10px;"/>';
		echo "<input id='". $id . "'  name='res_" . $args['section_id'] . "[" . $args['id'] . "]' type='hidden' value='".$attachement_id."'>";
		?>
		<script type='text/javascript'>
			jQuery( document ).ready( function( $ ) {
				var file_frame;
				var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
				var set_to_post_id = '<?php echo $attachement_id; ?>'; // set 
				// Video auswählen
				$('#upload_video_button_<?php echo $id; ?>').on('click', function(e){
					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						// Set the post ID to what we want
//						file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
						// Open frame
						file_frame.open();
						return;
					} else {
						// Set the wp.media post id so the uploader grabs the ID we want when initialised
						wp.media.model.settings.post.id = set_to_post_id;
					}
					// Create the media frame.
					file_frame = wp.media.frames.file_frame = wp.media({
						button: { text: 'Video auswählen'},
						multiple: false	// Set to true to allow multiple files to be selected
					});
					// When an video is selected, run a callback.
					file_frame.on( 'select', function() {
						var video_types = ['video/mp4']; 
						attachment = file_frame.state().get('selection').first().toJSON();
						console.log(attachment);
						if($.inArray(attachment['mime'], video_types) !== -1 ){
							// Do something with attachment.id and/or attachment.url here					
							$('#video-preview-wrapper-<?php echo $id; ?> > span').text('');		
							$('#video-preview-source-<?php echo $id; ?>').attr( 'src', attachment.url ).attr('type', attachment['mime']);
							$("#video-preview-<?php echo $id; ?>")[0].load();
							$('#video-preview-<?php echo $id; ?>').css('display','block').css( 'width', '400' );
							$('#<?php echo $id; ?> ').val( attachment.id );
							$('#delete_video_button_<?php echo $id; ?>').show();
							// Restore the main post ID
							wp.media.model.settings.post.id = wp_media_post_id;		
						}else{
							alert('Bitte wählen Sie eine Videodatei aus.');
						}								
					});
					file_frame.open();
				});
				// Video entfernen
				$('#delete_video_button_<?php echo $id; ?>').on('click', function(e){
					$('#video-preview-<?php echo $id; ?>').attr('src', '').css( 'width', '400' ).hide();
					$('#video-preview-wrapper-<?php echo $id; ?> > span').text('Kein Video ausgewählt.');
					$('#<?php echo $id; ?>').val('');
					$('#delete_video_button_<?php echo $id; ?>').hide();
				});
			});
		</script>   
		<?php
	}
}