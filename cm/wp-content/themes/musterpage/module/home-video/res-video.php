<!--  RES Video -->
<div class="headerIntroVideo">
    <div class="vertical-center">
        <div class="slogan duration2 topIncoming">
            <div class="container">
				<div class="sloganBox">
				
                <?php $the_query = new WP_Query(array('post_type' => 'slogans', 'order' => 'ASC')); ?>
                <?php if ($the_query->have_posts()) {
                    $the_query->the_post(); ?>
                    <h2 class="hidden-xs text-uppercase"><?php echo get_option('res_logohome')['titel_homescreen']; ?></h2>
                    <h2 class="visible-xs text-uppercase"><?php echo get_option('res_logohome')['titel_homescreen_mobile']; ?></h2>
					
                    <p class="hidden-xs"><?php echo get_option('res_logohome')['text_homescreen']; ?></p>
                    <p class="visible-xs"><?php echo get_option('res_logohome')['text_homescreen_mobile']; ?></p>
                    <?php wp_reset_postdata(); ?>
                <?php } ?>
                 <p class="scrollLink"><a class="btn btn-secondary" href="#home">mehr erfahren</a></p>
                </div>  
            </div>
            <div class="scrollSkipper claimSkipp animated infinite pulse"><a href="#home" class="arrow-down arrowWhite"></a></div>
            
        </div>
    </div>

    <div class="fullscreenVideo fadeIn duration3">
        <video class="videoScale" preload autoplay muted playsinline></video>
    </div>
</div>

<?php 
function homevideo_footer(){
	// Videos aus Page-Settings 
	$video_desktop_id = get_option('res_videohome')['video_desktop'];
	$video_desktop_standbild_id = get_option('res_videohome')['video_desktop_standbild'];
	$video_mobile_id = get_option('res_videohome')['video_mobile'];
	$video_mobile_standbild_id = get_option('res_videohome')['video_mobile_standbild'];
?>
<!--  Video Poster-Autoreplace Responsive -->
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var isMobile;
        function onResize(){
            var fullscreenVideo = $(".fullscreenVideo video");
            var videoPath, poster = "";
			
			var video_desktop_path = '<?php echo wp_get_attachment_url($video_desktop_id)?>';
			var standbild_desktop_path = '<?php echo wp_get_attachment_url($video_desktop_standbild_id)?>';
			var video_mobile_path = '<?php echo wp_get_attachment_url($video_mobile_id)?>';
			var standbild_mobile_path = '<?php echo wp_get_attachment_url($video_mobile_standbild_id)?>';
			
			var video_desktop_mime = '<?php echo get_post_mime_type($video_desktop_id); ?>';
			var video_mobile_mime = '<?php echo get_post_mime_type($video_mobile_id); ?>';

            if ($(window).width() <= 970 && isMobile !== true) {
                videoPath = video_mobile_path; // Mobile Video Path
                poster = standbild_mobile_path; // Mobile Poster
                fullscreenVideo.html('<source type="' + video_mobile_mime + '" src="'+videoPath+'"/>');
                fullscreenVideo.attr("poster", poster);
                isMobile = true;
            } else if($(window).width() > 970 && isMobile !== false) {
				videoPath = video_desktop_path; // Mobile Video Path
                poster = standbild_desktop_path; // Mobile Poster
                fullscreenVideo.html('<source type="' + video_desktop_mime + '" src="'+videoPath+'"/>');
                fullscreenVideo.attr("poster", poster);
                isMobile = false;
            }
        }
        $(window).on('resize', onResize);
        onResize();
    });
</script>
<?php 
}
add_action('wp_footer','homevideo_footer',1);
?>

