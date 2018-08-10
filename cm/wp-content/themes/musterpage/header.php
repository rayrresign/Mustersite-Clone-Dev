<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php	wp_title('|', true, 'right');	?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
<!--
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-87DrmpqHRiY8hPLIr7ByqhPIywuSsjuQAfMXAE0sMUpY3BM7nXjf+mLIUSvhDArs" crossorigin="anonymous">
	 
-->
<?php wp_head(); ?> 

<!-- preloadCSS -->
<?php //require_once("stylepreload.php"); ?>
	
	
<!-- Google Analytics Tagmanager-Code -->
<?php //if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false): ?>
<!--
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-2815401-15"></script>
	<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'UA-2815401-15');
	</script>
-->
<?php //endif; ?>
<style>
	@media only screen and (max-width: 970px){
	  .mobile-logo{background-image: url(<?= wp_get_attachment_image_url(get_option('res_logohome')['logo_mobile'],''); ?>);}
	}
</style>
</head>
	
<body <?php body_class(); ?> data-spy="scroll" data-target=".navbar-collapse" data-offset="85">
<div id="page">
<div id="faderPage">

<header class="res-header"> 
  <div class="container">
    <div id="navbar-primary" class="row">
		
      <div class="col-sm-3 topIncoming duration2 hidden-xs logo"> 
      		<a href="<? echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo wp_get_attachment_image_url(get_option('res_logohome')['logo'],''); ?>" alt="Logo"/>
		    </a>
      </div>
		
      <div class="col-sm-9 res-nav-header mobile-logo">
        <nav class="res-nav navbar topIncoming duration2">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed hidden-xs" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> 
            	<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand mobile-home-link" href="<? echo esc_url( home_url( '/' ) ); ?>"> <span></span></a></div>
          <?php
			  wp_nav_menu( array(
				'menu' => 'header-menu',
				'theme_location' => 'primary',
				'depth' => 2,
				'container' => 'div',
				'container_id' => 'navbar',
				'container_class' => 'collapse navbar-collapse',
				'menu_class' => 'nav navbar-nav navbar-right',
				'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
				'walker' => new wp_bootstrap_navwalker())
			  );    
         ?>
        </nav>
      </div>      
    </div>    
  </div>
	
</header>
	
	<?php 
		if(!isset($_COOKIE['Datenschutz'])) {
			 require_once('module/cookies/cookies.php');
		}	
	?>
	
<?php require_once("module/side-menu/side-menu.php"); ?>
<?php //require_once("module/page-overlayer/res-page-overlayer.php"); ?>
<?php //require_once("module/page-overlayer/res-overlayer-navigation.php"); ?>
<?php require_once('module/cta-overlayer/res-cta-overlayer.php'); ?>

<div class="content-layout">
