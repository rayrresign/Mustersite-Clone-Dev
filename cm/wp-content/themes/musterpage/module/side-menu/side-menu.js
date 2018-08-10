jQuery(document).ready(function($) { 
	
    var viewportWidth = $(window).width();
	
	/** Side Menu */
	$("body").prepend('<button id="side-menu-btn" class="side-lines-button x" type="button"><span class="side-lines"></span></button>');
		$("body button#side-menu-btn").on('click', function() {
				$(this).toggleClass("closebutton");
				$("body").toggleClass("openSideMenu");
		});
	
	$('#side-menu-btn').on('click', function(){
		if($(this).hasClass('closebutton')){
			
			slideMenuPoint();
			
		} else {	
			resetClasses();		
		}
	});
	
//	resetClasses();	
	
	function slideMenuPoint(){	
		var x = 1;					
		$('#side-menu-box').find('li').each(function(i){	
			i = jump(this, i);
				var $li = $(this);
				setTimeout(function () { 			
						doThis($li); 
				}, 150 * (i + 1));


			function jump(a,i){			
					if($(a).parent().hasClass('dropdown-menu')){ 
						x += 1;
					} else {
						return i -= x;
					}
				return i;
			}
		});		
	}	
	function doThis($li){
		$li.addClass('show-navs');
		$('.side-elements').addClass('sidemenu-animation');
	}
	
	function resetClasses(){
		setTimeout( function(){
			if(!$('body').hasClass('openSideMenu')  ) {
				// reset each li in nav Dropdown to default
				$('.side-menu-overlayer').find('li.dropdown').next().css( "margin-top" , '0' );
				
				$('#side-menu-box').find('li').each(function(){			
					var $li = $(this);
						doThat($li); 
				});
			}	
		}, 200);
	}			
			
	function doThat($li){
		$li.removeClass('show-navs');
		$('.side-elements').removeClass('sidemenu-animation');

	}
	if(viewportWidth > 970 ) {
		$('#side-menu-btn').hover(function () {
			$('#side-menu-box').addClass('teaser');
		}, function () {
			$('#side-menu-box').removeClass('teaser');
		});	
		
		$('.side-menu-overlayer').find('li.dropdown').on('click', function(){
			var heightUl = $(this).find('ul').height();
			if(!$(this).hasClass('open')){
				$(this).next().each(function(){
					$(this).css( "margin-top" , heightUl );			
				});
			} else {
				$(this).next().each(function(){
					$(this).css( "margin-top" , '0' );			
				});
			}

		});
	}
	
	$(window).scroll(function(){
		resetClasses();
	});	
	 
	
});