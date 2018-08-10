jQuery(document).ready(function($) {
	
	"use strict";
	
	 $('#upload_newsletter_entry_bild').click(function(e) {
            e.preventDefault();
			
			var custom_uploader = wp.media({
                title: 'Bild auswählen',
                button: {
                    text: 'Bild auswählen'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
			.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
				var imageSize = $('#img-size').val();
				var attachmentURL = (typeof attachment.sizes['res-newsletter-'+imageSize] === 'undefined')?attachment.url:attachment.sizes['res-newsletter-'+imageSize].url;
				
				console.info(attachmentURL);
								
                $('.croppedImg').attr('src', attachmentURL);
                $('#newsletter_entry_bild_input').val(attachmentURL);

                 if ($('img.croppedImg').length === 0) {
                	$('<img style="max-width:500px;" class="croppedImg" src="'+ attachmentURL +'"/>').insertBefore('#upload_newsletter_entry_bild');
                }

                if ($('.imgRemove').length === 0) {
                	$('#upload_newsletter_entry_bild').before('<p><a href="#" class="imgRemove">Bild ersetzen</a></p>');
                }
				
				var link = document.createElement('link');
				link.type = 'image/x-icon';
				link.rel = 'shortcut icon';
				link.href = attachmentURL;
				document.getElementsByTagName('head')[0].appendChild(link);

            }).open();
	 });
	
});