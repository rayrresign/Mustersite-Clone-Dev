
<script>
	// JS Variablen
	var site_url = "<?=site_url(); ?>"; 
	var template_directory_uri = "<?=get_template_directory_uri(); ?>";
	var home_url = "<? esc_url( home_url( '/' ) ); ?>";		

	// WOW JS	
//	jQuery.ajax({
//		url: "<?= get_template_directory_uri(); ?>/js/wow-animate/wow.min.js",
//		dataType: "script",
//		success: function() {
//			new WOW().init();
//		}
//	});
	
	// AOS Animations
	jQuery.ajax({
		url: "<?= get_template_directory_uri(); ?>/js/aos-animation/aos.js",
		dataType: "script",
		success: function() {
			new AOS.init
			({
			  // Global settings
			  disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
			  startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
			  initClassName: 'aos-init', // class applied after initialization
			  animatedClassName: 'aos-animate', // class applied on animation
			  useClassNames: false, // if true, will add content of `data-aos` as classes on scroll

			  // Settings that can be overriden on per-element basis, by `data-aos-*` attributes:
			  offset: 120, // offset (in px) from the original trigger point
			  delay: 0, // values from 0 to 3000, with step 50ms
			  duration: 2400, // values from 0 to 3000, with step 50ms
			  easing: 'ease-out', // default easing for AOS animations
			  once: false, // whether animation should happen only once - while scrolling down
			  mirror: false, // whether elements should animate out while scrolling past them
			  anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
			});
		}
	});
	
	//  Mailing-Footer Overlayer-Click	
	$("#res-footer-Mailing input").on('click', function(event) {
		event.preventDefault();
		$('#newsletterbox').modal('show');
	});
	
	// Sticky Footer - schreibt margin-bottom height in body
    var bumpIt = function() {
            $('body').css('margin-bottom', $('.res-footer').height());
        },
        didResize = false;
    bumpIt();

    $(window).resize(function() {
        didResize = true;
    });
    setInterval(function() {
        if (didResize) {
            didResize = false;
            bumpIt();
        }
    }, 250);	

	
</script>