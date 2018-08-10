
<!-- Parallax Slider from res-custom -->
<section class="rev-slider fullwidthbanner-container rev-parallax-bar"> 
		<?php $the_query = new WP_Query(array('post_type' => 'res-custom', 'order' => 'ASC')); ?>
		<?php if ($the_query->have_posts()) {
			$the_query->the_post(); 
	      	$slider_crop = get_field('parallax01-image');
		?>
    <div class="rev_slider_wrapper"> 
        <div id="rev-parallax-bar-01" data-version="5.4.5" class="rev_slider fullwidthabanner">
            <ul>
               <li data-transition="fade"> 
				<img src="<?php echo $slider_crop['sizes']['res-crop-slider']; ?>" class="rev-slidebg" alt="" data-bgparallax="8"> 
				   <div class="vertical-center rev-slider-parallax-text">
						<div class="slogan duration2 topIncoming text-center">
							<div class="container">
									<h3><?php the_field('parallax01-title'); ?></h3>
									<p><?php the_field('parallax01-text'); ?></p>
							</div>
						</div>
					</div>
                </li>
            </ul> 
        </div> 
    </div>
                  <?php wp_reset_postdata(); ?>
                <?php } ?>
    </section>


<?php
function revslider_parallax01(){
?>
		<script type="text/javascript">
			var tpj=jQuery;								
			var revapi490;
			tpj(document).ready(function() {
				if(tpj("#rev-parallax-bar-01").revolution == undefined){
					revslider_showDoubleJqueryError("#rev-parallax-bar-01");
				}else{
					revapi490 = tpj("#rev-parallax-bar-01").show().revolution({
						sliderLayout:'fullwidth', /* options are 'auto'(auto, wenn minheight gegeben ist, 'fullwidth' or 'fullscreen' */
						autoHeight: "off", //autohöhe skalliert, wenn sliderLayout auf auto ist automatisch 100vh nur bei Desktop
						spinner: "off", //Preloader zeichen off/on
						dottedOverlay:"none",
						responsiveLevels: [ 1690, 1390, 1100, 970, 480 ],
						gridwidth: [ 1690, 1390, 1100, 970, 480 ],
						gridheight:[ 550,550,440,400,300],
						parallax: {
							type: "scroll",
							origo: "slidercenter",
							levels: [ 10, 20, 30, 40, 50, 60, 70, 80, 90 ],
						},
						disableProgressBar: "on",
						shadow:0,
						hideThumbsOnMobile:"off",
						hideSliderAtLimit:0,
						hideCaptionAtLimit:0,
						hideAllCaptionAtLilmit:0,
						debugMode:false,
						fallbacks: {
							simplifyAll:"off",
							disableFocusListener:false,
						}
                        							
					});
				}
			});	/*ready*/
		</script>
<?php
}
add_action('wp_footer', 'revslider_parallax01');
?>

