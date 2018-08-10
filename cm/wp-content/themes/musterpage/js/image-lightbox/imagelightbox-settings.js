jQuery(document).ready(function($) {

	// Lightbox Touch-Responsive
    function activityIndicatorOn() {
		$('<div id="imagelightbox-loading"><div></div></div>').appendTo('body');
	}
   	function activityIndicatorOff() {
        $('#imagelightbox-loading').remove();
    }
    function overlayOn() {
        $('<div id="imagelightbox-overlay"></div>').appendTo('body');
    }
    function overlayOff() {
        $('#imagelightbox-overlay').remove();
    }
	function closeButtonOn() {
        $('<button type="button" id="imagelightbox-close" title="Close"></button>').appendTo('body').on('click', function() {
            $(this).remove();
        });
    }    
    function closeButtonOff() {
        $('#imagelightbox-close').remove();
    } 
    function captionOn() {
        var description = $('a[href="' + $('#imagelightbox').attr('src') + '"] img').attr('alt');
        if (description.length > 0){
            $('<div id="imagelightbox-caption">' + description + '</div>').appendTo('body');
        }
    }    
    function captionOff() {
        $('#imagelightbox-caption').remove();
    } 
 
        $('.postImg a').imageLightbox({
            onStart: function() { overlayOn(); closeButtonOn(); },
            onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd: function() { captionOff(); activityIndicatorOff(); }
        });

        $('.gallery-item a').imageLightbox({
            onStart: function() { overlayOn(); closeButtonOn(); },
            onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd: function() { captionOff(); activityIndicatorOff(); }
        });
		
        $('.event-flyer .lightbox a').imageLightbox({
            onStart: function() { overlayOn(); closeButtonOn(); },
            onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd: function() { captionOff(); activityIndicatorOff(); }
        });	

        $('.carousel-item a').imageLightbox({
            onStart: function() { overlayOn(); closeButtonOn(); },
            onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd: function() { captionOff(); activityIndicatorOff(); }
        });
		
        $('#pinwallgallery-content li a').imageLightbox({
            onStart: function() { overlayOn(); closeButtonOn(); },
            onEnd: function() { overlayOff(); captionOff(); closeButtonOff(); activityIndicatorOff(); },
            onLoadStart: function() { captionOff(); activityIndicatorOn(); },
            onLoadEnd: function() { captionOff(); activityIndicatorOff(); }
        });
	
	

});
