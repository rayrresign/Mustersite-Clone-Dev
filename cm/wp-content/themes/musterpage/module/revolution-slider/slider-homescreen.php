
<!-- REV-Slider-Homescreen Slider from Page-Settings -->
<?php 
	$image_res_crop = wp_get_attachment_image_src(get_option('res_logohome')['homescreen_bild'], get_option('res_logohome')['homescreen_bild_crop']);
?>
<section id="rev-slider-homescreen" class="rev-slider rev-homescreen"> 
    <div class="vertical-center rev-slider-text">
        <div class="slogan duration2 topIncoming text-uppercase">
            <div class="container">
                    <h2><?php echo get_option('res_logohome')['titel_homescreen']; ?></h2>
                    <p><?php echo get_option('res_logohome')['text_homescreen']; ?></p>
                 <p class="scrollLink"><a class="btn btn-secondary" href="#home">mehr erfahren</a></p>
            </div>
            <div class="scrollSkipper claimSkipp"><a href="#home" class="arrow-down arrowWhite"></a></div>
        </div>
    </div>

    <div class="rev_slider_wrapper"> 
        <div id="rev_slider_homescreen" data-version="5.4.5" class="rev_slider">
            <ul>
               <li data-transition="fade">
 					<img src="<?php echo $image_res_crop[0]; ?>" alt="" class="rev-slidebg" data-bgparallax="8"> 
                </li>
            </ul> 
        </div> 
    </div> 
</section>        

<?php 
function revslider_slider_homescreen(){
?>
		<script id="rev-slider-homescreen-script" type="text/javascript">
			var tpj=jQuery;								
			var revapi490;
			tpj(document).ready(function() {
				if(tpj("#rev_slider_homescreen").revolution == undefined){
					revslider_showDoubleJqueryError("#rev_slider_homescreen");
				}else{
					revapi490 = tpj("#rev_slider_homescreen").show().revolution({
						sliderLayout:'fullscreen', /* options are 'auto'(auto, wenn minheight gegeben ist, 'fullwidth' or 'fullscreen' */
						spinner:"off",
						parallax: {
							type:"scroll",
							origo:"slidercenter",
							levels:[10,20,30,40,50,60,70,80,90],
						},
						autoHeight:"on",
                        							
					});
				}
			});	/*ready*/
		</script>
<?php
}
add_action('wp_footer', 'revslider_slider_homescreen');
