<!-- Footer Minimal -->

<section class="footerMinimal well-top-md well-sm">
  <div class="container">
    <div class="row text-center">
	  <h2><?= get_option('res_kontaktdaten')['kontakt_slogan']; ?></h2>
      <div class="col-xs-12 footerMinimal well-sm">
      <a class="btn btn-default" href="<?= get_option('res_kontaktdaten')['phone'];?>" target="_parent">
         <h3>
          	<i class="fa fa-phone" aria-hidden="true" style="transform: rotate(15deg);"></i>
            <?= get_option('res_kontaktdaten')['phone_text'];?>
          </h3>
        </a>
      </div>
      <div class="col-xs-12 footerMinimal">
        <p> 
	    	<a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>">
				<i class="fa fa-envelope" aria-hidden="true"></i> <?= get_option('res_kontaktdaten')['mail_text'];?>
        	</a> 
		</p>
	  </div>
    </div>
    <div class="row">
      <div class="col-xs-12 footer-rights well-top text-center">
        <p>&copy; <?= date('Y'); ?> <?= get_option('res_kontaktdaten')['firma'];?> 
		   - Webdesign by <a href="http://www.resign.ch" rel="nofollow" target="_blank">RESIGN.</a> 
           - <a href="<? echo esc_url( home_url( '/' ) ); ?>?impressum=impressum">Impressum & Datenschutz</a> 
		</p>
      </div>
    </div>
  </div>
</section>