jQuery(document).ready(function ($){		

		var adjustment;

		$("ol.slides").sortable({
		 update: function(event, ui) {
				jQuery.post(object.ajax_url, { type: "orderSlides", pages: jQuery("ol.slides").sortable('serialize') } );
			}
		});

		$(".delete-link").click(function (e)
		{
			e.preventDefault();
			var q = confirm("Möchtest du dieses Bild wirklich aus dem Slider entfernen?");
			if (q == true) {
				var slide_li = jQuery(this).parentsUntil("li");
				var slide_id = jQuery(this).attr('slide-id');
				
				jQuery.post(object.ajax_url, { type: "deleteSlide", id: slide_id } );
				slide_li.fadeOut();
			}
			
		});


		/* General Mediaupload-function starts here */
		$("#upload_logo").click(function (event)
		{
			var resignModalUpload = false;
			event.preventDefault();
			if (resignModalUpload)
			{
				resignModalUpload.open();
				return
			}
			resignModalUpload = wp.media.frames.my_upload_frame = wp.media(
			{
				frame: "select",
				title: "Resign Image-Uploader",
				library: {
					type: "image"
				},
				button: {
					text: "hinzufügen",
				},
				multiple: true
			});
			resignModalUpload.on("select", function ()
			{
				var selection = resignModalUpload.state().get("selection");
				selection.map(function (attachment)
				{
					attachment = attachment.toJSON();
					if (attachment.id)
					{
						var resign_image_id = attachment.id;

						$.ajax({
						type: "POST",
						url: object.ajax_url,
						data: { resign_image_ajax : resign_image_id },
						success: function(data){
							var url = 'admin.php?page=gallery-slider';
							window.location.href = url;
						}
						});
					}
				})
			});
			resignModalUpload.open()
		})
	});