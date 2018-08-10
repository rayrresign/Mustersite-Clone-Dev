jQuery(document).ready(function($) { 
	
	
/* FANCY STICKY NAV ************************************************************************/
	if($(window).scrollTop() > 100){
		$('#side-menu-btn').hide();
	   	$('#side-menu-btn').addClass('nav-up-mobile');
		$('#side-menu-btn').show();
	}else{
		$('#side-menu-btn').css('position', 'relative');
	}

	// Hide Header on on scroll down
	var didScroll;
	var lastScrollTop = 0;
	var delta = 2.5;
	var navbarHeight = $('#fixedNav .res-header').outerHeight();
	var navbarHeightMobile = $('.res-nav-header').outerHeight();
	
	$(window).scroll(function(event){
		didScroll = true;
	});

	setInterval(function() {
		if (didScroll) {
			hasScrolled();
			didScroll = false;
		}
	}, 200);
//	console.log('navbarHeightMobile: '+ navbarHeightMobile);
	function hasScrolled() {
		var st = $(this).scrollTop();
		var viewportWidth = $(window).width();
		
//		console.log(st);
		// Make sure they scroll more than delta
		if(Math.abs(lastScrollTop - st) <= delta)
			return;

		// If they scrolled down and are past the navbar, add class .nav-up.
		// This is necessary so you never see what is "behind" the navbar	
		if (st > lastScrollTop && st >= 30){
			// Scroll Down
			$('#fixedNav .res-header').addClass('nav-up');
			
			if(viewportWidth < 970){
				$('#side-menu-btn, .res-nav-header').addClass('nav-up-mobile');	
			}else{
				$('#side-menu-btn').addClass('nav-up');
				$('.res-nav-header').css('position', 'relative');
				$('#side-menu-btn').css('position', 'relative');  // << auskommentieren wenn man nur mobile haben will
			}
		} else {
			// Scroll Up
			if(st + $(window).height() < $(document).height()) {				
				$('#fixedNav .res-header').removeClass('nav-up');
				
				if(viewportWidth < 970 ){						
					$('.res-nav-header').removeClass('nav-up-mobile');
					$('.res-nav-header').css('position', 'fixed');		
					
					$('#side-menu-btn').removeClass('nav-up-mobile'); 
					$('#side-menu-btn').css('position', 'fixed'); 
				}else{
					$('#fixedNav .res-nav-header').css('position', 'relative');
					$('#side-menu-btn').removeClass('nav-up'); // << auskommentieren wenn man nur mobile haben will
					$('#side-menu-btn').css('position', 'fixed'); 	
					
					if(st <= navbarHeight + 90){ // side-menu fix
						$('#side-menu-btn').css('position', 'relative');
					} 
				}
				
//				
			}
		}
		
		lastScrollTop = st;
	}


	
	/***************************  parallax  ****************************/	

	$.fn.is_on_screen = function(){    
		var win = $(window);
		var viewport = {
			top : win.scrollTop(),
			left : win.scrollLeft()
		};
		//viewport.right = viewport.left + win.width();
		viewport.bottom = viewport.top + win.height();

		var bounds = this.offset();
		//bounds.right = bounds.left + this.outerWidth();
		bounds.bottom = bounds.top + this.outerHeight();

		return (!(viewport.bottom < bounds.top || viewport.top > bounds.bottom));
	};


	function parallax() { 
	 var parallax_section = $('.parallax-section');

	  $(parallax_section).each(function(){ 
		 if ($('.parallax_module').is_on_screen()) {			 
			$(parallax_section).css("visibility","visible");

			var firstTop = $(this).offset().top; 
			var moveTop = (firstTop-winScrollTop)*0.3; //speed;
			 $(parallax_section).css("transform", "translate3d(0, " + moveTop + "px, 0)");		 
		 } else {
			$(parallax_section).css("visibility","hidden");

		 }

	  });
	}

	$(window).scroll(function(e){
	  winScrollTop = $(this).scrollTop();
	  parallax();
	});	
	
});