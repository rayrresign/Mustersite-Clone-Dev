<!-- Footer Standard -->
<section class="footerStandard well-top-lg">
    <div class="container">
        <div class="row">

            <div class="col-xs-12 col-sm-4 footerBox-Standard">
                
                <h4><?= get_option('res_kontaktdaten')['firma'];?></h4>
                <p><?= get_option('res_kontaktdaten')['strasse'];?><br>
					<?= get_option('res_kontaktdaten')['plz'];?> <?= get_option('res_kontaktdaten')['ort'];?><br>
					<a href="<?= get_option('res_kontaktdaten')['phone'];?>"><?= get_option('res_kontaktdaten')['phone_text'];?></a><br>
                    <a href="mailto:<?= get_option('res_kontaktdaten')['mail'];?>"><?= get_option('res_kontaktdaten')['mail_text'];?> </a><br>
                
            </div>

            <div class="col-xs-12 col-sm-4 footerBox-Standard footerSocial ">
                <?php
                if(!empty(get_option('res_social_media')['social_text'])){
					echo ' <h4 class="well-bottom">'.get_option('res_social_media')['social_text'].'</h4>';
				}
				?>
        		
               	<p>
					<?php 
					// Facebook 
					if(!empty(get_option('res_social_media')['facebook'])){
						echo '<a href="'.get_option('res_social_media')['facebook'].'" target="_blank"><i class="fa fa-facebook fa-3x"></i></a>';
					}
					// Google Plus 
					if(!empty(get_option('res_social_media')['google'])){
						echo '<a href="'.get_option('res_social_media')['google'].'" target="_blank"><i class="fa fa-google fa-3x"></i></a>';
					}
					// Twitter 
					if(!empty(get_option('res_social_media')['twitter'])){
						echo '<a href="'.get_option('res_social_media')['twitter'].'" target="_blank"><i class="fa fa-twitter fa-3x"></i></a>';
					}
					// Linkdin 
					if(!empty(get_option('res_social_media')['linkedin'])){
						echo '<a href="'.get_option('res_social_media')['linkedin'].'" target="_blank"><i class="fa fa-linkedin fa-3x"></i></a>';
					}					
					// Xing 
					if(!empty(get_option('res_social_media')['xing'])){
						echo '<a href="'.get_option('res_social_media')['xing'].'" target="_blank"><i class="fa fa-xing fa-3x"></i></a>';
					}
					// Xing 
					if(!empty(get_option('res_social_media')['instagram'])){
						echo '<a href="'.get_option('res_social_media')['instagram'].'" target="_blank"><i class="fa fa-instagram fa-3x"></i></a>';
					}
					// Xing 
					if(!empty(get_option('res_social_media')['youtube'])){
						echo '<a href="'.get_option('res_social_media')['youtube'].'" target="_blank"><i class="fa fa-youtube-play fa-3x"></i></a>';
					}
					// Eigene 1 
					if(!empty(get_option('res_social_media')['custom'])){
						echo '<a href="'.get_option('res_social_media')['custom'].'" target="_blank"><i class="fa fa-envelope fa-3x"></i></a>';
					}
					// Eigene 2
					if(!empty(get_option('res_social_media')['custom_2'])){
						echo '<a href="'.get_option('res_social_media')['custom_2'].'" target="_blank"><i class="fa fa-map-marker fa-3x"></i></a>';
					}
					?>
                </p>
            </div>

            <div class="col-xs-12 col-sm-4 footerBox-Standard">
                <h4>Newsletter abonnieren</h4>
                <div id="res-footer-Mailing">
                    <form action="#" method="post" name="mailingFormular">
                        <input class="form-control res-footer-Formmailing" readonly name="email" type="text"
                               placeholder="E-Mail Adresse eingeben">
                        <input class="btn btn-default res-footer-ButtonMmailing" name="contact_send" type="submit"
                               value="anmelden">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 footer-rights well-top">
                <p>Copyright <?= date('Y'); ?> &copy; <?= get_option('res_kontaktdaten')['firma'];?> - Webdesign by <a
                            href="http://www.resign.ch" rel="nofollow" target="_blank">RESIGN</a>. -
                    <a href="<? echo esc_url(home_url('/')); ?>?impressum=impressum">Impressum & Datenschutz</a></p>
            </div>
        </div>
    </div>
</section>
    