		</div>
	</div>
</div>



<div id="navOnTop"><a href="#page"><span class="arrow-up"></span></a></div>


<div id="faderFooter">
  <footer class="res-footer">
 	<?php require_once("module/footer/footer-standard.php"); ?>
 	<?php //require_once("module/footer/footer-minimal.php"); ?> 
   	<?php //require_once("module/footer-big-formular/footerBigFormular.php"); ?>
    
  </footer> 
</div>

<!-- Mailing -->
<?php require_once('module/footer-mailing/modal-mailing.php'); ?>

<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>

<!-- JS-Load -->
<?php require_once("js-load.php"); ?> 

<!-- Typekit - info soleil -->
<link rel="stylesheet" href="https://use.typekit.net/ekg6kyn.css">



<?php
	wp_footer();
?>

</body></html>
<?php res_cache(); ?>