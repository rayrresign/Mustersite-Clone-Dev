jQuery(document).ready(function($) {

    var viewportWidth = $(window).width();
	
	
	// Add Video Button to html5 Video  ----------------------------------------------------
	// Zeigt Button auf dem Video-----> kann nur auf einer Seite stehen mit class: home
	var playBtn = $('.res-vid-playBtn');
	var video = $('video');
	
	// Click auf Play-Button
	playBtn.on('click', function(){
		var this_video = $(this).find('video')[0];
		if(this_video.paused){
			this_video.play();
			$(this).addClass('res-video-play-handle');
		}else{
			this_video.pause(); // Wenn video Pausiert => play sonst pause	
			$(this).removeClass('res-video-play-handle');
		}
	});
	
	// Falls der Kunde auf den Html Start knopf drückt
	video.on('play', function(){
		$(this).parent().addClass('res-video-play-handle');
	});
	
	video.on('pause', function(){
		$(this).parent().removeClass('res-video-play-handle');			
	});
	// end; Add Video Button to html5 Video  ----------------------------------------------------
	
	
    //   Scroll to Links  #   
    $('.res-nav .nav a[href^="#"], #navOnTop a[href^="#"], #Logo a[href^="#"], .scrollLink a[href^="#"], a[href^="#"].scrollLink, .scrollSkipper a[href^="#"], .page-overlayer-nav a[href^="#"], #pointerNav a[href^="#"], .subnavbar .nav a[href^="#"], #side-menu-navigation a[href^="#"]').bind('click.smoothscroll', function(e) {
		e.preventDefault();
            var target = this.hash,
                $target = $(target);
		if($target.length){
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top - 85
			}, 1500, 'easeInOutExpo', function() {
				// window.location.hash = target;
				history.pushState(null, null, target);
			});
		} 
        });


	// Mobile Nav Close onpeager
		$("body button.lines-button").on('click', function() {
				$(this).toggleClass("closebutton");
				$("body").toggleClass("open");
		});
	
	
	//   Fixed Nav fancy Sticky
	$(window).bind('scroll', function() {
		$('.res-header').fixedNav({
			$window: $(this)
		});
	}); 
	$.fn.extend({
		fixedNav: function(options) {			
			var $self = $(this),
				self = this,
				$window = options.$window,
				offset = 80,
				$fixedWrapper = $('#fixedNav');
	
			if ($window.scrollTop() >= offset && !$('#fixedNav').length && $(window).width() >= 970) {
				$fixedWrapper = $('<div id="fixedNav"></div>').prependTo('body');
				$fixedWrapper.append($self.clone(true)).find('nav').removeAttr('id');
				$('#fixedNav .res-header').addClass('nav-up');


				setTimeout(function() {
					$fixedWrapper.find('nav').addClass('fixed');
				}, 0);
				
			} else if ($fixedWrapper.length && $window.scrollTop() <= offset) {
				$fixedWrapper.remove();
			}
			return self;
		}
	});
	
	//   Fixed SUBNAV 
	$('#navbar-primary').append('<div id="subnav-row" class="row"></div>');
	$('.subnavbar').clone().prependTo('#subnav-row').attr('id', 'subnavbar-fixed').addClass('hidden-xs');
	$(document).scroll(function() {
    	if($(document).scrollTop() >= 240 && $(window).width() > 992){	
			$('#subnavbar-fixed').css('display','block');
		} else if (($(document).scrollTop() <= 240)){
			$('#subnavbar-fixed').css('display','none');
		}
	});	
	$(window).on('resize', function(){
		if($(window).width() <= 992){
			$('#subnavbar-fixed').css('display','none');
		}
	});
	
	// page overlayer
//	$("body").prepend('<button class="lines-button x" type="button"><span class="lines"></span></button>');
	
	
    // Pointer Nav - nur bei Onepager		   
//    if (viewportWidth < 1200) {
//        $("#pointerNav").remove();
//
//    } else {
//        if (!$("body > #pointerNav").length && $("nav .nav > li a").text() !== 'Add a menu') {
//            $(".res-nav .navbar-collapse").clone(true, true).prependTo("body").attr('id', 'pointerNav');
//
//            $("body > .navbar-collapse li a").each(function() {
//                $(this).attr('data-toggle', 'tooltip').attr('data-placement', 'left');
//            });
//            $(function() {
//                $('[data-toggle="tooltip-off"]').tooltip();
//            });
//
//        }
//    }
	
    // Mobile Nav close-click	   
		if (viewportWidth < 780) {
			  //  mobile nav click close 
				$('.res-nav .nav a').on('click', function(){
				$(".navbar-toggle").click() 
			  });                           
		}
		
	  //  Overlayer Navi
		$('.page-overlayer-nav #navbar ul li a').on('click', function(){
		$(".closebutton").click() 
	  });                           


    // lade Inhalt dynamisch in Modalbox mit site_url
    $("a.load-content").click(function() {
        var post_id = $(this).attr("data-id");
        var reference = ('.singleContent');
        var target = "#" + $(this).attr("data-target");
        var loadUrl = site_url+"/?p=" + post_id;
        $(target + " .modal-body").load(loadUrl + " " + reference, function() {
            $(target).modal('show');
        });
        return false;
    });
	

	// FadeIn X FadeOut Page  /  benötigt 2 Divs  #faderPage  #faderFooter 
	var duration = 300; $('#faderPage, #faderFooter').fadeIn(duration).css('display', 'block'); $('nav a').click(function(e) {
		e.preventDefault();
		newLocation = this.href;
		if (!(newLocation.indexOf("#") != -1)) {
			$('#faderPage, #faderFooter').fadeOut(duration, function() {
				window.location = newLocation;
			});
		}
	});


    //  Show footer arrow or hide  
    var isVisible = false;
    $(window).scroll(function() {
        var shouldBeVisible = $(window).scrollTop() > 350;
        if (shouldBeVisible && !isVisible) {
            isVisible = true;
            $('#navOnTop').fadeIn("slow");
        } else if (isVisible && !shouldBeVisible) {
            isVisible = false;
            $('#navOnTop').fadeOut("slow");
        }
    });


    //  active Main-Nav Home  
    /*
	$(function() {
        $('.home .navbar-nav li').first().addClass("active");
    });
	*/


//	//  PostMag Box Height
	function boxHeightFix(){
		if($(window).width() > 970){
        	setTimeout(10000);
			var maxHeight = 0;
			var count = 0;
			$(".postMag .postContent").each(function(){
				count++;
			   if ($(this).height() >= maxHeight) { 
				   maxHeight = $(this).height(); 
			   }
			});	
			$(".postMag .postContent").height(maxHeight);
		}else{
			$(".postMag .postContent").removeAttr('style');	
		}
	}
	setTimeout(function() {
		boxHeightFix();
	}, 100);
	


	//  Team Box Height
	function boxHeightFixTeam(){
		if($(window).width() > 1200){
			var maxHeight = 0;
			$(".team .postContent").each(function(){
			   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
			});	
			$(".team .postContent").height(maxHeight);
		}else{
			$(".team .postContent").removeAttr('style');	
		}
	}
	setTimeout(function() {
		boxHeightFixTeam();
	}, 100);
	
	
	
	//   Video html5 Modalplay and Stop JS   okt 2017
             $('#modal-video').on('hidden.bs.modal', function() {
        $('#stopvideo').get(0).pause();
    });



	
    //  active tabs  
    $(function() {
        $('.tabs .nav-tabs li').first().addClass("active");
        $('.tabs .tab-content .tab-pane').first().addClass("active");
        $('.secondNav .nav-tabs li').first().addClass("active");
        $('.secondNav .tab-content .tab-pane').first().addClass("active");
    });
	
	// Rubrik / Category FILTER ------------------------------
	// Mobile -> Erstes aktiv setzen
	$('#filter-mobile-dropdown .filter-btn').first().addClass('active');
	$('#dropdown-menu .filter-btn').first().addClass('active');	
	$('#dropdown-menu .filter-btn').first().find('i').removeClass('fa-circle-thin');
	$('#dropdown-menu .filter-btn').first().find('i').addClass('fa-circle');	
	
	var last_choice = '', last_choice_2 = '';
	$('.filter-btn').on('click', function(){
		var selection = $(this).attr('data-tax');
		var choice = $(this).find('span').text();
		var active;
		
		//active setzen
		$('.filter-btn').each(function(){
			if($(this).hasClass('active')){
				active = $(this).attr('data-tax');
			}else{
				$('.filter-btn').first().addClass('active');
				$('.filter-btn').first().find('span').addClass('active');
			}
		});
							
		// Buttons wechseln			
		$('.filter-btn').each(function(){
			$(this).removeClass('active');
			$(this).find('i').removeClass('fa-circle');
			$(this).find('i').addClass('fa-circle-thin');
					
			if($(this).attr('data-tax') === selection){
				$(this).find('i').removeClass('fa-circle-thin');
				$(this).find('i').addClass('fa-circle');
				$(this).addClass('active');
			}	
		});
		
		// Mobile Auswahl wechseln
		if(choice !== last_choice || last_choice === last_choice_2){
			$('.choice').text(choice);					
		}else{
			$('.choice').text($('#filter-mobile-dropdown .filter-btn').find('span').first().text());
		}
				
		last_choice_2 = last_choice;
		last_choice = choice;
		
		// Content wechseln
		if(selection !== active){
			$('.taxonomy-filter').each(function(){
				$(this).fadeOut();
				if($(this).hasClass(selection)){
					$(this).fadeIn('400');			
				}					
			});					
		}else{
			// alle anzeigen
			$('.taxonomy-filter').each(function(){
				$(this).fadeIn();
			});
			// active wegnehmen
			$('.filter-btn').each(function(){
				$(this).removeClass('active');
				$(this).find('i').removeClass('fa-circle');
				$(this).find('i').addClass('fa-circle-thin');	
			});
		}				
	});
	

	//setCookie 2018
	//check if cookie exist
	if (!!$.cookie('Datenschutz')) {
		$('#cookieContainer').remove(); 
	} else {
	//if Cookie is not set, set cookie with Value 42 on root
		$('#cookies-close-x').on('click', function() {
			$.cookie("Datenschutz", "42", { path: '/' });
			$('#cookieContainer').fadeOut('fast');
		});		
	}

	
    //  Nice Scroll
	$("html").niceScroll({
			// Docu = http://areaaperta.com/nicescroll/index.html
		    cursorcolor: "#222",
			cursoropacitymin: 1, /* change opacity very cursor is inactive (scrollabar "hidden" state), range from 1 to 0, default is 0 (hidden) */
			cursoropacitymax: 1, /* change opacity very cursor is active (scrollabar "visible" state), range from 1 to 0, default is 1 (full opacity) */
			cursorwidth: "15px", /* cursor width in pixel, default is 5 (you can write "5px" too) */
		    mousescrollstep: 40, /*  scrolling speed with mouse wheel, default value is 40 (pixel) */
		    zindex: 9999,
		    cursorborder: "1px solid #222", /*  css definition for cursor border, default is "1px solid #fff" */
		    cursorborderradius: "none",
		    horizrailenabled:false,
			smoothscroll: true, /* scroll with ease movement (default:true) */
			cursorfixedheight: false, /* set fixed height for cursor in pixel (default:false) */
       		scrollspeed: 50,
        	autohidemode: false,
			//hidecursordelay: 400, /* set the delay in microseconds to fading out scrollbars (default:400) !!! Disable cursoropacitymin and cursoropacitymax  !!! */
		});

});