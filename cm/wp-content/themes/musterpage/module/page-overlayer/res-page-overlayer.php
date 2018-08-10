<!-- Page Overlayer  -->
<section id="page-overlayer">
  <div class="page-overlayer-inside">
          <div class="page-overlayer-content text-center">
             
			<div class="page-overlayer-adress">
					<h2 class="well-bottom">Kontakt</h2>
					<p><?= get_option('res_kontaktdaten')['firma'];?></p>
					<p><?= get_option('res_kontaktdaten')['strasse'];?></p>
					<p><?= get_option('res_kontaktdaten')['adresszusatz']; ?></p>
					<p><?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?><br><br></p>
					<p><a href="<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a></p>
					<p><a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?> </a></p>
             </div>
                          
            <div class="blog-link well-top-md text-center">
            	<h3>Unser Blog</h3>
                <p class="well-bottom-sm">Erfahren Sie mehr in unserem Blog</p>
            	<a class="btn btn-default" href="<?php esc_url( home_url( '/' ) ); ?>category/blog" target="_parent">
              	  <h4> <i class="fa fa-comment" aria-hidden="true"></i> &nbsp;Beiträge ansehen</h4>
                </a>
             </div>  
	  
         </div>
  </div>
</section>